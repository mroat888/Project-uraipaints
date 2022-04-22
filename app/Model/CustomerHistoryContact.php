<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerHistoryContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_shop_id',
        'employee_id',
        'cust_history_detail',
        'created_by',
        'created_by',
        'deleted_by',
    ]; 
}
