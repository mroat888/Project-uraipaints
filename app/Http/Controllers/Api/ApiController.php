<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function apiToken(){
        // -----  API 
        // dd(env("API_LINK"));
        $response = Http::post(env("API_LINK").'api/auth/login', [
            'username' => env("API_USER"),
            'password' => env("API_PASS"),
        ]);
        $res = $response->json();
        $api_token = $res['data'][0]['access_token'];

        return $api_token;
    }

    public function getAllSellers(){
        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/sellers');    
        $res_api = $response->json();               
        return $res_api;
    }

    public function fetch_subgroups($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/subgroups/');
        $res_api = $response->json();
        $subgroups = array();
        foreach($res_api['data'] as $value){
            if($value['group_id'] == $id){
                $subgroups[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'group_id' => $value['group_id']
                ];                    
            }
        }
        return response()->json([
            'status' => 200,
            'id' => $id,
            'subgroups' => $subgroups
        ]);

    }

    public function fetch_pdglists($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/pdglists/');
        $res_api = $response->json();
        $pdglists = array();
        foreach($res_api['data'] as $value){
            if($value['sub_code'] == $id){
                $pdglists[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                    'sub_code' => $value['sub_code']
                ];                    
            }
        }
        return response()->json([
            'status' => 200,
            'id' => $id,
            'pdglists' => $pdglists
        ]);

    }

}
