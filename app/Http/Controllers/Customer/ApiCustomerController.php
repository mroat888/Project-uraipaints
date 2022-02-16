<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ApiCustomerController extends Controller
{
    public function index(){
        // return view('customer.customer-api');

        $response = Http::post('http://49.0.64.92:8020/api/auth/login', [
            'username' => 'apiuser',
            'password' => 'testapi',
        ]);
        $res = $response->json();
        // dd($res);
        $api_token = $res['data'][0]['access_token'];
        // dd($res['data'][0]['access_token']);

        
        $response = Http::get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/customers', [
            'token' => $api_token,
        ]);
        $res_api = $response->json();
        // $res_api = $res['data'];

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] = 
            [
                'identify' => $value['identify'],
                'shopname' => $value['title']." ".$value['name'],
                'address' => $value['amphoe_name']." , ".$value['province_name'],
                'InMonthDays' => $value['InMonthDays'],
                'TotalDays' => $value['TotalDays'],
                'TotalCampaign' => $value['TotalCampaign'],
            ];
        }
        return view('customer.customer-api', compact('customer_api'));
    }

    public function api_fetch_customer_all($api_token, $sale_id){

    }
}
