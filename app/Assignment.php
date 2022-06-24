<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    Protected $table = 'assignments';
    protected $fillable = [
        'assign_work_date',
        'assign_request_date',
        'assign_approve_date',
        'assign_title',
        'assign_detail',
        'assign_fileupload',
        'approved_for',
        'assign_emp_id',
        'assign_approve_id',
        'assign_is_hot',
        'assign_status',
        'assign_result_detail',
        'assign_result_fileupload',
        'assign_result_status',
        'assignment_status',
        'assign_status_actoin',
        'assign_shop',
        'parent_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
