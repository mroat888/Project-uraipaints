<?php

namespace App\Http\Controllers\SaleMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RequestApproval;
use Carbon\Carbon;

class RequestApprovalController extends Controller
{

    public function index()
    {
        $list_approval = RequestApproval::orderBy('id', 'desc')->get();
        return view('saleman.requestApproval', compact('list_approval'));
    }

    public function store(Request $request)
    {
        if ($request->assign_is_hot == '') {
            $status = 0;
        }else{
            $status = 1;
        }

        RequestApproval::create([
            'assign_work_date' => $request->assign_work_date,
            'assign_request_date' => Carbon::now(),
            'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
            'assign_title' => $request->assign_title,
            'assign_detail' => $request->assign_detail,
            'approved_for' => $request->approved_for,
            'assign_emp_id' => 1,
            'assign_approve_id' => 2,
            'assign_is_hot' => $status,
            'assign_status' => 0,
            // 'assign_result_detail' => $request->assign_result_detail,
            // 'assign_result_status' => $request->assign_result_status,
            'created_by' => 1,
            'updated_by' => $request->updated_by,
            'deleted_by' => $request->deleted_by,
            'deleted_at' => $request->deleted_at,
        ]);

        echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='approval'; </script>");
    }

    public function edit($id)
    {
        $dataEdit = RequestApproval::find($id);
        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        if ($request->assign_is_hot == '') {
            $status = 0;
        }else{
            $status = 1;
        }

        RequestApproval::find($request->id)->update([
            'assign_work_date' => $request->assign_work_date,
            'assign_request_date' => Carbon::now(),
            'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
            'assign_title' => $request->assign_title,
            'assign_detail' => $request->assign_detail,
            'approved_for' => $request->approved_for,
            'assign_emp_id' => 1,
            'assign_approve_id' => 2,
            'assign_is_hot' => $status,
            // 'assign_status' => 0,
            // 'assign_result_detail' => $request->assign_result_detail,
            // 'assign_result_status' => $request->assign_result_status,
            'created_by' => 1,
            'updated_by' => Carbon::now(),
            'deleted_by' => $request->deleted_by,
            'deleted_at' => $request->deleted_at,
        ]);

        echo ("<script>alert('แก้ไขข้อมูลสำเร็จ'); location.href='approval'; </script>");
    }

    public function destroy($id)
    {
        RequestApproval::where('id', $id)->delete();
        return back();
    }
}
