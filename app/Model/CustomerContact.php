<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_contact_name',
        'customer_contact_phone',
        'created_by',
        'updated_by',
        'deleted_by',
    ];  
}
