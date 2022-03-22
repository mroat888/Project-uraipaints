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

        $data['request_approval'] = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->where('assignments.assign_status', 0) // สถานะการอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน)
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select('assignments.created_by')
            ->distinct()->get();

        // dd($data['request_approval']);

        return view('leadManager.approval_general', $data);
    }

    public function search(Request $request)
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['request_approval'] = DB::table('assignments')
        ->join('users', 'assignments.created_by', '=', 'users.id')
        ->where('assignments.assign_status', 0)
        ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        ->where('assignments.assign_request_date', $request->selectdateTo)
        ->where(function($query) use ($auth_team) {
            for ($i = 0; $i < count($auth_team); $i++){
                $query->orWhere('users.team_id', $auth_team[$i])
                    ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                    ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
            }
        })
        ->select('assignments.created_by')
        ->distinct()->get();

        return view('leadManager.approval_general', $data);
    }

    public function approval_history()
    {

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['approval_history'] = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->whereNotIn('assignments.assign_status', [0, 3])
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select(
                'users.name',
                'assignments.*')
            ->groupBy('assignments.created_by')
            ->get();

        $data['request_approval'] = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->where('assignments.assign_status', 0)
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select('assignments.created_by')
            ->distinct()->get();

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

        $data['approval_history'] = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->whereNotIn('assignments.assign_status', [0, 3])
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where('assignments.assign_approve_date', $request->selectdateTo)
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select(
                'users.name',
                'assignments.*')
            ->groupBy('assignments.created_by')
            ->get();

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
        $dataEdit = RequestApproval::find($id);
        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
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

            $data = AssignmentComment::where('assign_id', $request->id)->where('created_by', Auth::user()->id)->first();
            // return $request->id;
            if ($data) {
               $dataEdit = AssignmentComment::where('assign_id', $request->id)->update([
                    'assign_comment_detail' => $request->comment,
                    'updated_by' => Auth::user()->id,
                ]);

            } else {
                AssignmentComment::create([
                    'assign_id' => $request->id,
                    'assign_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                ]);
            }

            return redirect(url('lead/approval_general_detail', $request->createID));

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
                            Assignment::where('created_by', $chk)->where('assign_status', 0)->update([
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
                            Assignment::where('created_by', $chk)->where('assign_status', 0)->update([
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
                            Assignment::where('created_by', $chk)->where('assign_status', 0)->update([
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
                            Assignment::where('created_by', $chk)->where('assign_status', 0)->update([
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

    public function approval_confirm_detail(Request $request)
    {
        // dd($request);

        if ($request->checkapprove) {
            if ($request->approve) {
            $data = Assignment::get();
            if ($request->CheckAll == "Y") {
                // return "yy";
                // foreach ($data as $value) {
                    foreach ($request->checkapprove as $key => $chk) {
                        Assignment::where('id', $chk)->update([
                            'assign_status' => 1,
                            'assign_status_actoin' => 0,
                            'assign_approve_date' => Carbon::now(),
                            'assign_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                // }
            } else {
                // foreach ($data as $value) {
                    foreach ($request->checkapprove as $key => $chk) {
                        Assignment::where('id', $chk)->update([
                            'assign_status' => 1,
                            'assign_status_actoin' => 0,
                            'assign_approve_date' => Carbon::now(),
                            'assign_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                // }
            }
        }else {
            $data = Assignment::get();
                if ($request->CheckAll == "Y") {
                    // return "yy";
                    // foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('id', $chk)->update([
                                'assign_status' => 2,
                                'assign_status_actoin' => 0,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    // }
                    return back();
                } else {
                    // foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('id', $chk)->update([
                                'assign_status' => 2,
                                'assign_status_actoin' => 0,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    // }
                    return back();
                }
        }
        } else {
            return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
        }

        return back();
    }
}
