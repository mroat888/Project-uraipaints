<?php

namespace App\Http\Controllers\ShareData_Admin;

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
        $year = $year+0;
        $year_old = $year-1;
        $year_old2 = $year_old -1;
        
        $path_search = "campaigns/years/".$year."/sellers";
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $res_api = $response->json();

        $array_year = array($year, $year_old, $year_old2);

        if($res_api['code']== 200){

            $user = array();
            $compare_api = array();
            foreach($res_api['data'] as $key => $value){

                if (in_array($value['identify'], $user)){
                    foreach($user as $key_user => $value_user){
                        if($value['identify'] == $value_user ){
                            $key_array = array_search($value['year'], $array_year);
                            $compare_api[$key_user][$key_array] = [
                                'year' => $value['year'],
                                'identify' => $value['identify'],
                                'name' => $value['name'],
                                'TotalLimit' => $value['TotalLimit'],
                            ];
                        }
                    }
                }else{
                    $user[] = $value['identify'];
                    $key_array = array_search($value['year'], $array_year);
                    $compare_api[][$key_array] = [
                        'year' => $value['year'],
                        'identify' => $value['identify'],
                        'name' => $value['name'],
                        'TotalLimit' => $value['TotalLimit'],
                    ];
                }
            }

            // dd($user, $compare_api);
            $data['user'] = $user;
            $data['compare_api'] = $compare_api;
        }

        $data['array_year'] = $array_year;

        return view('shareData_headManager.report_sale_compare_year', $data);

    }

}
