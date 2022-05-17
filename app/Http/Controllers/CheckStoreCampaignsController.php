<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class CheckStoreCampaignsController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function show($position, $id){

        $api_token = $this->api_token->apiToken();

        //- ดึงชื่อร้านค้า ตาม ID
        $response_cust = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers/'.$id);
        $res_custapi = $response_cust->json();
        $data['customer_shop'] = $res_custapi['data'][0];
        
        //- ดึงแคมเปญของร้านค้า
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers/'.$id.'/campaigns');
        $res_api = $response->json();

        $year_sum= array();
        $check_year = array();
        
        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['cust_campaigns_api'] = array();
                foreach ($res_api['data'] as $key => $value) {
                    $data['cust_campaigns_api'][$key] = 
                    [
                        'year' => $value['year'],
                        'campaign_id' => $value['campaign_id'],
                        'description' => $value['description'],
                        'saleamount' => $value['saleamount'],
                        'amount_limit' => $value['amount_limit'],
                        'amount_diff' => $value['amount_diff'],
                        'amount_limit_th' => $value['amount_limit_th'],
                        'amount_net_th' => $value['amount_net_th'],
                    ];

                    // -- Sum Year
                    if(!empty($check_year)){
                        if (in_array($value['year'], $check_year)){
                            foreach($year_sum as $key_year_sum => $value_year_sum){
                                if($year_sum[$key_year_sum]['year'] == $value['year']){
                                    $year_sum[$key_year_sum]['saleamount'] = $year_sum[$key_year_sum]['saleamount'] + $value['saleamount'];
                                    $year_sum[$key_year_sum]['amount_limit'] = $year_sum[$key_year_sum]['amount_limit'] + $value['amount_limit'];
                                    $year_sum[$key_year_sum]['amount_diff'] = $year_sum[$key_year_sum]['amount_diff'] + $value['amount_diff'];
                                }
                            }
                        }else{
                            // echo "ไม่พบพบข้อมูล ".$value['year']."<br>";
                            $check_year[] = $value['year'];
                            $year_sum[] = [
                                'year' => $value['year'],
                                'saleamount' => $value['saleamount'],
                                'amount_limit' => $value['amount_limit'],
                                'amount_diff' => $value['amount_diff'],
                            ];
                        }
                    }else{
                        // echo "ไม่พบพบข้อมูล ".$value['year']."<br>";
                        $check_year[] = $value['year'];
                        $year_sum[] = [
                                'year' => $value['year'],
                                'saleamount' => $value['saleamount'],
                                'amount_limit' => $value['amount_limit'],
                                'amount_diff' => $value['amount_diff'],
                            ];
                    }
                    // -- End Sum Year
                    
                } 
            }
        }
        

       // dd($data['year_sum']);
       $data['year_sum'] = $year_sum;

        switch($position){
            case "sellers" : $return = "shareData.check_store_campaigns_detail";
            break;
            case "leader" : $return = "ShareData_LeadManager.check_store_campaigns_detail";
            break;
            case "header" : $return = "ShareData_HeadManager.check_store_campaigns_detail";
            break;
            case "admin" : $return = "shareData_admin.check_store_campaigns_detail";
            break;
        }

        return view($return, $data);

    }
}
