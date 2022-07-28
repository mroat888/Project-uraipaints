<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\ProductPrice;
use App\ProductPriceGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductPriceController extends Controller
{

    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['product_price'] = ProductPrice::where('status', '1')->orderBy('id', 'desc')->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        if(!is_null($res_api)){
            $data['groups'] = array();
            foreach ($res_api['data'] as $key => $value) {
                $data['groups'][$key] =
                [
                    'id' => $value['identify'],
                    'group_name' => $value['name'],
                ];
            }
        }

        if (Auth::user()->status == 1) {
            return view('saleman.product_price', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_price', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_price', $data);
        }
    }

    public function search(Request $request)
    {
        $data['product_price'] = DB::table('product_price');

        if ($request->category != '') {
            $data['product_price'] = $data['product_price']->where('category_id', $request->category);
        }

        if ($request->search != '') {
            $data['product_price'] = $data['product_price']->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $data['product_price'] = $data['product_price']->where('status', '1')->orderBy('id', 'desc')->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        if(!is_null($res_api)){
            $data['groups'] = array();
            foreach ($res_api['data'] as $key => $value) {
                $data['groups'][$key] =
                [
                    'id' => $value['identify'],
                    'group_name' => $value['name'],
                ];
            }
        }

        if (Auth::user()->status == 1) {
            return view('saleman.product_price', $data);
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_price', $data);
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_price', $data);
        }
    }

    public function view_detail($id)
    {
        $data_product = ProductPrice::where('id', $id)->first();
        $gallerys = ProductPriceGallery::where('product_price_id', $id)->orderBy('id', 'desc')->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        if(!is_null($res_api)){
            $dataGroups = array();
            foreach ($res_api['data'] as $key => $value) {
                $dataGroups[$key] =
                [
                    'id' => $value['identify'],
                    'group_name' => $value['name'],
                ];
            }
        }

        if (Auth::user()->status == 1) {
            return view('saleman.product_price_detail', compact('data_product', 'gallerys', 'dataGroups'));
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_price_detail', compact('data_product', 'gallerys', 'dataGroups'));
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_price_detail', compact('data_product', 'gallerys', 'dataGroups'));
        }
    }

}
