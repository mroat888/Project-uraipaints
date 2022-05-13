<?php

namespace App\Http\Controllers\Admin;

use App\Assignment;
use App\AssignmentComment;
use App\Customer;
use App\CustomerShopComment;
use App\CustomerVisit;
use App\Http\Controllers\Controller;
use App\MonthlyPlan;
use App\SalePlan;
use App\SaleplanComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiController;

class ApprovalSalePlanController extends Controller
{
    public function __construct(){
        $this->apicontroller = new ApiController();
    }

    public function index()
    {
        $data['monthly_plan'] = MonthlyPlan::join('users', 'monthly_plans.created_by', '=', 'users.id')
            ->whereIn('monthly_plans.status_approve', [2,4]) //-- สถานะ อนุมัติ, ปิดแผน
            ->select('users.name', 'monthly_plans.*')
            ->orderBy('monthly_plans.id', 'desc')
            ->get();

        $data['teams'] = DB::table('master_team_sales')->get();

        $data['api_token'] = $this->apicontroller->apiToken();

        return view('admin.approval_saleplan', $data);
    }

    public function approvalsaleplan_detail($id)
    {
        // ข้อมูล Sale plan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->where('monthly_plan_id', $id)
        ->whereIn('sale_plans_status', [1, 2, 3])
        ->orderBy('id', 'desc')->get();

        // -----  API Login ----------- //
        $api_token = $this->apicontroller->apiToken(); // API Login
        //--- End Api Login ------------ //
        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $mon_plan = DB::table('monthly_plans')->where('id', $id)->first(); // ค้นหา id ผู้ขออนุมัติ
        $user_api = DB::table('users')->where('id',$mon_plan->created_by)->first(); // ค้นหา user api เพื่อใช้ดึง api
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.$user_api->api_identify.'/customers');
        $res_api = $response->json();

        $data['customer_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['customer_api'][$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
            ];
        }

        // ลูกค้าใหม่เปลี่ยนมาใช้อันนี้
        $data['customer_new'] = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->whereIn('customer_shops_saleplan.shop_aprove_status', [1, 2, 3])
        // ->where('customer_shops.created_by', Auth::user()->id)
        ->where('customer_shops_saleplan.monthly_plan_id', $id)
        ->select(
            'province.PROVINCE_NAME',
            'customer_shops.*',
            'customer_shops.id as custid',
            'customer_shops_saleplan.*'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();

        // เยี่ยมลูกค้า

        $customer_visits = DB::table('customer_visits')
            ->where('monthly_plan_id', $id)
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();

        $data['customer_visit_api'] = array();

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

        return view('admin.approval_saleplan_detail', $data);
    }

    public function approvalsaleplan_close($id){
        // ข้อมูล Sale plan
        $data['list_saleplan'] = DB::table('sale_plans')
            ->where('monthly_plan_id', $id)
            ->whereIn('sale_plans_status', [2, 4])
            ->orderBy('id', 'desc')->get();

       // dd($data['list_saleplan']);

        // -----  API Login ----------- //
        $api_token = $this->apicontroller->apiToken(); // API Login
        $mon_plan = DB::table('monthly_plans')->where('id', $id)->first(); // ค้นหา id ผู้ขออนุมัติ
        $user_api = DB::table('users')->where('id',$mon_plan->created_by)->first(); // ค้นหา user api เพื่อใช้ดึง api

        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.$user_api->api_identify.'/customers');
        $res_api = $response->json();

        $data['customer_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['customer_api'][$key] =
            [
                'identify' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['adrress2'],
            ];
        }

        // // -----  API สินค้านำเสนอ----------- //
        $path_search = "pdglists?sortorder=DESC";
        // $path_search = "products?sortorder=DESC";
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        // dd($res_api['data']);

        $data['pdglists_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['pdglists_api'][$key] =
            [
                'identify' => $value['identify'],
                'name' => $value['name'],
                'sub_code' => $value['sub_code'],
            ];
        }


        list($year,$month,$day) = explode('-', $mon_plan->month_date);
        $month = $month + 0; //-- ทำให้เป็นตัวเลข เพื่อตัดเลข 0 ด้านหน้าออก

        $path_search = "reports/sellers/".$user_api->api_identify."/closesaleplans?years=".$year."&months=".$month;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        if($res_api['code'] == 200){
            $data['saleplan_api'] = $res_api['data'];
        }

        // dd($data['saleplan_api']);

        $data['mon_plan'] = $mon_plan;
        $data['sale_name'] = DB::table('users')->where('id',$mon_plan->created_by)->select('name')->first(); // ชื่อเซลล์

        return view('admin.approval_saleplan_close', $data);
    }

    public function approvalsaleplan_close_update(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {

            DB::table('monthly_plans')
            ->where('id', $request->monthly_plans_id)
            ->update([
                'status_approve' => 4,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if (DB::table('monthly_plan_result')->where('monthly_plan_id', $request->monthly_plans_id)->count() == 0)
            {
                DB::table('monthly_plan_result')
                ->insert([
                    'monthly_plan_id' => $request->monthly_plans_id,
                    'sale_plan' => $request->saleplan_amount,
                    'close_sale' => $request->close_sale,
                    'bill_amount' => $request->bill_amount,
                    'total_sales' => $request->total_sale,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }else {
                DB::table('monthly_plan_result')->where('monthly_plan_id', $request->monthly_plans_id)
                    ->update([
                    'monthly_plan_id' => $request->monthly_plans_id,
                    'sale_plan' => $request->saleplan_amount,
                    'close_sale' => $request->close_sale,
                    'bill_amount' => $request->bill_amount,
                    'total_sales' => $request->total_sale,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }



            DB::commit();

            return redirect('admin/approvalsaleplan');

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }

    }

    public function search(Request $request){

        //dd($request);

        if(!is_null($request->selectdateTo) && $request->sel_team != 0){
            list($year,$month) = explode('-', $request->selectdateTo);

            $data['monthly_plan'] = MonthlyPlan::join('users', 'monthly_plans.created_by', '=', 'users.id')
                ->whereNotIn('monthly_plans.status_approve', [0])
                ->whereYear('monthly_plans.month_date', $year)
                ->whereMonth('monthly_plans.month_date', $month)
                ->where('users.team_id', $request->sel_team)
                ->select('users.name', 'monthly_plans.*')
                ->orderBy('monthly_plans.id', 'desc')
                ->get();

                $data['search_year'] = $year;
                $data['search_month'] = $month;

        }elseif(!is_null($request->selectdateTo) && $request->sel_team == 0){
            list($year,$month) = explode('-', $request->selectdateTo);

            $data['monthly_plan'] = MonthlyPlan::join('users', 'monthly_plans.created_by', '=', 'users.id')
                ->whereNotIn('monthly_plans.status_approve', [0])
                ->whereYear('monthly_plans.month_date', $year)
                ->whereMonth('monthly_plans.month_date', $month)
                ->select('users.name', 'monthly_plans.*')
                ->orderBy('monthly_plans.id', 'desc')
                ->get();

                $data['search_year'] = $year;
                $data['search_month'] = $month;

        }elseif(is_null($request->selectdateTo) && $request->sel_team != 0){
            $data['monthly_plan'] = MonthlyPlan::join('users', 'monthly_plans.created_by', '=', 'users.id')
                ->whereIn('monthly_plans.status_approve', [2,4])
                ->where('users.team_id', $request->sel_team)
                ->select('users.name', 'monthly_plans.*')
                ->orderBy('monthly_plans.id', 'desc')
                ->get();
        }else{
            $data['monthly_plan'] = MonthlyPlan::join('users', 'monthly_plans.created_by', '=', 'users.id')
                ->whereIn('monthly_plans.status_approve', [2,4])
                ->select('users.name', 'monthly_plans.*')
                ->orderBy('monthly_plans.id', 'desc')
                ->get();
        }

        $data['teams'] = DB::table('master_team_sales')->get();

        $data['api_token'] = $this->apicontroller->apiToken();

        return view('admin.approval_saleplan', $data);
    }

    public function comment_saleplan($id, $createID)
    {
        // return $id;

            $data['data'] = SaleplanComment::where('saleplan_id', $id)->where('created_by', Auth::user()->id)->first();
            $data['saleplanID'] = $id;
            $data['createID'] = $createID;

            $data['title'] = SalePlan::where('id', $id)->first();

            $data['sale_plan_comments'] = DB::table('sale_plan_comments')
            ->where('saleplan_id', $id)
            ->whereNotIn('created_by', [Auth::user()->id])
            ->orderby('created_at', 'desc')
            ->get();
            // dd($data['sale_plan_comments']);

            // return $data;
            if ($data) {
                return view('admin.create_comment_saleplan', $data);
            }else {
                return view('admin.create_comment_saleplan', $data);
            }
    }

    public function comment_customer_new($id, $custsaleplanID, $createID)
    {
        // return $id;

            // $data['data'] = CustomerShopComment::where('customer_id', $id)->where('created_by', Auth::user()->id)->first();
            // $data['customerID'] = $id;
            // $data['createID'] = $createID;

            $data['data'] = CustomerShopComment::where('customer_shops_saleplan_id', $custsaleplanID)->where('created_by', Auth::user()->id)->first();
            $data['customerID'] = $id;
            $data['customersaleplanID'] = $custsaleplanID;
            $data['createID'] = $createID;

            $data['customer_shop_comments'] = DB::table('customer_shop_comments')
            ->where('customer_shops_saleplan_id', $custsaleplanID)
            ->whereNotIn('created_by', [Auth::user()->id])
            ->orderby('created_at', 'desc')
            ->get();

            $data['customer'] = Customer::where('id', $id)->first();
            // return $data;
            if ($data) {
                return view('admin.create_comment_customer_new', $data);
            }else {
                return view('admin.create_comment_customer_new', $data);
            }
    }

    public function create_comment_saleplan(Request $request)
    {
        // dd($request);
            $data = SaleplanComment::where('saleplan_id', $request->id)->where('created_by', Auth::user()->id)->first();
            if ($data) {
                // $dataEdit = SaleplanComment::where('saleplan_id', $request->id)->update([
                //     'saleplan_comment_detail' => $request->comment,
                //     'updated_by' => Auth::user()->id,
                // ]);
                DB::table('sale_plan_comments')->where('id', $data->id)
                ->update([
                    'saleplan_comment_detail' => $request->comment,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                return redirect(url('admin/approvalsaleplan_detail', $request->createID));

            } else {

                DB::table('sale_plan_comments')
                ->insert([
                    'saleplan_id' => $request->id,
                    'saleplan_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                return redirect(url('admin/approvalsaleplan_detail', $request->createID));
            }

    }

    public function create_comment_customer_new(Request $request)
    {
        // dd($request);

        $data = DB::table('customer_shop_comments')
        ->where('customer_shops_saleplan_id', $request->cust_shops_saleplan_id)
        ->where('created_by', Auth::user()->id)
        ->first();

        if ($data) {
            DB::table('customer_shop_comments')
            ->where('customer_shops_saleplan_id', $request->cust_shops_saleplan_id)
            ->update([
                'customer_comment_detail' => $request->comment,
                'updated_by' => Auth::user()->id,
                'updated_at'=> date('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('customer_shop_comments')
            ->insert([
                'customer_shops_saleplan_id' => $request->cust_shops_saleplan_id,
                'customer_id' => $request->customer_shops_id,
                'customer_comment_detail' => $request->comment,
                'created_by' => Auth::user()->id,
                'created_at'=> date('Y-m-d H:i:s')
            ]);
        }

        return redirect(url('admin/approvalsaleplan_detail', $request->monthly_plans_id));

    }

    public function retrospective(Request $request)
    {

        $request_approval_month = MonthlyPlan::find($request->restros_id);
        $request_approval_month->status_approve   = 0; // ย้อนกับเป็นแบบร่าง
        $request_approval_month->update();

        $request_approval = SalePlan::where('monthly_plan_id', $request->restros_id)->get();
        foreach ($request_approval as $key => $value) {
            $value->sale_plans_status   = 0; // ย้อนกับเป็นแบบร่าง
            $value->update();
        }

        DB::table('customer_shops_saleplan')->where('monthly_plan_id', $request->restros_id)
        ->update([
            'shop_aprove_status' => 0,  // ย้อนกับเป็นแบบร่าง
        ]);

        // $request_approval_customer = Customer::where('monthly_plan_id', $id)->get();
        // foreach ($request_approval_customer as $key => $value) {
        //     $value->shop_aprove_status   = 0; // ย้อนกับเป็นแบบร่าง
        //     $value->update();
        // }

        return back();
    }
}
