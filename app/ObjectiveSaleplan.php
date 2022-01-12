<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectiveSaleplan extends Model
{
    Protected $table = 'master_objective_saleplans';
    protected $fillable = [
        'masobj_title',
        'deleted_by',
        'deleted_at',
    ];
}
