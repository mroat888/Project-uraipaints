<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{

    public function __construct(){
        $this->apicontroller = new ApiController();
    }

    public function index()
    {
        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        $data['api_token'] = $api_token;

        switch (Auth::user()->status) {
            case '1':
                $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/reports/delivery-status?seller_id='.Auth::user()->api_identify);
                break;
            case '2':
                $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/reports/delivery-status?saleleaders_id='.Auth::user()->api_identify);
                break;
            case '3':
                $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/reports/delivery-status?saleheaders_id='.Auth::user()->api_identify);
                break;
            case '4':
                $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/reports/delivery-status');
                break;
        }

        $res_api = $response->json();

        if($res_api['code'] == 200){
            $data['delivery_api'] = array();
            foreach ($res_api['data'] as $key => $value) {
                $data['delivery_api'][$key] =
                [
                    'shop_name' => $value['name'],
                    'province' => $value['province'],
                    'invonce_no' => $value['invonce_no'],
                    'total_quan' => $value['total_quan'],
                    'delivery_type' => $value['delivery_type'],
                    'delivery_status' => $value['delivery_status'],
                    'delivery_date' => $value['delivery_date'],
                    'remark' => $value['remark'],
                ];
            }
        }else {
            $data['delivery_api'] = "";
        }

        switch (Auth::user()->status) {
            case '1':
                $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers');
                break;
            case '2':
                $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/saleleaders/'.Auth::user()->api_identify.'/customers');
                break;
            case '3':
                $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/saleheaders/'.Auth::user()->api_identify.'/customers');
                break;
            case '4':
                $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers');
                break;
        }

        $res_api2 = $response2->json();

        if($res_api2['code'] == 200){
            $data['customer_api'] = array();
            foreach ($res_api2['data'] as $key => $value) {
                $data['customer_api'][$key] =
                [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }

        switch (Auth::user()->status) {
            case '1':
                $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/provinces');
                break;
            case '2':
                $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/saleleaders/'.Auth::user()->api_identify.'/provinces');
                break;
            case '3':
                $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/saleheaders/'.Auth::user()->api_identify.'/provinces');
                break;
            case '4':
                $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces');
                break;
        }

        $res_api3 = $response3->json();

        if($res_api3['code'] == 200){
            $data['province_api'] = array();
            foreach ($res_api3['data'] as $key => $value) {
                $data['province_api'][$key] =
                [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                ];
            }
        }

        if (Auth::user()->status == 1) {
            return view('saleman.delivery_status', $data);

        }elseif (Auth::user()->status == 2) {
            return view('leadManager.delivery_status', $data);

        }elseif (Auth::user()->status == 3) {
            return view('headManager.delivery_status', $data);

        }elseif (Auth::user()->status == 4) {
            return view('admin.delivery_status', $data);
        }

    }

    public function search_delivery_status(Request $request)
    {
        // dd($request);
        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        $data['api_token'] = $api_token;

        switch (Auth::user()->status) {
            case '1':
                $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/reports/delivery-status',[
                    'seller_id' => Auth::user()->api_identify,
                    'customer_id' => $request->customer,
                    'provine_id' => $request->province,
                    'delivery_date' => $request->date,
                    'delivery_status' => $request->status
                ]);
                break;
            case '2':
                $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/reports/delivery-status',[
                    'saleleaders_id' => Auth::user()->api_identify,
                    'customer_id' => $request->customer,
                    'provine_id' => $request->province,
                    'delivery_date' => $request->date,
                    'delivery_status' => $request->status
                ]);
                break;
            case '3':
                $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/reports/delivery-status?saleheaders_id='.Auth::user()->api_identify,[
                    // 'saleheaders_id' => Auth::user()->api_identify,
                    'customer_id' => $request->customer,
                    'provine_id' => $request->province,
                    'delivery_date' => $request->date,
                    'delivery_status' => $request->status
                ]);
                break;
            case '4':
                $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/reports/delivery-status',[
                    'customer_id' => $request->customer,
                    'provine_id' => $request->province,
                    'delivery_date' => $request->date,
                    'delivery_status' => $request->status
                ]);
                break;
        }

        $res_api = $response->json();

        if($res_api['code'] == 200){
            $data['delivery_api'] = array();
            foreach ($res_api['data'] as $key => $value) {
                $data['delivery_api'][$key] =
                [
                    'shop_name' => $value['name'],
                    'province' => $value['province'],
                    'invonce_no' => $value['invonce_no'],
                    'total_quan' => $value['total_quan'],
                    'delivery_type' => $value['delivery_type'],
                    'delivery_status' => $value['delivery_status'],
                    'delivery_date' => $value['delivery_date'],
                    'remark' => $value['remark'],
                ];
            }
        }else {
            $data['delivery_api'] = "";
        }

        switch (Auth::user()->status) {
            case '1':
                $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers');
                break;
            case '2':
                $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/saleleaders/'.Auth::user()->api_identify.'/customers');
                break;
            case '3':
                $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/saleheaders/'.Auth::user()->api_identify.'/customers');
                break;
            case '4':
                $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers');
                break;
        }
        $res_api2 = $response2->json();

        if($res_api2['code'] == 200){
            $data['customer_api'] = array();
            foreach ($res_api2['data'] as $key => $value) {
                $data['customer_api'][$key] =
                [
                    'identify' => $value['identify'],
                    'title' => $value['title'],
                    'name' => $value['name'],
                ];
            }
        }

        switch (Auth::user()->status) {
            case '1':
                $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/provinces');
                break;
            case '2':
                $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/saleleaders/'.Auth::user()->api_identify.'/provinces');
                break;
            case '3':
                $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/saleheaders/'.Auth::user()->api_identify.'/provinces');
                break;
            case '4':
                $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/provinces');
                break;
        }
        // $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/provinces/search?name='.$request->province);
        $res_api3 = $response3->json();

        if($res_api3['code'] == 200){
            $data['province_api'] = array();
            foreach ($res_api3['data'] as $key => $value) {
                $data['province_api'][$key] =
                [
                    'identify' => $value['identify'],
                    'name_thai' => $value['name_thai'],
                ];
            }
        }

        if (Auth::user()->status == 1) {
            return view('saleman.delivery_status', $data);

        }elseif (Auth::user()->status == 2) {
            return view('leadManager.delivery_status', $data);

        }elseif (Auth::user()->status == 3) {
            return view('headManager.delivery_status', $data);

        }elseif (Auth::user()->status == 4) {
            return view('admin.delivery_status', $data);
        }
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
