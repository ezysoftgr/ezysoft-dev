<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\Translation\t;

class ProductController extends Controller
{


    public function quantity(Request $request)
    {


//        $destinations = Destination::where('user_id',
//            $request->get('user_id'))->where('active',1)->get();
        $ids = [];


        if ($request->all()){
            foreach ($request->all() as $key => $value) {
                $product = Product::where('id_source', $value['id_source'])->first();
                if (isset($product->id) && $product->id) {
                    $product->quantity = $value['quantity'];
                    $product->save();


                    foreach ($product->destinations as $destination) {
                        if ($destination->pivot->import){
                            $product->destinations()->updateExistingPivot($destination->id, [
                                'upd' => true,
                            ]);
                        }
                    }





                    $ids[] = $value['id_source'];
                }
            }

        }

        return response()->json(
            [
                'status' => 1,
                'message' => 'Quantity updated',
                'action'  => 'upd_quantity',
                'id' 	  => implode(',', $ids),
                'type'    => 'product'
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $id_source   = $request->get('id_source');
        $withTrashed = Product::onlyTrashed()->where('id_source', $id_source)->where('user_id', $request->get('user_id'))->first();
        if ($withTrashed) {
           $withTrashed->restore();
        }
        $product     = Product::where('id_source', $id_source)
            ->where('user_id', $request->get('user_id'))->first();
        $destinations = Destination::where('user_id', $request->get('user_id'))->where('active',1)->get();
        if (count($destinations)){
            if ($product){
                // Επιστροφή του JSON response



                $id   = $product->id;
                $updProduct = Product::updateOrCreate(['id'=> $id], $request->all());
                foreach ($destinations as $destination) {

                    $pivotRecord = DestinationProduct::withTrashed()
                        ->where('product_id', $product->id)
                        ->where('destination_id', $destination->id)
                        ->first();

                    if ($pivotRecord->trashed()) {
                        $pivotRecord->restore();
                        $updProduct->destinations()->updateExistingPivot($destination->id,
                            [
                                'upd' => false,
                                'del' => false,
                                'import' => false
                            ]);
                    }

                    $item = $product->destinations()->where('destination_id', $destination->id)->first();


                    if($item->pivot['import'] && !$item->pivot['del']){
                        $updProduct->destinations()->updateExistingPivot($destination->id, ['upd'=> true]);
                    }else{
                        $updProduct->destinations()->updateExistingPivot($destination->id,
                            [
                                'upd' => false,
                                'del' => false
                            ]);
                    }
                }
                $status = true;
                $action = 'update';
                $message = 'Το προϊόν ενημερώθηκε με επιτυχία';





            } else {


                    $id   = 0;
                    $action = 'new';
                    $status = true;
                    $productNew = Product::updateOrCreate(['id'=> $id], $request->all());

                    if (count($destinations)){
                        foreach ($destinations as $destination){
                            $productNew->destinations()->attach($destination->id);
                        }
                    }
                    $message = 'Το προϊόν δημιουργήθηκε με επιτυχία';

            }

            // Επιστροφή του JSON response
            return response()->json(
                [
                    'status' => $status,
                    'message' => $message,
                    'action'  => $action,
                    'id' 	  => $id_source,
                    'type'    => 'product'
                ]);
        }else{
            // Επιστροφή του JSON response
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Not found destinations',
                    'action'  => 'destinations',
                    'id' 	  => 0,
                    'type'    => 'destination'
                ]);

        }




    }


	public function existInDatabase(Request $request){

        $id_source   = $request->get('id_source');
		$product   = Product::where('id_source',$id_source)
            ->where('user_id',$request->get('user_id'))->first();

		if ($product && isset($product->id) && $product->id){
			$status = true;
            $message = 'Το προϊόν υπάρχει ήδη στη βάση δεδομένων';
		}else{
			$status = false;
            $message = 'Το προϊόν δεν βρέθηκε';
		}

		 return response()->json(
            [
                'status' 	=> $status,
                'action' 		=> 'search_product',
                'message' 	=> $message,
                'id' 		=> $id_source,
                'type'      => 'product'
            ]
        );

	}
    public function exclude(Request $request)
    {
        $id_source = $request->get('id_source');


        $withTrashed = Product::onlyTrashed()->where('id_source', $id_source)
            ->where('user_id', $request->get('user_id'))->first();
        if ($withTrashed) {
            $withTrashed->restore();
        }

        $product   = Product::where('id_source',$id_source)
            ->where('user_id',$request->get('user_id'))->first();
        $destinations = Destination::where('user_id', $request->get('user_id'))->where('active',1)->get();
        if (isset($product->id) && $product->id) {
            if (count($destinations)) {

                foreach ($destinations as $destination) {
                    $item = $product->destinations()->where('destination_id',
                        $destination->id)->first();

                    if ($item->pivot['import']) {
                        $product->destinations()->updateExistingPivot(
                            $item->id, [ 'upd' => false, 'del' => true]
                        );
                    } else {

                        $productDestination =
                            DestinationProduct::where('product_id', $product->id)
                                ->where('destination_id', $destination->id)
                                ->first();
                        $productDestination->delete();

                    }
                }

            }

           // $product->delete();
            $status = true;
            $message = 'Εξαιρείται το προϊόν από ezySoft';
        }else{
            $status = 0;
            $message = 'Το προϊόν δεν βρέθηκε για εξαίρεση';
        }

        return response()->json(
            [
                'status' 	=> $status,
                'action' 		=> 'exclude_product',
                'type'      => 'product',
                'message' 	=> $message,
                'id' 		=> $id_source,
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $id_source = $request->get('id_source');
        $product   = Product::where('id_source',$id_source)
            ->where('user_id',$request->get('user_id'))->first();
        if (isset($product->id) && $product->id ) {
            $destinations = Destination::where('user_id', $request->get('user_id'))->where('active',1)->get();

            if (count($destinations)){
                foreach ($destinations as $destination){
                    $item = $product->destinations()->where('destination_id',
                        $destination->id)->first();

                    if ($item->pivot['import']) {
                        $product->destinations()->updateExistingPivot(
                            $item->id, [ 'upd' => false, 'del' => true]
                        );
                    } else {

                        $productDestination =
                            DestinationProduct::where('product_id', $product->id)
                                ->where('destination_id', $destination->id)
                                ->first();
                        $productDestination->delete();
                        $product->delete();
                    }
                }
            }

            $message = 'Το προϊόν έχει διαγραφεί';
        }else{
            $status = 0;
            $message = 'Το προϊόν δεν βρέθηκε';
        }

        // Επιστροφή του JSON response
        return response()->json(
            [
                'status' 	=> $status,
                'action' 		=> 'delete',
                'type'      => 'product',
                'message' 	=> $message,
                'id' 		=> $id_source,
            ]
        );
    }
    public function listUpdate($id)
    {

        $products = Product::where('user_id', $id)
            ->whereHas('destinations', function ($query) {
                $query->where('upd', true);
            })->paginate(50);


        return response()->json($products->items());
    }

    public function listDelete($id)
    {



        $products = Product::where('user_id', $id)
            ->whereHas('destinations', function ($query) {
                $query->where('del', true);
            })->paginate(50);


        return response()->json($products->items());
    }


    public function listNew($id)
    {

        $products = Product::where('user_id', $id)
            ->whereHas('destinations', function ($query) {
                $query->where('import', 0);
            })->paginate(50);




        return response()->json($products->items());
    }


    /**
     * @param $id
     * @return mixed
     */
    public function listUpdateCount($id)
    {
       return Product::where('imported', true)
            ->where('upd', true)
            ->where('user_id', $id)->count();
    }


    /**
     * @param $id
     * @return mixed
     */
    public function listDeleteCount($id)
    {
        return Product::where('imported', true)
            ->where('delete', true)
            ->where('user_id', $id)->count();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function listNewCount($id)
    {
        return Product::where('imported','=', 0)->where('user_id', $id)->count();
    }


    /**
     * @param Request $request
     * @param $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request, $action)
    {
            $id = $request->get('id');
            $product = Product::find($id);


            if ($product){
                if ($action == 'new'){


                    $product->destinations()->updateExistingPivot(
                        $request->get('id_destination'), [ 'upd' => false, 'del' => false,'import'=> true, 'id_entry'=> $request->get('id_entry')]
                    );


                    $message ='Product has been created';
                }elseif ($action== 'update'){


                    $product->destinations()->updateExistingPivot(
                        $request->get('id_destination'), [ 'upd' => false, 'del' => false,'import'=> true]
                    );

                    $message = 'Product has been updated';
                }elseif ($action=='delete'){
                    $productDestination =
                        DestinationProduct::where('product_id', $product->id)
                            ->where('destination_id', $request->get('id_destination'))
                            ->first();
                    $productDestination->delete();
                    $product->delete();
                    $message = 'Το προϊόν έχει διαγραφεί';
                }

            }else{
                $message = 'Το προϊόν δεν βρέθηκε';
            }
            return response()->json([
               'status' => 200,
                'message' => $message
            ]);
    }

    public function status(Request  $request)
    {
        $id_source = $request->get('id_source');
        $product   = Product::where('id_source',$id_source)
            ->where('user_id',$request->get('user_id'))->first();
        if (isset($product->id) && $product->id) {
            $product->active = $request->get('active');
            $product->save();

            $destinations = Destination::where('user_id', $request->get('user_id'))->where('active',1)->get();

            if (count($destinations)) {
                foreach ($destinations as $destination) {
                    $item = $product->destinations()->where('destination_id', $destination->id)->first();
                    if($item->pivot['import'] && !$item->pivot['del']){
                        $product->destinations()->updateExistingPivot($destination->id, ['upd'=> true]);
                    }else{
                        $product->destinations()->updateExistingPivot($destination->id,
                            [
                                'upd' => false,
                                'del' => false
                            ]);
                    }
                }

            }


            $message = 'Η κατάσταση του προϊόντος ενημερώθηκε με επιτυχία';
            $status = 1;
        }else{
            $message = 'Το προϊόν δεν βρέθηκε';
            $status = 0;
        }
        return response()->json(
            [
                'status' 	=> $status,
                'action' 		=> 'update_status_list',
                'type'      => 'product',
                'message' 	=> $message,
                'id' 		=> $id_source,
            ]
        );
    }
}
