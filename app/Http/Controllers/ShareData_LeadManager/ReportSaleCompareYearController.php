<?php

namespace App\Http\Controllers\ShareData_LeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportSaleCompareYearController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        
        $path_search = "campaigns/years/".$year."/sellers?leader_id=".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $compare_api = $response->json();

        $user = array();
        foreach($compare_api['data'] as $key => $value){

            if (in_array($value['identify'], $user)){

            }else{
                $user[] = $value['identify'];
            }
        }

        dd($user);
    }

}
