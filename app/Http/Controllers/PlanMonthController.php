<?php

namespace App\Http\Controllers;

use App\AssignmentComment;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SalePlan;
use App\CustomerVisit;
use App\ObjectiveSaleplan;
use App\MonthlyPlan;
use App\SaleplanComment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiController;
use App\MasterPresentSaleplan;
use App\ObjectiveVisit;

class PlanMonthController extends Controller
{
    public function __construct(){
        $this->apicontroller = new ApiController();
    }

    public function index()
    {

        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->get();
        $data['monthly_plan_next'] = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

        // dd($data);

        $data['objective'] = ObjectiveSaleplan::all();
        // $data['objective_visit'] = ObjectiveVisit::all();
        $data['master_present'] = MasterPresentSaleplan::orderBy('id', 'desc')->get();

        // -- ข้อมูล แผนงานงาน Saleplan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->leftjoin('sale_plan_comments', 'sale_plans.id', 'sale_plan_comments.saleplan_id')
        ->where('sale_plans.monthly_plan_id', $data['monthly_plan_next']->id)
        ->where('sale_plans.created_by', Auth::user()->id)
        ->select('sale_plans.*', 'sale_plan_comments.saleplan_id')->distinct()
        ->orderBy('sale_plans.id', 'desc')->get();

        // -- ข้อมูลลูกค้าใหม่ // ลูกค้าใหม่เปลี่ยนมาใช้อันนี้
        $data['customer_new'] = DB::table('customer_shops_saleplan')
        ->leftJoin('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->join('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
        ->join('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->where('customer_shops.created_by', Auth::user()->id)
        ->where('customer_shops_saleplan.monthly_plan_id', $data['monthly_plan_next']->id)
        ->select(
            'master_customer_new.cust_name',
            'province.PROVINCE_NAME',
            'amphur.AMPHUR_NAME',
            'customer_shops.*',
            'customer_shops.id as cust_id',
            'customer_shops_saleplan.*'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();

        $data['customer_shops'] = DB::table('customer_shops')->where('created_by', Auth::user()->id)->get();

        // $data['customer_new'] = DB::table('customer_shops')
        // ->join('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        // ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        // ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        // ->where('customer_shops.created_by', Auth::user()->id)
        // ->where('customer_shops.monthly_plan_id', $data['monthly_plan_next']->id)
        // ->select(
        //     'province.PROVINCE_NAME',
        //     'amphur.AMPHUR_NAME',
        //     'customer_shops.*'
        // )
        // ->orderBy('customer_shops.id', 'desc')
        // ->get();

        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        $data['api_token'] = $api_token;

        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/customers');
        $res_api = $response->json();

        $data['customer_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['customer_api'][$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['amphoe_name']." , ".$value['province_name'],
            ];
        }

        // ---- สร้างข้อมูล เยี่ยมลูกค้า โดย link กับ api ------- //
        $customer_visits = CustomerVisit::where('customer_visits.created_by', Auth::user()->id)
            ->where('customer_visits.monthly_plan_id', $data['monthly_plan_next']->id)
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();

        $data['customer_visit_api'] = array();
        foreach($customer_visits as $key => $cus_visit){

            foreach ($res_api['data'] as $key_api => $value_api) {
                $res_visit_api = $res_api['data'][$key_api];
                if($cus_visit->customer_shop_id == $res_visit_api['identify']){
                    $data['customer_visit_api'][$key_api] =
                    [
                        'id' => $cus_visit->id,
                        'identify' => $res_visit_api['identify'],
                        'shop_name' => $res_visit_api['title']." ".$res_visit_api['name'],
                        'shop_address' => $res_visit_api['amphoe_name']." , ".$res_visit_api['province_name'],
                        'shop_phone' => $res_visit_api['telephone'],
                        'shop_mobile' => $res_visit_api['mobile'],
                        'focusdate' => $res_visit_api['focusdate'],
                    ];
                }
            }

        }
        // -----  END API

        // dd($data);
        return view('saleman.planMonth', $data);
    }

    public function approve($id)
    { // ส่งอนุมัติให้ผู้จัดการเขต
        // dd($id);

        //-*-  OAT คอมเม้นต์ จะเปลี่ยนไปใช้ตัวล่าง อัพเดท code เพื่อตัดการ วนลูป **-/
        // $request_approval = SalePlan::where('monthly_plan_id', $id)->get();
        // foreach ($request_approval as $key => $value) {
        //     $value->sale_plans_status   = 1;
        //     $value->updated_by   = Auth::user()->id;
        //     $value->updated_at   = Carbon::now();
        //     $value->update();
        // }
        DB::table('sale_plans')->where('monthly_plan_id', $id)
        ->update([
            'sale_plans_status' => 1,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        //-*-  OAT คอมเม้นต์ จะเปลี่ยนไปใช้ตัวล่าง เพิ่มตารางสำหรับ แผนเข้าพบลูกค้าใหม่โดยเฉพาะ **-/
        // $request_approval_customer = Customer::where('monthly_plan_id', $id)->get();
        // foreach ($request_approval_customer as $key => $value) {
        //     $value->shop_aprove_status   = 1;
        //     $value->updated_by   = Auth::user()->id;
        //     $value->updated_at   = Carbon::now();
        //     $value->update();
        // }
        DB::table('customer_shops_saleplan')->where('monthly_plan_id', $id)
        ->update([
            'shop_aprove_status' => 1,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        $request_approval_month = MonthlyPlan::find($id);
        $request_approval_month->status_approve   = 1;
        $request_approval_month->updated_by   = Auth::user()->id;
        $request_approval_month->updated_at   = Carbon::now();
        $request_approval_month->update();

        return back();
    }

    public function saleplan_view_comment($id)
    {
        $sale_comments = SaleplanComment::where('saleplan_id', $id)->get();

        $comment = array();
        foreach ($sale_comments as $key => $value) {
            $users = DB::table('users')->where('id', $value['created_by'])->first();

            if(!is_null($value->updated_at)){
                $date_comment = substr($value->updated_at,0,10);
            }else{
                $date_comment = substr($value->created_at,0,10);
            }

            $comment[$key] =
            [
                'saleplan_comment_detail' => $value->saleplan_comment_detail,
                'user_comment' => $users->name,
                'created_at' => $date_comment,
            ];
        }

        return response()->json($comment);
    }

    public function customernew_view_comment($id)
    {

        $customer_shop_comments = DB::table('customer_shop_comments')
        ->where('customer_shops_saleplan_id', $id)
        ->get();

        $comment = array();
        foreach ($customer_shop_comments as $key => $value) {
            $users = DB::table('users')->where('id', $value->created_by)->first();

            if(!is_null($value->updated_at)){
                $date_comment = substr($value->updated_at,0,10);
            }else{
                $date_comment = substr($value->created_at,0,10);
            }

            $comment[$key] =
            [
                'customer_comment_detail' => $value->customer_comment_detail,
                'user_comment' => $users->name,
                'created_at' => $date_comment,
            ];
        }

        return response()->json($comment);
    }

    public function search_month_planMonth(Request $request)
    {
        $from = $request->fromMonth."-01";
        $to = $request->toMonth."-31";
        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)
        ->whereDate('month_date', '>=', $from)
        ->whereDate('month_date', '<=', $to)
        ->orderBy('month_date', 'desc')->get();

        $data['monthly_plan_next'] = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

       // dd($data);

       $data['objective'] = ObjectiveSaleplan::all();
       // $data['objective_visit'] = ObjectiveVisit::all();
       $data['master_present'] = MasterPresentSaleplan::orderBy('id', 'desc')->get();

       // -- ข้อมูล แผนงานงาน Saleplan
       $data['list_saleplan'] = DB::table('sale_plans')
       ->leftjoin('sale_plan_comments', 'sale_plans.id', 'sale_plan_comments.saleplan_id')
       ->where('sale_plans.monthly_plan_id', $data['monthly_plan_next']->id)
       ->where('sale_plans.created_by', Auth::user()->id)
       ->select('sale_plans.*', 'sale_plan_comments.saleplan_id')->distinct()
       ->orderBy('sale_plans.id', 'desc')->get();

       // -- ข้อมูลลูกค้าใหม่ // ลูกค้าใหม่เปลี่ยนมาใช้อันนี้
       $data['customer_new'] = DB::table('customer_shops_saleplan')
       ->leftJoin('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
       ->join('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
       ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
       ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
       ->where('customer_shops.created_by', Auth::user()->id)
       ->where('customer_shops_saleplan.monthly_plan_id', $data['monthly_plan_next']->id)
       ->select(
           'province.PROVINCE_NAME',
           'amphur.AMPHUR_NAME',
           'customer_shops.*',
           'customer_shops.id as cust_id',
           'customer_shops_saleplan.*'
       )
       ->orderBy('customer_shops.id', 'desc')
       ->get();

       $data['customer_shops'] = DB::table('customer_shops')->where('created_by', Auth::user()->id)->get();

       // $data['customer_new'] = DB::table('customer_shops')
       // ->join('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
       // ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
       // ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
       // ->where('customer_shops.created_by', Auth::user()->id)
       // ->where('customer_shops.monthly_plan_id', $data['monthly_plan_next']->id)
       // ->select(
       //     'province.PROVINCE_NAME',
       //     'amphur.AMPHUR_NAME',
       //     'customer_shops.*'
       // )
       // ->orderBy('customer_shops.id', 'desc')
       // ->get();

       // -----  API  //
       $api_token = $this->apicontroller->apiToken(); // API Login
       $data['api_token'] = $api_token;

       // -----  API ลูกค้าที่ sale ดูแล ----------- //
       $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/customers');
       $res_api = $response->json();

       $data['customer_api'] = array();
       foreach ($res_api['data'] as $key => $value) {
           $data['customer_api'][$key] =
           [
               'id' => $value['identify'],
               'shop_name' => $value['title']." ".$value['name'],
               'shop_address' => $value['amphoe_name']." , ".$value['province_name'],
           ];
       }

       // ---- สร้างข้อมูล เยี่ยมลูกค้า โดย link กับ api ------- //
       $customer_visits = CustomerVisit::where('customer_visits.created_by', Auth::user()->id)
           ->where('customer_visits.monthly_plan_id', $data['monthly_plan_next']->id)
           ->select('customer_visits.*')
           ->orderBy('id', 'desc')->get();

       $data['customer_visit_api'] = array();
       foreach($customer_visits as $key => $cus_visit){

           foreach ($res_api['data'] as $key_api => $value_api) {
               $res_visit_api = $res_api['data'][$key_api];
               if($cus_visit->customer_shop_id == $res_visit_api['identify']){
                   $data['customer_visit_api'][$key_api] =
                   [
                       'id' => $cus_visit->id,
                       'identify' => $res_visit_api['identify'],
                       'shop_name' => $res_visit_api['title']." ".$res_visit_api['name'],
                       'shop_address' => $res_visit_api['amphoe_name']." , ".$res_visit_api['province_name'],
                       'shop_phone' => $res_visit_api['telephone'],
                       'shop_mobile' => $res_visit_api['mobile'],
                       'focusdate' => $res_visit_api['focusdate'],
                   ];
               }
           }

       }
       // -----  END API

       // dd($data);
        return view('saleman.planMonth', $data);
    }
}
