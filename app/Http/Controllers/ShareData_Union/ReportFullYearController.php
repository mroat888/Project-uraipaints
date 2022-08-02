<?php

namespace App\Http\Controllers\ShareData_Union;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportFullYearController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){

        $year = date('Y');
        // $year = "2020";
        $api_token = $this->api_token->apiToken();

        switch  (Auth::user()->status){
            case 1 :    $path_group_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdgroups";
                        $path_subgroup_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdsubgroups"; 
                        $path_pdlist_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdlists"; 
                break;
            case 2 :    $path_group_top = "reports/years/".$year."/leaders/".Auth::user()->api_identify."/pdgroups";
                        $path_subgroup_top = "reports/years/".$year."/leaders/".Auth::user()->api_identify."/pdsubgroups"; 
                        $path_pdlist_top = "reports/years/".$year."/leaders/".Auth::user()->api_identify."/pdlists"; 
                break;
            case 3 :    $path_group_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdgroups";
                        $path_subgroup_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdsubgroups"; 
                        $path_pdlist_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdlists"; 
                break;
            case 4 :    $path_group_top = "reports/years/".$year."/pdgroups";
                        $path_subgroup_top = "reports/years/".$year."/pdsubgroups"; 
                        $path_pdlist_top = "reports/years/".$year."/pdlists"; 
                break;
        }

        // กลุ่มสินค้า สำหรับค้นหา
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $group_api = $response->json();
        
        $data['group_api'] = $group_api['data'];

        // สินค้า Top Group
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_group_top,[
            'sortorder' => 'DESC'
        ]);
        $data['grouptop_api'] = $response->json();
        // dd($data['grouptop_api'] );

        $sum_group_sales = 0;
        $sum_group_customers = 0;

        foreach($data['grouptop_api']['data'] as $key => $value){
            $sum_group_sales += $value['sales'];
            $sum_group_customers += $value['customers'];
        }

        $data['summary_group_api'] = [
            'sum_group_sales' => $sum_group_sales,
            'sum_group_customers' => $sum_group_customers,
        ];
        // จบ สินค้า Top Group

        // สินค้า Top SubGroup
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_subgroup_top,[
            'sortorder' => 'DESC'
        ]);
        $data['subgrouptop_api'] = $response->json();

        $sum_subgroup_sales = 0;
        $sum_subgroup_customers = 0;

        foreach($data['grouptop_api']['data'] as $key => $value){
            $sum_subgroup_sales += $value['sales'];
            $sum_subgroup_customers += $value['customers'];
        }

        $data['summary_subgroup_api'] = [
            'sum_subgroup_sales' => $sum_subgroup_sales,
            'sum_subgroup_customers' => $sum_subgroup_customers,
        ];
        // จบ สินค้า Top SubGroup
        

        // สินค้า Top Product List   
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_pdlist_top,[
            'sortorder' => 'DESC'
        ]);
        $data['pdlisttop_api'] = $response->json();

        $sum_pdlist_sales = 0;
        $sum_pdlist_customers = 0;


        foreach($data['pdlisttop_api']['data'] as $key => $value){
            $sum_pdlist_sales += $value['sales'];
            $sum_pdlist_customers += $value['customers'];
        }

        $data['summary_pdlist_api'] = [
            'sum_pdlist_sales' => $sum_pdlist_sales,
            'sum_pdlist_customers' => $sum_pdlist_customers,
        ];
        // จบ สินค้า Top Product List  

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        if(Auth::user()->status == 4){ // สิทธิ์แอดมิน
            $data['users'] = DB::table('users')
            ->whereIn('status', [1]) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();

            $data['team_sales'] = DB::table('master_team_sales')->get();
        }else{
            $data['users'] = DB::table('users')
            ->whereIn('status', [1]) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })->get();

            $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })->get();
        }
    
        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_full_year', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_full_year', $data);
                break;
            case 3 :    return view('shareData_headManager.report_full_year', $data);
                break;
            case 4 :    return view('shareData_admin.report_full_year', $data);
                break;
        }
    }

    public function search(Request $request){

        $year = date('Y');
        $sel_group = "";
        $sel_subgroup = "";
        $sel_productlist = "";
        $sel_month = "";
        $selectteam_sales = "";
        $selectusers = "";

        if(!is_null($request->sel_year)){
            $year = $request->sel_year;
        }

        if(!is_null($request->sel_group)){
            $sel_group = implode( ',', $request->sel_group);
            $sel_group = "/".$sel_group;
        }
        if(!is_null($request->sel_subgroup)){
            $sel_subgroup = implode( ',', $request->sel_subgroup);
            $sel_subgroup = "/".$sel_subgroup;
        }
        if(!is_null($request->sel_productlist)){
            $sel_productlist = implode( ',', $request->sel_productlist);
            $sel_productlist = "/".$sel_productlist;
        }
        if(!is_null($request->sel_month_form)){
            $sel_month = $request->sel_month_form;
        }
        if(!is_null($request->selectteam_sales)){
            $selectteam_sales = $request->selectteam_sales;
        }
        if(!is_null($request->selectusers)){
            $selectusers = $request->selectusers;
        }

        switch  (Auth::user()->status){
            case 1 :    $path_group_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdgroups".$sel_group;
                        $path_subgroup_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdsubgroups".$sel_subgroup; 
                        $path_pdlist_top = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/pdlists".$sel_productlist; 
                break;
            case 2 :    $path_group_top = "reports/years/".$year."/leaders/".Auth::user()->api_identify."/pdgroups".$sel_group;
                        $path_subgroup_top = "reports/years/".$year."/leaders/".Auth::user()->api_identify."/pdsubgroups".$sel_subgroup; 
                        $path_pdlist_top = "reports/years/".$year."/leaders/".Auth::user()->api_identify."/pdlists".$sel_productlist; 
                break;
            case 3 :    $path_group_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdgroups".$sel_group;
                        $path_subgroup_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdsubgroups".$sel_subgroup; 
                        $path_pdlist_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdlists".$sel_productlist; 
                break;
            case 4 :    $path_group_top = "reports/years/".$year."/pdgroups".$sel_group;
                        $path_subgroup_top = "reports/years/".$year."/pdsubgroups".$sel_subgroup; 
                        $path_pdlist_top = "reports/years/".$year."/pdlists".$sel_productlist; 
                break;
        }

        $api_token = $this->api_token->apiToken();

        // กลุ่มสินค้า สำหรับค้นหา
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $group_api = $response->json();
        $data['group_api'] = $group_api['data'];

        // สินค้า Top Group
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_group_top,[
            'sortorder' => 'DESC',
            'month' => $sel_month,
            'team_id' => $selectteam_sales,
            'seller_id' => $selectusers,
        ]);
        $data['grouptop_api'] = $response->json();
        // dd($data['grouptop_api'] );

        $sum_group_sales = 0;
        $sum_group_customers = 0;

        if(!is_null($data['grouptop_api']) && $data['grouptop_api']['code'] == 200){
            foreach($data['grouptop_api']['data'] as $key => $value){
                $sum_group_sales += $value['sales'];
                $sum_group_customers += $value['customers'];
            }
        }

        $data['summary_group_api'] = [
            'sum_group_sales' => $sum_group_sales,
            'sum_group_customers' => $sum_group_customers,
        ];
        // จบ สินค้า Top Group

        // สินค้า Top SubGroup
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_subgroup_top,[
            'sortorder' => 'DESC',
            'month' => $sel_month,
            'team_id' => $selectteam_sales,
            'seller_id' => $selectusers,
        ]);
        $data['subgrouptop_api'] = $response->json();

        // dd($request, $path_subgroup_top, $data['subgrouptop_api']);

        $sum_subgroup_sales = 0;
        $sum_subgroup_customers = 0;

        if(!is_null($data['subgrouptop_api']) && $data['subgrouptop_api']['code'] == 200){
            foreach($data['subgrouptop_api']['data'] as $key => $value){
                $sum_subgroup_sales += $value['sales'];
                $sum_subgroup_customers += $value['customers'];
            }
        }

        $data['summary_subgroup_api'] = [
            'sum_subgroup_sales' => $sum_subgroup_sales,
            'sum_subgroup_customers' => $sum_subgroup_customers,
        ];
        // จบ สินค้า Top SubGroup
        

        // สินค้า Top Product List   
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_pdlist_top,[
            'sortorder' => 'DESC',
            'month' => $sel_month,
            'team_id' => $selectteam_sales,
            'seller_id' => $selectusers,
        ]);
        $data['pdlisttop_api'] = $response->json();

        $sum_pdlist_sales = 0;
        $sum_pdlist_customers = 0;

        if(!is_null($data['pdlisttop_api']) && $data['pdlisttop_api']['code'] == 200){
            foreach($data['pdlisttop_api']['data'] as $key => $value){
                $sum_pdlist_sales += $value['sales'];
                $sum_pdlist_customers += $value['customers'];
            }
        }

        $data['summary_pdlist_api'] = [
            'sum_pdlist_sales' => $sum_pdlist_sales,
            'sum_pdlist_customers' => $sum_pdlist_customers,
        ];
        // จบ สินค้า Top Product List  

        // หาทีม และ ผู้แทนขานในทีม
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        if(Auth::user()->status == 4){ // สิทธิ์แอดมิน
            $data['users'] = DB::table('users')
            ->whereIn('status', [1]) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();

            $data['team_sales'] = DB::table('master_team_sales')->get();
        }else{
            $data['users'] = DB::table('users')
            ->whereIn('status', [1]) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })->get();

            $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })->get();
        }
        // จบ หาทีม และ ผู้แทนขานในทีม

        // dd($path_search_top);
        $data['sel_month'] = $sel_month;
        $data['sel_team_sales'] = $selectteam_sales;
        $data['sel_users'] = $selectusers;

        

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_full_year', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_full_year', $data);
                break;
            case 3 :    return view('shareData_headManager.report_full_year', $data);
                break;
            case 4 :    return view('shareData_admin.report_full_year', $data);
                break;
        }
   
    }

    public function show($pdgroup,$year,$month,$team,$seller,$id)
    {
        $data[] = null;
        // dd($pdgroup,$year,$id);

        switch  (Auth::user()->status){
            case 1 :    $path_search = "reports/years/".$year."/sellers/".Auth::user()->api_identify."/".$pdgroup."/".$id."/customers";
                break;
            case 2 :    $path_search = "reports/years/".$year."/leaders/".Auth::user()->api_identify."/".$pdgroup."/".$id."/customers";
                break;
            case 3 :    $path_search = "reports/years/".$year."/headers/".Auth::user()->api_identify."/".$pdgroup."/".$id."/customers";
                break;
            case 4 :    $path_search = "reports/years/".$year."/".$pdgroup."/".$id."/customers";
                break;
        }

        switch($pdgroup){
            case "pdgroups" : $search_listgroups = "groups/".$id;   
                break; 
            case "pdsubgroups" : $search_listgroups = "subgroups/".$id;   
                break; 
            case "pdlists" : $search_listgroups = "pdglists/".$id;   
                break; 
        }


        $api_token = $this->api_token->apiToken();

       

        if($month == 0){
            $month = "";
        }else{
            $month = $month;
        }

        if($team == "0"){
            $team_id = "";
        }else{
            if(Auth::user()->status > 1){ // -- เฉพาะสิทธ์ผู้จัดการและแอดมิน
                $team_id = $team;
            }else{
                $team_id = "";
            }
        }

        if($seller == "0"){
            $seller_id = "";
        }else{
            if(Auth::user()->status > 1){ // -- เฉพาะสิทธ์ผู้จัดการและแอดมิน
                $seller_id = $seller;
            }else{
                $seller_id = "";
            }
        }

    
        //-- บล๊อคที่ 1 ชื่อกลุ่ม
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$search_listgroups,[
            'month' => $month,
            'team_id' => $team_id,
            'seller_id' => $seller_id,
        ]);
        $res_group = $response->json();

        //-- จบ บล๊อคที่ 1 ชื่อกลุ่ม

       // dd($res_group['data'][0]['identify']);

        //-- บล๊อคที่ 2 ร้านค้า
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search,[
            'sortorder' => 'DESC',
            'month' => $month,
            'team_id' => $team_id,
            'seller_id' => $seller_id,
        ]);
        $res_api = $response->json();

        // dd($res_api);

        if(isset($res_api) && $res_api['code'] == 200 ){
            $data['customer_api'] = $res_api;

            $sum_sales = 0;
            $sum_sales_present = 0;
            foreach($data['customer_api']['data'] as $value){
                $sum_sales += $value['sales'];
            }

            $data['pdgroup_api'] = [
                'identify' => $res_group['data'][0]['identify'],
                'name' => $res_group['data'][0]['name'],
                'sum_sales' => $sum_sales,
            ];

        }
        //-- จบ บล๊อคที่ 2 ร้านค้า

        

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_full_year_detail', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_full_year_detail', $data);
                break;
            case 3 :    return view('shareData_headManager.report_full_year_detail', $data);
                break;
            case 4 :    return view('shareData_admin.report_full_year_detail', $data);
                break;
        }

    }
}
