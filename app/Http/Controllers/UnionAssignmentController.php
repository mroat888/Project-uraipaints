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

    public function assignment_result_get($id){
        $dataResult = DB::table('assignments')->where('id', $id)->first();
        $emp_approve = DB::table('users')
        ->where('id', $dataResult->assign_approve_id)
        ->first();

        return response()->json([
            'dataResult' => $dataResult,
            'emp_approve' => $emp_approve
        ]);
    }

    public function saleplan_result(Request $request){ // สรุปผลลัพธ์
        // dd($request);
        DB::beginTransaction();
        try {

            $pathFle = 'upload/AssignmentFile';
            $uploadfile = '';
            if (!empty($request->file('assign_result_fileupload'))) {
                $uploadF = $request->file('assign_result_fileupload');
                $file_name = 'file-' . time() . '.' . $uploadF->getClientOriginalExtension();
                $uploadF->move(public_path($pathFle), $file_name);
                $uploadfile = $file_name;
            }

            DB::table('assignments')->where('id', $request->assign_id)
            ->update([
                'assign_result_detail' => $request->assign_result_detail,
                'assign_result_status' => $request->assign_result_status,
                'assign_result_fileupload' => $uploadfile,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                'data' => $uploadfile,
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
                'data' => $request,
            ]);
        }
    }
}
