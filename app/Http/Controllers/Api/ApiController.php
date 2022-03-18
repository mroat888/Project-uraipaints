<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DataTables;

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
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers');    
        $res_api = $response->json();               
        return $res_api;
    }

    public function fetch_subgroups($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/subgroups/');
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
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists/');
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


    public function fetch_products($id){
        
        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/products?productlist_id='.$id);
        $res_api = $response->json();
        $products = array();
        foreach($res_api['data'] as $value){
            if($value['list_code'] == $id){
                $products[] = [
                    'identify' => $value['identify'],
                    'name' => $value['name'],
                ];                    
            }
        }
        return Datatables::of($products)
        ->addIndexColumn()
        ->editColumn('identify',function($row){
            return $row['identify'];
        })
        ->editColumn('name',function($row){
            return $row['name'];
        })
        ->make(true);

        // return response()->json([
        //     'status' => 200,
        //     'id' => $id,
        //     'products' => $products
        // ]);
    }


    public function fetch_amphur_api($id){

        $api_token = $this->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces/'.$id.'/amphures/');
        $res_api = $response->json();
        $amphures = array();
        foreach($res_api['data'] as $value){
            $amphures[] = [
                'identify' => $value['identify'],
                'name_thai' => $value['name_thai'],
                'province_id' => $value['province_id']
            ];                    
        }

        return response()->json([
            'status' => 200,
            'id' => $id,
            'amphures' => $res_api
        ]);
    }

}
