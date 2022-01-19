<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        //dd($res['data']['access_token']);

        $response = Http::get('http://49.0.64.92:8020/api/v1/customers', [
            'token' => $api_token,
        ]);
        $res_api = $response->json();
        // $res_api = $res['data'];

        $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] = 
            [
                'id' => $value['identify'],
                'image' => '',
                'title' => $value['title']." ".$value['name'],
                'address' => $value['address1']." ".$value['adrress2'],
            ];
        }
        return view('customer.customer-api', compact('customer_api'));

        // --- Login API ---- 
        // $data = [
        //     'username' => 'apiuser',
        //     'password' => 'testapi',
        // ];

        // $curl = curl_init();
        
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "http://49.0.64.92:8020/api/auth/login",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30000,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => json_encode($data),
        //     CURLOPT_HTTPHEADER => array(
        //         // Set here requred headers
        //         "accept: */*",
        //         "accept-language: en-US,en;q=0.8",
        //         "content-type: application/json",
        //     ),
        // ));
        
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        
        // curl_close($curl);
        
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     //print_r(json_decode($response));
        // }
        // $res_api = json_decode($response);
        // $api_token = $res_api->data[0]->access_token;

        // api_fetch_customer_all($api_token);

        // --- END Login API ---- 

        //------------------------
        // $data = [
        //     'token' => $api_token,
        // ];

        // $curl = curl_init();
        
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "http://49.0.64.92:8020/api/v1/customers",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30000,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_POSTFIELDS => json_encode($data),
        //     CURLOPT_HTTPHEADER => array(
        //         // Set here requred headers
        //         "accept: */*",
        //         "accept-language: en-US,en;q=0.8",
        //         "content-type: application/json",
        //     ),
        // ));
        
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        
        // curl_close($curl);
        
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     //print_r(json_decode($response));
        // }

        // $res_api = json_decode($response,true);
        // $customer_api = array();
        // foreach ($res_api['data'] as $key => $value) {
        //     $customer_api[$key] = 
        //     [
        //         'id' => $value['identify'],
        //         'image' => '',
        //         'title' => $value['title'].$value['name'],
        //         'address' => $value['address1'].$value['adrress2'],
        //     ];
        // }

        // // $item = $res_api['data'] ;
        // // $customer_api = array('customer_api' => $item);
        // // dd($customer_api);

        //------------------------
        
        // return view('customer.customer-api', compact('customer_api'));
    }

    public function api_fetch_customer_all($api_token){

        $data = [
            'token' => $api_token,
        ];

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://49.0.64.92:8020/api/v1/customers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            print_r(json_decode($response));
        }
    }
}
