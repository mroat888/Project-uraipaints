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
        // $data['request_approval'] = DB::table('assignments')
        // ->join('users', 'assignments.created_by', '=', 'users.id')
        // ->whereIn('assignments.assign_status', [0,1,2])
        // ->where('users.team_id', Auth::user()->team_id)
        // ->select('assignments.created_by')
        // ->distinct()->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        $data['request_approval'] = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->whereIn('assignments.assign_status', [0,1,2])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select('assignments.created_by')
            ->distinct()->get();

        return view('headManager.approval_general', $data);
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
        ->where('assignments.assign_status', 0)
        ->where('assignments.created_by', $id)
        ->where('assignments.assign_request_date', '!=', "NULL")
        ->orderBy('id', 'desc')->get();

        return view('headManager.approval_general_detail', $data);
    }

    public function search(Request $request){
        list($year,$month) = explode('-', $request->selectdateTo);

        // $data['request_approval'] = DB::table('assignments')
        // ->join('users', 'assignments.created_by', '=', 'users.id')
        // ->whereIn('assignments.assign_status', [0,1,2])
        // ->where('users.team_id', Auth::user()->team_id)
        // ->whereYear('assignments.created_at', $year)
        // ->whereMonth('assignments.created_at', $month)
        // ->select('assignments.created_by')
        // ->distinct()->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        $data['request_approval'] = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->whereIn('assignments.assign_status', [0,1,2])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->whereYear('assignments.created_at', $year)
            ->whereMonth('assignments.created_at', $month)
            ->select('assignments.created_by')
            ->distinct()->get();

        return view('headManager.approval_general', $data);
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
                return view('headManager.create_comment_request_approval', $data);
            }else {
                return view('headManager.create_comment_request_approval', $data);
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

            return redirect(url('head/approval_general_detail', $request->createID));

    }

}
