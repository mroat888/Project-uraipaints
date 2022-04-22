<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentComment extends Model
{
    Protected $table = 'assignments_comments';
    protected $fillable = [
        'assign_id',
        'assign_comment_detail',
        'created_by',
        'updated_by',
    ];
}
