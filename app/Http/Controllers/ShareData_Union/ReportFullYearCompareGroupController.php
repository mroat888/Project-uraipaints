<?php

namespace App\Http\Controllers\ShareData_Union;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportFullYearCompareGroupController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $year = date("Y");
        $year_2 = $year+0;
        $year_1 = $year-1; 
        $sel_month = "";
        $sel_team = "";
        $sel_seller = "";

        $data = $this->queryfullyearcompare($year_1, $year_2, $sel_month, $sel_team, $sel_seller);

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_full_year_compare_group', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_full_year_compare_group', $data);
                break;
            case 3 :    return view('shareData_headManager.report_full_year_compare_group', $data);
                break;
            case 4 :    return view('shareData_admin.report_full_year_compare_group', $data);
                break;
        }
    }

    public function search(Request $request)
    {
        if($request->sel_year_to >= $request->sel_year_form){
            $year_2 = $request->sel_year_to;
            $year_1 = $request->sel_year_form; 
        }else{
            $year_2 = $request->sel_year_form;
            $year_1 = $request->sel_year_to; 
        }

        if(isset($request->sel_month_form) && !is_null($request->sel_month_form)){
            $sel_month = $request->sel_month_form;
        }else{
            $sel_month = "";
        }

        if(isset($request->selectteam_sales) && !is_null($request->selectteam_sales)){
            $sel_team = $request->selectteam_sales;
        }else{
            $sel_team = "";
        }


        if(isset($request->selectusers) && !is_null($request->selectusers)){
            $sel_seller = $request->selectusers;  
        }else{
            $sel_seller = "";
        }
        
        $data = $this->queryfullyearcompare($year_1, $year_2, $sel_month, $sel_team, $sel_seller);
        
        if(is_null($data)){
            $data['year_search'] = array($year_2, $year_1);
        }

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_full_year_compare_group', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_full_year_compare_group', $data);
                break;
            case 3 :    return view('shareData_headManager.report_full_year_compare_group', $data);
                break;
            case 4 :    return view('shareData_admin.report_full_year_compare_group', $data);
                break;
        }
    }

    public function queryfullyearcompare($year_1, $year_2, $month, $sel_team, $sel_seller)
    {
        $year_search = $year_1.",".$year_2;
        $data['sel_users'] = $sel_seller;
        $data['sel_team_sales'] = $sel_team;
        $data['sel_month'] = $month;

        switch  (Auth::user()->status){
            case 1 :    $path_search = "reports/years/".$year_search."/sellers/".Auth::user()->api_identify."/pdgroups"; 
                break;
            case 2 :    $path_search = "reports/years/".$year_search."/leaders/".Auth::user()->api_identify."/pdgroups";
                break;
            case 3 :    $path_search = "reports/years/".$year_search."/headers/".Auth::user()->api_identify."/pdgroups";
                break;
            case 4 :    $path_search = "reports/years/".$year_search."/pdgroups";
                break;
        }

        $api_token = $this->api_token->apiToken();

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search,[
            'sortorder' => 'DESC',
            'year_compare' => 'Y',
            'month' => $month, 
            'team_id' => $sel_team,
            'seller_id' => $sel_seller,
        ]);
        $res_api = $response->json();

        //-- แยกข้อมูลออกเป็น 2 ชุด 
        $year_1 = $year_1; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี (ปีเก่า)
        $year_2 = $year_2; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี (ปีใหม่)
            
        if(!is_null($res_api) && $res_api['code'] == 200){
            $data['trans_last_date'] = $res_api['trans_last_date'];
            // dd($res_api['data']);
            foreach($res_api['data'] as $value){

                if(isset($value['pdgroup_id'])){
                    $pdgroup_id = $value['pdgroup_id'];
                }elseif(isset($value['identify'])){
                    $pdgroup_id = $value['identify'];
                }else{
                    $pdgroup_id = "";
                }

                if(isset($value['pdgroup_name'])){
                    $pdgroup_name = $value['pdgroup_name'];
                }elseif(isset($value['name'])){
                    $pdgroup_name = $value['name'];
                }else{
                    $pdgroup_name = "";
                }


                if($year_1 == $value['year']){ //--  ข้อมูลชุดที่ 1 (ปีเก่า)
                    $pdgroup_api[$year_1][] = [
                        'year' => $value['year'],
                        'pdgroup_id' => $pdgroup_id,
                        'pdgroup_name' => $pdgroup_name,
                        'sales' => $value['sales'],
                        'customers' => $value['customers'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }

                if($year_2 == $value['year']){ //-- ข้อมูลชุดที่ 2 (ปีใหม่)
                    $pdgroup_api[$year_2][] = [
                        'year' => $value['year'],
                        'pdgroup_id' => $pdgroup_id,
                        'pdgroup_name' => $pdgroup_name,
                        'sales' => $value['sales'],
                        'customers' => $value['customers'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }
            }

            //-- ส่วนประมวลผล เพื่อใช้ Datatable
            $count_1 = 0;
            $count_2 = 0;
            if(isset($pdgroup_api[$year_1])){
                $count_1 = count($pdgroup_api[$year_1]);
            }
            if(isset($pdgroup_api[$year_2])){
                $count_2 = count($pdgroup_api[$year_2]);
            }

            if($count_1 >= $count_2){
                $group_count = $pdgroup_api[$year_1];
                $compare_year = $year_2;
                $data['year_search'] = array($year_1, $year_2);
            }else{
                $group_count = $pdgroup_api[$year_2];
                $compare_year = $year_1;
                $data['year_search'] = array($year_2, $year_1);
            }

            foreach($group_count as $key => $pdg_compare){
                $compare_sales = 0;
                $compare_sales_th = 0;
                
                $sale_diff = 0;
                $persent_diff = 0;

                //-- ใช้เช็คค่ ฟิลล์ที่ส่งมาจาก API แต่ระบบชื่อไม่เหมือนกันแต่ข้อมูลเดียวกัน --
                if(isset($pdg_compare['pdgroup_id'])){
                    $pdgroup_id = $pdg_compare['pdgroup_id'];
                }elseif(isset($value['identify'])){
                    $pdgroup_id = $pdg_compare['identify'];
                }else{
                    $pdgroup_id = "";
                }

                if(isset($pdg_compare['pdgroup_name'])){
                    $pdgroup_name = $pdg_compare['pdgroup_name'];
                }elseif(isset($value['name'])){
                    $pdgroup_name = $pdg_compare['name'];
                }else{
                    $pdgroup_name = "";
                }
                //-- จบ ใช้เช็คค่ ฟิลล์ที่ส่งมาจาก API แต่ระบบชื่อไม่เหมือนกันแต่ข้อมูลเดียวกัน --

                if(isset($pdgroup_api[$compare_year])){
                    foreach($pdgroup_api[$compare_year] as $value_compare){

                        //-- ใช้เช็คค่ ฟิลล์ที่ส่งมาจาก API แต่ระบบชื่อไม่เหมือนกันแต่ข้อมูลเดียวกัน --
                        if(isset($value_compare['pdgroup_id'])){
                            $pdgroup_compare_id = $value_compare['pdgroup_id'];
                        }elseif(isset($value['identify'])){
                            $pdgroup_compare_id = $value_compare['identify'];
                        }else{
                            $pdgroup_compare_id = "";
                        }
                        //-- จบ ใช้เช็คค่ ฟิลล์ที่ส่งมาจาก API แต่ระบบชื่อไม่เหมือนกันแต่ข้อมูลเดียวกัน --

                        if($pdgroup_compare_id == $pdgroup_id){
                            $compare_sales_th = $value_compare['sales_th'];
                            $compare_sales = $value_compare['sales'];
                            
                            $sale_diff = $compare_sales - $pdg_compare['sales'];
                            if($pdg_compare['sales'] != 0){
                                $persent_diff = ($sale_diff*100)/$pdg_compare['sales'];
                            }
                        }
                    }
                }

                if($sale_diff == 0){
                    $sale_diff = 0 - $pdg_compare['sales'];
                }

                if($persent_diff == 0){
                    if($pdg_compare['sales'] != 0){
                        $persent_diff = ($sale_diff*100)/$pdg_compare['sales'];
                    }
                }
                $data['pdggroup_compare'][] = [
                    'pdgroup_id' => $pdgroup_id,
                    'pdgroup_name' => $pdgroup_name,
                    'sales_1' => $pdg_compare['sales'],
                    'sales_2' => $compare_sales,
                    'sale_diff' => $sale_diff,
                    'persent_diff' => $persent_diff,
                ];
            }

            // ดึงข้อมูล ทีม และ ผู้แทนขาย
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
            //-- จบส่วนประมวลผล เพื่อใช้ Datatable
        }else{
            $data = null;
        }

        return $data;
    }

}
