<?php

namespace App\Http\Controllers\Admin;

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
        // $data['request_approval'] = DB::table('assignments')
        // ->join('users', 'assignments.created_by', '=', 'users.id')
        // ->whereIn('assignments.assign_status', [0,1,2])
        //     ->select('assignments.created_by')
        //     ->distinct()->get();

        // return view('admin.approval_general', $data);
    }

    public function approval_history()
    {
        $request = "";
        $data = $this->fetch_approval_history($request);
        return view('admin.approval_general_history', $data);
    }

    public function approval_history_search(Request $request)
    {     
        $data = $this->fetch_approval_history($request);
        return view('admin.approval_general_history', $data);
    }

    public function fetch_approval_history($request)
    {
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

        if(isset($request->selectteam_sales)){
            $selectteam_sales =  $request->selectteam_sales;
            $assignments_history = $assignments_history
                ->where(function($query) use ($selectteam_sales) {
                    $query->orWhere('users.team_id', $selectteam_sales)
                        ->orWhere('users.team_id', 'like', $selectteam_sales.',%')
                        ->orWhere('users.team_id', 'like', '%,'.$selectteam_sales);
                });
            $data['checkteam_sales'] = $request->selectteam_sales;
        }

        if(isset($request->selectusers)){
            $assignments_history = $assignments_history
            ->where('assignments.created_by', $request->selectusers);
            $data['checkusers'] = $request->selectusers;
        }

        if(isset($request->selectdateFrom)){
            $assignments_history = $assignments_history
            ->whereDate('assignments.assign_request_date', '>=', $request->selectdateFrom);
            $data['checkdateFrom'] = $request->selectdateFrom;
        }else{
            $data['checkdateFrom'] = "";
        }

        if(isset($request->selectdateTo)){
            $assignments_history = $assignments_history
            ->whereDate('assignments.assign_request_date', '<=', $request->selectdateTo);
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
            ->get();
        $data['team_sales'] = DB::table('master_team_sales')->get();

        return $data;
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

        return view('admin.approval_general_history_detail', $data);
    }


    public function approval_general_detail($id)
    {
        $data['request_approval'] = Assignment::join('users', 'assignments.created_by', '=', 'users.id')
        ->select(
            'users.name' ,
            'assignments.*')
        ->whereIn('assignments.assign_status', [0,1,2])
        // ->where('assignments.created_by', $id)
        ->where('assignments.assign_request_date', '!=', "NULL")
        ->orderBy('id', 'desc')->get();

        return view('admin.approval_general_detail', $data);
    }

    public function search(Request $request)
    {
        list($year,$month) = explode('-', $request->selectdateTo);

            $data['request_approval'] = DB::table('assignments')
        ->join('users', 'assignments.created_by', '=', 'users.id')
        ->whereIn('assignments.assign_status', [0,1,2])
        ->whereYear('assignments.created_at', $year)
        ->whereMonth('assignments.created_at', $month)
            ->select('assignments.created_by')
            ->distinct()->get();

            return view('admin.approval_general', $data);
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
                return view('admin.create_comment_request_approval', $data);
            }else {
                return view('admin.create_comment_request_approval', $data);
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

            return redirect(url('admin/approval_general_detail', $request->createID));

    }

}
