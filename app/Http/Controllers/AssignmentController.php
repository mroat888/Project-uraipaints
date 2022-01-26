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
        ->where('assignments.assign_status', 3)
        ->select('assignments.*', 'users.name')
        ->orderBy('assignments.id', 'desc')->get();

        $user = DB::table('users')->get();
        return view('leadManager.add_assignment', compact('assignments', 'user'));
    }

    public function store(Request $request)
    {
        Assignment::create([
            'assign_work_date' => $request->date,
            'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
            'assign_title' => $request->assign_title,
            'assign_detail' => $request->assign_detail,
            'assign_emp_id' => $request->assign_emp_id,
            'assign_status' => 3,
            'assign_approve_id' => Auth::user()->id,
            'assign_result_status' => 0,
            'created_by' => Auth::user()->id,
        ]);

        // echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='assignment'; </script>");
        return back();
    }

    public function edit($id)
    {
        $dataEdit = Assignment::find($id);
        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        Assignment::find($request->id)->update([
            'assign_work_date' => $request->date,
            // 'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
            'assign_title' => $request->assign_title,
            'assign_detail' => $request->assign_detail,
            'assign_emp_id' => $request->assign_emp_id,
            'assign_status' => 1,
            'assign_approve_id' => Auth::user()->id,
            'assign_result_status' => 0,
            'updated_by' => Auth::user()->id,
        ]);

        return back();
    }

    public function destroy($id)
    {
        Assignment::where('id', $id)->delete();
        return back();
    }

    public function searchShop(Request $request)
    {
        if ($request->ajax()) {

            $data = Customer::where('shop_name', $request->search)->first();
        }
            return $data;


    }
}
