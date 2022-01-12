<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerShop extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_name',
        'shop_address',
        'shop_province_id',
        'shop_amphur_id',
        'shop_district_id',
        'shop_zipcode',
        'shop_profile_image',
        'shop_fileupload',
        'shop_status',
        'employee_id',
        'created_by',
        'created_by',
        'deleted_by',
    ]; 
}
