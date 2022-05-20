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
use Yajra\DataTables\Facades\DataTables;
// use DataTables;

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

    public function index2()
    {
        $data['list_approval'] = RequestApproval::leftjoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
            ->where('assignments.created_by', Auth::user()->id)->whereNotIn('assignments.assign_status', [3])
            ->select('assignments.*', 'assignments_comments.assign_id')
            ->orderBy('assignments.assign_request_date', 'asc')->distinct()->get();

        $products = array();
        foreach ($data['list_approval'] as $key => $value) {
            $products[] = [
                'key' => $key + 1,
                'assign_title' => $value->assign_title,
                'assign_work_date' => $value->assign_work_date,
                'assign_status' => $value->assign_status,
                'assign_is_hot' => $value->assign_is_hot,
                'assign_id' => $value->assign_id,
                'assign_status_actoin' => $value->assign_status_actoin,
                'id' => $value->id,
            ];
        }
        return DataTables::of($products)
            ->addIndexColumn()
            ->editColumn('key', function ($row) {
                return $row['key'];
            })
            ->editColumn('assign_title', function ($row) {
                return $row['assign_title'];
            })
            ->editColumn('assign_work_date', function ($row) {
                return $row['assign_work_date'];
            })
            ->editColumn('assign_status_actoin', function ($row) {
                if ($row['assign_status_actoin'] == 0) {
                    $status_read = 'ยังไม่ได้อ่าน';
                }else{
                    $status_read = 'อ่านแล้ว';
                }

                return $status_read;
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row['assign_id']) {
                    $btn .= '<button onclick="approval_comment(' . $row['id'] . ')"
                class="btn btn-icon btn-violet mr-10" data-toggle="modal" data-target="#ApprovalComment">
                <span class="btn-icon-wrap"><i class="ion ion-md-chatbubbles" style="font-size: 18px;"></i></span></button>';
                }
                if ($row['assign_status'] == 1) { //-- OAT เปลี่ยนให้แสดง เรื่องด่วนแยกต่างหาก
                    $btn = '<button onclick="edit_modal(' . $row['id'] . ')" class="btn btn-icon btn-info mr-10" data-toggle="modal"
                        data-target="#editApproval"> <span class="btn-icon-wrap"><i class="ion ion-md-document" style="font-size: 18px;"></i></span></button>';
                }elseif ($row['assign_status'] == 0) {
                    $btn .= '<button onclick="edit_modal(' . $row['id'] . ')"
                    class="btn btn-icon btn-warning mr-10" data-toggle="modal"
                    data-target="#editApproval">
                    <span class="btn-icon-wrap"><i class="ion ion-md-create" style="font-size: 18px;"></i></span></button>

                    <button id="btn_request_delete" class="btn btn-icon btn-danger mr-10"
                        value="' . $row['id'] . '">
                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-trash"></i></h4>
                    </button>';
                }
                return $btn;
            })
            ->rawColumns(['action' => 'action'])

            ->addColumn('assign_status', function ($row) {
                if ($row['assign_status'] == 0) {
                    $status = '<span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>';
                    // if ($row['assign_is_hot'] == 1) {
                    //     $status .= '<span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>';
                    // }
                    if ($row['assign_id']) {
                        $status .= '<span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>';
                    }
                } elseif ($row['assign_status'] == 1) {
                    $status = '<span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>';
                    // if ($row['assign_is_hot'] == 1) {
                    //     $status .= '<span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>';
                    // }
                    if ($row['assign_id']) {
                        $status .= '<span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>';
                    }
                } else {
                    $status = '<span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>';
                    // if ($row['assign_is_hot'] == 1) {
                    //     $status .= '<span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>';
                    // }
                    if ($row['assign_id']) {
                        $status .= '<span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>';
                    }
                }
                return $status;
            })
            // ->rawColumns(['assign_status' => 'assign_status'])

            ->addColumn('assign_is_hot', function ($row) {
                if ($row['assign_is_hot'] == 1) {
                    $status_ishot = '<span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>';
                }else{
                    $status_ishot = "";
                }
                return $status_ishot;
            })

            ->rawColumns(['assign_status' => 'assign_status', 'status_ishot' => 'assign_is_hot'])
            ->make(true);
    }

    public function store(Request $request)
    {
        if ($request->assign_is_hot == '') {
            $status = 0;
        } else {
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
        } else {
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
            $date_comment = substr($value->created_at, 0, 10);
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
        $from = $request->fromMonth . "-01";
        $to = $request->toMonth . "-31";
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
