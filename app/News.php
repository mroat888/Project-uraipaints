<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    Protected $table = 'news_promotions';
    protected $fillable = [
        'news_date',
        'news_date_last',
        'news_title',
        'ref_number',
        'news_detail',
        'news_tags',
        'news_image',
        'url',
        'status_promotion',
        'status_pin',
        'status',
        'status_share',
        'status_usage',
        'created_by',
        'updated_by',
    ];
}
