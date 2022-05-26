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
        $api_token = $this->api_token->apiToken();

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers',[
            'limits' => env("API_CUST_LIMIT")
        ]);
        $res_api = $response->json();

        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['customer_api'] = $res_api['data'];
            }
        }

        // ดึงจังหวัด -- API
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces');
        $res_api = $response->json();
        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['provinces'] = $res_api['data'];
            }
        }

        // -- แปลงมาใช้ดึงจากฐานข้อมูล
        // $api_customers = DB::table('api_customers')->get();
        // foreach($api_customers as $key => $value){
        //     $data['customer_api'][] = [
        //         'image_url' => $value->image_url,
        //         'identify' => $value->identify,
        //         'title' => $value->title,
        //         'name' => $value->name,
        //         'amphoe_name' => $value->amphoe_name,
        //         'province_name' => $value->province_name,
        //         'telephone' => $value->telephone,
        //         'mobile' => $value->mobile,
        //     ];
        // }

        // $api_provinces = DB::table('api_provinces')->get();
        // foreach($api_provinces as $key => $value){
        //    $data['provinces'][] = [
        //        'identify' => $value->identify,
        //        'name_thai' => $value->name_thai,
        //    ];
        // }

        return view('shareData_admin.check_name_store', $data);
    }

    public function search(Request $request)
    {

        $api_token = $this->api_token->apiToken();

        if(!is_null($request->amphur)){ 
            $patch_search = '/amphures/'.$request->amphur.'/customers';
        }elseif(!is_null($request->province)){
            $patch_search = '/provinces/'.$request->province.'/customers';
        }else{
            $patch_search = '/customers';
        }

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").$patch_search,[
            'limits' => env("API_CUST_LIMIT")
        ]);
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $data['customer_api'] = $res_api['data'];
        }

        // ดึงจังหวัด -- API
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces');
        $res_provinces_api = $response->json();
        $data['provinces'] = $res_provinces_api['data'];


        
        // -- แปลงมาใช้ดึงจากฐานข้อมูล
        // $api_customers = DB::table('api_customers');

        // if(!is_null($request->amphur)){
        //     $api_customer = $api_customer->where('amphoe_id', $request->amphur);
        // }elseif(!is_null($request->province)){
        //     $api_customer = $api_customer->where('province_id', $request->province);
        // }
        
        // $api_customers = $$api_customers->get();

        // foreach($api_customers as $key => $value){
        //     $data['customer_api'][] = [
        //         'image_url' => $value->image_url,
        //         'identify' => $value->identify,
        //         'title' => $value->title,
        //         'name' => $value->name,
        //         'amphoe_name' => $value->amphoe_name,
        //         'province_name' => $value->province_name,
        //         'telephone' => $value->telephone,
        //         'mobile' => $value->mobile,
        //     ];
        // }

        // $api_provinces = DB::table('api_provinces')->get();
        // foreach($api_provinces as $key => $value){
        //    $data['provinces'][] = [
        //        'identify' => $value->identify,
        //        'name_thai' => $value->name_thai,
        //    ];
        // }
        
        return view('shareData_admin.check_name_store', $data);
    }

    public function show($id)
    {
        $api_token = $this->api_token->apiToken();    
        $data['api_token'] = $api_token;
        
        //- ดึงชื่อร้านค้า ตาม ID
        $response_cust = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers/'.$id);
        $res_custapi = $response_cust->json();
        $data['customer_shop'] = $res_custapi;

        
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

}
