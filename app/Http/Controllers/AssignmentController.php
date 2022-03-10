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
        ->orWhere('assignments.assign_approve_id', Auth::user()->id)
        ->where('assignments.assign_status', 3) // สถานะการอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน)
        ->select('assignments.*', 'users.name')
        ->orderBy('assignments.id', 'desc')->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $users = DB::table('users')
            // ->where('team_id', Auth::user()->team_id)
            ->where('status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
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

            $auth_team_id = explode(',',Auth::user()->team_id);
            $auth_team = array();
            foreach($auth_team_id as $value){
                $auth_team[] = $value;
            }

            $users = DB::table('users')
                // ->where('team_id', Auth::user()->team_id)
                ->where('status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
                ->where(function($query) use ($auth_team) {
                    for ($i = 0; $i < count($auth_team); $i++){
                        $query->orWhere('team_id', $auth_team[$i])
                            ->orWhere('team_id', 'like', $auth_team[$i].',%')
                            ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                    }
                })
                ->get();

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
                    'assign_status' => 3,
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
                    'assign_status' => 3,
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

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $dataUser = DB::table('users')
            // ->where('team_id', Auth::user()->team_id)
            ->where('status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();


        $data = array(
            'dataEdit'  => $dataEdit,
            'dataUser'  => $dataUser,
        );
        // dd($data);

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
                'assign_status' => 3,
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

    public function lead_search_month_add_assignment(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $assignments = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.created_by', Auth::user()->id)
        ->where('assignments.assign_status', 3)
        ->whereDate('assignments.assign_work_date', '>=', $from)
        ->whereDate('assignments.assign_work_date', '<=', $to)
        ->orderBy('assignments.id', 'desc')
        ->select('assignments.*', 'users.name')->get();

        $users = DB::table('users')
            ->where('team_id', Auth::user()->team_id)
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();

        return view('leadManager.add_assignment', compact('assignments', 'users'));
    }

    public function head_search_month_add_assignment(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $assignments = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.created_by', Auth::user()->id)
        ->where('assignments.assign_status', 3)
        ->whereDate('assignments.assign_work_date', '>=', $from)
        ->whereDate('assignments.assign_work_date', '<=', $to)
        ->orderBy('assignments.id', 'desc')
        ->select('assignments.*', 'users.name')->get();

        $users = DB::table('users')
            ->where('team_id', Auth::user()->team_id)
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();

        return view('headManager.add_assignment', compact('assignments', 'users'));
    }

}
