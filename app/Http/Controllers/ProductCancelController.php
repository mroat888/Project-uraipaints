<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\ProductCancel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductCancelController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['product_cancel'] = ProductCancel::where('status', "1")->orderBy('id', 'desc')->get();

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
            return view('saleman.product_cancel', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_cancel', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_cancel', $data);
        }

    }

    public function search(Request $request)
    {
        $data['product_cancel'] = DB::table('product_cancel');

        if ($request->status_usage != '') {
            $data['product_cancel'] = $data['product_cancel']->where('status', $request->status_usage);
        }

        if ($request->brand != '') {
            $data['product_cancel'] = $data['product_cancel']->where('brand_id', $request->brand);
        }

        if ($request->category != '') {
            $data['product_cancel'] = $data['product_cancel']->where('category_id', $request->category);
        }

        $data['product_cancel'] = $data['product_cancel']->where('status', "1")->orderBy('id', 'desc')->get();

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
            return view('saleman.product_cancel', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_cancel', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_cancel', $data);
        }
    }

    public function view_detail($id)
    {
        $dataEdit = ProductCancel::find($id);

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        $editGroups = array();
        foreach ($res_api['data'] as $key => $value) {
            $editGroups[$key] =
            [
                'id' => $value['identify'],
                'group_name' => $value['name'],
            ];
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        $editBrands = array();
        foreach ($res_api2['data'] as $key => $value) {
            $editBrands[$key] =
            [
                'id' => $value['identify'],
                'brand_name' => $value['name'],
            ];
        }

        $data = array(
            'dataEdit'  => $dataEdit,
            'editGroups'  => $editGroups,
            'editBrands'  => $editBrands,
        );
        echo json_encode($data);
    }
}
