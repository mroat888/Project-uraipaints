<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerVisit extends Model
{
    Protected $table = 'customer_visits';
    protected $fillable = [
        'monthly_plan_id',
        'customer_shop_id',
        'customer_visit_date',
        'customer_visit_tags',
        'customer_visit_objective',
        'created_by',
        'updated_by',
    ];
}
