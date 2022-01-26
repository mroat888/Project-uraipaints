<?php

namespace App\Http\Controllers\LeadManager;

use App\Assignment;
use App\AssignmentComment;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{

    public function index()
    {
        $data['request_approval'] = DB::table('assignments')
        ->join('users', 'assignments.created_by', '=', 'users.id')
        ->where('assignments.assign_status', 0)
            ->select('assignments.created_by')
            ->distinct()->get();

        return view('leadManager.approval_general', $data);
    }

    public function approval_history()
    {

        $data['approval_history'] = DB::table('assignments')
        ->join('users', 'assignments.created_by', '=', 'users.id')
        // ->leftjoin('assignments_comments', 'assignments.id', '=', 'assignments_comments.assign_id')
        ->whereNotIn('assignments.assign_status', [0, 3])
        ->select(
            'users.name',
            // 'assignments_comments.assign_id',
            'assignments.*')
        ->groupBy('assignments.created_by')
        ->get();


        return view('leadManager.approval_general_history', $data);
    }

    public function approval_general_history_detail($id)
    {
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

    public function comment_approval($id, $createID)
    {
        // return $createID;

            $data['comment'] = AssignmentComment::where('assign_id', $id)->first();
            $data['assignID'] = $id;
            $data['createID'] = $createID;

            // return $data;
            if ( $data['comment']) {
                return view('leadManager.create_comment_request_approval', $data);
            }else {
                return view('leadManager.create_comment_request_approval', $data);
            }
    }

    public function create_comment_request_approval(Request $request)
    {
        // dd($request);

            $data = AssignmentComment::where('assign_id', $request->id)->first();
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


            if ($request->checkapprove) {
                if ($request->approve) {
                $data = Assignment::get();
                if ($request->CheckAll == "Y") {
                    // return "yy";
                    foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('created_by', $chk)->where('assign_status', 0)->update([
                                'assign_status' => 1,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                    return back();
                } else {
                    foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('created_by', $chk)->where('assign_status', 0)->update([
                                'assign_status' => 1,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                    return back();
                }
        }else {
            $data = Assignment::get();
                if ($request->CheckAll == "Y") {
                    // return "yy";
                    foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('created_by', $chk)->where('assign_status', 0)->update([
                                'assign_status' => 2,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                    return back();
                } else {
                    foreach ($data as $value) {
                        foreach ($request->checkapprove as $key => $chk) {
                            Assignment::where('created_by', $chk)->where('assign_status', 0)->update([
                                'assign_status' => 2,
                                'assign_approve_date' => Carbon::now(),
                                'assign_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                    return back();
                }
        }
    } else {
        return back()->with('error', "กรุณาเลือกรายการ");
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
