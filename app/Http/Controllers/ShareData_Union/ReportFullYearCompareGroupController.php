<?php

namespace App\Http\Controllers\ShareData_Union;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportFullYearCompareGroupController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){

        $year = date("Y");
        $year_2 = $year+0;
        $year_1 = $year-1; 
        $year_search = $year_1.",".$year_2;

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
        ]);
        $res_api = $response->json();

        //-- แยกข้อมูลออกเป็น 2 ชุด 
        $year_1 = $year_1; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี (ปีเก่า)
        $year_2 = $year_2; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี (ปีใหม่)
            
        // dd($res_api);
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
            $count_1 = count($pdgroup_api[$year_1]);
            $count_2 = count($pdgroup_api[$year_2]);

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
                    'sales_1' => $pdg_compare['sales_th'],
                    'sales_2' => $compare_sales_th,
                    'sale_diff' => $sale_diff,
                    'persent_diff' => $persent_diff,
                ];
            }
            //-- จบส่วนประมวลผล เพื่อใช้ Datatable
        }

        // dd($res_api, $pdggroup_compare);

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

    public function search(Request $request){
        
        $year_2 = $request->sel_year_to;
        $year_1 = $request->sel_year_form; 
        $year_search = $year_1.",".$year_2;

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
        ]);
        $res_api = $response->json();

        //-- แยกข้อมูลออกเป็น 2 ชุด 
        $year_1 = $year_1; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี (ปีเก่า)
        $year_2 = $year_2; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี (ปีใหม่)
            
        // dd($res_api);
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
            $count_1 = count($pdgroup_api[$year_1]);
            $count_2 = count($pdgroup_api[$year_2]);

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
                    'sales_1' => $pdg_compare['sales_th'],
                    'sales_2' => $compare_sales_th,
                    'sale_diff' => $sale_diff,
                    'persent_diff' => $persent_diff,
                ];
            }
            //-- จบส่วนประมวลผล เพื่อใช้ Datatable
        }

        // dd($res_api, $pdggroup_compare);

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

}
