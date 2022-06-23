<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\ProductAge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductAgeController extends Controller
{

    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['product_age'] = ProductAge::where('status', "1")->orderBy('id', 'desc')->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        $data['groups'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['groups'][$key] =
            [
                'id' => $value['identify'],
                'group_name' => $value['name'],
            ];
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        $data['brands'] = array();
        foreach ($res_api2['data'] as $key => $value) {
            $data['brands'][$key] =
            [
                'id' => $value['identify'],
                'brand_name' => $value['name'],
            ];
        }

        if (Auth::user()->status == 1) {
            return view('saleman.product_age', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_age', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_age', $data);
        }

    }

    public function search(Request $request)
    {
        $data['product_age'] = DB::table('product_age');

        if ($request->status_usage != '') {
            $data['product_age'] = $data['product_age']->where('status', $request->status_usage);
        }

        if ($request->brand != '') {
            $data['product_age'] = $data['product_age']->where('brand_id', $request->brand);
        }

        if ($request->category != '') {
            $data['product_age'] = $data['product_age']->where('category_id', $request->category);
        }

        $data['product_age'] = $data['product_age']->where('status', "1")->orderBy('id', 'desc')->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        $data['groups'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['groups'][$key] =
            [
                'id' => $value['identify'],
                'group_name' => $value['name'],
            ];
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        $data['brands'] = array();
        foreach ($res_api2['data'] as $key => $value) {
            $data['brands'][$key] =
            [
                'id' => $value['identify'],
                'brand_name' => $value['name'],
            ];
        }

        if (Auth::user()->status == 1) {
            return view('saleman.product_age', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_age', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_age', $data);
        }
    }

    public function view_detail($id)
    {
        $data_product = ProductAge::find($id);

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        $dataGroups = array();
        foreach ($res_api['data'] as $key => $value) {
            $dataGroups[$key] =
            [
                'id' => $value['identify'],
                'group_name' => $value['name'],
            ];
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        $dataBrands = array();
        foreach ($res_api2['data'] as $key => $value) {
            $dataBrands[$key] =
            [
                'id' => $value['identify'],
                'brand_name' => $value['name'],
            ];
        }

        $data = array(
            'data_product'  => $data_product,
            'dataGroups'  => $dataGroups,
            'dataBrands'  => $dataBrands,
        );
        if (Auth::user()->status == 1) {
            return view('saleman.product_age_view_detail', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_age_view_detail', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_age_view_detail', $data);
        }
    }
}
