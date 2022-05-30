<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Assignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{

    public function index()
    {
        $data['assignments'] = DB::table('assignments')
            ->join('users', 'assignments.assign_emp_id', 'users.id')
            ->where('assignments.created_by', Auth::user()->id)
            ->select('assignments.*', 'users.name')
            ->orderBy('assignments.id', 'desc')->get();

            $data['team_sales'] = DB::table('master_team_sales')->get();
            $data['users'] = DB::table('users')->whereNotIn('id', [Auth::user()->id])->get();

            $data['managers'] = DB::table('users')->where('status', 2)->get();

        return view('admin.add_assignment', $data);
    }

    // public function fetch_user($id){
    //         $users = DB::table('users')->where('id', $id)->first();

    //     $auth_team_id = explode(',',$users->team_id);
    //     $auth_team = array();
    //     foreach($auth_team_id as $value){
    //         $auth_team[] = $value;
    //     }

    //     $saleman = DB::table('users')
    //     ->where('status', 1)
    //     ->where(function($query) use ($auth_team) {
    //         for ($i = 0; $i < count($auth_team); $i++){
    //             $query->orWhere('users.team_id', $auth_team[$i])
    //                 ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
    //                 ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
    //         }
    //     })
    //     ->get();


    //     return response()->json([
    //         'status' => 200,
    //         'saleman' => $saleman
    //     ]);
    // }

    public function fetch_user(){

        $saleman = DB::table('users')->whereNotIn('id', [Auth::user()->id])->get();

        return response()->json([
            'status' => 200,
            'saleman' => $saleman
        ]);
    }


    public function searchselect(Request $request)
    {
        if ($request->ajax()) {

            // $knowledges = DB::table('users')->orderBy('id', 'desc')->get();
            $teams = DB::table('users')->where('team_id', $request->visit_result_status)->orderBy('id', 'desc')->get();
            // $url = 'public/upload/Knowledge/';
            $output = '';

            if ($request->visit_result_status == '') {
                $output .= '<button type="submit" class="btn btn-primary">บันทึก</button>';
            }else{
                foreach ($teams as $value) {

                    $output .=
                    '
                        <option value="'.$value->id .'">'.$value->name.'</option>
               ';
            }
        }
            return $output;
        }
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
        $users_team = DB::table('users')->where('id',$dataEdit->assign_approve_id)->first();

        $dataUser = DB::table('users')->whereNotIn('id', [Auth::user()->id])->get();

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
                'assign_detail' => $request->assign_detail_edit,
                'assign_emp_id' => $request->assign_emp_id_edit,
                'assign_status' => 3,
                'assign_approve_id' => $request->get_manager,
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

    public function update_status_result(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            DB::table('assignments')->where('id',$request->id)
            ->update([
                'assign_result_status' => $request->result_send,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
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
        DB::beginTransaction();
        try {
            $data = Assignment::where('id', $id)->first();
                if (!empty($data->assign_fileupload)) {
                    $path2 = 'public/upload/AssignmentFile/';
                    unlink($path2 . $data->assign_fileupload);
                }

            Assignment::where('id', $id)->delete();

            DB::commit();
            return back();

        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function search(Request $request)
    {
        // dd($request);

        $data['assignments'] = DB::table('assignments')->join('users', 'assignments.assign_emp_id', 'users.id')
            ->whereIn('assignments.assign_status', [3])
            ->where('assignments.created_by', Auth::user()->id);

            if(!is_null($request->select_status)){ //-- สถานะ
                $data['assignments'] = $data['assignments']
                    ->where('assignments.assign_result_status', $request->select_status);
                $data['select_status'] = $request->select_status;
            }


            if(!is_null($request->selectusers)){ //-- ผู้แทนขาย
                $data['assignments'] = $data['assignments']
                    ->where('users.id', $request->selectusers);
                $data['selectusers'] = $request->selectusers;
            }

            if(!is_null($request->selectteam_sales)){ //-- ทีมขาย
                $team = $request->selectteam_sales;
                $data['assignments'] = $data['assignments']
                    ->where(function($query) use ($team) {
                        $query->orWhere('users.team_id', $team)
                            ->orWhere('users.team_id', 'like', $team.',%')
                            ->orWhere('users.team_id', 'like', '%,'.$team);
                    });
                $data['selectteam_sales'] = $request->selectteam_sales;
            }

            if(!is_null($request->selectdateTo)){ //-- วันที่
                list($year,$month) = explode('-', $request->selectdateTo);
                $data['assignments'] = $data['assignments']->whereYear('assignments.created_at',$year)
                ->whereMonth('assignments.created_at', $month);
                $data['date_filter'] = $request->selectdateTo;
            }

            $data['assignments'] = $data['assignments']
            ->select('assignments.*', 'users.name')
            ->orderBy('assignments.id', 'desc')->get();

            $data['team_sales'] = DB::table('master_team_sales')->get();
            $data['users'] = DB::table('users')->whereNotIn('id', [Auth::user()->id])->get();

            $data['managers'] = DB::table('users')->where('status', 2)->get();

        return view('admin.add_assignment', $data);
    }
}
