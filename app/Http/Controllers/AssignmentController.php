<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{

    public function index()
    {
        $assignments = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.created_by', Auth::user()->id)
        // ->where('assignments.assign_status', 1)
        ->select('assignments.*', 'users.name')
        ->orderBy('assignments.id', 'desc')->get();

        $users = DB::table('users')
            ->where('team_id', Auth::user()->team_id)
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();

        return view('leadManager.add_assignment', compact('assignments', 'users'));
    }

    public function assignIndex()
    {
        $assignments = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.created_by', Auth::user()->id)
        // ->where('assignments.assign_status', 1)
        ->select('assignments.*', 'users.name')
        ->orderBy('assignments.id', 'desc')->get();

        $users = DB::table('users')->get();

        return view('headManager.add_assignment', compact('assignments', 'users'));
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            $pathFle = 'upload/AssignmentFile';
            $uploadfile = '';
            if (!empty($request->file('assignment_fileupload'))) {
                $uploadF = $request->file('assignment_fileupload');
                $file_name = 'file-' . time() . '.' . $uploadF->getClientOriginalExtension();
                $uploadF->move(public_path($pathFle), $file_name);
                $uploadfile = $file_name;
            }

            foreach ($request->assign_emp_id as $key => $emp_id) {
                DB::table('assignments')
                ->insert([
                    'assign_work_date' => $request->date,
                    // 'assign_request_date' => Carbon::now(), // วันขอนุมัติ
                    'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
                    'assign_title' => $request->assign_title,
                    'assign_detail' => $request->assign_detail,
                    'assign_fileupload' => $uploadfile,
                    'assign_emp_id' => $emp_id,
                    'assign_status' => 1,
                    'assign_approve_id' => Auth::user()->id,
                    'assign_result_status' => 0,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
            }

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

    public function store_head(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            $pathFle = 'upload/AssignmentFile';
            $uploadfile = '';
            if (!empty($request->file('assignment_fileupload'))) {
                $uploadF = $request->file('assignment_fileupload');
                $file_name = 'file-' . time() . '.' . $uploadF->getClientOriginalExtension();
                $uploadF->move(public_path($pathFle), $file_name);
                $uploadfile = $file_name;
            }

            foreach ($request->assign_emp_id as $key => $emp_id) {
                DB::table('assignments')
                ->insert([
                    'assign_work_date' => $request->date,
                    // 'assign_request_date' => Carbon::now(), // วันขอนุมัติ
                    'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
                    'assign_title' => $request->assign_title,
                    'assign_detail' => $request->assign_detail,
                    'assign_fileupload' => $uploadfile,
                    'assign_emp_id' => $emp_id,
                    'assign_status' => 1,
                    'assign_approve_id' => Auth::user()->id,
                    'assign_result_status' => 0,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
            }

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

    public function edit($id)
    {
        $dataEdit = Assignment::find($id);
        // $dataUser = DB::table('users')->get();
        $dataUser = DB::table('users')
            ->where('team_id', Auth::user()->team_id)
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();

        $data = array(
            'dataEdit'  => $dataEdit,
            'dataUser'  => $dataUser,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            DB::table('assignments')->where('id',$request->id)
            ->update([
                'assign_work_date' => $request->date,
                'assign_title' => $request->assign_title,
                'assign_detail' => $request->assign_detail,
                'assign_emp_id' => $request->assign_emp_id_edit,
                'assign_status' => 1,
                'assign_approve_id' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }

    }

    public function destroy($id)
    {
        $data = Assignment::where('id', $id)->first();
            if (!empty($data->assign_fileupload)) {
                $path2 = 'public/upload/AssignmentFile/';
                unlink($path2 . $data->assign_fileupload);
            }

        Assignment::where('id', $id)->delete();
        return back();
    }

    // public function assignment_result_get($id)
    // {
    //     $dataResult = Assignment::where('id', $id)->first();


    // $data = array(
    //     'dataResult'     => $dataResult,
    // );
    // echo json_encode($data);

    // }

}
