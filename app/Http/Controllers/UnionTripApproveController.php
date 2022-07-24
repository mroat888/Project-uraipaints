<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class UnionTripApproveController extends Controller
{
    public function __construct()
    {
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $page = "index";
        $data = $this->fetch_approve_trip($page);

        switch  (Auth::user()->status){
            case 2 :    return view('leadManager.approval_trip', $data);
                break;
            case 3 :    return view('headManager.approval_trip', $data);
                break;
        }
    }

    public function trip_history()
    {
        $page = "history";
        $data = $this->fetch_approve_trip($page);

        switch  (Auth::user()->status){
            case 2 :    return view('leadManager.approval_trip_history', $data);
                break;
            case 3 :    return view('headManager.approval_trip_history', $data);
                break;
        }
    }

    public function fetch_approve_trip($page)
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $trip_header = DB::table('trip_header')
            ->join('users', 'trip_header.created_by', '=', 'users.id')
            ->select(
                'trip_header.*',
                'users.name',
                'users.api_identify'
            )
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->where('users.status', '1'); // เฉพาะ saleman

            if($page == "index"){
                $trip_header = $trip_header->where('trip_header.trip_status', 1); // สถานส่งขออนุมัติ
            }

            if($page == "history"){
                $trip_header = $trip_header->whereNotIn('trip_header.trip_status', [0,1]); // ไม่ดึง แบบร่าง และขออนุมัติ
            }

            $trip_header = $trip_header->orderBy('trip_header.id', 'desc')->get();

        $data['trip_header'] = $trip_header;

        $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        return $data;
    }

    public function search(Request $request)
    {
        $page = "index";
        $data = $this->search_fetch($request, $page);

        switch  (Auth::user()->status){
            case 2 :    return view('leadManager.approval_trip', $data);
                break;
            case 3 :    return view('headManager.approval_trip', $data);
                break;
            case 4 :
                break;
        }
    }

    public function trip_history_search(Request $request)
    {
        $page = "history";
        $data = $this->search_fetch($request, $page);

        switch  (Auth::user()->status){
            case 2 :    return view('leadManager.approval_trip_history', $data);
                break;
            case 3 :    return view('headManager.approval_trip_history', $data);
                break;
            case 4 :
                break;
        }
    }


    public function search_fetch($request, $page)
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $trip_header = DB::table('trip_header')
            ->join('users', 'trip_header.created_by', '=', 'users.id')
            ->select(
                'trip_header.*',
                'users.name',
                'users.api_identify'
            )
            ->where('users.status', '1'); // เฉพาะ saleman

            if($page == "index"){
                $trip_header = $trip_header->where('trip_header.trip_status', 1); // สถานส่งขออนุมัติ
            }

            if($page == "history"){
                $trip_header = $trip_header->whereNotIn('trip_header.trip_status', [0,1]); // ไม่ดึง แบบร่าง และขออนุมัติ
            }

        if(!is_null($request->selectteam_sales)){
            $team = $request->selectteam_sales;
            $trip_header = $trip_header->where(function($query) use ($team) {
                    $query->orWhere('users.team_id', $team)
                        ->orWhere('users.team_id', 'like', $team.',%')
                        ->orWhere('users.team_id', 'like', '%,'.$team);
                            });
        }else{
            $trip_header = $trip_header->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            });
        }

        if(!is_null($request->selectdateFrom)){
            list($year,$month) = explode('-', $request->selectdateFrom);
            $trip_header =  $trip_header->whereMonth('trip_header.trip_date', $month)
                ->whereYear('trip_header.trip_date', $year);
        }

            $trip_header =  $trip_header->orderBy('trip_header.id', 'desc')
            ->get();

        $data['trip_header'] = $trip_header;

        $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        return $data;
    }

    public function approval_trip_confirm_all(Request $request)
    {
        DB::beginTransaction();
        try {
            $count_checkapprove = count($request->checkapprove);

            if(!is_null($request->approve)){
                $trip_status = 2; // อนุมัติ
            }else{
                $trip_status = 3; // ปฎิเสธ
            }

            for($i=0;$i<$count_checkapprove; $i++){
                DB::table('trip_header')->where('id', $request->checkapprove[$i])
                ->update([
                    'trip_status' => $trip_status,
                    'approve_at' => date('Y-m-d H:i:s'),
                    'approve_id' => Auth::user()->id,
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }

    public function trip_retrospective(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::table('trip_header')->where('id', $request->restros_id)
            ->update([
                'trip_status' => '0',
                'approve_at' => date('Y-m-d H:i:s'),
                'approve_id' => Auth::user()->id,
            ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }

    public function trip_fetchshowdetail($id)
    {
        $api_token = $this->api_token->apiToken();

        $data['trip_header'] = DB::table('trip_header')->where('id', $id)->first();
        $data['users'] = DB::table('users')->where('id', $data['trip_header']->created_by)->first();
        $data['trip_revision'] = DB::table('trip_header_revision_history')->where('trip_header_id', $id)->orderBy('id','desc')->first();

        $data['trip_comments'] = DB::table('trip_comments')
            ->leftJoin('users', 'users.id', 'trip_comments.created_by')
            ->where('trip_comments.trip_header_id', $id)
            ->select(
                'users.name',
                'trip_comments.*',
            )
            ->get();

        $trip_detail = DB::table('trip_detail')->where('trip_header_id', $id)->get();

        // ดึงจังหวัด -- API
        switch  (Auth::user()->status){
            case 1 :    $path_search = "sellers/".Auth::user()->api_identify."/provinces";
                break;
            case 2 :    $path_search = 'saleleaders/'.Auth::user()->api_identify.'/provinces';
                break;
            case 3 :    $path_search = 'saleheaders/'.Auth::user()->api_identify.'/provinces';
                break;
            case 4 :    $path_search = 'provinces';
                break;
        }
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['provinces'] = $res_api['data'];
            }
        }

        // --- ดึงข้อมูลร้านค้า
        switch  (Auth::user()->status){
            case 1 :    $path_search = 'sellers/'.Auth::user()->api_identify.'/customers';
                break;
            case 2 :    $path_search = 'saleleaders/'.Auth::user()->api_identify.'/customers';
                break;
            case 3 :    $path_search = 'saleheaders/'.Auth::user()->api_identify.'/customers';
                break;
            case 4 :    $path_search = 'customers';
                break;
        }

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'sortorder' => 'DESC',
        ]);
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $customer_api = $res_api['data'];
        }
        // --- จบ ดึงข้อมูลร้านค้า

        $data['trip_detail'] = array();
        
        if(count($trip_detail) > 0){
            foreach($trip_detail as $value){
                $formprovince = "-";
                $toprovince = "-";
                foreach($data['provinces'] as $provinces){
                    if($value->trip_from == $provinces['identify'] ){
                        $formprovince = $provinces['name_thai'];
                    }

                    if($value->trip_to == $provinces['identify'] ){
                        $toprovince = $provinces['name_thai'];
                    }
                }

                $customer_name = "";
                $customers = explode(',', $value->customer_id);
                foreach($customers as $customer_id){
                    foreach($customer_api as $customer){
                        if($customer_id == $customer['identify']){
                            $customer_name .= $customer['title']." ".$customer['name']."<br />";
                        }
                    }
                }

                $data['trip_detail'][] = [
                    'id' => $value->id,
                    'trip_header_id' => $value->trip_header_id,
                    'trip_detail_date' => $value->trip_detail_date,
                    'trip_from' => $formprovince,
                    'trip_to' => $toprovince,
                    'customer_id' => $customer_name
                ];
            }
        }

        return $data;
    }

    public function trip_showdetail($id)
    {
        $data = $this->trip_fetchshowdetail($id);

        switch  (Auth::user()->status){
            case 1 :    return view('saleman.approval_trip_showdetail', $data);
                break;
            case 2 :    return view('leadManager.approval_trip_showdetail', $data);
                break;
            case 3 :    return view('headManager.approval_trip_showdetail', $data);
                break;
            case 4 :    return view('admin.approval_trip_showdetail', $data);
                break;
        }
    }

    public function trip_editdetail($id)
    {
        $data = $this->trip_fetchshowdetail($id);

        switch  (Auth::user()->status){
            case 2 :    return view('leadManager.approval_trip_editdetail', $data);
                break;
            case 3 :
                break;
            case 4 :
                break;
        }
    }

    public function trip_updatedetail(Request $request)
    {
        $check_trip = DB::table('trip_header')->where('id', $request->trip_header_id)->first();

        if(($check_trip->trip_day != $request->trip_day) || ($check_trip->allowance != $request->allowance) || ($check_trip->sum_allowance != $request->sum_allowance)){
            DB::table('trip_header_revision_history')
            ->insert([
                'trip_header_id' => $check_trip->id,
                'trip_day_history' => $check_trip->trip_day,
                'allowance_history' => $check_trip->allowance,
                'sum_allowance_history' => $check_trip->sum_allowance,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('trip_header')->where('id', $request->trip_header_id)
            ->update([
                'trip_day' => $request->trip_day,
                'allowance' => $request->allowance,
                'sum_allowance' => $request->sum_allowance,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if((isset($request->checkapprove)) && ($request->checkapprove == "approve")){
            DB::table('trip_header')->where('id', $request->trip_header_id)
            ->update([
                'approve_at' => date('Y-m-d H:i:s'),
                'approve_id' => Auth::user()->id,
                'trip_status' => 2,
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
        ]);
    }

    public function trip_comment(Request $request)
    {
        if(is_null($request->trip_comment_id)){
            DB::table('trip_comments')
            ->insert([
                'trip_header_id' => $request->trip_header_id,
                'trip_comment_detail' => $request->comment_detail,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }else{
            DB::table('trip_comments')
            ->where('id', $request->trip_comment_id)
            ->update([
                'trip_header_id' => $request->trip_header_id,
                'trip_comment_detail' => $request->comment_detail,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
        ]);

    }

    public function report_email($id)
    {
        $data = $this->trip_fetchshowdetail($id);

        switch  (Auth::user()->status){
            case 1 :    return view('saleman.approval_trip_showdetail', $data);
                break;
            case 2 :    return view('leadManager.approval_trip_showdetail', $data);
                break;
            case 3 :    return view('headManager.approval_trip_showdetail', $data);
                break;
            case 4 :    return view('admin.approval_trip_showdetail', $data);
                break;
        }
    }

}
