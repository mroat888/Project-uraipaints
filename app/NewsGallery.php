<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsGallery extends Model
{
    Protected $table = 'news_gallerys';
    protected $fillable = [
        'news_id',
        'image',
        'path',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
