<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectiveAssign extends Model
{
    Protected $table = 'master_objective_assigns';
    protected $fillable = [
        'masassign_title',
        'deleted_by',
        'deleted_at',
    ];
}
