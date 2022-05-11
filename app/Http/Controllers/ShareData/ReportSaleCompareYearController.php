<?php

namespace App\Http\Controllers\ShareData;

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

        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $path_search = "campaigns/years/".$year."/sellers/".Auth::user()->api_identify;
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

                $path_search = "campaigns/sellers/".Auth::user()->api_identify."/customers";
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
            

            //--- คำนวนสรูปแต่ะละจังหวัด  -- ทำไม่เสร็จเว้นไว้ก่อน
            
            // $data['sum_TotalPromotion'] = array();
            // $first_loop = "Y";
            

            // foreach($data['campaigns_year'] as $key => $value){
                
            //     $province_name_check = "";
            //     $sum_TotalPromotion = 0;
            //     $sum_TotalLimit = 0;
            //     $sum_TotalAmountSale = 0;
                
                
            //     foreach($data['customer_campaigns'][$key] as $key_cust => $value_cust){


            //         if($province_name_check != $value_cust['province_name']){

            //             $province_name_check = $value_cust['province_name'];
            //             if($first_loop == "Y"){
            //                 $first_loop = "N";
                            
            //             }else{
            //                 $data['sum_TotalPromotion'][$key][] =  $sum_TotalPromotion;
            //                 $data['province_name'][$key][] = $value_cust['province_name'];
            //                 $sum_TotalPromotion = 0;
            //             }

            //             $sum_TotalPromotion += $value_cust['TotalPromotion'];
            //             $sum_TotalLimit += $value_cust['TotalLimit'];
            //             $sum_TotalAmountSale += $value_cust['TotalAmountSale'];
            //         }else{
            //             $sum_TotalPromotion += $value_cust['TotalPromotion'];
            //             $sum_TotalLimit += $value_cust['TotalLimit'];
            //             $sum_TotalAmountSale += $value_cust['TotalAmountSale'];
            //         }
                    
            //     }
            // }

            // dd($data['customer_campaigns'], $data['sum_TotalPromotion'], $data['province_name']);

            //--- คำนวนสรูปแต่ะละจังหวัด  -- ทำไม่เสร็จเว้นไว้ก่อน
        }
        
        return view('shareData.report_sale_compare_year', $data);
    }
}
