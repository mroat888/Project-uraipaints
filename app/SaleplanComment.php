<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleplanComment extends Model
{
    Protected $table = 'sale_plan_comments';
    protected $fillable = [
        'saleplan_id',
        'saleplan_comment_detail',
        'created_by',
        'updated_by',
    ];
}
