<?php

namespace App\Http\Livewire;


use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Order;

class OrderList extends Component
{
    public $search;
    public function render()
    {
        $search = '%'.$this->search.'%';
        $user = Auth::user();

        return view('livewire.orders.index',[
            'orders' => Order::where('reference','like',$search)->where('user_id',$user->id)->paginate(5),
            'count'         => Order::where('user_id',$user->id)->count()
        ]);
    }
}
