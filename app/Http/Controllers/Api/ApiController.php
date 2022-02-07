<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function apiToken(){
        // -----  API 
        $response = Http::post('http://49.0.64.92:8020/api/auth/login', [
            'username' => 'apiuser',
            'password' => 'testapi',
        ]);
        $res = $response->json();
        $api_token = $res['data'][0]['access_token'];

        return $api_token;
    }

    public function getAllSellers(){
        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/sellers');    
        $res_api = $response->json();               
        return $res_api;
    }
}
