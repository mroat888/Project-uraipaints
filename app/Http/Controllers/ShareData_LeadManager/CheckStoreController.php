<?php

namespace App\Http\Controllers\ShareData_LeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;


class CheckStoreController extends Controller
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
            ->whereIn('status', [1,2])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();
   
        // dd($users_saleman);

        $api_token = $this->api_token->apiToken();
        $customer_api = array();
        foreach($users_saleman as $saleman){
            $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/sellers/'.$saleman->api_identify.'/customers');
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
                            'InMonthDays' => $value['InMonthDays'],
                            'TotalDays' => $value['TotalDays'],
                            'TotalCampaign' => $value['TotalCampaign'],
                        ];
                    }
                }
            }

        }

        // dd($customer_api);
        
        return view('shareData_leadManager.check_name_store', compact('customer_api'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $api_token = $this->api_token->apiToken();

        //- ดึงชื่อร้านค้า ตาม ID
        $response_cust = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/customers/'.$id);
        $res_custapi = $response_cust->json();
        $data['customer_shop'] = $res_custapi['data'][0];
        
        //- ดึงแคมเปญของร้านค้า
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/customers/'.$id.'/campaigns');
        $res_api = $response->json();
        
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
                }
            }
        }

        return view('shareData_leadManager.check_name_store_detail', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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