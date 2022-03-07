<?php

namespace App\Http\Controllers\ShareData_Admin;

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

        $users_saleman = DB::table('users')->whereIn('status', [1])->get();
        
        //dd($users_saleman);
        $sellers_api = array();
        $summary_sellers_api = array();
        $sum_target = 0;
        $sum_sales = 0;
        $sum_diff = 0;
        $sum_persent_sale = 0;
        $sum_persent_diff = 0;
        foreach($users_saleman as $key => $users_iden){

            $api_token = $this->api_token->apiToken();
            $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/sellers/'.$users_iden->api_identify.'/campignpromotes');
            $res_api = $response->json();

           // dd($users_iden->api_identify, $res_api);

            if($res_api['code'] == 200){
                foreach($res_api['data'] as $value){
                    $persent_sale = round(($value['Sales']*100)/$value['Target']);
                    $persent_diff = round(($value['Diff']*100)/$value['Target']);
                    
                    $sellers_api[$key][] = [
                        'saleman_name' => $users_iden->name,
                        'campaign_id' => $value['campaign_id'],
                        'description' => $value['description'],
                        'fromdate' => $value['fromdate'],
                        'todate' => $value['todate'],
                        'remark' => $value['remark'],
                        'Target' => $value['Target'],
                        'Sales' => $value['Sales'],
                        'Diff' => $value['Diff'],
                        'status' => $value['status'],
                        'persent_sale' => $persent_sale,
                        'persent_diff' => $persent_diff,
                    ];

                    $sum_target += $value['Target'];
                    $sum_sales += $value['Sales'];
                    $sum_diff += $value['Diff'];
                }
            }
        }

        $sum_persent_sale = round(($sum_sales*100)/$sum_target);
        $sum_persent_diff = round(($sum_diff*100)/$sum_target);

        $summary_sellers_api = [
            'sum_target' => $sum_target,
            'sum_sales' => $sum_sales,
            'sum_diff' => $sum_diff,
            'sum_persent_sale' => $sum_persent_sale,
            'sum_persent_diff' => $sum_persent_diff,
        ];

        // ดึงรายการสินค้าใหม่
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/campaignpromotes/');
        $campaignpromotes_api = $response->json();

        // dd($sellers_api);

        return view('shareData_admin.report_product_new', compact('sellers_api', 'summary_sellers_api','campaignpromotes_api'));
    }

    public function search(Request $request){
        // dd($request);

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/campaignpromotes/'.$request->sel_campaign.'/sellertargets');
        $res_api = $response->json();

        $campaign_detail_api = array();
        $summary_campaign_detail_api = array();
        $sum_target = 0;
        $sum_sales = 0;
        $sum_diff = 0;
        $sum_persent_sale = 0;
        $sum_persent_diff = 0;

        if($res_api['code'] == 200){
            $sales = 0;
            $diff =0;
            foreach($res_api['data'] as $value){

                if($value['Sales'] != ""){
                    $sales += $value['Sales'];
                }
                if($value['Diff'] != ""){
                    $diff += $value['Diff'];
                }

                if($value['Target'] != ""){
                    if($value['Sales'] != ""){
                        $persent_sale = round(($value['Sales']*100)/$value['Target']);
                    }else{
                        $persent_sale = 0;
                    }
                    if($value['Diff'] != ""){
                        $persent_diff = round(($value['Diff']*100)/$value['Target']);
                    }else{
                        $persent_diff = 0;
                    }
                }else{
                    $persent_sale = 0;
                    $persent_diff = 0;
                }

                $campaign_detail_api[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'Target' => $value['Target'],
                    'Sales' => $sales,
                    'Diff' => $diff,
                    'Active' => $value['Active'],
                    'persent_sale' => $persent_sale,
                    'persent_diff' => $persent_diff,
                ];

                if($value['Target'] != ""){
                    $sum_target += $value['Target'];
                }
                if($value['Sales'] != ""){
                    $sum_sales += $value['Sales'];
                }
                if($value['Diff'] != ""){
                    $sum_diff += $value['Diff'];
                }
                
            }
        }

        $sum_persent_sale = round(($sum_sales*100)/$sum_target);
        $sum_persent_diff = round(($sum_diff*100)/$sum_target);

        $summary_campaign_detail_api = [
            'sum_target' => $sum_target,
            'sum_sales' => $sum_sales,
            'sum_diff' => $sum_diff,
            'sum_persent_sale' => $sum_persent_sale,
            'sum_persent_diff' => $sum_persent_diff
        ];


        // ดึงรายการสินค้าใหม่
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/campaignpromotes/');
        $campaignpromotes_api = $response->json();

        // ดึงรายละเอียดแคมเปญ
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/campaignpromotes/'.$request->sel_campaign);
        $campaignpromotes_name_api = $response->json();
        
        // dd($campaignpromotes_name_api['data']);
        return view('shareData_admin.report_product_new_detail', compact('campaign_detail_api', 'campaignpromotes_api', 'summary_campaign_detail_api', 'campaignpromotes_name_api'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
