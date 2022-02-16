<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ApiCustomerController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){
        
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/customers');
        $res_api = $response->json();

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

    public function show($id){
        return view('customer.customer-api_detail');
    }
}
