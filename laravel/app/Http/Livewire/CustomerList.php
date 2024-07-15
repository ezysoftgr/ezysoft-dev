<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    public $search;
    use WithPagination;
    public function render()
    {
        $search = '%'.$this->search.'%';
        $user = Auth::user();

        return view('livewire.customers.index'
            ,[
                'customers' => Customer::where('user_id',$user->id)
                    ->where(function ($query) use ($search) {
                        $query->where('firstname', "like", $search);
                        $query->orWhere('lastname', "like",$search);
                        $query->orWhere('email', "like",$search);
                        $query->orWhere('phone', "like",$search);
                        $query->orWhere('mobile', "like",$search);
                    })
                    ->paginate(5),
                'count'         => Customer::where('user_id',$user->id)->count()
            ]);
    }
}
