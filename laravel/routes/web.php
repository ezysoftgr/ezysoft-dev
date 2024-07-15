<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', \App\Http\Livewire\Dashboard::class)->name('dashboard');
    Route::get('products', \App\Http\Livewire\ProductList::class)->name('products');
    Route::get('customers', \App\Http\Livewire\CustomerList::class)->name('customers');
    Route::get('orders', \App\Http\Livewire\OrderList::class)->name('orders');
    Route::get('destinations', \App\Http\Livewire\DestinationList::class)->name('destinations');

});
