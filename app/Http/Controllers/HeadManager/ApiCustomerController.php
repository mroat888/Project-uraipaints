<?php

namespace App\Http\Controllers\HeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiController;

class ApiCustomerController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $users_saleman = DB::table('users')
            ->whereIn('status', [1,2,3])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        $api_token = $this->api_token->apiToken();
        $customer_api = array();
        foreach($users_saleman as $saleman){
            $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/sellers/'.$saleman->api_identify.'/customers');
            $res_api = $response->json();

            if(!empty($res_api)){
                if($res_api['code'] == 200){
                    foreach ($res_api['data'] as $key => $value) {
                        $customer_api[] = 
                        [
                            'identify' => $value['identify'],
                            'shopname' => $value['title']." ".$value['name'],
                            'address' => $value['amphoe_name']." , ".$value['province_name'],
                            'telephone' => $value['telephone']." , ".$value['mobile'],
                            'TotalCampaign' => $value['TotalCampaign'],
                        ];
                    }
                }
            }
            
        }
      
        return view('reports.report_store_head', compact('customer_api'));
    }

    public function show($id)
    {
        $api_token = $this->api_token->apiToken();

        //- ดึงชื่อร้านค้า ตาม ID
        $response_cust = Http::withToken($api_token)->get(env("API_LINK").'api/v1/customers/'.$id);
        $res_custapi = $response_cust->json();
        $data['customer_shop'] = $res_custapi['data'][0];
        
        //- ดึงแคมเปญของร้านค้า
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/customers/'.$id.'/campaigns');
        $res_api = $response->json();

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
            }
        }

        return view('reports.report_store_head_detail', $data);
    }
}
