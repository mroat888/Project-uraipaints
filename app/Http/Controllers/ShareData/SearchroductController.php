<?php

namespace App\Http\Controllers\ShareData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use DataTables;

class SearchroductController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        //-- แบบเชื่อม API 
        // $api_token = $this->api_token->apiToken();
        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists/');
        // $data['pdglists'] = $response->json();

        //-- ดึงจากฐานข้อมูล และแปลงเป็น Array จะไม่ต้องแก้ไขที่หน้า view
        $pdglists = DB::table('api_pdglists')->get();
        foreach($pdglists as $value){
            $data['pdglists']['data'][] =[
                'identify' => $value->identify,
                'name' => $value->name,
                'sub_code' => $value->sub_code,
            ];
        }

        return view('shareData.search_product', $data);
    }

    public function search(Request $request){

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups?sortorder=DESC/');
        $groups_api = $response->json();

        $product_api = null;

        if(!is_null($request->sel_pdglists)){
            $api_token = $this->api_token->apiToken();
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists/'.$request->sel_pdglists.'/products');
            if($response['code'] == 200){
                $product_api = $response->json();
            }
        }

        return view('shareData.search_product', compact('product_api', 'groups_api'));

    }

}
