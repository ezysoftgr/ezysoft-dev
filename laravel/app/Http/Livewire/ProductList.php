<?php

namespace App\Http\Livewire;

use App\Models\DestinationProduct;
use Livewire\Component;
use App\Models\Product;
use App\Models\Store;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

use App\Models\Destination;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\Translation\t;

class ProductList extends Component
{
    use withPagination;
    public $search='';
    public $show_destination=0;
    public $destinations;
    public $selectedItems = [];
    public $id_model;
    protected $listeners = ['refresh'];
    public $action;
    public $messages = [];
    public $type=0;

    public function render()
    {
        $search = '%'.$this->search.'%';
        $user = Auth::user();
        return view('livewire.catalog.products.index',[
            'count'         => Product::where('user_id','=', $user->id)->count(),
            'products'      =>  Product::where('user_id',$user->id)
                ->where(function ($query) use ($search) {
                    $query->where('name', "like", $search);
                    $query->orWhere('reference', "like",$search);
                    $query->orWhere('ean', "like",$search);
                    $query->orWhere('mpn', "like",$search);
                    $query->orWhere('id_source', "like",$search);

                })->where(function ($query) use ($search) {
                    if ($this->type == 1){
                        $query->whereHas('destinations', function($pivotQuery) use ($search) {
                            $pivotQuery->where('import', 0);
                        });
                    }elseif ($this->type ==2){
                        $query->whereHas('destinations', function($pivotQuery) use ($search) {
                            $pivotQuery->where('upd', 1);
                        });
                    }elseif ($this->type ==3){
                        $query->whereHas('destinations', function($pivotQuery) use ($search) {
                            $pivotQuery->where('del', 1);
                        });
                    }
                })
                ->paginate(6),
            'destinations'  => Destination::where('user_id',$user->id)->count()
        ]);
    }



    public function toDestination($id, $action)
    {
        $this->show_destination = true;
        $this->id_model = $id;
        $this->action = $action;
        $product = Product::find($this->id_model);



        $this->destinations = $product->destinations;
    }

    public function store()
    {
        $this->validate([
            'selectedItems'   => 'required',
        ]);



        $product = Product::find($this->id_model);
        $destinations = $product->destinations()->whereIn('destination_id',
            $this->selectedItems)->get();

        foreach ($destinations as $destination) {


            if (!$destination->pivot->import){
                $products = $product->toArray();
                $products['action'] = 'new';
                $response =  $this->post($destination->destination_url,$products);
                $this->addList($destination->id, $response['response']['id']);
            }elseif($destination->pivot->upd){
                $products = $product->toArray();
                $products['action'] = 'update';
                $response =  $this->post($destination->destination_url,$products);

                $this->updateList($destination->id);
            }elseif ($destination->pivot->del){
                $products = $product->toArray();
                $products['action'] = 'delete';
                $response =  $this->post($destination->destination_url,$products);
                $this->deleteList($destination->id);
            }else{
                $response['response']['status'] = 200;
                $response['response']['message'] = 'Το κατάστημά σας είναι πλήρως ενημερωμένο.';
            }
        }

            $this->messages[$destination->id] = [
                'status' => $response['response']['status'],
                'message' => $response['response']['message'],
                'complete' => true
            ];
        }



        //$this->close();


    public function addList($id_destination, $id_entry)
    {
        $product = Product::find($this->id_model);
        $product->destinations()->updateExistingPivot($id_destination,
            [
                'upd' => false,
                'del' => false,
                'import' => true,
                'id_entry' => $id_entry
            ]);

    }

    public function updateList($id_destination)
    {
        $product = Product::find($this->id_model);
        $product->destinations()->updateExistingPivot($id_destination,
            [
                'upd' => false,
                'del' => false,
                'import' => true,

            ]);
    }
    public function deleteList($destination_id)
    {
        $product = Product::find($this->id_model);
        $productDestination =
            DestinationProduct::where('product_id', $product->id)
                ->where('destination_id', $destination_id)
                ->first();
        $productDestination->delete();
        $product->delete();
    }

    public function close()
    {        $this->show_destination = false;
        $this->selectedItems = [];

        $this->messages = [];
        $this->resetErrorBag();
    }


    private function request($method, $endpoint, $data = []) {


        $url = $endpoint;


        $curl = curl_init($url);

        switch ($method) {
            case 'GET':
                if (!empty($data)) {
                    $url .= '?' . http_build_query($data);
                }
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            default:
                throw new Exception('Invalid HTTP method');
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
         'Content-Type:application/json'
        ]);
        ;

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }

        curl_close($curl);

        return ['code' => $httpCode, 'response' => json_decode($response, true)];
    }

    public function post($endpoint, $data = []) {
        return $this->request('POST', $endpoint, $data);
    }

    public function clear()
    {
        $this->type = 0;
    }

}
