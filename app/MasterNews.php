<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterNews extends Model
{
    Protected $table = 'master_news';
    protected $fillable = [
        'name_tag',
        'created_by'
    ];
}
