<?php

namespace App\Http\Controllers\ShareData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\DB;

class ProductNewController extends Controller
{

    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $request = "";
        $data = $this->fetch_product_new($request);
        return view('shareData.report_product_new', $data);
    }

    public function search(Request $request)
    {
        $data = $this->fetch_product_new($request);
        return view('shareData.report_product_new', $data);
    }

    public function fetch_product_new($request)
    {
        if($request != ""){
            $year_now = $request->sel_year;
            $sel_campaign = $request->sel_campaign;
        }else{
            $sel_campaign = null;
            $year_now = date("Y");
        }

        if(!is_null($sel_campaign)){
            $patch_search = "campaignpromotes/".$sel_campaign."/sellertargets/".Auth::user()->api_identify;
        }else{
            $patch_search = "campaignpromotes/*/sellertargets/".Auth::user()->api_identify;
        }

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
            'years' => $year_now
        ]);
        $res_api = $response->json();

        $sellers_api = array();
        $summary_sellers_api = array();
        $trans_last_date = "";

        $sum_target = 0;
        $sum_sales = 0;
        $sum_diff = 0;
        $sum_persent_sale = 0;
        $sum_persent_diff = 0;

        if($res_api['code'] == 200){

            foreach($res_api['data'] as $value){

                $persent_sale = round(($value['Sales']*100)/$value['Target']);
                $persent_diff = round(($value['Diff']*100)/$value['Target']);

                $sellers_api[] = [
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

            }

            list($year,$month,$day) = explode("-", $res_api['trans_last_date']);
            $year_thai = $year+543;
            $trans_last_date = $day."/".$month."/".$year_thai;

            $sum_persent_sale = round(($sum_sales*100)/$sum_target);
            $sum_persent_diff = round(($sum_diff*100)/$sum_target);
        }

        $summary_sellers_api = [
            'sum_target' => $sum_target,
            'sum_sales' => $sum_sales,
            'sum_diff' => $sum_diff,
            'sum_persent_sale' => $sum_persent_sale,
            'sum_persent_diff' => $sum_persent_diff,
        ];

        $data['sellers_api'] = $sellers_api;
        $data['summary_sellers_api'] = $summary_sellers_api;
        $data['trans_last_date'] = $trans_last_date;

        return $data;
    }

}
