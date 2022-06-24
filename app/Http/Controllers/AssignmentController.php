<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;
use App\Assignment_gallery;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{

    public function index()
    {
        $data['assignments'] = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.created_by', Auth::user()->id)
        ->where('assignments.assign_status', 3)
        ->select('assignments.*', 'users.name')
        ->orderBy('assignments.id', 'desc')->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['users'] = DB::table('users')
        // ->where('team_id', Auth::user()->team_id)
        ->whereIn('status', [1]) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        ->where(function($query) use ($auth_team) {
            for ($i = 0; $i < count($auth_team); $i++){
                $query->orWhere('team_id', $auth_team[$i])
                    ->orWhere('team_id', 'like', $auth_team[$i].',%')
                    ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
            }
        })->get();

    $data['team_sales'] = DB::table('master_team_sales')
    ->where(function($query) use ($auth_team) {
        for ($i = 0; $i < count($auth_team); $i++){
            $query->orWhere('id', $auth_team[$i])
                ->orWhere('id', 'like', $auth_team[$i].',%')
                ->orWhere('id', 'like', '%,'.$auth_team[$i]);
        }
    })->get();

    $team_sales =  DB::table('master_team_sales')
    ->where(function($query) use ($auth_team) {
        for ($i = 0; $i < count($auth_team); $i++){
            $query->orWhere('id', $auth_team[$i])
                ->orWhere('id', 'like', $auth_team[$i].',%')
                ->orWhere('id', 'like', '%,'.$auth_team[$i]);
        }
    })
    ->get();

        return view('leadManager.add_assignment', $data);
    }

    public function assignIndex()
    {
        $data['assignments'] = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.created_by', Auth::user()->id)
        ->where('assignments.assign_status', 3)
        ->select('assignments.*', 'users.name')
        ->orderBy('assignments.id', 'desc')->get();

            $auth_team_id = explode(',',Auth::user()->team_id);
            $auth_team = array();
            foreach($auth_team_id as $value){
                $auth_team[] = $value;
            }

            $data['users'] = DB::table('users')
                // ->where('team_id', Auth::user()->team_id)
                ->whereIn('status', [1, 2]) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
                ->where(function($query) use ($auth_team) {
                    for ($i = 0; $i < count($auth_team); $i++){
                        $query->orWhere('team_id', $auth_team[$i])
                            ->orWhere('team_id', 'like', $auth_team[$i].',%')
                            ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                    }
                })->get();

            $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })->get();

        return view('headManager.add_assignment', $data);
    }

    public function get_assign()
    {
        $assignments = Assignment::where('assign_emp_id', Auth::user()->id)
        ->where('assign_status', 3)
        ->orderBy('id', 'desc')
        ->get();

        if (Auth::user()->status == 2) {
            return view('leadManager.get_assignment', compact('assignments'));
        }elseif (Auth::user()->status == 3) {
            return view('headManager.get_assignment', compact('assignments'));
        }

    }

    public function store(Request $request)
    {
        // dd($request);
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

    public function store_head(Request $request)
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

            $pathFle = 'upload/AssignmentFile';
            $uploadfile = '';
            if (!empty($request->file('assignment_fileupload_update'))) {
                $uploadF = $request->file('assignment_fileupload_update');
                $file_name = 'file-' . time() . '.' . $uploadF->getClientOriginalExtension();
                $uploadF->move(public_path($pathFle), $file_name);
                $uploadfile = $file_name;
            }

            if ($uploadfile != '') {
                DB::table('assignments')->where('id',$request->id)
            ->update([
                'assign_work_date' => $request->date,
                'assign_title' => $request->assign_title,
                'assign_detail' => $request->assign_detail,
                'assign_emp_id' => $request->assign_emp_id_edit,
                'assign_fileupload' => $uploadfile,
                'assign_status' => 3,
                'assign_approve_id' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
            }else{
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
            }

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

    public function lead_search_month_add_assignment(Request $request)
    {
        // dd($request);
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['assignments'] = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.created_by', Auth::user()->id)
        ->where('assignments.assign_status', 3);

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

        if(!is_null($request->selectusers)){ //-- ผู้แทนขาย
            $data['assignments'] = $data['assignments']
                ->where('users.id', $request->selectusers);
            $data['selectusers'] = $request->selectusers;
        }

        if(!is_null($request->selectdateTo)){ //-- วันที่
            list($year,$month) = explode('-', $request->selectdateTo);
            $data['assignments'] = $data['assignments']->whereYear('assignments.created_at',$year)
            ->whereMonth('assignments.created_at', $month);
            $data['date_filter'] = $request->selectdateTo;
        }

        $data['assignments'] = $data['assignments']->orderBy('assignments.id', 'desc')
            ->select('assignments.*', 'users.name')->get();

        $data['users'] = DB::table('users')
                // ->where('team_id', Auth::user()->team_id)
                ->whereIn('status', [1, 2]) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
                ->where(function($query) use ($auth_team) {
                    for ($i = 0; $i < count($auth_team); $i++){
                        $query->orWhere('team_id', $auth_team[$i])
                            ->orWhere('team_id', 'like', $auth_team[$i].',%')
                            ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                    }
                })
                ->get();

                $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        return view('leadManager.add_assignment', $data);
    }

    public function lead_search_month_get_assignment(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $assignments = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.assign_emp_id', Auth::user()->id)
        ->where('assignments.assign_status', 3)
        ->whereDate('assignments.assign_work_date', '>=', $from)
        ->whereDate('assignments.assign_work_date', '<=', $to)
        ->orderBy('assignments.id', 'desc')
        ->select('assignments.*', 'users.name')->get();

        $users = DB::table('users')->where('id', Auth::user()->id)->get();

        return view('leadManager.get_assignment', compact('assignments', 'users'));
    }

    public function head_search_month_add_assignment(Request $request)
    {
        // dd($request);
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['assignments'] = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.created_by', Auth::user()->id)
        ->where('assignments.assign_status', 3);

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

        if(!is_null($request->selectusers)){ //-- ผู้แทนขาย
            $data['assignments'] = $data['assignments']
                ->where('users.id', $request->selectusers);
            $data['selectusers'] = $request->selectusers;
        }

        if(!is_null($request->selectdateTo)){ //-- วันที่
            list($year,$month) = explode('-', $request->selectdateTo);
            $data['assignments'] = $data['assignments']->whereYear('assignments.created_at',$year)
            ->whereMonth('assignments.created_at', $month);
            $data['date_filter'] = $request->selectdateTo;
        }

        $data['assignments'] = $data['assignments']->orderBy('assignments.id', 'desc')
            ->select('assignments.*', 'users.name')->get();

        $data['users'] = DB::table('users')
                // ->where('team_id', Auth::user()->team_id)
                ->whereIn('status', [1, 2]) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
                ->where(function($query) use ($auth_team) {
                    for ($i = 0; $i < count($auth_team); $i++){
                        $query->orWhere('team_id', $auth_team[$i])
                            ->orWhere('team_id', 'like', $auth_team[$i].',%')
                            ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                    }
                })
                ->get();

                $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        return view('headManager.add_assignment', $data);
    }

    public function head_search_month_get_assignment(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $assignments = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
        ->where('assignments.assign_emp_id', Auth::user()->id)
        ->where('assignments.assign_status', 3)
        ->whereDate('assignments.assign_work_date', '>=', $from)
        ->whereDate('assignments.assign_work_date', '<=', $to)
        ->orderBy('assignments.id', 'desc')
        ->select('assignments.*', 'users.name')->get();

        $users = DB::table('users')->where('id', Auth::user()->id)->get();

        return view('headManager.get_assignment', compact('assignments', 'users'));
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

    public function assign_file($id)
    {
        $assign_gallery = Assignment_gallery::where('assignment_id', $id)->orderBy('id', 'desc')->get();

        if (Auth::user()->status == 2) {
            return view('leadManager.add_assignment_file', compact('assign_gallery', 'id'));
        }elseif (Auth::user()->status == 3) {
            return view('headManager.add_assignment_file', compact('assign_gallery', 'id'));
        }elseif (Auth::user()->status == 4) {
            return view('admin.add_assignment_file', compact('assign_gallery', 'id'));
        }
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
