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

    public function index(){

        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $year_2 = $year+0;
        $year_1 = $year-1; 
        $year_search = $year_1.",".$year_2;

        switch  (Auth::user()->status){
            case 1 :    $path_search_provinces = "sellers/".Auth::user()->api_identify."/provinces";
                        $path_search = "reports/years/".$year_search."/sellers/".Auth::user()->api_identify."/customers"; 
                break;
            case 2 :    $path_search_provinces = "saleleaders/".Auth::user()->api_identify."/provinces";
                        $path_search = "reports/years/".$year_search."/leaders/".Auth::user()->api_identify."/customers";
                break;
            case 3 :    $path_search_provinces = "saleheaders/".Auth::user()->api_identify."/provinces";
                        $path_search = "reports/years/".$year_search."/headers/".Auth::user()->api_identify."/customers";
                break;
            case 4 :    $path_search_provinces = "provinces";
                        $path_search = "reports/years/".$year_search."/customers";
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

        $data['keysearch_provinces'] = $data['provinces'][0]['identify']; 

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'province_id' => $data['provinces'][0]['identify'],
            'year_compare' => 'Y',
        ]);
        $api_customer = $response->json();

        //-- แยกข้อมูลออกเป็น 2 ชุด 
        $year_1 = $year_1; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี
        $year_2 = $year_2; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี

        // dd($api_customer);
        if(!is_null($api_customer) && $api_customer['code'] == 200){

            $data['trans_last_date'] = $api_customer['trans_last_date'];

            foreach($api_customer['data'] as $value){

                if($year_1 == $value['year']){ //--  ข้อมูลชุดที่ 1
                    $customer_api[$year_1][] = [
                        'year' => $value['year'],
                        'identify' => $value['identify'],
                        'title' => $value['title'],
                        'name' => $value['name'],
                        'sales' => $value['sales'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }

                if($year_2 == $value['year']){ //-- ข้อมูลชุดที่ 2
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
            $count_1 = count($customer_api[$year_1]);
            $count_2 = count($customer_api[$year_2]);

            if($count_1 >= $count_2){
                $customer_count = $customer_api[$year_1];
                $compare_year = $year_2;
                $data['year_search'] = array($year_1, $year_2);
            }else{
                $customer_count = $customer_api[$year_2];
                $compare_year = $year_1;
                $data['year_search'] = array($year_2, $year_1);
            }

            $sum_sales = 0;
            $sum_compare_sale = 0;
            $sum_customer_diff = 0;
            $sum_persent_diff = 0;

            // dd($customer_count);

            foreach($customer_count as $key => $customer){
                $customer_diff = 0;
                $persent_diff = 0 ;
                $customer_compare_sales = 0;
                $customer_compare_sales_th = 0;

                foreach($customer_api[$compare_year] as $customer_compare){
                    if($customer_compare['identify'] == $customer['identify']){
                        $customer_compare_sales = $customer_compare['sales'];
                        $customer_compare_sales_th = $customer_compare['sales_th'];
                        $customer_diff = $customer_compare['sales'] - $customer['sales'];
                        if($customer['sales'] != 0){
                            $persent_diff = ($customer_diff*100)/$customer['sales'];
                        }
                    }
                }

                if($customer_diff == 0){
                    $customer_diff = 0 - $customer['sales'];
                }

                if($persent_diff == 0){
                    if($customer['sales'] != 0){
                        $persent_diff = ($customer_diff*100)/$customer['sales'];
                    }
                }

                $data['customer_compare_api'][] = [
                    'identify' => $customer['identify'],
                    'name' => $customer['name'],
                    'sales_th' => $customer['sales_th'],
                    'compare_sales_th' => $customer_compare_sales_th,
                    'customer_diff' => $customer_diff,
                    'persent_diff' => $persent_diff,
                ];
                
                $sum_sales += $customer['sales'];
                $sum_compare_sale += $customer_compare_sales;
            }

            $sum_customer_diff = $sum_compare_sale - $sum_sales;
            $sum_persent_diff = ($sum_customer_diff*100)/$sum_sales;

            $data['summary_customer_compare_api'] = [
                'sum_sales' => $sum_sales,
                'sum_compare_sale' => $sum_compare_sale,
                'sum_customer_diff' => $sum_customer_diff,
                'sum_persent_diff' => $sum_persent_diff,
            ];
            // -- จบส่วนประมวลผล เพื่อใช้ Datatable
        }
       
        
        // dd($data['customer_api']);

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

    public function search(Request $request){
        //dd($request);

        $year_2 = $request->sel_year_to;
        $year_1 = $request->sel_year_form; 
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


        if(!is_null($request->province)){
            $path_search .= "&province_id=".$request->province;
            $data['keysearch_provinces'] = $request->province;
        }

        if(!is_null($request->amphur)){
            $path_search .= "&amphoe_id=".$request->amphur;
            $data['keysearch_amphur'] = $request->amphur;
        }


        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $api_customer = $response->json();

        //-- แยกข้อมูลออกเป็น 2 ชุด 
        $year_1 = $year_1; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี
        $year_2 = $year_2; //-- ใช้แบ่งกลุ่มลูกค้าแต่ละปี

        //dd($path_search, $api_customer);
        
        if(!is_null($api_customer) && $api_customer['code'] == 200){

            $data['trans_last_date'] = $api_customer['trans_last_date'];

            foreach($api_customer['data'] as $value){

                if($year_1 == $value['year']){ //--  ข้อมูลชุดที่ 1
                    $customer_api[$year_1][] = [
                        'year' => $value['year'],
                        'identify' => $value['identify'],
                        'title' => $value['title'],
                        'name' => $value['name'],
                        'sales' => $value['sales'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }

                if($year_2 == $value['year']){ //-- ข้อมูลชุดที่ 2
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
            $count_1 = count($customer_api[$year_1]);
            $count_2 = count($customer_api[$year_2]);

            if($count_1 >= $count_2){
                $customer_count = $customer_api[$year_1];
                $compare_year = $year_2;
                $data['year_search'] = array($year_1, $year_2);
            }else{
                $customer_count = $customer_api[$year_2];
                $compare_year = $year_1;
                $data['year_search'] = array($year_2, $year_1);
            }

            $sum_sales = 0;
            $sum_compare_sale = 0;
            $sum_customer_diff = 0;
            $sum_persent_diff = 0;

            // dd($customer_count);

            foreach($customer_count as $key => $customer){
                $customer_diff = 0;
                $persent_diff = 0 ;
                $customer_compare_sales = 0;
                $customer_compare_sales_th = 0;

                foreach($customer_api[$compare_year] as $customer_compare){
                    if($customer_compare['identify'] == $customer['identify']){
                        $customer_compare_sales = $customer_compare['sales'];
                        $customer_compare_sales_th = $customer_compare['sales_th'];
                        $customer_diff = $customer_compare['sales'] - $customer['sales'];
                        if($customer['sales'] != 0){
                            $persent_diff = ($customer_diff*100)/$customer['sales'];
                        }
                    }
                }

                if($customer_diff == 0){
                    $customer_diff = 0 - $customer['sales'];
                }

                if($persent_diff == 0){
                    if($customer['sales'] != 0){
                        $persent_diff = ($customer_diff*100)/$customer['sales'];
                    }
                }

                $data['customer_compare_api'][] = [
                    'identify' => $customer['identify'],
                    'name' => $customer['name'],
                    'sales_th' => $customer['sales_th'],
                    'compare_sales_th' => $customer_compare_sales_th,
                    'customer_diff' => $customer_diff,
                    'persent_diff' => $persent_diff,
                ];
                
                $sum_sales += $customer['sales'];
                $sum_compare_sale += $customer_compare_sales;
            }

            $sum_customer_diff = $sum_compare_sale - $sum_sales;
            $sum_persent_diff = ($sum_customer_diff*100)/$sum_sales;

            $data['summary_customer_compare_api'] = [
                'sum_sales' => $sum_sales,
                'sum_compare_sale' => $sum_compare_sale,
                'sum_customer_diff' => $sum_customer_diff,
                'sum_persent_diff' => $sum_persent_diff,
            ];
            // -- จบส่วนประมวลผล เพื่อใช้ Datatable
        }
        
        // dd($data['customer_compare_api']);

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


}
