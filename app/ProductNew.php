<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductNew extends Model
{
    protected $table = 'product_new';
    protected $fillable = [
        'product_title',
        'product_detail',
        'product_url',
        'product_image',
        'product_status',
        'status_usage',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
