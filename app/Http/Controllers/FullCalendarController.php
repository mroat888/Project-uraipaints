<?php

namespace App\Http\Controllers;

use Redirect,Response;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiController;

class FullCalendarController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        if(request()->ajax())
        {

         $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
         $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

         $data = Event::where('created_by', Auth::user()->id)
         ->whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)
         ->get(['id','title','start', 'end']);
         return Response::json($data);
        }
        return view('fullcalendar');
    }

    public function show($id){
        $data_event = DB::table('events')->where('id',$id)->first();
        
        $path_search = env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers';      
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get($path_search);
        $res_api = $response->json();

        $customer_api = array();
        $data_show = array();

        // dd($data_event);

        foreach ($res_api['data'] as $key => $value) {
            $customer_api[$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['amphoe_name']." , ".$value['province_name'],
            ];
        }
        

        if(!is_null($data_event->sale_plans_id)){
            $sale_plans = DB::table('sale_plans')->where('id', $data_event->sale_plans_id)->first();
            $data_show['header'] = "แผนงาน";
            $data_show['title'] = $sale_plans->sale_plans_title;
            foreach($customer_api as $key_api => $value_api){
                if($customer_api[$key_api]['id'] == $sale_plans->customer_shop_id){
                    $data_show['shop_name'] = $customer_api[$key_api]['shop_name'];
                }
            }
        }elseif(!is_null($data_event->customer_shops_saleplan_id)){
            
            $sale_sale_cust_new = DB::table('customer_shops_saleplan')->where('id', $data_event->customer_shops_saleplan_id)->first();
            $customer_shop_objective = DB::table('master_objective_saleplans')->where('id', $sale_sale_cust_new->customer_shop_objective)->first();
            $customer_shop = DB::table('customer_shops')->where('id', $sale_sale_cust_new->customer_shop_id)->first();
            $data_show['header'] = "เข้าพบลูกค้าใหม่";
            $data_show['title'] = $customer_shop_objective->masobj_title;
            $data_show['shop_name'] = $customer_shop->shop_name;
            
        }elseif(!is_null($data_event->customer_visits_id)){
            $data_show['header'] = "เข้าพบลูกค้าเยี่ยม";
            $customer_visits = DB::table('customer_visits')->where('id',$data_event->customer_visits_id)->first();
            $master_objective_visit = DB::table('master_objective_visit')->where('id', $customer_visits->customer_visit_objective)->first();
            $data_show['title'] = $master_objective_visit->visit_name;
            foreach($customer_api as $key_api => $value_api){
                if($customer_api[$key_api]['id'] == $customer_visits->customer_shop_id){
                    $data_show['shop_name'] = $customer_api[$key_api]['shop_name'];
                }
            }

        }
        
        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'data_show' => $data_show,
        ]);

    }


    // public function create(Request $request)
    // {
    //     $insertArr = [ 'title' => $request->title,
    //                    'start' => $request->start,
    //                    'end' => $request->end
    //                 ];
    //     $event = Event::insert($insertArr);
    //     return Response::json($event);
    // }


    // public function update(Request $request)
    // {
    //     $where = array('id' => $request->id);
    //     $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
    //     $event  = Event::where($where)->update($updateArr);

    //     return Response::json($event);
    // }


    public function destroy(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();

        return Response::json($event);
    }

}
