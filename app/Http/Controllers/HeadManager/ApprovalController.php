<?php

namespace App\Http\Controllers\HeadManager;

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

        $data['assignments_history'] = DB::table('assignments')
        ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        ->leftJoin('api_customers', 'api_customers.identify', 'assignments.assign_shop')
        ->join('users', 'assignments.created_by', 'users.id')
        ->whereIn('assignments.assign_status', [0]) // สถานะอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน, 4=แก้ไขงาน))
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

        return view('headManager.approval_general', $data);

        // $auth_team_id = explode(',',Auth::user()->team_id);
        // $auth_team = array();
        // foreach($auth_team_id as $value){
        //     $auth_team[] = $value;
        // }
        // $data['request_approval'] = DB::table('assignments')
        //     ->join('users', 'assignments.created_by', '=', 'users.id')
        //     ->whereIn('assignments.assign_status', [0,1,2])
        //     ->where(function($query) use ($auth_team) {
        //         for ($i = 0; $i < count($auth_team); $i++){
        //             $query->orWhere('users.team_id', $auth_team[$i])
        //                 ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
        //                 ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
        //         }
        //     })
        //     ->select('assignments.created_by')
        //     ->distinct()->get();

        // dd($data['request_approval']);

    }

    public function search(Request $request){

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $assignments_history = DB::table('assignments')
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


        // list($year,$month) = explode('-', $request->selectdateTo);
        // $auth_team_id = explode(',',Auth::user()->team_id);
        // $auth_team = array();
        // foreach($auth_team_id as $value){
        //     $auth_team[] = $value;
        // }
        // $data['request_approval'] = DB::table('assignments')
        //     ->join('users', 'assignments.created_by', '=', 'users.id')
        //     ->whereIn('assignments.assign_status', [0,1,2])
        //     ->where(function($query) use ($auth_team) {
        //         for ($i = 0; $i < count($auth_team); $i++){
        //             $query->orWhere('users.team_id', $auth_team[$i])
        //                 ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
        //                 ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
        //         }
        //     })
        //     ->whereYear('assignments.created_at', $year)
        //     ->whereMonth('assignments.created_at', $month)
        //     ->select('assignments.created_by')
        //     ->distinct()->get();

        return view('headManager.approval_general', $data);
    }

    public function approval_history()
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['assignments_history'] = DB::table('assignments')
        ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
        ->leftJoin('api_customers', 'api_customers.identify', 'assignments.assign_shop')
        ->join('users', 'assignments.created_by', 'users.id')
        ->whereNotIn('assignments.assign_status', [0, 3]) // สถานะอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน, 4=แก้ไขงาน))
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

        return view('headManager.approval_general_history', $data);
    }

    public function approval_history_search(Request $request){
        // dd($request);

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

        // dd($data);

        return view('headManager.approval_general_history', $data);
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

        return view('headManager.approval_general_history_detail', $data);
    }


    public function approval_general_detail($id)
    {
        $data['request_approval'] = Assignment::join('users', 'assignments.created_by', '=', 'users.id')
        ->select(
            'users.name' ,
            'assignments.*')
        ->whereIn('assignments.assign_status', [0, 1, 2])
        ->where('assignments.created_by', $id)
        ->where('assignments.assign_request_date', '!=', "NULL")
        ->orderBy('id', 'desc')->get();

        return view('headManager.approval_general_detail', $data);
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
                return view('headManager.create_comment_request_approval', $data);
            }else {
                return view('headManager.create_comment_request_approval', $data);
            }
    }

    public function create_comment_request_approval(Request $request)
    {
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
            } else {
                DB::table('assignments_comments')
                ->insert([
                    'assign_id' => $request->id,
                    'assign_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
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

            // return redirect(url('head/approval_general_detail', $request->createID));

    }

}
