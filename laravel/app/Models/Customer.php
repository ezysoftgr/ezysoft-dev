<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'id_source',
        'firstname',
        'lastname',
        'email',
        'address',
        'postcode',
        'city',
        'phone',
        'mobile',
        'active',
        'object',
        'addresses'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
