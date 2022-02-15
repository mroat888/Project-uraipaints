<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteTag extends Model
{
    Protected $table = 'master_note';
    protected $fillable = [
        'name_tag',
    ];
}
