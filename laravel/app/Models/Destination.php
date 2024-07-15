<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'destination_url_conn',
        'destination_url',
        'user_id',
        'active',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'destination_product')->withPivot(
            'id_entry','import','upd','del','exclude'
        )->withTimestamps();
    }
}
