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

        try{

            $api_token = $this->api_token->apiToken();
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
            $res_api = $response->json();

            if(!is_null($res_api) && $res_api['code'] == 200){
                $data['groups'] = array();
                foreach ($res_api['data'] as $key => $value) {
                    $data['groups'][$key] =
                    [
                        'id' => $value['identify'],
                        'group_name' => $value['name'],
                    ];
                }
            }

            $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
            $res_api2 = $response2->json();

            if(!is_null($res_api2) && $res_api2['code'] == 200){
                $data['brands'] = array();
                foreach ($res_api2['data'] as $key => $value) {
                    $data['brands'][$key] =
                    [
                        'id' => $value['identify'],
                        'brand_name' => $value['name'],
                    ];
                }
            }

            $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
            $res_api3 = $response3->json();
    
            if(!is_null($res_api3) && $res_api3['code'] == 200){
                $data['pdglists'] = array();
                foreach ($res_api3['data'] as $key => $value) {
                    $data['pdglists'][$key] =
                    [
                        'id' => $value['identify'],
                        'pdglist_name' => $value['name'],
                    ];
                }
            }
            
        } catch( Exception $e ){

            if (Auth::user()->status == 1) {
                return view('saleman.catalog', $data);
            }elseif (Auth::user()->status == 2) {
                return view('leadManager.catalog', $data);
            }elseif (Auth::user()->status == 3) {
                return view('headManager.catalog', $data);
            }

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

        try{

            $api_token = $this->api_token->apiToken();
            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
            $res_api = $response->json();

            if(!is_null($res_api) && $res_api['code'] == 200){
                $data['groups'] = array();
                foreach ($res_api['data'] as $key => $value) {
                    $data['groups'][$key] =
                    [
                        'id' => $value['identify'],
                        'group_name' => $value['name'],
                    ];
                }
            }

            $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
            $res_api2 = $response2->json();

            if(!is_null($res_api2) && $res_api2['code'] == 200){
                $data['brands'] = array();
                foreach ($res_api2['data'] as $key => $value) {
                    $data['brands'][$key] =
                    [
                        'id' => $value['identify'],
                        'brand_name' => $value['name'],
                    ];
                }
            }

            $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
            $res_api3 = $response3->json();

            if(!is_null($res_api3) && $res_api3['code'] == 200){
                $data['pdglists'] = array();
                foreach ($res_api3['data'] as $key => $value) {
                    $data['pdglists'][$key] =
                    [
                        'id' => $value['identify'],
                        'pdglist_name' => $value['name'],
                    ];
                }
            }
            
        } catch( Exception $e ){

            if (Auth::user()->status == 1) {
                return view('saleman.catalog', $data);
            }elseif (Auth::user()->status == 2) {
                return view('leadManager.catalog', $data);
            }elseif (Auth::user()->status == 3) {
                return view('headManager.catalog', $data);
            }
            
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
        $data_product = Catalog::where('id', $id)->first();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        if(!is_null($res_api) && $res_api['code'] == 200){
            $dataGroups = array();
            foreach ($res_api['data'] as $key => $value) {
                $dataGroups[$key] =
                [
                    'id' => $value['identify'],
                    'group_name' => $value['name'],
                ];
            }
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        if(!is_null($res_api2) && $res_api2['code'] == 200){
            $dataBrands = array();
            foreach ($res_api2['data'] as $key => $value) {
                $dataBrands[$key] =
                [
                    'id' => $value['identify'],
                    'brand_name' => $value['name'],
                ];
            }
        }

        $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
        $res_api3 = $response3->json();

        if(!is_null($res_api3) && $res_api3['code'] == 200){
            $dataPdglists = array();
            foreach ($res_api3['data'] as $key => $value) {
                $dataPdglists[$key] =
                [
                    'id' => $value['identify'],
                    'pdglist_name' => $value['name'],
                ];
            }
        }


        $data = array(
            'data_product'  => $data_product,
            'dataGroups'  => $dataGroups,
            'dataBrands'  => $dataBrands,
            'dataPdglists'  => $dataPdglists,
        );
        if (Auth::user()->status == 1) {
            return view('saleman.catalog_view_detail', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.catalog_view_detail', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.catalog_view_detail', $data);
        }
    }
}


