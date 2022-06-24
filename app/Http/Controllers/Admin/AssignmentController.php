<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Assignment;
use App\Assignment_gallery;
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
        DB::beginTransaction();
        try {

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }


            // if (!empty($request->file('assignment_fileupload'))) {
            //     $uploadF = $request->file('assignment_fileupload');
            //     $file_name = 'file-' . time() . '.' . $uploadF->getClientOriginalExtension();
            //     $uploadF->move(public_path($pathFle), $file_name);
            //     $uploadfile = $file_name;
            // }

            if ($request->CheckAll) {
            $data['users'] = DB::table('users')
            ->where('status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

            foreach ($data['users'] as $key => $emp_id) {
             $data = Assignment::create(
                [
                    'assign_work_date' => $request->date,
                    // 'assign_request_date' => Carbon::now(), // วันขอนุมัติ
                    'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
                    'assign_title' => $request->assign_title,
                    'assign_detail' => $request->assign_detail,
                    'assign_emp_id' => $emp_id->id,
                    'assign_status' => 3,
                    'assign_approve_id' => Auth::user()->id,
                    'assign_result_status' => 0,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ])->id;

                $assignments_id[$key] = [
                    'id' => $data,
                ];

            }

            $gallery = array();
            foreach ($request->assignment_fileupload as $key => $gallery) {
                $pathFle = 'upload/AssignmentFile';
                $uploadfile = '';
                if (!empty($request->assignment_fileupload[$key])) {
                    $img = $request->assignment_fileupload[$key];
                    $img_name = 'file-' . time(). $key. '.' . $img->getClientOriginalExtension();
                    $save_path = $img->move(public_path($pathFle), $img_name);
                    $uploadfile = $img_name;

                }
                $gallery_file[$key] = [
                    'img' => $uploadfile,
                ];
            }

            // dd($gallery_file);

            foreach ($assignments_id as $keyID => $a)
            {
                foreach ($gallery_file as $keyG => $g)
                {
                    Assignment_gallery::insert([
                        'assignment_id' => $assignments_id[$keyID]['id'],
                        'image' => $gallery_file[$keyG]['img'],
                        'status' => $keyG,
                        'created_by'   => Auth::user()->id,
                    ]);
                }
            }

            }else{
                $assignments_id = array();
                foreach ($request->assign_emp_id as $key => $emp_id) {
                  $data = Assignment::create([
                        'assign_work_date' => $request->date,
                        // 'assign_request_date' => Carbon::now(), // วันขอนุมัติ
                        'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
                        'assign_title' => $request->assign_title,
                        'assign_detail' => $request->assign_detail,
                        'assign_emp_id' => $emp_id,
                        'assign_status' => 3,
                        'assign_approve_id' => Auth::user()->id,
                        'assign_result_status' => 0,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                    ])->id;

                    $assignments_id[$key] = [
                        'id' => $data,
                    ];

                }

                $gallery = array();
                    foreach ($request->assignment_fileupload as $key => $gallery) {
                        $pathFle = 'upload/AssignmentFile';
                        $uploadfile = '';
                        if (!empty($request->assignment_fileupload[$key])) {
                            $img = $request->assignment_fileupload[$key];
                            $img_name = 'file-' . time(). $key. '.' . $img->getClientOriginalExtension();
                            $save_path = $img->move(public_path($pathFle), $img_name);
                            $uploadfile = $img_name;

                        }
                        $gallery_file[$key] = [
                            'img' => $uploadfile,
                        ];
                    }

                    // dd($gallery_file);

                    foreach ($assignments_id as $keyID => $a)
                    {
                        foreach ($gallery_file as $keyG => $g)
                        {
                            Assignment_gallery::insert([
                                'assignment_id' => $assignments_id[$keyID]['id'],
                                'image' => $gallery_file[$keyG]['img'],
                                'status' => $keyG,
                                'created_by'   => Auth::user()->id,
                            ]);
                        }
                    }


            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                'data' => $request,
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

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = Assignment::where('id', $request->assign_id_delete)->first();
            if (!empty($data->assign_fileupload)) {
                $path2 = 'public/upload/AssignmentFile/';
                unlink($path2 . $data->assign_fileupload);
            }

            $data2 = Assignment_gallery::where('assignment_id', $request->assign_id_delete)->first();
            if (!empty($data2->image)) {
                $path1 = 'public/upload/AssignmentFile/';
                unlink($path1 . $data2->image);

            Assignment_gallery::where('assignment_id', $data->id)->delete();

            }


        Assignment::where('id', $request->assign_id_delete)->delete();
        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
        ]);
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

    public function file_store(Request $request)
    {
        // dd($request->assignment_gallery);
        DB::beginTransaction();
        try {

        foreach ($request->assignment_gallery as $key => $gallery) {

            $path = 'upload/AssignmentFile';
            $image = '';
            $img_name = '';
            $img = '';
            if (!empty($request->assignment_gallery[$key])) {
                $img = $request->assignment_gallery[$key];
                $img_name = 'file-' . time(). $key. '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;

            }

            Assignment_gallery::insert([
                'assignment_id' => $request->assignment_id,
                'image' => $image,
                'status' => $key,
                'created_by'   => Auth::user()->id,
            ]);

        }
        // return back();

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                // 'data' => $img_name,
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
                // 'data' => $request,
            ]);
        }
    }

    public function file_edit($id)
    {
        $dataEdit = Assignment_gallery::find($id);

        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function file_update(Request $request)
    {
            $path = 'upload/AssignmentFile';
            $image = '';
            $data = Assignment_gallery::find($request->id);

            if (!empty($request->file('assignment_gallery'))) {
                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->image)) {
                    $path2 = 'upload/AssignmentFile/';
                    unlink(public_path($path2) . $data->image);
                }

                $img = $request->file('assignment_gallery');
                $img_name = 'file-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;


                $data2 = Assignment_gallery::find($request->id);
                $data2->image             = $image;
                $data2->updated_by        = Auth::user()->id;
                $data2->updated_at        = Carbon::now();
                $data2->update();
                DB::commit();
            }

        return back();
    }

    public function file_destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = Assignment_gallery::find($request->assignment_id_delete);
            if (!empty($data->image)) {
                $path1 = 'public/upload/AssignmentFile/';
                unlink($path1 . $data->image);
            }

            Assignment_gallery::find($request->assignment_id_delete)->delete();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
        ]);
    }
}
