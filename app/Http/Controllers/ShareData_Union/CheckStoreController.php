<?php

namespace App\Http\Controllers\ShareData_Union;

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

        switch  (Auth::user()->status){
            case 1 :    $patch_search = "sellers/".Auth::user()->api_identify."/customers"; //-- Sale
                break;
            case 2 :    $patch_search = "saleleaders/".Auth::user()->api_identify."/customers"; //-- Lead
                break;
            case 3 :    $patch_search = "saleheaders/".Auth::user()->api_identify."/customers"; //-- Head
                break;
            case 4 :    $patch_search = "customers"; //-- Admin
                break;
        }

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
            'limits' => env("API_CUST_LIMIT")
        ]);
        $res_api = $response->json();

        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['customer_api'] = $res_api['data'];
            }
        }

        // ดึงจังหวัด -- API
        $data['provinces'] = $this->fetch_provinces($api_token);

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

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.check_name_store', $data); //-- Sale
                break;
            case 2 :    return view('shareData_leadManager.check_name_store', $data);//-- Lead
                break;
            case 3 :    return view('shareData_headManager.check_name_store', $data); //-- Head
                break;
            case 4 :    return view('shareData_admin.check_name_store', $data); //-- Admin
                break;
        }
    }

    public function search(Request $request)
    {

        $api_token = $this->api_token->apiToken();

        // switch  (Auth::user()->status){
        //     case 1 :    //-- Sale
        //                 if(!is_null($request->amphur)){ 
        //                     $patch_search = 'sellers/'.Auth::user()->api_identify.'/customers?sortorder=DESC&amphoe_id='.$request->amphur;
        //                 }elseif(!is_null($request->province)){
        //                     $patch_search = 'sellers/'.Auth::user()->api_identify.'/customers?sortorder=DESC&province_id='.$request->province;
        //                 }else{
        //                     $patch_search = "sellers/".Auth::user()->api_identify."/customers";
        //                 }
        //         break;
        //     case 2 :    //-- Lead
        //                 if(!is_null($request->amphur)){ 
        //                     $patch_search = 'saleleaders/'.Auth::user()->api_identify.'/customers?sortorder=DESC&amphoe_id='.$request->amphur;
        //                 }elseif(!is_null($request->province)){
        //                     $patch_search = 'saleleaders/'.Auth::user()->api_identify.'/customers?sortorder=DESC&province_id='.$request->province;
        //                 }else{
        //                     $patch_search = "saleleaders/".Auth::user()->api_identify."/customers";
        //                 }
        //         break;
        //     case 3 :    //-- Head
        //                 if(!is_null($request->amphur)){ 
        //                     $patch_search = 'saleheaders/'.Auth::user()->api_identify.'/customers?sortorder=DESC&amphoe_id='.$request->amphur;
        //                 }elseif(!is_null($request->province)){
        //                     $patch_search = 'saleheaders/'.Auth::user()->api_identify.'/customers?sortorder=DESC&province_id='.$request->province;
        //                 }else{
        //                     $patch_search = "saleheaders/".Auth::user()->api_identify."/customers";
        //                 }
        //         break;
        //     case 4 :    //-- Admin
        //                 if(!is_null($request->amphur)){ 
        //                     $patch_search = 'amphures/'.$request->amphur.'/customers';
        //                 }elseif(!is_null($request->province)){
        //                     $patch_search = 'provinces/'.$request->province.'/customers';
        //                 }else{
        //                     $patch_search = 'customers';
        //                 }
        //         break;
        // }

        switch  (Auth::user()->status){
            case 1 :    $patch_search = "sellers/".Auth::user()->api_identify."/customers"; //-- Sale
                break;
            case 2 :    $patch_search = "saleleaders/".Auth::user()->api_identify."/customers"; //-- Lead
                break;
            case 3 :    $patch_search = "saleheaders/".Auth::user()->api_identify."/customers"; //-- Head
                break;
            case 4 :    $patch_search = "customers"; //-- Admin
                break;
        }

        $amphoe_id = "";
        $province_id = "";

        if(!is_null($request->amphur)){ 
            $amphoe_id = $request->amphur;
        }elseif(!is_null($request->province)){
            $province_id = $request->province;
        }
        
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_search,[
            'sortorder' => 'DESC',
            'province_id' => $province_id,
            'amphoe_id' => $amphoe_id,
            'limits' => env("API_CUST_LIMIT")
        ]);

        $res_api = $response->json();

        if(!is_null($res_api) && $res_api['code'] == 200){
            $data['customer_api'] = $res_api['data'];
        }

        // ดึงจังหวัด -- API
        $data['provinces'] = $this->fetch_provinces($api_token);

        
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
        
        switch  (Auth::user()->status){
            case 1 :    return view('shareData.check_name_store', $data); //-- Sale
                break;
            case 2 :    return view('shareData_leadManager.check_name_store', $data);//-- Lead
                break;
            case 3 :    return view('shareData_headManager.check_name_store', $data); //-- Head
                break;
            case 4 :    return view('shareData_admin.check_name_store', $data); //-- Admin
                break;
        }
    }

    public function fetch_provinces($api_token)
    {
        switch  (Auth::user()->status){
            case 1 :    $patch_provinces = "sellers/".Auth::user()->api_identify."/provinces"; //-- Sale        
                break;
            case 2 :    $patch_provinces = "saleleaders/".Auth::user()->api_identify."/provinces"; //-- Lead                
                break;
            case 3 :    $patch_provinces = "saleheaders/".Auth::user()->api_identify."/provinces"; //-- Head                  
                break;
            case 4 :    $patch_provinces = "provinces"; //-- Admin                      
                break;
        }
        // ดึงจังหวัด -- API
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$patch_provinces);
        $res_api = $response->json();
        $provinces = null;
        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $provinces = $res_api['data'];
            }
        }

        return $provinces;
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

        switch  (Auth::user()->status){
            case 1 :    return view('shareData.check_name_store_detail', $data); //-- Sale
                break;
            case 2 :    return view('shareData_leadManager.check_name_store_detail', $data); //-- Lead
                break;
            case 3 :    return view('shareData_headManager.check_name_store_detail', $data); //-- Head
                break;
            case 4 :    return view('shareData_admin.check_name_store_detail', $data); //-- Admin
                break;
        }
    }

}
