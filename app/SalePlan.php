<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalePlan extends Model
{
    Protected $table = 'sale_plans';
    protected $fillable = [
        'customer_shop_id',
        'sale_plans_title',
        'sale_plans_date',
        'sale_plans_tags',
        'sale_plans_objective',
        'sale_plans_approve_id	',
        'status_result',
        'sale_plans_status',
        'created_by',
        'updated_by',
    ];
}
