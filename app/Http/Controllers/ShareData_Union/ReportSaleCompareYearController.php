<?php

namespace App\Http\Controllers\ShareData_LeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportSaleCompareYearController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){
        /**
         *   --------- บล๊อกที่ 1 ------------- 
         */
        
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $api_token = $this->api_token->apiToken();

        switch  (Auth::user()->status){
            case 1 :    $path_search = "campaigns/years/".$year."/sellers/".Auth::user()->api_identify;
                break;
            case 2 :    $path_search = "campaigns/years/".$year."/leaders/".Auth::user()->api_identify;
                break;
            case 3 :    $path_search = "campaigns/years/".$year."/headers/".Auth::user()->api_identify;
                break;
            case 4 :    $path_search = "campaigns/years/".$year."/admins/";
                break;
        }

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search,[
            'back_years' => 1
        ]);

        $campaigns_year = array();
        $customer_campaigns = array();

        if($response['code'] == 200){
            // $data['compare_api'] = $response->json();
            $campaigns_year_api = $response->json();

            foreach($campaigns_year_api['data'] as $key => $value){
                $campaigns_year[$key] = [
                    'year' => $value['year'],
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'TotalPromotion' => $value['TotalPromotion'],
                    'TotalCustomer' => $value['TotalCustomer'],
                    'TotalLimit' => $value['TotalLimit'],
                    'TotalAmountSale' => $value['TotalAmountSale'],
                    'DiffAmount' => $value['DiffAmount'],
                    'amount_limit_th' => $value['amount_limit_th'],
                    'amount_net_th' => $value['amount_net_th'],
                ];

                $path_search = "campaigns/saleleaders/".Auth::user()->api_identify."/customers";
                $response_campaigns = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search,[
                    'years' => $value['year'],
                ]);

                if($response_campaigns['code'] == 200){
                    $cust_campaigns_api = $response_campaigns->json();
                    foreach($cust_campaigns_api['data'] as $key_cust => $value_cust){
                        $customer_campaigns[$key][$key_cust] = [
                            'year' => $value_cust['year'],
                            'province_name' => $value_cust['province_name'],
                            'amphoe_name' => $value_cust['amphoe_name'],
                            'identify' => $value_cust['identify'],
                            'name' => $value_cust['name'],
                            'TotalPromotion' => $value_cust['TotalPromotion'],
                            'TotalLimit' => $value_cust['TotalLimit'],
                            'TotalAmountSale' => $value_cust['TotalAmountSale'],
                            'DiffAmount' => $value_cust['DiffAmount'],
                            'amount_limit_th' => $value_cust['amount_limit_th'],
                            'amount_net_th' => $value_cust['amount_net_th']
                        ];
                    }

                    // $myCollection[] = collect($customer_campaigns[$key]);
                }
            }
           
            $data['customer_campaigns'] = $customer_campaigns;
            $data['campaigns_year'] = $campaigns_year;
        }

        /**
         *   --------- จบ บล๊อกที่ 1 ------------- 
         */


        /**
         *  --------- บล๊อกที่ 2 ------------- 
         */

        $patch_search = "/campaigns/years/".$year."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$patch_search,[
            'saleleader_id' => Auth::user()->api_identify,
        ]);
        $res_api = $response->json();

        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['customer_api'] = $res_api;
            }
        }

        $data['year'] = $year;

        // ดึงจังหวัด -- API
        $path_search = "/saleleaders/".Auth::user()->api_identify."/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['provinces'] = $res_api;
            }
        }

        /**
         *   --------- จบ บล๊อกที่ 2 ------------- 
         */

        switch  (Auth::user()->status){
            case 1 : $return = "shareData.report_sale_compare_year";
                break;
            case 2 : $return = "shareData_leadManager.report_sale_compare_year";
                break;
            case 3 : $return = "shareData_headManager.report_sale_compare_year";
                break;
            case 4 : $return = "shareData_admin.report_sale_compare_year";
                break;
        }

        return view($return, $data);
    }

    public function search(request $request)
    {   
        /**
         *   --------- บล๊อกที่ 1 ------------- 
         */
        
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $path_search = "campaigns/years/".$year."/leaders/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search,[
            'back_years' => 1
        ]);

        $data['api_token'] = $api_token ;

        $campaigns_year = array();
        $customer_campaigns = array();

        if($response['code'] == 200){
            // $data['compare_api'] = $response->json();
            $campaigns_year_api = $response->json();

            foreach($campaigns_year_api['data'] as $key => $value){
                $campaigns_year[$key] = [
                    'year' => $value['year'],
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'TotalPromotion' => $value['TotalPromotion'],
                    'TotalCustomer' => $value['TotalCustomer'],
                    'TotalLimit' => $value['TotalLimit'],
                    'TotalAmountSale' => $value['TotalAmountSale'],
                    'DiffAmount' => $value['DiffAmount'],
                    'amount_limit_th' => $value['amount_limit_th'],
                    'amount_net_th' => $value['amount_net_th'],
                ];

                $path_search = "campaigns/saleleaders/".Auth::user()->api_identify."/customers";
                $response_campaigns = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search,[
                    'years' => $value['year'],
                ]);

                if($response_campaigns['code'] == 200){
                    $cust_campaigns_api = $response_campaigns->json();
                    foreach($cust_campaigns_api['data'] as $key_cust => $value_cust){
                        $customer_campaigns[$key][$key_cust] = [
                            'year' => $value_cust['year'],
                            'province_name' => $value_cust['province_name'],
                            'amphoe_name' => $value_cust['amphoe_name'],
                            'identify' => $value_cust['identify'],
                            'name' => $value_cust['name'],
                            'TotalPromotion' => $value_cust['TotalPromotion'],
                            'TotalLimit' => $value_cust['TotalLimit'],
                            'TotalAmountSale' => $value_cust['TotalAmountSale'],
                            'DiffAmount' => $value_cust['DiffAmount'],
                            'amount_limit_th' => $value_cust['amount_limit_th'],
                            'amount_net_th' => $value_cust['amount_net_th']
                        ];
                    }

                    // $myCollection[] = collect($customer_campaigns[$key]);
                }
            }
           
            $data['customer_campaigns'] = $customer_campaigns;
            $data['campaigns_year'] = $campaigns_year;
        }

        /**
         *   --------- จบ บล๊อกที่ 1 ------------- 
         */


         /**
         *  --------- บล๊อกที่ 2 ------------- 
         */

        $patch_search = "/campaigns/years/".$request->year_form_search."/customers";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$patch_search,[
            'saleleader_id' => Auth::user()->api_identify,
            'province_id' => $request->province, 
            'amphoe_id' => $request->amphur,
        ]);
        $res_api = $response->json();

        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['customer_api'] = $res_api;
            }
        }

        $data['year'] = $request->year_form_search;

        // ดึงจังหวัด -- API
        $path_search = "/saleleaders/".Auth::user()->api_identify."/provinces";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$path_search);
        $res_api = $response->json();
        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['provinces'] = $res_api;
            }
        }

        /**
         *   --------- จบ บล๊อกที่ 2 ------------- 
         */

        
        return view('shareData_leadManager.report_sale_compare_year', $data);
    }

}
