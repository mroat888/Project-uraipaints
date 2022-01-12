<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    Protected $table = 'notes';
    protected $fillable = [
        'note_date',
        'note_title',
        'note_detail',
        'note_tags',
    ];
}
