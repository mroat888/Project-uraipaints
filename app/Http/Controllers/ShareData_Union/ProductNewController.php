<?php

namespace App\Http\Controllers\ShareData_Union;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ProductNewController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        // $year_now = date("Y");
        $year_now = "2021";
        $api_token = $this->api_token->apiToken();

        switch  (Auth::user()->status){
            case 2 :    $patch_search = "campaignpromotes/*/sellertargets"; //-- Lead
                        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
                            'years' => $year_now, 
                            'saleleader_id' => Auth::user()->api_identify,
                        ]);
                break;
            case 3 :    $patch_search = "campaignpromotes/*/sellertargets"; //-- Head
                        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
                            'years' => $year_now, 
                            'saleheader_id' => Auth::user()->api_identify,
                        ]);
                break;
            case 4 :    $patch_search = "campaignpromotes/*/sellertargets"; //-- Admin
                        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
                            'years' => $year_now, 
                        ]);
                break;
        }

        $res_api = $response->json();

        $campaign_api = array();
        $campaign_api_target = array();
        $campaign_api_sales = array();
        $campaign_api_diff = array();
        $data['campaign_api_description'] = array();
        $data['campaign_api_datetime'] = array();

        $sellers_api = array();
        $summary_sellers_api = array();

        if($res_api['code'] == 200){

            $sum_target = 0;
            $sum_sales = 0;
            $sum_diff = 0;
            $sum_persent_sale = 0;
            $sum_persent_diff = 0;
            foreach($res_api['data'] as $value){

                if(!in_array($value['campaign_id'], $campaign_api)){ //-- เช็ค ถ้าไม่มีเก็บใน array ให้เพิ่มเข้าไปใหม่
                    $campaign_api[] = $value['campaign_id'];
                    $campaign_api_target[] = 0; 
                    $campaign_api_sales[] = 0; 
                    $campaign_api_diff[] = 0; 
                    $data['campaign_api_description'][] = $value['description'];

                    list($fyear,$fmonth,$fday) = explode("-",$value['fromdate']);
                    $fyear_thai = $fyear+543;
                    $fromdate = $fday."/".$fmonth."/".$fyear_thai;

                    list($toyear,$tomonth,$today) = explode("-",$value['todate']);
                    $toyear_thai = $fyear+543;
                    $todate = $today."/".$tomonth."/".$toyear_thai;

                    $data['campaign_api_datetime'][] = $fromdate." - ".$todate;
                }
 
            }

            //--    
                foreach($campaign_api as $key_campaign_api => $value_campaign_api){
                    foreach($res_api['data'] as $value){
                        if($value_campaign_api == $value['campaign_id']){
                            $campaign_api_target[$key_campaign_api] += $value['Target'];
                            $campaign_api_sales[$key_campaign_api] += $value['Sales'];
                            $campaign_api_diff[$key_campaign_api] += $value['Diff'];

                            //--
                            $persent_sale = round(($value['Sales']*100)/$value['Target']);
                            $persent_diff = round(($value['Diff']*100)/$value['Target']);
            
                            $data['sellers_api'][$key_campaign_api][] = [
                                'campaign_id' => $value['campaign_id'],
                                'description' => $value['description'],
                                'fromdate' => $value['fromdate'],
                                'todate' => $value['todate'],
                                'remark' => $value['remark'],
                                'identify' => $value['identify'],
                                'name' => $value['name'],
                                'Target' => $value['Target'],
                                'Sales' => $value['Sales'],
                                'Diff' => $value['Diff'],
                                // 'status' => $value['status'],
                                'persent_sale' => $persent_sale,
                                'persent_diff' => $persent_diff,
                            ];
            
                            $sum_target += $value['Target'];
                            $sum_sales += $value['Sales'];
                            $sum_diff += $value['Diff'];
                            //--
                        }
                    }
                }
            //--

            list($year,$month,$day) = explode("-", $res_api['trans_last_date']);
            $year_thai = $year+543;
            $data['trans_last_date'] = $day."/".$month."/".$year_thai;

            $sum_persent_sale = round(($sum_sales*100)/$sum_target);
            $sum_persent_diff = round(($sum_diff*100)/$sum_target);

            $data['summary_sellers_api'] = [
                'sum_target' => $sum_target,
                'sum_sales' => $sum_sales,
                'sum_diff' => $sum_diff,
                'sum_persent_sale' => $sum_persent_sale,
                'sum_persent_diff' => $sum_persent_diff,
            ];

            $data['campaign_api'] = $campaign_api;
            $data['campaign_api_target'] = $campaign_api_target;
            $data['campaign_api_sales'] = $campaign_api_sales;
            $data['campaign_api_diff'] = $campaign_api_diff;
        }

      // dd($data['campaign_api'], $data['campaign_api_target']);

        switch  (Auth::user()->status){
            case 2 :    $return = "shareData_leadManager.report_product_new"; //-- Lead
                        return view('shareData_leadManager.report_product_new', $data);
                break;
            case 3 :    $return = "shareData_headManager.report_product_new"; //-- Head
                        return view('shareData_headManager.report_product_new', $data);
                break;
            case 4 :    $return = "shareData_admin.report_product_new"; //-- Admin
                        return view('shareData_admin.report_product_new', $data);
                break;
        }

    }

    public function search(Request $request){

        $year_now = $request->year_search;
        $data['year_search'] = $request->year_search;
        
        $api_token = $this->api_token->apiToken();

        switch  (Auth::user()->status){
            case 2 :    $patch_search = "campaignpromotes/*/sellertargets"; //-- Lead
                        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
                            'years' => $year_now, 
                            'saleleader_id' => Auth::user()->api_identify,
                        ]);
            break;
            case 3 :    $patch_search = "campaignpromotes/*/sellertargets"; //-- Head
                        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
                            'years' => $year_now, 
                            'saleheader_id' => Auth::user()->api_identify,
                        ]);
            break;
            case 4 :    $patch_search = "campaignpromotes/*/sellertargets"; //-- Admin
                        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
                            'years' => $year_now, 
                        ]);
            break;
        }

        $res_api = $response->json();

        $campaign_api = array();
        $campaign_api_target = array();
        $campaign_api_sales = array();
        $campaign_api_diff = array();
        $data['campaign_api_description'] = array();
        $data['campaign_api_datetime'] = array();

        $sellers_api = array();
        $summary_sellers_api = array();

        if($res_api['code'] == 200){

            $sum_target = 0;
            $sum_sales = 0;
            $sum_diff = 0;
            $sum_persent_sale = 0;
            $sum_persent_diff = 0;
            foreach($res_api['data'] as $value){

                if(!in_array($value['campaign_id'], $campaign_api)){ //-- เช็ค ถ้าไม่มีเก็บใน array ให้เพิ่มเข้าไปใหม่
                    $campaign_api[] = $value['campaign_id'];
                    $campaign_api_target[] = 0; 
                    $campaign_api_sales[] = 0; 
                    $campaign_api_diff[] = 0; 
                    $data['campaign_api_description'][] = $value['description'];

                    list($fyear,$fmonth,$fday) = explode("-",$value['fromdate']);
                    $fyear_thai = $fyear+543;
                    $fromdate = $fday."/".$fmonth."/".$fyear_thai;

                    list($toyear,$tomonth,$today) = explode("-",$value['todate']);
                    $toyear_thai = $fyear+543;
                    $todate = $today."/".$tomonth."/".$toyear_thai;

                    $data['campaign_api_datetime'][] = $fromdate." - ".$todate;
                }
 
            }

            //--    
                foreach($campaign_api as $key_campaign_api => $value_campaign_api){
                    foreach($res_api['data'] as $value){
                        if($value_campaign_api == $value['campaign_id']){
                            $campaign_api_target[$key_campaign_api] += $value['Target'];
                            $campaign_api_sales[$key_campaign_api] += $value['Sales'];
                            $campaign_api_diff[$key_campaign_api] += $value['Diff'];

                            //--
                            $persent_sale = round(($value['Sales']*100)/$value['Target']);
                            $persent_diff = round(($value['Diff']*100)/$value['Target']);
            
                            $data['sellers_api'][$key_campaign_api][] = [
                                'campaign_id' => $value['campaign_id'],
                                'description' => $value['description'],
                                'fromdate' => $value['fromdate'],
                                'todate' => $value['todate'],
                                'remark' => $value['remark'],
                                'identify' => $value['identify'],
                                'name' => $value['name'],
                                'Target' => $value['Target'],
                                'Sales' => $value['Sales'],
                                'Diff' => $value['Diff'],
                                // 'status' => $value['status'],
                                'persent_sale' => $persent_sale,
                                'persent_diff' => $persent_diff,
                            ];
            
                            $sum_target += $value['Target'];
                            $sum_sales += $value['Sales'];
                            $sum_diff += $value['Diff'];
                            //--
                        }
                    }
                }
            //--

            list($year,$month,$day) = explode("-", $res_api['trans_last_date']);
            $year_thai = $year+543;
            $data['trans_last_date'] = $day."/".$month."/".$year_thai;

            $sum_persent_sale = round(($sum_sales*100)/$sum_target);
            $sum_persent_diff = round(($sum_diff*100)/$sum_target);

            $data['summary_sellers_api'] = [
                'sum_target' => $sum_target,
                'sum_sales' => $sum_sales,
                'sum_diff' => $sum_diff,
                'sum_persent_sale' => $sum_persent_sale,
                'sum_persent_diff' => $sum_persent_diff,
            ];

            $data['campaign_api'] = $campaign_api;
            $data['campaign_api_target'] = $campaign_api_target;
            $data['campaign_api_sales'] = $campaign_api_sales;
            $data['campaign_api_diff'] = $campaign_api_diff;
        }

      // dd($data['campaign_api'], $data['campaign_api_target']);

      switch  (Auth::user()->status){
        case 2 :    return view('shareData_leadManager.report_product_new', $data); //-- Lead
            break;
        case 3 :    return view('shareData_headManager.report_product_new', $data); //-- Head
            break;
        case 4 :    return view('shareData_admin.report_product_new', $data); //-- Admin
            break;
        }
    }

}
