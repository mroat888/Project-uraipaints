<?php

namespace App\Http\Controllers\SaleMan;

use App\Assignment;
use App\AssignmentComment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RequestApproval;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestApprovalController extends Controller
{

    public function index()
    {

        $list_approval = RequestApproval::leftjoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        ->where('assignments.created_by', Auth::user()->id)->whereNotIn('assignments.assign_status', [3])
        ->select('assignments.*', 'assignments_comments.assign_id')
        ->orderBy('assignments.assign_request_date', 'asc')->distinct()->get();
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
            // 'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
            'assign_title' => $request->assign_title,
            'assign_detail' => $request->assign_detail,
            'approved_for' => $request->approved_for,
            'assign_is_hot' => $status,
            'assign_status' => 0,
            'created_by' => Auth::user()->id,
        ]);

        echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='approval'; </script>");
    }

    public function edit($id)
    {
        $dataEdit = RequestApproval::find($id);
        RequestApproval::find($id)->update([
            'assign_status_actoin' => 1,
            'updated_by' => Auth::user()->id,
        ]);

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
            // 'assign_emp_id' => 1,
            // 'assign_approve_id' => 2,
            'assign_is_hot' => $status,
            // 'assign_status' => 0,
            // 'assign_result_detail' => $request->assign_result_detail,
            // 'assign_result_status' => $request->assign_result_status,
            'updated_by' => Auth::user()->id,
        ]);

        echo ("<script>alert('แก้ไขข้อมูลสำเร็จ'); location.href='approval'; </script>");
    }

    public function destroy(Request $request)
    {

        DB::beginTransaction();
        try {

            RequestApproval::where('id', $request->request_id_delete)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลขออนุมัติเรียบร้อยแล้ว',
        ]);
    }


    public function view_comment($id)
    {
        $request_comment = AssignmentComment::where('assign_id', $id)->get();
        $dataResult = Assignment::where('id', $id)->first();

        RequestApproval::find($id)->update([
            'assign_status_actoin' => 1,
            'updated_by' => Auth::user()->id,
        ]);


        $comment = array();
        foreach ($request_comment as $key => $value) {
            $users = DB::table('users')->where('id', $value['created_by'])->first();
            $date_comment = substr($value->created_at,0,10);
            $comment[$key] =
            [
                'assign_comment_detail' => $value->assign_comment_detail,
                'user_comment' => $users->name,
                'created_at' => $date_comment,
                'assign_detail' => $dataResult->assign_detail,
                'assign_title' => $dataResult->assign_title,
                'assign_work_date' => $dataResult->assign_work_date,
            ];
        }

        echo json_encode($comment);
    }

    public function search_month_requestApprove(Request $request)
    {
        // dd($request);
        // $from = Carbon::parse($request->fromMonth)->format('m');
        // $to = Carbon::parse($request->toMonth)->format('m');
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $list_approval = RequestApproval::leftjoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        ->where('assignments.created_by', Auth::user()->id)->whereNotIn('assignments.assign_status', [3])
        ->whereDate('assignments.assign_work_date', '>=', $from)
        ->whereDate('assignments.assign_work_date', '<=', $to)
        ->select('assignments.*', 'assignments_comments.assign_id')
        ->orderBy('assignments.assign_request_date', 'asc')->distinct()->get();

        // return $list_approval;

        return view('saleman.requestApproval', compact('list_approval'));
    }
}
