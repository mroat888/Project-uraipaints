<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerShopComment extends Model
{
    protected $table = 'customer_shop_comments';
    protected $fillable = [
        'customer_id',
        'customer_comment_detail',
        'created_by',
        'updated_by',
    ];
}
