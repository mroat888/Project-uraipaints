<?php

namespace App\Http\Controllers\ShareData;

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

        $path_search = "campaigns/years/".$year."/sellers/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $data['compare_api'] = $response->json();

        return view('shareData.report_sale_compare_year', $data);
    }
}
