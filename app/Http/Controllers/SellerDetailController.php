<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class SellerDetailController extends Controller
{
    public function __construct(){
        $this->apicontroller = new ApiController();
    }
    
    public function show($position, $seller_level, $id){
        
        $api_token = $this->apicontroller->apiToken();

        switch($seller_level){
            case "saleleaders" :    $patch_search = "saleleaders/".$id;
                                    $return_detail = "team_detail_lead";
                break;
            case "sellers" :        $patch_search = "sellers/".$id;
                                    $return_detail = "team_detail_seller";
                break;
        }

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$patch_search);
        $data['res_api'] = $response->json();

        // dd($position, $seller_level, $id,$data['res_api']);

        switch($position){
            case "leader" : $return = "leadManager.".$return_detail;
            break;
            case "header" : $return = "headManager.".$return_detail;
            break;
        }

       // dd($return);
  
        return view($return, $data);
        
    }
}
