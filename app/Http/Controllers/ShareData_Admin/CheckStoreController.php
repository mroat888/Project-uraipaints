<?php

namespace App\Http\Controllers\ShareData_Admin;

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
        $users_saleman = DB::table('users')->get();
        // dd($users_saleman);

        $api_token = $this->api_token->apiToken();
        $customer_api = array();
        foreach($users_saleman as $saleman){
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.$saleman->api_identify.'/customers');
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

        // ดึงจังหวัด -- API
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces');
        $res_api = $response->json();
        $provinces = $res_api;
        
        return view('shareData_admin.check_name_store', compact('customer_api', 'provinces'));
    }

    public function search(Request $request)
    {
        $users_saleman = DB::table('users')->get();
        // dd($users_saleman);

        $api_token = $this->api_token->apiToken();
        $data['customer_api'] = array();
        foreach($users_saleman as $saleman){
            $patch_search = "/sellers/".$saleman->api_identify."/customers/search?sort_by=cust_title&province_id=".$request->province."&amphoe_id=".$request->amphur;
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$patch_search);
            $res_api = $response->json();

            if(!empty($res_api)){
                if($res_api['code'] == 200){
                    foreach ($res_api['data'] as $key => $value) {
                        $data['customer_api'][] = 
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

        // ดึงจังหวัด -- API
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces');
        $res_api = $response->json();
        $data['provinces'] = $res_api;
        
        return view('shareData_admin.check_name_store', $data);
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
                                }
                            }
                        }else{
                            // echo "ไม่พบพบข้อมูล ".$value['year']."<br>";
                            $check_year[] = $value['year'];
                            $year_sum[] = [
                                'year' => $value['year'],
                                'saleamount' => $value['saleamount'],
                                'amount_limit' => $value['amount_limit'],
                            ];
                        }
                    }else{
                        // echo "ไม่พบพบข้อมูล ".$value['year']."<br>";
                        $check_year[] = $value['year'];
                        $year_sum[] = [
                                'year' => $value['year'],
                                'saleamount' => $value['saleamount'],
                                'amount_limit' => $value['amount_limit'],
                            ];
                    }
                    // -- End Sum Year

                }
            }
        }

        $data['year_sum'] = $year_sum;

        return view('shareData_admin.check_name_store_detail', $data);

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
