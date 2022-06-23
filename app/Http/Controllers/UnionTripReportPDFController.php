<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use PDF;
use Mail;

class UnionTripReportPDFController extends Controller
{
    public function __construct()
    {
        $this->api_token = new ApiController();
    }

    public function mail($id){
        $api_token = $this->api_token->apiToken();

        $data['trip_header'] = DB::table('trip_header')
        ->join('users', 'trip_header.created_by', '=', 'users.id')
            ->select(
                'users.*',
                'trip_header.*',
            )
        ->where('trip_header.id', $id)
        ->first();

        //-- trip detail
        $trip_detail = DB::table('trip_detail')->where('trip_header_id', $id)->get();

        // ดึงจังหวัด -- API
        switch  (Auth::user()->status){
            case 1 :    $path_search = "sellers/".Auth::user()->api_identify."/provinces";
                break;
            case 2 :    $path_search = 'saleleaders/'.Auth::user()->api_identify.'/provinces';
                break;
            case 3 :    $path_search = 'saleheaders/'.Auth::user()->api_identify.'/provinces';
                break;
            case 4 :    $path_search = 'provinces';
                break;
        }
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['provinces'] = $res_api['data'];
            }
        }

        // --- ดึงข้อมูลร้านค้า
        switch  (Auth::user()->status){
            case 1 :    $path_search = 'sellers/'.Auth::user()->api_identify.'/customers';
                break;
            case 2 :    $path_search = 'saleleaders/'.Auth::user()->api_identify.'/customers';
                break;
            case 3 :    $path_search = 'saleheaders/'.Auth::user()->api_identify.'/customers';
                break;
            case 4 :    $path_search = 'customers';
                break;
        }

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'sortorder' => 'DESC',
        ]);
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $customer_api = $res_api['data'];
        }
        // --- จบ ดึงข้อมูลร้านค้า

        $data['trip_detail'] = array();
        if(count($trip_detail) > 0){
            foreach($trip_detail as $value){

                foreach($data['provinces'] as $provinces){
                    if($value->trip_from == $provinces['identify'] ){
                        $formprovince = $provinces['name_thai'];
                    }

                    if($value->trip_to == $provinces['identify'] ){
                        $toprovince = $provinces['name_thai'];
                    }
                }

                foreach($customer_api as $customer){
                    if($value->customer_id == $customer['identify']){
                        $customer_name = $customer['title']." ".$customer['name'];
                    }
                }

                $data['trip_detail'][] = [
                    'id' => $value->id,
                    'trip_header_id' => $value->trip_header_id,
                    'trip_detail_date' => $value->trip_detail_date,
                    'trip_from' => $formprovince,
                    'trip_to' => $toprovince,
                    'customer_id' => $customer_name
                ];
            }
        }
        //-- จบ trip detail

        $pdf = PDF::loadView('pdf.trip_user_report',$data);

        $data["email"] = "mroat07@gmail.com";
        $data["title"] = "From URPRINT.com";
        $data["body"] = "This is Demo";

        Mail::send('mail.trip_user_mail', $data, function($message)use($data, $pdf) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "text.pdf");
        });
    }

    public function pdf(Request $request)
    {
        if(isset($request->checkapprove)){
            $triph_id = $request->checkapprove;

            $data['trip_header'] = DB::table('trip_header')
            ->join('users', 'trip_header.created_by', '=', 'users.id')
                ->select(
                    'trip_header.*',
                    'users.name',
                    'users.status',
                )
            ->where(function($query) use ($triph_id) {
                for ($i = 0; $i < count($triph_id); $i++){
                    $query->orWhere('trip_header.id', $triph_id[$i]);
                }
            })
            ->get();

            $pdf = PDF::loadView('pdf.trip_report',$data);

        }else{
            $pdf = PDF::loadView('pdf.trip_report');
        }

        return $pdf->stream();
    }

    public function userpdf($id)
    {
        $api_token = $this->api_token->apiToken();

        $data['trip_header'] = DB::table('trip_header')
        ->join('users', 'trip_header.created_by', '=', 'users.id')
            ->select(
                'users.*',
                'trip_header.*',
            )
        ->where('trip_header.id', $id)
        ->first();

        //-- trip detail
        $trip_detail = DB::table('trip_detail')->where('trip_header_id', $id)->get();

        // ดึงจังหวัด -- API
        switch  (Auth::user()->status){
            case 1 :    $path_search = "sellers/".Auth::user()->api_identify."/provinces";
                break;
            case 2 :    $path_search = 'saleleaders/'.Auth::user()->api_identify.'/provinces';
                break;
            case 3 :    $path_search = 'saleheaders/'.Auth::user()->api_identify.'/provinces';
                break;
            case 4 :    $path_search = 'provinces';
                break;
        }
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();
        if(!empty($res_api)){
            if($res_api['code'] == 200){
                $data['provinces'] = $res_api['data'];
            }
        }

        // --- ดึงข้อมูลร้านค้า
        switch  (Auth::user()->status){
            case 1 :    $path_search = 'sellers/'.Auth::user()->api_identify.'/customers';
                break;
            case 2 :    $path_search = 'saleleaders/'.Auth::user()->api_identify.'/customers';
                break;
            case 3 :    $path_search = 'saleheaders/'.Auth::user()->api_identify.'/customers';
                break;
            case 4 :    $path_search = 'customers';
                break;
        }

        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search,[
            'sortorder' => 'DESC',
        ]);
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $customer_api = $res_api['data'];
        }
        // --- จบ ดึงข้อมูลร้านค้า

        $data['trip_detail'] = array();
        if(count($trip_detail) > 0){
            foreach($trip_detail as $value){

                foreach($data['provinces'] as $provinces){
                    if($value->trip_from == $provinces['identify'] ){
                        $formprovince = $provinces['name_thai'];
                    }

                    if($value->trip_to == $provinces['identify'] ){
                        $toprovince = $provinces['name_thai'];
                    }
                }

                $customer_name = "";
                $customers = explode(',', $value->customer_id);
                foreach($customers as $customer_id){
                    foreach($customer_api as $customer){
                        if($customer_id == $customer['identify']){
                            $customer_name .= $customer['title']." ".$customer['name']."<br />";
                        }
                    }
                }

                $data['trip_detail'][] = [
                    'id' => $value->id,
                    'trip_header_id' => $value->trip_header_id,
                    'trip_detail_date' => $value->trip_detail_date,
                    'trip_from' => $formprovince,
                    'trip_to' => $toprovince,
                    'customer_id' => $customer_name
                ];
            }
        }
        //-- จบ trip detail

        $pdf = PDF::loadView('pdf.trip_user_report',$data);
        return $pdf->stream();
    }


    public function report_email()
    {

        $pdf = PDF::loadView('pdf.trip_report_email');
        return $pdf->stream();
    }



}
