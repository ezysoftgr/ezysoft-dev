<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_source',
        'user_id',
        'reference',
        'product_list',
        'payment',
        'customer_id',
        'carrier',
        'id_carrier',
        'total_paid',
        'total_paid_tax_incl',
        'total_paid_tax_excl',
        'total_paid_real',
        'total_products',
        'total_shipping',
        'codfee',
        'voucher',
        'order_object',
        'histories',
        'order_payments',
        'current_state',
        'invoices_collection',
        'order_details_list',
        'message',
        'current_state',
        'note'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function countProducts()
    {
        if (!empty($this->product_list)){
            $decodeJson = json_decode($this->product_list);
            return count($decodeJson);
        }

        return  0;
    }
}
