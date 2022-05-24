<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductNewGallery extends Model
{
    Protected $table = 'product_new_gallery';
    protected $fillable = [
        'product_new_id',
        'image',
        'path',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
