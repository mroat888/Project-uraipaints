<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class UnionTripController extends Controller
{
    public function __construct()
    {
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['trips'] = DB::table('trip_header')->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->get();

        switch  (Auth::user()->status){
            case 1 :    return view('saleman.trip', $data); 
                break;
            case 2 :    return view('leadManager.trip', $data); 
                break;
            case 3 :    return view('headManager.trip', $data); 
                break;
            case 4 :   
                break;
        }
    }

    public function create()
    {
        $today = date('Y-m-d');
        list($year,$month,$day) = explode('-', $today);
        $trips = DB::table('trip_header')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('created_by', Auth::user()->id)
            ->first();

        if(is_null($trips)){

            return response()->json([
                'status' => 200,
                'api_identify' => Auth::user()->api_identify,
                'namesale' => Auth::user()->name,
            ]);
            
        }else{
            return response()->json([
                'status' => 404,
                'trip_header' => $trips,
                'api_identify' => Auth::user()->api_identify,
                'namesale' => Auth::user()->name,
            ]);
        }
    }

    public function edit($id)
    {
        $trip_header = DB::table('trip_header')->where('id', $id)->first();
        return response()->json([
            'status' => 200,
            'message' => 'ดึงข้อมูลสำเร็จ',
            'trip_header' => $trip_header,
            'api_identify' => Auth::user()->api_identify,
            'namesale' => Auth::user()->name,
        ]);
    }

    public function store(Request $request)
    {
        $insert = DB::table('trip_header')->insert([
            'trip_start' => $request->trip_start,
            'trip_end' => $request->trip_end,
            'trip_day' => $request->trip_day,
            'allowance' => $request->allowance,
            'sum_allowance' => $request->sum_allowance,
            'trip_status' => 0,
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if($insert){
            $trip_id = DB::table('trip_header')->orderby('id', 'desc')->first();
        }

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'trip_id' => $trip_id->id,
        ]);
    }

    public function update(Request $request)
    {
        DB::table('trip_header')->where('id', $request->trip_header_id)
        ->update([
            'trip_start' => $request->trip_start_edit,
            'trip_end' => $request->trip_end_edit,
            'trip_day' => $request->trip_day_edit,
            'allowance' => $request->allowance_edit,
            'sum_allowance' => $request->sum_allowance_edit,
            'trip_status' => 0,
            'updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
        ]);
    }

    public function destroy(Request $request)
    {
        DB::table('trip_header')->where('id', $request->trip_header_id_delete)->delete();
        DB::table('trip_detail')->where('trip_header_id', $request->trip_header_id_delete)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลสำเร็จ',
        ]);
    }

    public function request_approve($id)
    {
        DB::table('trip_header')->where('id', $id)
        ->update([
            'request_approve_at' => date('Y-m-d H:i:s'),
            'trip_status' => '1',
        ]);
        return redirect()->back(); 
    }

    public function manager_request_approve($id)
    {
        DB::table('trip_header')->where('id', $id)
        ->update([
            'request_approve_at' => date('Y-m-d H:i:s'),
            'approve_at' => date('Y-m-d H:i:s'),
            'approve_id' => Auth::user()->id,
            'trip_status' => '2',
        ]);
        return redirect()->back(); 
    }

    public function trip_detail($id)
    {
        $api_token = $this->api_token->apiToken();  
        
        $data['trip_header'] = DB::table('trip_header')->where('id', $id)->first();
        $data['users'] = DB::table('users')->where('id', $data['trip_header']->created_by)->first();
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

                foreach($data['provinces'] as $provinces){
                    if($value->trip_from == $provinces['identify'] ){
                        $formprovince = $provinces['name_thai'];
                    }

                    if($value->trip_to == $provinces['identify'] ){
                        $toprovince = $provinces['name_thai'];
                    }
                }

                foreach($customer_api as $customer){
                    if($value->customer_id == $customer['identify']){
                        $customer_name = $customer['title']." ".$customer['name'];
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

        switch  (Auth::user()->status){
            case 1 :    return view('saleman.tripdetail', $data); 
                break;
            case 2 :    return view('leadManager.tripdetail', $data); 
                break;
            case 3 :    return view('headManager.tripdetail', $data); 
                break;
            case 4 :   
                break;
        }
    }

    public function trip_detail_store(Request $request){

        DB::table('trip_detail')->insert([
            'trip_header_id' => $request->trip_header_id,
            'trip_detail_date' => $request->trip_detail_date,
            'trip_from' => $request->formprovince,
            'trip_to' => $request->toprovince,
            'customer_id' => $request->customer_id,
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
        ]);

    }

    public function trip_detail_edit($id)
    {
        $api_token = $this->api_token->apiToken();  
        
        $trip_detail = DB::table('trip_detail')->where('id', $id)->first();

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
                $provinces = $res_api['data'];
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
            'province_id' => $trip_detail->trip_to,
        ]);
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $customer_api = $res_api['data'];
        }
        // --- จบ ดึงข้อมูลร้านค้า


        return response()->json([
            'status' => 200,
            'trip_detail' => $trip_detail,
            'provinces' => $provinces,
            'customer_api' => $customer_api,
        ]);

    }

    public function trip_detail_update(Request $request)
    {
        DB::table('trip_detail')->where('id', $request->trip_detail_id)
        ->update([
            'trip_detail_date' => $request->trip_detail_date_edit,
            'trip_from' => $request->formprovince_edit,
            'trip_to' => $request->toprovince_edit,
            'customer_id' => $request->customer_id_edit,
            'updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
        ]);
    }

    public function trip_detail_destroy(Request $request)
    {
        DB::table('trip_detail')->where('id', $request->trip_detail_id_delete)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลสำเร็จ',
        ]);
    }

}
