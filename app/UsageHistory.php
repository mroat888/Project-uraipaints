<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsageHistory extends Model
{

    Protected $table = 'usage_history';
    protected $fillable = [
        'emp_id',
        'date',
    ];
}
