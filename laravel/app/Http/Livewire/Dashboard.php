<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        $listImport  = Product::whereHas('destinations', function($query) {
            $query->where('import', 0);
        })->count();

        $listUpdate  = Product::whereHas('destinations', function($query) {
            $query->where('upd', 1);
        })->count();

        $listDelete  = Product::whereHas('destinations', function($query) {
            $query->where('del', 1);
        })->count();


        return view('livewire.dashboard',
            [

                'user' => $user,
                'listImport' => $listImport,
                'listUpdate' =>  $listUpdate,
                'listDelete' =>  $listDelete,
            ]);
    }
}
