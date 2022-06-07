<?php

namespace App\Http\Controllers;

use App\Catalog;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CatalogController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['product_catalog'] = Catalog::where('status', "1")->orderBy('id', 'desc')->get();

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

        $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
        $res_api3 = $response3->json();

        $data['pdglists'] = array();
        foreach ($res_api3['data'] as $key => $value) {
            $data['pdglists'][$key] =
            [
                'id' => $value['identify'],
                'pdglist_name' => $value['name'],
            ];
        }

        if (Auth::user()->status == 1) {
            return view('saleman.catalog', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.catalog', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.catalog', $data);
        }

    }

    public function search(Request $request)
    {
        $data['product_catalog'] = DB::table('product_catalog');

        if ($request->brand != '') {
            $data['product_catalog'] = $data['product_catalog']->where('brand_id', $request->brand);
        }

        if ($request->category != '') {
            $data['product_catalog'] = $data['product_catalog']->where('category_id', $request->category);
        }

        $data['product_catalog'] = $data['product_catalog']->where('status', "1")->orderBy('id', 'desc')->get();

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

        $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
        $res_api3 = $response3->json();

        $data['pdglists'] = array();
        foreach ($res_api3['data'] as $key => $value) {
            $data['pdglists'][$key] =
            [
                'id' => $value['identify'],
                'pdglist_name' => $value['name'],
            ];
        }

        if (Auth::user()->status == 1) {
            return view('saleman.catalog', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.catalog', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.catalog', $data);
        }
    }


    public function catalog_detail($id)
    {
        $dataEdit = Catalog::find($id);

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

        $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
        $res_api3 = $response3->json();

        $editPdglists = array();
        foreach ($res_api3['data'] as $key => $value) {
            $editPdglists[$key] =
            [
                'id' => $value['identify'],
                'pdglist_name' => $value['name'],
            ];
        }

        $data = array(
            'dataEdit'  => $dataEdit,
            'editGroups'  => $editGroups,
            'editBrands'  => $editBrands,
            'editPdglists'  => $editPdglists,
        );
        echo json_encode($data);
    }
}


