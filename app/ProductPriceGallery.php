<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPriceGallery extends Model
{
    protected $table = 'product_price_gallery';
    protected $fillable = [
        'product_price_id',
        'image',
        'path',
        'created_by',
        'updated_by',
    ];
}
