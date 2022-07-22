<?php

namespace App\Http\Controllers\ShareData_Union;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportCustomerCompareYearController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $year = date('Y');
        $year_2 = $year+0;
        $year_1 = $year-1; 

        if($year_2 >= $year_1){
            $year_2 = $year_2;
            $year_1 = $year_1; 
        }else{
            $year_2 = $year_1;
            $year_1 = $year_2; 
        }
        
        $request = "";
        $data = $this->querycostomercompare($year_1, $year_2, $request);

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_customer_compare_year', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_customer_compare_year', $data);
                break;
            case 3 :    return view('shareData_headManager.report_customer_compare_year', $data);
                break;
            case 4 :    return view('shareData_admin.report_customer_compare_year', $data);
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

        $data = $this->querycostomercompare($year_1, $year_2, $request);

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_customer_compare_year', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_customer_compare_year', $data);
                break;
            case 3 :    return view('shareData_headManager.report_customer_compare_year', $data);
                break;
            case 4 :    return view('shareData_admin.report_customer_compare_year', $data);
                break;
        }
    }

    public function querycostomercompare($year_1, $year_2, $request)
    {
        $year_search = $year_1.",".$year_2;
        $data['year_search'] = array($year_1, $year_2);
        
        switch  (Auth::user()->status){
            case 1 :    $path_search_provinces = "sellers/".Auth::user()->api_identify."/provinces";
                        $path_search = "reports/years/".$year_search."/sellers/".Auth::user()->api_identify."/customers?year_compare=Y";
                break;
            case 2 :    $path_search_provinces = "saleleaders/".Auth::user()->api_identify."/provinces";
                        $path_search = "reports/years/".$year_search."/leaders/".Auth::user()->api_identify."/customers?year_compare=Y";
                break;
            case 3 :    $path_search_provinces = "saleheaders/".Auth::user()->api_identify."/provinces";
                        $path_search = "reports/years/".$year_search."/headers/".Auth::user()->api_identify."/customers?year_compare=Y";
                break;
            case 4 :    $path_search_provinces = "provinces";
                        $path_search = "reports/years/".$year_search."/customers?year_compare=Y";
                break;
        }

        $api_token = $this->api_token->apiToken();
        // --- หาจังหวัดแสดงในส่วนค้นหา --
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search_provinces);
        $api_provinces = $response->json();
        foreach($api_provinces['data'] as $value){
            if($value['identify'] != ""){
                $data['provinces'][] = [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                    'region_id' => $value['region_id']
                ];
            }
        }
        // --- จบ หาจังหวัดแสดงในส่วนค้นหา --

        if(isset($request->province) && !is_null($request->province)){
            $path_search .= "&province_id=".$request->province;
            $data['keysearch_provinces'] = $request->province;
        }

        if(isset($request->amphur) && !is_null($request->amphur)){
            $path_search .= "&amphoe_id=".$request->amphur;
            $data['keysearch_amphur'] = $request->amphur;
        }

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $api_customer = $response->json();

        //-- แยกข้อมูลออกเป็น 2 ชุด 
        $year_1 = $year_1; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี
        $year_2 = $year_2; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี

        if(!is_null($api_customer) && $api_customer['code'] == 200){

            $data['trans_last_date'] = $api_customer['trans_last_date'];

            $identify_array = array();
            foreach($api_customer['data'] as $value){ //-- เก็บรหัส identify ทั้งหมดเพื่อเช็ค
                if(!in_array($value['identify'], $identify_array)){
                    $identify_array[] = $value['identify'];
                }
            }

            foreach($api_customer['data'] as $value){

                if($year_1 == $value['year']){ //--  ข้อมูลชุดที่ 1 (ปีเก่า)
                    $customer_api[$year_1][] = [
                        'year' => $value['year'],
                        'identify' => $value['identify'],
                        'title' => $value['title'],
                        'name' => $value['name'],
                        'sales' => $value['sales'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }

                if($year_2 == $value['year']){ //-- ข้อมูลชุดที่ 2 (ปีใหม่)
                    $customer_api[$year_2][] = [
                        'year' => $value['year'],
                        'identify' => $value['identify'],
                        'title' => $value['title'],
                        'name' => $value['name'],
                        'sales' => $value['sales'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }

            }

            //-- ส่วนประมวลผล เพื่อใช้ Datatable
            $sum_sales = 0;
            $sum_compare_sale = 0;
            $sum_customer_diff = 0;
            $sum_persent_diff = 0;

            for($i = 0; $i<count($identify_array); $i++){
                $customer_name = "";
                $customer_diff = 0;
                $persent_diff = 0 ;
                $year1_sales = 0;
                $year2_sales = 0;
                $year1_sales_th = 0;
                $year2_sales_th = 0;

                if(isset($customer_api[$year_1])){
                    foreach($customer_api[$year_1] as $year1_value){
                        if($year1_value['identify'] == $identify_array[$i]){
                            $customer_name = $year1_value['name'];
                            $year1_sales_th = $year1_value['sales_th'];
                            $year1_sales = $year1_value['sales'];
                        }
                    }
                }

                if(isset($customer_api[$year_2])){
                    foreach($customer_api[$year_2] as $year2_value){
                        if($year2_value['identify'] == $identify_array[$i]){
                            $customer_name = $year2_value['name'];
                            $year2_sales_th = $year2_value['sales_th'];
                            $year2_sales = $year2_value['sales'];
                        }
                    }
                }

                $customer_diff = $year2_sales -  $year1_sales;

                if($year2_sales != 0){
                    $persent_diff = ($customer_diff*100)/$year2_sales;
                }else{
                    $persent_diff = -100;
                }


                $data['customer_compare_api'][] = [
                    'identify' => $identify_array[$i],
                    'name' => $customer_name,
                    'sales' => $year1_sales,
                    'compare_sales' => $year2_sales,
                    'sales_th' => $year1_sales_th,
                    'compare_sales_th' => $year2_sales_th,
                    'customer_diff' => $customer_diff,
                    'persent_diff' => $persent_diff,
                ];
                
                $sum_sales += $year1_sales;
                $sum_compare_sale += $year2_sales;
            }

            // dd(count($identify_array), $data['customer_compare_api']);

            $sum_customer_diff = $sum_compare_sale - $sum_sales;
            if($sum_sales > 0){
                $sum_persent_diff = ($sum_customer_diff*100)/$sum_sales;
            }else{
                $sum_persent_diff = 0;
            }

            $data['summary_customer_compare_api'] = [
                'sum_sales' => $sum_sales,
                'sum_compare_sale' => $sum_compare_sale,
                'sum_customer_diff' => $sum_customer_diff,
                'sum_persent_diff' => $sum_persent_diff,
            ];
            // -- จบส่วนประมวลผล เพื่อใช้ Datatable
        }

        return $data;

    }


}
