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
        $assignments = DB::table('assignments')
            ->join('users', 'assignments.assign_emp_id', 'users.id')
            ->where('assignments.created_by', Auth::user()->id)
            ->select('assignments.*', 'users.name')
            ->orderBy('assignments.id', 'desc')
            ->get();
        
        $managers = DB::table('users')->where('status', 2)->get();
        return view('admin.add_assignment', compact('managers', 'assignments'));
    }

    public function fetch_user($id){
        $users = DB::table('users')->where('id', $id)->first();
        $saleman = DB::table('users')->where('status', 1)->where('team_id', $users->team_id)->get();
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
                     // 'assign_request_date' => Carbon::now(), // วันขอนุมัติ
                     'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
                     'assign_title' => $request->assign_title,
                     'assign_detail' => $request->assign_detail,
                     'assign_fileupload' => $uploadfile,
                     'assign_emp_id' => $emp_id,
                     'assign_status' => 3,
                     'assign_approve_id' => $request->assign_manager,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataEdit = Assignment::find($id);
        $dataManager = DB::table('users')->where('status',2)->get();
        $users_team = DB::table('users')->where('id',$dataEdit->assign_approve_id)->first();
        $dataUser = DB::table('users')
            ->where('team_id', $users_team->team_id)
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();

        $data = array(
            'dataEdit'  => $dataEdit,
            'dataUser'  => $dataUser,
            'dataManager' => $dataManager,
        );
        echo json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
