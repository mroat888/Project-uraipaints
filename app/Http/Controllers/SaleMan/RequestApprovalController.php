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
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiController;
// use DataTables;

class RequestApprovalController extends Controller
{

    public function __construct(){
        $this->apicontroller = new ApiController();
        $this->api_token = $this->apicontroller->apiToken(); // API Login
    }

    public function index()
    {
        $api_token = $this->apicontroller->apiToken(); // API Login
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers');
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $data['customer_api'] = array();
            foreach ($res_api['data'] as $key => $value) {
                $data['customer_api'][$key] =
                [
                    'id' => $value['identify'],
                    'shop_name' => $value['title']." ".$value['name'],
                    'shop_address' => $value['amphoe_name']." , ".$value['province_name'],
                ];
            }
        }

        // -- OAT ทดสอบดึงจากฐานข้อมูลที่ทำรอไว้ --
        // $api_customers = DB::table('api_customers')
        //     ->where('SellerCode', Auth::user()->api_identify)
        //     ->get();
        // $data['customer_api'] = array();
        // foreach ($api_customers as $key => $value) {
        //     $data['customer_api'][$key] =
        //     [
        //         'id' => $value->identify,
        //         'shop_name' => $value->title." ".$value->name,
        //         'shop_address' => $value->amphoe_name." , ".$value->province_name,
        //     ];
        // }

        return view('saleman.requestApproval', $data);
    }

    public function index2()
    {
        // $data['list_approval'] = RequestApproval::leftjoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        //     ->where('assignments.created_by', Auth::user()->id)->whereNotIn('assignments.assign_status', [3])
        //     ->select('assignments.*', 'assignments_comments.assign_id')
        //     ->orderBy('assignments.assign_request_date', 'asc')->distinct()->get();

        $data['list_approval']  = DB::table('assignments')
            ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
            ->where('assignments.created_by', Auth::user()->id)
            ->whereNotIn('assignments.assign_status', [3]) // สถานะการอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน, 4=ให้แก้ไขงาน)
            ->select('assignments.*', 'assignments_comments.assign_id')
            ->orderBy('assignments.assign_request_date', 'desc')
            ->groupBy('assignments.id')
            ->get();

        $products = array();

   
        foreach ($data['list_approval'] as $key => $value) {
           
            if(!is_null($value->assign_shop)){
                

                $api_customers = DB::table('api_customers')
                    ->where('identify', $value->assign_shop)
                    ->first();
                $assign_shop_name = $api_customers->title." ".$api_customers->name;

                // $path_search = "/sellers/".Auth::user()->api_identify."/customers/".$value->assign_shop;
                // $response = Http::withToken($this->api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
                // $res_api = $response->json();
                // $assign_shop_name = $res_api['data']['title']." ".$res_api['data']['name'];
                // $assign_shop_name = $this->api_token;
            }else{
                $assign_shop_name = "";
            }

            $products[] = [
                'key' => $key + 1,
                'assign_title' => $value->assign_title,
                'assign_shop_name' => $assign_shop_name,
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
            ->addColumn('assign_is_hot', function ($row) {
                if ($row['assign_is_hot'] == 1) {
                    $status_ishot = '<span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>';
                }else{
                    $status_ishot = "";
                }
                return $status_ishot;
            })
            ->editColumn('assign_title', function ($row) {
                return $row['assign_title'];
            })
            ->editColumn('assign_work_date', function ($row) {
                return $row['assign_work_date'];
            })
            ->editColumn('assign_shop_name', function ($row) {
                return $row['assign_shop_name'];
            })
            // ->editColumn('assign_status_actoin', function ($row) {
            //     if ($row['assign_status_actoin'] == 0) {
            //         $status_read = 'ยังไม่ได้อ่าน';
            //     }else{
            //         $status_read = 'อ่านแล้ว';
            //     }

            //     return $status_read;
            // })
            ->addColumn('action', function ($row) {
                $btn = '';
                $btn .= '<button onclick="approval_comment(' . $row['id'] . ')"
                class="btn btn-icon btn-purple mr-10" data-toggle="modal" data-target="#ApprovalComment">
                <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></button>';

                // if ($row['assign_id']) {
                //     $btn .= '<button onclick="approval_comment(' . $row['id'] . ')"
                // class="btn btn-icon btn-violet mr-10" data-toggle="modal" data-target="#ApprovalComment">
                // <span class="btn-icon-wrap"><i class="ion ion-md-chatbubbles" style="font-size: 18px;"></i></span></button>';
                // }
                if ($row['assign_status'] == 1) {
                    $btn .= '<button onclick="edit_modal(' . $row['id'] . ')" class="btn btn-icon btn-info mr-10" data-toggle="modal"
                        data-target="#editApproval"> <span class="btn-icon-wrap"><i class="ion ion-md-document" style="font-size: 18px;"></i></span></button>';
                }elseif ($row['assign_status'] == 0) {
                    $btn .= '<button onclick="edit_modal(' . $row['id'] . ')"
                    class="btn btn-icon btn-warning mr-10" data-toggle="modal"
                    data-target="#editApproval">
                    <span class="btn-icon-wrap"><i class="ion ion-md-create" style="font-size: 18px;"></i></span></button>';

                    /* $btn .= '<button id="btn_request_delete" class="btn btn-icon btn-danger mr-10"
                        value="' . $row['id'] . '">
                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-trash"></i></h4>
                    </button>';*/
                }
                return $btn;
            })
            // ->rawColumns(['action' => 'action'])

            ->addColumn('assign_status', function ($row) {
                if ($row['assign_status'] == 0) {
                    $status = '<span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>';
                } elseif ($row['assign_status'] == 1) {
                    $status = '<span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>';
                } else {
                    $status = '<span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>';
                }
                if ($row['assign_id']) {
                    $status .= '<span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>';
                }
                return $status;
            })

            ->addColumn('assign_status_approve', function ($row) {
                if ($row['assign_status'] == 0 || $row['assign_status'] == 4){
                    $status_approve = '<span class="badge badge-soft-warning" style="font-size: 12px;">ขออนุมัติ</span>';
                }elseif($row['assign_status'] == 1 || $row['assign_status'] == 2){
                    $status_approve = '<span class="badge badge-soft-success" style="font-size: 12px;">สำเร็จ</span>';
                }
                return $status_approve;
            })

            ->rawColumns(['assign_status' => 'assign_status', 'assign_is_hot' => 'assign_is_hot', 
            'assign_status_approve' => 'assign_status_approve', 'action' => 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // dd($request);
        if ($request->assign_is_hot == '') {
            $status = 0;
        } else {
            $status = 1;
        }

        // $api_token = $this->apicontroller->apiToken(); // API Login
        // $path_search = "/sellers/".Auth::user()->api_identify."/customers/".$request->sel_searchShop2;
        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        // $res_api = $response->json();
        // $assign_shop_name = $res_api['data']['title']." ".$res_api['data']['name'];

        DB::table('assignments')
        ->insert([
            'assign_work_date' => $request->assign_work_date,
            'assign_request_date' => Carbon::now(),
            // 'assign_approve_date' => Carbon::now(), // วันที่อนุมัติ
            'assign_title' => $request->assign_title,
            'assign_detail' => $request->assign_detail,
            'approved_for' => $request->approved_for,
            'assign_is_hot' => $status,
            'assign_shop' => $request->sel_searchShop2,
            // 'assign_shop_name' => $assign_shop_name,
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


        $api_token = $this->apicontroller->apiToken(); // API Login

        $path_search = "sellers/".Auth::user()->api_identify."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['amphoe_name']." , ".$value['province_name'],
            ];
        }

        // $data = array(
        //     'dataEdit'     => $dataEdit,
        // );
        return response()->json([
            'status' => 200,
            'dataEdit' => $dataEdit,
            'customer_api' => $customer_api,
        ]);

        //echo json_encode($data);
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
        $dataResult = Assignment::leftjoin('master_objective_assigns', 'master_objective_assigns.id', 'assignments.approved_for')
        ->where('assignments.id', $id)
        ->first();

        RequestApproval::find($id)->update([
            'assign_status_actoin' => 1,
            'updated_by' => Auth::user()->id,
        ]);

        $dataassign = array();
        $dataassign = [
            'assign_detail' => $dataResult->assign_detail,
            'assign_title' => $dataResult->assign_title,
            'assign_work_date' => $dataResult->assign_work_date,
            'masassign_title' => $dataResult->masassign_title,
            'assign_status' => $dataResult->assign_status,
        ];

        $comment = array();
        foreach ($request_comment as $key => $value) {
            $users = DB::table('users')->where('id', $value['created_by'])->first();
            $date_comment = substr($value->created_at, 0, 10);
            $comment[$key] =
                [
                    'assign_comment_detail' => $value->assign_comment_detail,
                    'user_comment' => $users->name,
                    'created_at' => $date_comment,
                ];
        }

        // echo json_encode($comment, $dataassign);
        return response()->json([
            'comment' => $comment,
            'dataassign' => $dataassign
        ]);
    }

    // public function search_month_requestApprove(Request $request)
    public function search_month_requestApprove($fromMonth, $toMonth)
    {
        // $from = $request->fromMonth . "-01";
        // $to = $request->toMonth . "-31";
        $from = $fromMonth . "-01";
        $to = $toMonth . "-31";
        $list_approval = DB::table('assignments')
            ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
            ->where('assignments.created_by', Auth::user()->id)
            ->whereNotIn('assignments.assign_status', [3]) // สถานะการอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน, 4=ให้แก้ไขงาน)
            ->whereDate('assignments.assign_work_date', '>=', $from)
            ->whereDate('assignments.assign_work_date', '<=', $to)
            ->select('assignments.*', 'assignments_comments.assign_id')
            ->orderBy('assignments.assign_request_date', 'desc')
            ->groupBy('assignments.id')
            ->get();

            $products = array();
            foreach ($list_approval as $key => $value) {
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
                ->addColumn('assign_is_hot', function ($row) {
                    if ($row['assign_is_hot'] == 1) {
                        $status_ishot = '<span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>';
                    }else{
                        $status_ishot = "";
                    }
                    return $status_ishot;
                })
                ->editColumn('assign_title', function ($row) {
                    return $row['assign_title'];
                })
                ->editColumn('assign_work_date', function ($row) {
                    return $row['assign_work_date'];
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<button onclick="approval_comment(' . $row['id'] . ')"
                    class="btn btn-icon btn-purple mr-10" data-toggle="modal" data-target="#ApprovalComment">
                    <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></button>';

                    if ($row['assign_status'] == 1) {
                        $btn .= '<button onclick="edit_modal(' . $row['id'] . ')" class="btn btn-icon btn-info mr-10" data-toggle="modal"
                            data-target="#editApproval"> <span class="btn-icon-wrap"><i class="ion ion-md-document" style="font-size: 18px;"></i></span></button>';
                    }elseif ($row['assign_status'] == 0) {
                        $btn .= '<button onclick="edit_modal(' . $row['id'] . ')"
                        class="btn btn-icon btn-warning mr-10" data-toggle="modal"
                        data-target="#editApproval">
                        <span class="btn-icon-wrap"><i class="ion ion-md-create" style="font-size: 18px;"></i></span></button>';
                    }
                    return $btn;
                })
                // ->rawColumns(['action' => 'action'])
    
                ->addColumn('assign_status', function ($row) {
                    if ($row['assign_status'] == 0) {
                        $status = '<span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>';
                    } elseif ($row['assign_status'] == 1) {
                        $status = '<span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>';
                    } else {
                        $status = '<span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>';
                    }
                    if ($row['assign_id']) {
                        $status .= '<span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>';
                    }
                    return $status;
                })
    
                ->addColumn('assign_status_approve', function ($row) {
                    if ($row['assign_status'] == 0 || $row['assign_status'] == 4){
                        $status_approve = '<span class="badge badge-soft-warning" style="font-size: 12px;">ขออนุมัติ</span>';
                    }elseif($row['assign_status'] == 1 || $row['assign_status'] == 2){
                        $status_approve = '<span class="badge badge-soft-success" style="font-size: 12px;">สำเร็จ</span>';
                    }
                    return $status_approve;
                })
    
                ->rawColumns(['assign_status' => 'assign_status', 'assign_is_hot' => 'assign_is_hot', 
                'assign_status_approve' => 'assign_status_approve', 'action' => 'action'])
                ->make(true);

        // return response()->json([
        //     'status' => 200,
        //     'list_approval' => $list_approval
        // ]);

        // return $list_approval;

        // return view('saleman.requestApproval', compact('list_approval'));
    }
}
