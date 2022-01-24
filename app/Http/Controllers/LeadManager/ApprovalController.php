<?php

namespace App\Http\Controllers\LeadManager;

use App\Assignment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{

    public function index()
    {
        // $data['request_approval'] = Assignment::join('users', 'assignments.created_by', '=', 'users.id')
        // ->where('assignments.assign_status', 0)
        // ->select(
        //     'users.name' ,
        //     'assignments.*')->get();


        $data['request_approval'] = DB::table('assignments')
        ->join('users', 'assignments.created_by', '=', 'users.id')
        ->where('assignments.assign_status', 0)
            ->select('assignments.created_by')
            ->distinct()->get();

        return view('leadManager.approval_general', $data);
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

    // public function approvalUpdate($id)
    // {
    //     return $id;
    // }

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
}
