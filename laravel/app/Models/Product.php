<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';
	protected $fillable = [
		'id_source',
        'name',
        'reference',
        'price',
        'mpn',
        'ean',
        'name',
        'description',
        'description_short',
        'id_lang',
        'manufacturer',
        'images',
        'default_image',
        'user_id',
        'category_full_path',
        'id_category_default',
        'quantity',
        'skroutz_price',
        'shopflix_price',
        'available_now',
		'wholesale_price',
        'meta_description',
        'meta_title',
        'features',
        'active',
		'category_name_default',
		'categories_ids',
        'has_image',
        'has_features'


    ];

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_product')->withPivot(
            'id_entry','import','upd','del','exclude'
        )->withTimestamps();
    }
}
