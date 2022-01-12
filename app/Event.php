<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    Protected $table = 'events';
    protected $fillable = [
        'title',
        'start',
        'end',
    ];
}
