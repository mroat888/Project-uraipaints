<?php

namespace App\Http\Controllers\ShareData_Union;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportProductReturnController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){

        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $year = $year+0;
        $year_search = $year;

        $data['year_search'] = $year;

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

        // dd($year_api);
        if(!is_null($year_api) && $year_api['code'] == 200){

            foreach($year_api['data'] as $value){
                // $persent_sale =  round(($value['netSales'] * 100 ) / $sum_netSales);
                $data['yearadmin_api'][] = [
                    'year' => $value['year'],
                    // 'identify' => $value['identify'],
                    // 'name' => $value['name'],
                    'sales' => $value['sales'],
                    'credits' => $value['credits'],
                    '%Credit' => $value['%Credit'],
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
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $month_api = $response->json();

        if(!is_null($month_api) && $month_api['code'] == 200){

            foreach($month_api['data'] as $value){
                $data['monthadmin_api'][] = [
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
            $data['customer_trans_last_date'] = $month_api['trans_last_date'];
        }
        // dd($data['monthadmin_api']);
         /**
         *   --------- จบ บล๊อกที่ รายเดือน ------------- 
         */

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_product_return', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_product_return', $data);
                break;
            case 3 :    return view('shareData_headManager.report_product_return', $data);
                break;
            case 4 :    return view('shareData_admin.report_product_return', $data);
                break;
        }
    }

    public function search(Request $request){
        $year = $request->sel_year_form;
        $year_search = $year;
        $data['year_search'] = $year;

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

        // dd($year_api);
        if(!is_null($year_api) && $year_api['code'] == 200){

            foreach($year_api['data'] as $value){
                // $persent_sale =  round(($value['netSales'] * 100 ) / $sum_netSales);
                $data['yearadmin_api'][] = [
                    'year' => $value['year'],
                    // 'identify' => $value['identify'],
                    // 'name' => $value['name'],
                    'sales' => $value['sales'],
                    'credits' => $value['credits'],
                    '%Credit' => $value['%Credit'],
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
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $month_api = $response->json();

        if(!is_null($month_api) && $month_api['code'] == 200){

            foreach($month_api['data'] as $value){
                $data['monthadmin_api'][] = [
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
            $data['customer_trans_last_date'] = $month_api['trans_last_date'];
        }
        // dd($data['monthadmin_api']);
         /**
         *   --------- จบ บล๊อกที่ รายเดือน ------------- 
         */

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.report_product_return', $data);
                break;
            case 2 :    return view('shareData_leadManager.report_product_return', $data);
                break;
            case 3 :    return view('shareData_headManager.report_product_return', $data);
                break;
            case 4 :    return view('shareData_admin.report_product_return', $data);
                break;
        }
    }

}

