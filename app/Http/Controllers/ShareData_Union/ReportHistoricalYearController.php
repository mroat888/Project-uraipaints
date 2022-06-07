<?php

namespace App\Http\Controllers\ShareData_Union;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportHistoricalYearController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){

        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $year = $year+0;
        $year_old1 = $year-1; 
        $year_search = $year.",".$year_old1;

        $data['year_search'] = array($year, $year_old1);

         /**
         *   --------- บล๊อกที่ รายปี ------------- 
         */

        switch  (Auth::user()->status){
            case 1 :    $path_search = "reports/years/".$year_search."/sellers/".Auth::user()->api_identify;
                break;
            case 2 :    $path_search = "reports/years/".$year_search."/leaders/".Auth::user()->api_identify;
                break;
            case 3 :    $path_search = "reports/years/".$year_search."/headers/".Auth::user()->api_identify;
                break;
            case 4 :    $path_search = "reports/years/".$year_search;
                break;
        }

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $year_api = $response->json();


        if($year_api['code'] == 200){

            foreach($year_api['data'] as $value){
                // $persent_sale =  round(($value['netSales'] * 100 ) / $sum_netSales);
                $data['yearadmin_api'][] = [
                    'year' => $value['year'],
                    // 'identify' => $value['identify'],
                    // 'name' => $value['name'],
                    'sales' => $value['sales'],
                    'customers' => $value['customers'],
                    'months' => $value['months'],
                    'sales_th' => $value['sales_th'],
                ];        
            }

            $data['trans_last_date'] = $year_api['trans_last_date'];
        }

         /**
         *   --------- จบ บล๊อกที่ รายปี ------------- 
         */

         /**
         *   --------- บล๊อกที่ รายเดือน ------------- 
         */

        switch  (Auth::user()->status){
            case 1 :    $path_search = "reports/years/".$year_search."/sellers/".Auth::user()->api_identify."/months";
                break;
            case 2 :    $path_search = "reports/years/".$year_search."/leaders/".Auth::user()->api_identify."/months";
                break;
            case 3 :    $path_search = "reports/years/".$year_search."/headers/".Auth::user()->api_identify."/months";
                break;
            case 4 :    $path_search = "reports/years/".$year_search."/months";
                break;
        }

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search, [
            'year_compare' => 'Y'
        ]);
        $month_api = $response->json();

        if($month_api['code'] == 200){

            $year = $data['yearadmin_api'][0]['year']; //-- ให้สัมพันธ์กับค้นหาปีด้านบน
            $year_old1 = $data['yearadmin_api'][1]['year']; //-- ให้สัมพันธ์กับค้นหาปีด้านบน

            foreach($month_api['data'] as $value){

                if($year == $value['year']){ //-- แยกข้อมูลออกเป็น 2 ชุด ข้อมูลชุดที่ 1
                    $data['monthadmin_api'][$year][] = [
                        // 'identify' => $value['identify'],
                        // 'name' => $value['name'],
                        'year' => $value['year'],
                        'quater' => $value['quater'],
                        'month' => $value['month'],
                        'sales' => $value['sales'],
                        'credits' => $value['credits'],
                        '%Credit' => $value['%Credit'],
                        'customers' => $value['customers'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }

                if($year_old1 == $value['year']){ //-- ข้อมูลชุดที่ 2
                    $data['monthadmin_api'][$year_old1][] = [
                        // 'identify' => $value['identify'],
                        // 'name' => $value['name'],
                        'year' => $value['year'],
                        'quater' => $value['quater'],
                        'month' => $value['month'],
                        'sales' => $value['sales'],
                        'credits' => $value['credits'],
                        '%Credit' => $value['%Credit'],
                        'customers' => $value['customers'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }
            }
            $data['customer_trans_last_date'] = $month_api['trans_last_date'];
        }
         /**
         *   --------- จบ บล๊อกที่ รายเดือน ------------- 
         */

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_historical_year', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_historical_year', $data);
                break;
            case 3 :    return view('shareData_headManager.report_historical_year', $data);
                break;
            case 4 :    return view('shareData_admin.report_historical_year', $data);
                break;
        }

    }

    public function search(Request $request){

        $year = $request->sel_year_form;
        $year_old1 = $request->sel_year_to; 
        $year_search = $year.",".$year_old1;

         /**
         *   --------- บล๊อกที่ รายปี ------------- 
         */

        switch  (Auth::user()->status){
            case 1 :    $path_search = "reports/years/".$year_search."/sellers/".Auth::user()->api_identify;
                break;
            case 2 :    $path_search = "reports/years/".$year_search."/leaders/".Auth::user()->api_identify;
                break;
            case 3 :    $path_search = "reports/years/".$year_search."/headers/".Auth::user()->api_identify;
                break;
            case 4 :    $path_search = "reports/years/".$year_search;
                break;
        }

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $year_api = $response->json();

        if($year_api['code'] == 200){

            foreach($year_api['data'] as $value){
                // $persent_sale =  round(($value['netSales'] * 100 ) / $sum_netSales);
                $data['yearadmin_api'][] = [
                    'year' => $value['year'],
                    // 'identify' => $value['identify'],
                    // 'name' => $value['name'],
                    'sales' => $value['sales'],
                    'customers' => $value['customers'],
                    'months' => $value['months'],
                    'sales_th' => $value['sales_th'],
                ];        
            }

            $data['trans_last_date'] = $year_api['trans_last_date'];
        }

         /**
         *   --------- จบ บล๊อกที่ รายปี ------------- 
         */

         /**
         *   --------- บล๊อกที่ รายเดือน ------------- 
         */

        switch  (Auth::user()->status){
            case 1 :    $path_search = "reports/years/".$year_search."/sellers/".Auth::user()->api_identify."/months";
                break;
            case 2 :    $path_search = "reports/years/".$year_search."/leaders/".Auth::user()->api_identify."/months";
                break;
            case 3 :    $path_search = "reports/years/".$year_search."/headers/".Auth::user()->api_identify."/months";
                break;
            case 4 :    $path_search = "reports/years/".$year_search."/months";
                break;
        }

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search, [
            'year_compare' => 'Y'
        ]);
        $month_api = $response->json();

        if($month_api['code'] == 200){

            $year = $data['yearadmin_api'][0]['year']; //-- ให้สัมพันธ์กับค้นหาปีด้านบน
            $year_old1 = $data['yearadmin_api'][1]['year']; //-- ให้สัมพันธ์กับค้นหาปีด้านบน

            foreach($month_api['data'] as $value){

                if($year == $value['year']){ //-- แยกข้อมูลออกเป็น 2 ชุด ข้อมูลชุดที่ 1
                    $data['monthadmin_api'][$year][] = [
                        // 'identify' => $value['identify'],
                        // 'name' => $value['name'],
                        'year' => $value['year'],
                        'quater' => $value['quater'],
                        'month' => $value['month'],
                        'sales' => $value['sales'],
                        'credits' => $value['credits'],
                        '%Credit' => $value['%Credit'],
                        'customers' => $value['customers'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }

                if($year_old1 == $value['year']){ //-- ข้อมูลชุดที่ 2
                    $data['monthadmin_api'][$year_old1][] = [
                        // 'identify' => $value['identify'],
                        // 'name' => $value['name'],
                        'year' => $value['year'],
                        'quater' => $value['quater'],
                        'month' => $value['month'],
                        'sales' => $value['sales'],
                        'credits' => $value['credits'],
                        '%Credit' => $value['%Credit'],
                        'customers' => $value['customers'],
                        'sales_th' => $value['sales_th'],
                    ];        
                }
            }
            $data['customer_trans_last_date'] = $month_api['trans_last_date'];
        }
         /**
         *   --------- จบ บล๊อกที่ รายเดือน ------------- 
         */

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_historical_year', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_historical_year', $data);
                break;
            case 3 :    return view('shareData_headManager.report_historical_year', $data);
                break;
            case 4 :    return view('shareData_admin.report_historical_year', $data);
                break;
        }
    }
}
