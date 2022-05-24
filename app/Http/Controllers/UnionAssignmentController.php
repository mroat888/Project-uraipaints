<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnionAssignmentController extends Controller
{
    public function commentshow ($id){
        // $request_comment = AssignmentComment::where('assign_id', $id)->get();
        // $dataResult = Assignment::leftjoin('master_objective_assigns', 'master_objective_assigns.id', 'assignments.approved_for')
        // ->where('assignments.id', $id)
        // ->first();

        $request_comment = DB::table('assignments_comments')->where('assign_id', $id)->get();
        $dataResult = DB::table('assignments')
            ->leftJoin('master_objective_assigns', 'master_objective_assigns.id', 'assignments.approved_for')
            ->where('assignments.id', $id)
            ->first();

        $dataassign = array();
        $dataassign = [
            'assign_detail' => $dataResult->assign_detail,
            'assign_title' => $dataResult->assign_title,
            'assign_work_date' => $dataResult->assign_work_date,
            'masassign_title' => $dataResult->masassign_title,
            'assign_status' => $dataResult->assign_status,
        ];

        $comment = array();
        foreach ($request_comment as $key => $value) {
            $users = DB::table('users')->where('id', $value->created_by)->first();
            $date_comment = substr($value->created_at, 0, 10);
            $comment[$key] =
                [
                    'assign_comment_detail' => $value->assign_comment_detail,
                    'user_comment' => $users->name,
                    'created_at' => $date_comment,
                ];
        }

        return response()->json([
            'comment' => $comment,
            'dataassign' => $dataassign
        ]);

    }
}
