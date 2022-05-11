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


        $data['objective'] = ObjectiveSaleplan::all();
        // $data['objective_visit'] = ObjectiveVisit::all();
       // $data['master_present'] = MasterPresentSaleplan::get();

        // -- ข้อมูล แผนงานงาน Saleplan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->leftjoin('sale_plan_comments', 'sale_plans.id', 'sale_plan_comments.saleplan_id')
        ->join('master_objective_saleplans', 'sale_plans.sale_plans_objective', 'master_objective_saleplans.id')
        ->where('sale_plans.monthly_plan_id', $data['monthly_plan_next']->id)
        ->where('sale_plans.created_by', Auth::user()->id)
        ->select('sale_plans.*', 'sale_plan_comments.saleplan_id', 'master_objective_saleplans.masobj_title')->distinct()
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
        ->orderBy('customer_shops_saleplan.id', 'desc')
        ->get();

        // dd($data['customer_new']);

        $data['customer_shops'] = DB::table('customer_shops')->where('customer_shops.shop_status', 0)->where('created_by', Auth::user()->id)->get();

        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        $data['api_token'] = $api_token;

        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers');
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $data['customer_api'] = array();
            foreach ($res_api['data'] as $key => $value) {
                $data['customer_api'][$key] =
                [
                    'id' => $value['identify'],
                    'shop_name' => $value['title']." ".$value['name'],
                    'shop_address' => $value['amphoe_name']." , ".$value['province_name'],
                ];
            }
        }

        // ---- สร้างข้อมูล เยี่ยมลูกค้า โดย link กับ api ------- //
        $customer_visits = CustomerVisit::where('created_by', Auth::user()->id)
            ->where('monthly_plan_id', $data['monthly_plan_next']->id)
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();

        $data['customer_visit_api'] = array();

        // -----  API สินค้านำเสนอ----------- //
        $path_search = "pdglists?sortorder=DESC";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        $data['pdglists_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['pdglists_api'][$key] =
            [
                'identify' => $value['identify'],
                'name' => $value['name'],
                'sub_code' => $value['sub_code'],
            ];
        }

        // dd($data['pdglists_api']);

        foreach($customer_visits as $key => $cus_visit){

            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers/'.$cus_visit->customer_shop_id);
            $res_visit_api = $response->json();
            // dd($res_visit_api);
            if($res_visit_api['code'] == 200){
                foreach ($res_visit_api['data'] as $key_api => $value_api) {
                    $res_visit_api = $res_visit_api['data'][$key_api];
                    $data['customer_visit_api'][] =
                    [
                        'id' => $cus_visit->id,
                        'identify' => $res_visit_api['identify'],
                        'shop_name' => $res_visit_api['title']." ".$res_visit_api['name'],
                        'shop_address' => $res_visit_api['amphoe_name']." , ".$res_visit_api['province_name'],
                        'shop_phone' => $res_visit_api['telephone'],
                        'shop_mobile' => $res_visit_api['mobile'],
                        'focusdate' => $res_visit_api['focusdate'],
                        'monthly_plan_id' => $cus_visit->monthly_plan_id,
                    ];
                }
            }

        }
        // -----  END API

        // dd($data);
        return view('saleman.planMonth', $data);
    }

    public function history($id)
    {

        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)->where('id', $id)->orderBy('month_date', 'desc')->get();
        $data['monthly_plan_history'] = MonthlyPlan::where('created_by', Auth::user()->id)->where('id', $id)->orderBy('month_date', 'desc')->first();
        $data['monthly_plan_next'] = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();


        $data['objective'] = ObjectiveSaleplan::all();
        // $data['objective_visit'] = ObjectiveVisit::all();
       // $data['master_present'] = MasterPresentSaleplan::get();

        // -- ข้อมูล แผนงานงาน Saleplan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->leftjoin('sale_plan_comments', 'sale_plans.id', 'sale_plan_comments.saleplan_id')
        ->where('sale_plans.monthly_plan_id', $id)
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
        ->where('customer_shops_saleplan.monthly_plan_id', $id)
        ->select(
            'master_customer_new.cust_name',
            'province.PROVINCE_NAME',
            'amphur.AMPHUR_NAME',
            'customer_shops.*',
            'customer_shops.id as cust_id',
            'customer_shops_saleplan.*'
        )
        ->orderBy('customer_shops_saleplan.id', 'desc')
        ->get();

        // dd($data['customer_new']);

        $data['customer_shops'] = DB::table('customer_shops')->where('customer_shops.shop_status', 0)->where('created_by', Auth::user()->id)->get();

        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        $data['api_token'] = $api_token;

        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers');
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
        $customer_visits = CustomerVisit::where('created_by', Auth::user()->id)
            ->where('monthly_plan_id', $id)
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();

        $data['customer_visit_api'] = array();

        // -----  API สินค้านำเสนอ----------- //
        $path_search = "pdglists?sortorder=DESC";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        $data['pdglists_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['pdglists_api'][$key] =
            [
                'identify' => $value['identify'],
                'name' => $value['name'],
                'sub_code' => $value['sub_code'],
            ];
        }

        // dd($data['pdglists_api']);

        foreach($customer_visits as $key => $cus_visit){

            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers/'.$cus_visit->customer_shop_id);
            $res_visit_api = $response->json();
            // dd($res_visit_api);
            if($res_visit_api['code'] == 200){
                foreach ($res_visit_api['data'] as $key_api => $value_api) {
                    $res_visit_api = $res_visit_api['data'][$key_api];
                    $data['customer_visit_api'][] =
                    [
                        'id' => $cus_visit->id,
                        'identify' => $res_visit_api['identify'],
                        'shop_name' => $res_visit_api['title']." ".$res_visit_api['name'],
                        'shop_address' => $res_visit_api['amphoe_name']." , ".$res_visit_api['province_name'],
                        'shop_phone' => $res_visit_api['telephone'],
                        'shop_mobile' => $res_visit_api['mobile'],
                        'focusdate' => $res_visit_api['focusdate'],
                        'monthly_plan_id' => $cus_visit->monthly_plan_id,
                    ];
                }
            }

        }
        // -----  END API

        // dd($data);
        return view('saleman.planMonth_history', $data);
    }

    public function approve($id)
    {
        DB::table('sale_plans')->where('monthly_plan_id', $id)
        ->update([
            'sale_plans_status' => 1,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
            'request_approve_at' =>Carbon::now()
        ]);

        DB::table('customer_shops_saleplan')->where('monthly_plan_id', $id)
        ->update([
            'shop_aprove_status' => 1,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
            'request_approve_at' =>Carbon::now()
        ]);

        $request_approval_month = MonthlyPlan::find($id);
        $request_approval_month->status_approve   = 1;
        $request_approval_month->updated_by   = Auth::user()->id;
        $request_approval_month->updated_at   = Carbon::now();
        $request_approval_month->request_approve_at   = Carbon::now();
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


        $data['objective'] = ObjectiveSaleplan::all();
        // $data['objective_visit'] = ObjectiveVisit::all();
       // $data['master_present'] = MasterPresentSaleplan::get();

        // -- ข้อมูล แผนงานงาน Saleplan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->leftjoin('sale_plan_comments', 'sale_plans.id', 'sale_plan_comments.saleplan_id')
        ->join('master_objective_saleplans', 'sale_plans.sale_plans_objective', 'master_objective_saleplans.id')
        ->where('sale_plans.monthly_plan_id', $data['monthly_plan_next']->id)
        ->where('sale_plans.created_by', Auth::user()->id)
        ->select('master_objective_saleplans.*', 'sale_plans.*', 'sale_plan_comments.saleplan_id')->distinct()
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
        ->orderBy('customer_shops_saleplan.id', 'desc')
        ->get();

        // dd($data['customer_new']);

        $data['customer_shops'] = DB::table('customer_shops')->where('customer_shops.shop_status', 0)->where('created_by', Auth::user()->id)->get();

        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        $data['api_token'] = $api_token;

        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers');
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
        $customer_visits = CustomerVisit::where('created_by', Auth::user()->id)
            ->where('monthly_plan_id', $data['monthly_plan_next']->id)
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();

        $data['customer_visit_api'] = array();

        // -----  API สินค้านำเสนอ----------- //
        $path_search = "pdglists?sortorder=DESC";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        $data['pdglists_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['pdglists_api'][$key] =
            [
                'identify' => $value['identify'],
                'name' => $value['name'],
                'sub_code' => $value['sub_code'],
            ];
        }

        // dd($data['pdglists_api']);

        foreach($customer_visits as $key => $cus_visit){

            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers/'.$cus_visit->customer_shop_id);
            $res_visit_api = $response->json();
            // dd($res_visit_api);
            if($res_visit_api['code'] == 200){
                foreach ($res_visit_api['data'] as $key_api => $value_api) {
                    $res_visit_api = $res_visit_api['data'][$key_api];
                    $data['customer_visit_api'][] =
                    [
                        'id' => $cus_visit->id,
                        'identify' => $res_visit_api['identify'],
                        'shop_name' => $res_visit_api['title']." ".$res_visit_api['name'],
                        'shop_address' => $res_visit_api['amphoe_name']." , ".$res_visit_api['province_name'],
                        'shop_phone' => $res_visit_api['telephone'],
                        'shop_mobile' => $res_visit_api['mobile'],
                        'focusdate' => $res_visit_api['focusdate'],
                        'monthly_plan_id' => $cus_visit->monthly_plan_id,
                    ];
                }
            }

        }
        // -----  END API

        // dd($data);
        return view('saleman.planMonth', $data);
    }

    public function approvalsaleplan_close($id)
    {

        // ข้อมูล Sale plan
        $data['list_saleplan'] = DB::table('sale_plans')
            ->where('monthly_plan_id', $id)
            ->whereIn('sale_plans_status', [2, 3, 4])
            ->orderBy('id', 'desc')->get();

        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $mon_plan = DB::table('monthly_plans')->where('id', $id)->first(); // ค้นหา id ผู้ขออนุมัติ
        $user_api = DB::table('users')->where('id',$mon_plan->created_by)->first(); // ค้นหา user api เพื่อใช้ดึง api

        list($year,$month,$day) = explode('-', $mon_plan->month_date);
        $month = $month + 0; //-- ทำให้เป็นตัวเลข เพื่อตัดเลข 0 ด้านหน้าออก

        $path_search = "reports/sellers/B2/closesaleplans?years=".$year."&months=".$month;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        $data['saleplan_api'] = $res_api['data'];

        $data['mon_plan'] = $mon_plan;
        $data['sale_name'] = DB::table('users')->where('id',$mon_plan->created_by)->select('name')->first(); // ชื่อเซลล์

        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.$user_api->api_identify.'/customers');
        // $res_api = $response->json();

        // $data['customer_api'] = array();
        // foreach ($res_api['data'] as $key => $value) {
        //     $data['customer_api'][$key] =
        //     [
        //         'id' => $value['identify'],
        //         'shop_name' => $value['title']." ".$value['name'],
        //         'shop_address' => $value['amphoe_name']." ".$value['province_name'],
        //     ];
        // }

        // // -----  API สินค้านำเสนอ----------- //
        // $path_search = "pdglists?sortorder=DESC";
        // $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        // $res_api = $response->json();

        // $data['pdglists_api'] = array();
        // foreach ($res_api['data'] as $key => $value) {
        //     $data['pdglists_api'][$key] =
        //     [
        //         'identify' => $value['identify'],
        //         'name' => $value['name'],
        //         'sub_code' => $value['sub_code'],
        //     ];
        // }

        // dd($data['pdglists_api']);




        // ลูกค้าใหม่
        $data['customer_new'] = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->join('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->whereIn('customer_shops_saleplan.shop_aprove_status', [2, 3])
        // ->where('customer_shops.created_by', Auth::user()->id)
        ->where('customer_shops_saleplan.monthly_plan_id', $id)
        ->select(
            'province.PROVINCE_NAME',
            'customer_shops.*',
            'customer_shops.id as custid',
            'customer_shops_saleplan.*',
            'master_customer_new.cust_name'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();

        return view('saleman.approval_saleplan_close', $data);
    }
}
