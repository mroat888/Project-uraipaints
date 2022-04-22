<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsBanner extends Model
{
    Protected $table = 'news_banners';
    protected $fillable = [
        'date',
        'date_last',
        'detail',
        'banner',
        'created_by',
        'updated_by',
    ];
}
