<?php

namespace App\Http\Controllers\LeadManager;

use App\Assignment;
use App\AssignmentComment;
use App\CustomerShopComment;
use App\Http\Controllers\Controller;
use App\RequestApproval;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{

    public function index()
    {

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        // $data['request_approval'] = DB::table('assignments')
        //     ->join('users', 'assignments.created_by', '=', 'users.id')
        //     ->where('assignments.assign_status', 0) // สถานะการอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน)
        //     ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        //     ->where(function($query) use ($auth_team) {
        //         for ($i = 0; $i < count($auth_team); $i++){
        //             $query->orWhere('users.team_id', $auth_team[$i])
        //                 ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
        //                 ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
        //         }
        //     })
        //     ->whereNotNull('assignments.assign_request_date')->select('users.name', 'assignments.*')->get();

        $data['request_approval'] = DB::table('assignments')
        ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        ->leftJoin('api_customers', 'api_customers.identify', 'assignments.assign_shop')
        ->join('users', 'assignments.created_by', 'users.id')
        ->whereIn('assignments.assign_status', [0, 4]) // สถานะอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน, 4=แก้ไขงาน))
        ->where(function($query) use ($auth_team) {
            for ($i = 0; $i < count($auth_team); $i++){
                $query->orWhere('users.team_id', $auth_team[$i])
                    ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                    ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
            }
        })
        ->select(
            'assignments.*',
            'assignments_comments.assign_id' ,
            'users.name',
            'users.id as user_id',
            'users.api_identify',
            'api_customers.title as api_customers_title',
            'api_customers.name as api_customers_name',
        )
        ->orderBy('assignments.assign_request_date', 'desc')
        ->groupBy('assignments.id')
        ->get();

            $data['users'] = DB::table('users')
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
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
            })->get();

        // dd($data['request_approval']);

        return view('leadManager.approval_general', $data);
    }

    public function search(Request $request)
    {
        // dd($request);
        // $auth_team_id = explode(',',Auth::user()->team_id);
        // $auth_team = array();
        // foreach($auth_team_id as $value){
        //     $auth_team[] = $value;
        // }

        // $data['request_approval'] = DB::table('assignments')
        // ->join('users', 'assignments.created_by', '=', 'users.id')
        // ->where('assignments.assign_status', 0)
        // ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        // ->where('assignments.assign_request_date', $request->selectdateTo)
        // ->where(function($query) use ($auth_team) {
        //     for ($i = 0; $i < count($auth_team); $i++){
        //         $query->orWhere('users.team_id', $auth_team[$i])
        //             ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
        //             ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
        //     }
        // })
        // ->select('assignments.created_by')
        // ->distinct()->get();

        // return view('leadManager.approval_general', $data);

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['request_approval'] = DB::table('assignments')
        ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        ->leftJoin('api_customers', 'api_customers.identify', 'assignments.assign_shop')
        ->join('users', 'assignments.created_by', 'users.id')
        ->whereIn('assignments.assign_status', [0, 4]) // สถานะอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน, 4=แก้ไขงาน))
        ->select(
            'assignments.*',
            'assignments_comments.assign_id' ,
            'users.name',
            'users.id as user_id',
            'users.api_identify',
            'api_customers.title as api_customers_title',
            'api_customers.name as api_customers_name',
        );

        if(!is_null($request->selectteam_sales)){
            $request_approval = $data['request_approval']->where('users.team_id', $request->selectteam_sales);
            $data['checkteam_sales'] = $request->selectteam_sales;
        }else{
            $request_approval = $data['request_approval']->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            });
        }

        if(!is_null($request->selectusers)){
            $request_approval = $request_approval->where('assignments.created_by', $request->selectusers);
            $data['checkusers'] = $request->selectusers;
        }

        if(!is_null($request->selectdateFrom)){
            $request_approval = $request_approval->whereDate('assignments.assign_request_date', '>=', $request->selectdateFrom);
            $data['checkdateFrom'] = $request->selectdateFrom;
        }else{
            $data['checkdateFrom'] = "";
        }

        if(!is_null($request->selectdateTo)){
            $request_approval = $request_approval->whereDate('assignments.assign_request_date', '<=', $request->selectdateTo);
            $data['checkdateTo'] = $request->selectdateTo;
        }else{
            $data['checkdateTo'] = "";
        }

        $request_approval = $request_approval
        ->orderBy('assignments.assign_request_date', 'desc')
        ->groupBy('assignments.id')
        ->get();

        $data['request_approval'] = $request_approval;

        $data['users'] = DB::table('users')
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
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
            })->get();

        return view('leadManager.approval_general', $data);
    }

    public function approval_history()
    {

        // $auth_team_id = explode(',',Auth::user()->team_id);
        // $auth_team = array();
        // foreach($auth_team_id as $value){
        //     $auth_team[] = $value;
        // }

        // $data['approval_history'] = DB::table('assignments')
        //     ->join('users', 'assignments.created_by', '=', 'users.id')
        //     ->whereNotIn('assignments.assign_status', [0, 3])
        //     ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        //     ->where(function($query) use ($auth_team) {
        //         for ($i = 0; $i < count($auth_team); $i++){
        //             $query->orWhere('users.team_id', $auth_team[$i])
        //                 ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
        //                 ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
        //         }
        //     })
        //     ->select(
        //         'users.name',
        //         'assignments.*')
        //     ->groupBy('assignments.created_by')
        //     ->get();

        // $data['request_approval'] = DB::table('assignments')
        //     ->join('users', 'assignments.created_by', '=', 'users.id')
        //     ->where('assignments.assign_status', 0)
        //     ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        //     ->where(function($query) use ($auth_team) {
        //         for ($i = 0; $i < count($auth_team); $i++){
        //             $query->orWhere('users.team_id', $auth_team[$i])
        //                 ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
        //                 ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
        //         }
        //     })
        //     ->select('assignments.created_by')
        //     ->distinct()->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['assignments_history'] = DB::table('assignments')
        ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        ->leftJoin('api_customers', 'api_customers.identify', 'assignments.assign_shop')
        ->join('users', 'assignments.created_by', 'users.id')
        ->whereNotIn('assignments.assign_status', [0, 3])
        ->where(function($query) use ($auth_team) {
            for ($i = 0; $i < count($auth_team); $i++){
                $query->orWhere('users.team_id', $auth_team[$i])
                    ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                    ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
            }
        })
        ->select(
            'assignments.*',
            'assignments_comments.assign_id' ,
            'users.name',
            'users.id as user_id',
            'users.api_identify',
            'api_customers.title as api_customers_title',
            'api_customers.name as api_customers_name',
        )
        ->orderBy('assignments.assign_request_date', 'desc')
        ->groupBy('assignments.id')
        ->get();

        $data['users'] = DB::table('users')
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
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

        return view('leadManager.approval_general_history', $data);
    }

    public function approval_general_history_detail($id)
    {
        $data['id_create'] = $id;
        $data['history'] = Assignment::join('users', 'assignments.created_by', '=', 'users.id')
        ->leftjoin('assignments_comments', 'assignments.id', '=', 'assignments_comments.assign_id')
        ->select(
            'assignments_comments.assign_id',
            'users.name',
            'assignments.*')
        ->whereNotIn('assignments.assign_status', [0, 3])
        ->where('assignments.created_by', $id)
        ->where('assignments.assign_request_date', '!=', "NULL")
        ->orderBy('id', 'desc')->get();

        return view('leadManager.approval_general_history_detail', $data);
    }

    public function search_history(Request $request)
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $assignments_history = DB::table('assignments')
        ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        ->leftJoin('api_customers', 'api_customers.identify', 'assignments.assign_shop')
        ->join('users', 'assignments.created_by', 'users.id')
        ->whereNotIn('assignments.assign_status', [0, 3])
        ->select(
            'assignments.*',
            'assignments_comments.assign_id' ,
            'users.name',
            'users.id as user_id',
            'users.api_identify',
            'api_customers.title as api_customers_title',
            'api_customers.name as api_customers_name',
        );

        if(!is_null($request->selectteam_sales)){
            $assignments_history = $assignments_history->where('users.team_id', $request->selectteam_sales);
            $data['checkteam_sales'] = $request->selectteam_sales;
        }else{
            $assignments_history = $assignments_history->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            });
        }

        if(!is_null($request->selectusers)){
            $assignments_history = $assignments_history->where('assignments.created_by', $request->selectusers);
            $data['checkusers'] = $request->selectusers;
        }

        if(!is_null($request->selectdateFrom)){
            $assignments_history = $assignments_history->whereDate('assignments.assign_request_date', '>=', $request->selectdateFrom);
            $data['checkdateFrom'] = $request->selectdateFrom;
        }else{
            $data['checkdateFrom'] = "";
        }

        if(!is_null($request->selectdateTo)){
            $assignments_history = $assignments_history->whereDate('assignments.assign_request_date', '<=', $request->selectdateTo);
            $data['checkdateTo'] = $request->selectdateTo;
        }else{
            $data['checkdateTo'] = "";
        }

        $assignments_history = $assignments_history
        ->orderBy('assignments.assign_request_date', 'desc')
        ->groupBy('assignments.id')
        ->get();

        $data['assignments_history'] = $assignments_history;

        $data['users'] = DB::table('users')
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
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


        // $auth_team_id = explode(',',Auth::user()->team_id);
        // $auth_team = array();
        // foreach($auth_team_id as $value){
        //     $auth_team[] = $value;
        // }

        // $data['approval_history'] = DB::table('assignments')
        //     ->join('users', 'assignments.created_by', '=', 'users.id')
        //     ->whereNotIn('assignments.assign_status', [0, 3])
        //     ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        //     ->where('assignments.assign_approve_date', $request->selectdateTo)
        //     ->where(function($query) use ($auth_team) {
        //         for ($i = 0; $i < count($auth_team); $i++){
        //             $query->orWhere('users.team_id', $auth_team[$i])
        //                 ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
        //                 ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
        //         }
        //     })
        //     ->select(
        //         'users.name',
        //         'assignments.*')
        //     ->groupBy('assignments.created_by')
        //     ->get();

        return view('leadManager.approval_general_history', $data);
    }

    public function search_detail(Request $request)
    {
        // dd($request->selectdateTo);

        // list($year,$month) = explode('-', $request->selectdateTo);
        $data['history'] = Assignment::join('users', 'assignments.created_by', '=', 'users.id')
        ->leftjoin('assignments_comments', 'assignments.id', '=', 'assignments_comments.assign_id')
        ->whereNotIn('assignments.assign_status', [0, 3])
        ->where('assignments.created_by', $request->id)
        ->where('assignments.assign_request_date', '!=', "NULL")
        ->where('assignments.assign_approve_date', $request->selectdateTo)
        ->select(
            'assignments_comments.assign_id',
            'users.name',
            'assignments.*')
        ->orderBy('assignments.id', 'desc')->get();

        $data['id_create'] = $request->id;

        return view('leadManager.approval_general_history_detail', $data);
    }


    public function approval_general_detail($id)
    {
        $data['request_approval'] = Assignment::join('users', 'assignments.created_by', '=', 'users.id')
        ->select(
            'users.name' ,
            'assignments.*')
        ->where('assignments.assign_status', 0)
        ->where('assignments.created_by', $id)
        ->where('assignments.assign_request_date', '!=', "NULL")
        ->orderBy('id', 'desc')->get();

        return view('leadManager.approval_general_detail', $data);
    }

    public function view_approval($id)
    {
        // $dataEdit = RequestApproval::find($id);
        // $data = array(
        //     'dataEdit'     => $dataEdit,
        // );
        // echo json_encode($data);

        $dataEdit = DB::table('assignments')
            ->where('assignments.id', $id)
            ->first();

        $dataEdit_comment_edit = DB::table('assignments_comments')
            ->where('assign_id', $id)
            ->where('created_by', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $request_comment = DB::table('assignments_comments')
            ->where('assign_id', $id)
            ->whereNotIn('assignments_comments.created_by', [Auth::user()->id])
            ->orderBy('assignments_comments.created_at', 'desc')
            ->get();

        if(count($request_comment) > 0){
            foreach ($request_comment as $key => $value) {
                $users = DB::table('users')->where('id', $value->created_by)->first();
                $date_comment = substr($value->created_at, 0, 10);
                $dataEdit_comment[$key] =
                    [
                        'assign_comment_detail' => $value->assign_comment_detail,
                        'user_comment' => $users->name,
                        'created_at' => $date_comment,
                    ];
            }

        }else{
            $dataEdit_comment = null;
        }

        return response()->json([
            'status' => 200,
            'dataEdit' => $dataEdit,
            'dataEdit_comment_edit' => $dataEdit_comment_edit,
            'dataEdit_comment' => $dataEdit_comment,
        ]);
    }

    public function comment_approval($id, $createID)
    {
        // return $createID;

            $data['comment'] = AssignmentComment::where('assign_id', $id)->where('created_by', Auth::user()->id)->first();
            $data['assignID'] = $id;
            $data['createID'] = $createID;

            // return $data;
            if ( $data['comment']) {
                return view('leadManager.create_comment_request_approval', $data);
            }else {
                return view('leadManager.create_comment_request_approval', $data);
            }
    }

    public function comment_approval_history($id, $createID)
    {
        // return $createID;

            $data['comment'] = AssignmentComment::where('assign_id', $id)->where('created_by', Auth::user()->id)->first();
            $data['assignID'] = $id;
            $data['createID'] = $createID;

            // return $data;
            if ( $data['comment']) {
                return view('leadManager.show_comment_request_approval_history', $data);
            }else {
                return view('leadManager.show_comment_request_approval_history', $data);
            }
    }

    public function create_comment_request_approval(Request $request)
    {
        // dd($request);

            // $data = AssignmentComment::where('assign_id', $request->id)->where('created_by', Auth::user()->id)->first();
            // // return $request->id;
            // if ($data) {
            //    $dataEdit = AssignmentComment::where('assign_id', $request->id)->update([
            //         'assign_comment_detail' => $request->comment,
            //         'updated_by' => Auth::user()->id,
            //     ]);

            // } else {
            //     AssignmentComment::create([
            //         'assign_id' => $request->id,
            //         'assign_comment_detail' => $request->comment,
            //         'created_by' => Auth::user()->id,
            //     ]);
            // }

            // return redirect(url('lead/approval_general_detail', $request->createID));

            DB::beginTransaction();
        try {

            $data = AssignmentComment::where('assign_id', $request->id)->where('created_by', Auth::user()->id)->first();

            if ($data) {
                DB::table('assignments_comments')
                ->where('assign_id', $request->id)
                ->where('created_by', Auth::user()->id)
                ->update([
                    'assign_id' => $request->id,
                    'assign_comment_detail' => $request->comment,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                DB::table('assignments')->where('id', $request->id)
                ->update([
                    'assign_status' => $request->approval_send,
                    'assign_approve_id' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                DB::table('assignments_comments')
                ->insert([
                    'assign_id' => $request->id,
                    'assign_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                DB::table('assignments')->where('id', $request->id)
                ->update([
                    'assign_status' => $request->approval_send,
                    'assign_approve_id' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกได้',
            ]);
        }

    }



    public function approval_confirm_all(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            if ($request->checkapprove) {
                if ($request->approve) {
                $data = Assignment::get();
                if ($request->CheckAll == "Y") {
                    // return "yy";
                    foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('id', $chk)->where('assign_status', 0)->update([
                                'assign_status' => 1,
                                'assign_status_actoin' => 0,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลได้',
                    ]);
                } else {
                    foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            // return $chk;
                            Assignment::where('id', $chk)->where('assign_status', 0)->update([
                                'assign_status' => 1,
                                'assign_status_actoin' => 0,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลได้',
                    ]);
                }
        }else {
            $data = Assignment::get();
                if ($request->CheckAll == "Y") {
                    // return "yy";
                    foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('id', $chk)->where('assign_status', 0)->update([
                                'assign_status' => 2,
                                'assign_status_actoin' => 0,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลได้',
                    ]);
                } else {
                    foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('id', $chk)->where('assign_status', 0)->update([
                                'assign_status' => 2,
                                'assign_status_actoin' => 0,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'บันทึกข้อมูลได้',
                    ]);
                }
            }
        }else{
            DB::rollback();
            // return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
            return response()->json([
                'status' => 404,
                'message' => 'กรุณาเลือกรายการอนุมัติ',
            ]);
        }

        DB::commit();
        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลได้',
        ]);


    } catch (\Exception $e) {

        DB::rollback();
        return response()->json([
            'status' => 404,
            'message' => 'ไม่สามารถบันทึกข้อมูลได้',
        ]);

    }
    }

    // public function approval_confirm_detail(Request $request)
    // {
    //     // dd($request);

    //     if ($request->checkapprove) {
    //         if ($request->approve) {
    //         $data = Assignment::get();
    //         if ($request->CheckAll == "Y") {
    //             // return "yy";
    //             // foreach ($data as $value) {
    //                 foreach ($request->checkapprove as $key => $chk) {
    //                     Assignment::where('id', $chk)->update([
    //                         'assign_status' => 1,
    //                         'assign_status_actoin' => 0,
    //                         'assign_approve_date' => Carbon::now(),
    //                         'assign_approve_id' => Auth::user()->id,
    //                         'updated_by' => Auth::user()->id,
    //                     ]);
    //                 }
    //             // }
    //         } else {
    //             // foreach ($data as $value) {
    //                 foreach ($request->checkapprove as $key => $chk) {
    //                     Assignment::where('id', $chk)->update([
    //                         'assign_status' => 1,
    //                         'assign_status_actoin' => 0,
    //                         'assign_approve_date' => Carbon::now(),
    //                         'assign_approve_id' => Auth::user()->id,
    //                         'updated_by' => Auth::user()->id,
    //                     ]);
    //                 }
    //             // }
    //         }
    //     }else {
    //         $data = Assignment::get();
    //             if ($request->CheckAll == "Y") {
    //                 // return "yy";
    //                 // foreach ($data as $value) {
    //                     foreach ($request->checkapprove as $key => $chk) {
    //                         Assignment::where('id', $chk)->update([
    //                             'assign_status' => 2,
    //                             'assign_status_actoin' => 0,
    //                             'assign_approve_date' => Carbon::now(),
    //                             'assign_approve_id' => Auth::user()->id,
    //                             'updated_by' => Auth::user()->id,
    //                         ]);
    //                     }
    //                 // }
    //                 return back();
    //             } else {
    //                 // foreach ($data as $value) {
    //                     foreach ($request->checkapprove as $key => $chk) {
    //                         Assignment::where('id', $chk)->update([
    //                             'assign_status' => 2,
    //                             'assign_status_actoin' => 0,
    //                             'assign_approve_date' => Carbon::now(),
    //                             'assign_approve_id' => Auth::user()->id,
    //                             'updated_by' => Auth::user()->id,
    //                         ]);
    //                     }
    //                 // }
    //                 return back();
    //             }
    //     }
    //     } else {
    //         return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
    //     }

    //     return back();
    // }
}
