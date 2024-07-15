<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Cassandra\Custom;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        $id_source  = $request->get('customer')['id_source'];
        $user_id    = $request->get('customer')['user_id'];
        $chker      = Customer::where('id_source', $id_source)->where('user_id',$user_id)->first();


        if (isset($chker->id) && $chker->id){
            $upd = Customer::updateOrCreate(['id'=> $chker->id],  $request->get('customer'));
            $id = $upd->orders()->create($request->get('order'));
        }else{
            $customer = Customer::updateOrCreate(['id'=> 0],  $request->get('customer'));
            $id = $customer->orders()->create( $request->get('order'));
        }

        return response()->json( [
            'status' 	=> 1,
            'action' 		=> 'new_order',
            'type'      => 'order',
            'message' 	=> 'Η παραγγελία δημιουργήθηκε με επιτυχία',
            'id' 		=> $request->get('id_source'),
        ]);

    }
}
