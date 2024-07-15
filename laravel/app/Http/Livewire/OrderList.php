<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{ public $search;

    use WithPagination;
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
