<?php

namespace App\Http\Controllers\LeadManager;

use App\Assignment;
use App\AssignmentComment;
use App\Customer;
use App\CustomerShopComment;
use App\CustomerVisit;
use App\Http\Controllers\Controller;
use App\MonthlyPlan;
use App\SalePlan;
use Carbon\Carbon;
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
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        $data['monthly_plan'] = DB::table('monthly_plans')
            ->join('users', 'users.id', 'monthly_plans.created_by')
            ->where('monthly_plans.status_approve', 1)
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select(
                'users.*',
                'monthly_plans.*'
            )
            ->paginate(10);

        return view('leadManager.approval_saleplan', $data);
    }

    public function saleplan_history()
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        $data['monthly_plan'] = DB::table('monthly_plans')
            ->join('users', 'users.id', 'monthly_plans.created_by')
            ->whereIn('monthly_plans.status_approve', [2, 3])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select(
                'users.*',
                'monthly_plans.*'
            )
            ->paginate(10);

        return view('leadManager.approval_saleplan_history', $data);
    }

    public function search(Request $request){

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        list($year,$month) = explode('-', $request->selectdateTo);
        $data['monthly_plan'] = DB::table('monthly_plans')
            ->join('users', 'users.id', 'monthly_plans.created_by')
            ->where('monthly_plans.status_approve', 1)
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->whereYear('month_date', $year)
            ->whereMonth('month_date', $month)
            ->select(
                'users.*',
                'monthly_plans.*'
            )
            ->paginate(10);

        return view('leadManager.approval_saleplan', $data);
    }

    public function history_search(Request $request){

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        list($year,$month) = explode('-', $request->selectdateTo);
        $data['monthly_plan'] = DB::table('monthly_plans')
            ->join('users', 'users.id', 'monthly_plans.created_by')
            ->whereIn('monthly_plans.status_approve', [2, 3])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->whereYear('month_date', $year)
            ->whereMonth('month_date', $month)
            ->select(
                'users.*',
                'monthly_plans.*'
            )
            ->paginate(10);

        return view('leadManager.approval_saleplan_history', $data);
    }

    public function approvalsaleplan_detail($id)
    {

        // ข้อมูล Sale plan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->where('monthly_plan_id', $id)
        // ->where('sale_plans.created_by', Auth::user()->id)
        ->whereIn('sale_plans_status', [1, 2, 3])
        ->orderBy('id', 'desc')->get();

        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $mon_plan = DB::table('monthly_plans')->where('id', $id)->first(); // ค้นหา id ผู้ขออนุมัติ
        $user_api = DB::table('users')->where('id',$mon_plan->created_by)->first(); // ค้นหา user api เพื่อใช้ดึง api
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/sellers/'.$user_api->api_identify.'/customers');
        $res_api = $response->json();

        $data['customer_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['customer_api'][$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['amphoe_name']." ".$value['province_name'],
            ];
        }

        $data['sale_name'] = DB::table('users')->where('id',$mon_plan->created_by)->select('name')->first(); // ชื่อเซลล์

        // ลูกค้าใหม่
        $data['customer_new'] = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->join('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->whereIn('customer_shops_saleplan.shop_aprove_status', [1, 2, 3])
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

        // เยี่ยมลูกค้า
        $customer_visits = DB::table('customer_visits')
            ->where('monthly_plan_id', $id)
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();

        $data['customer_visit_api'] = array();

        foreach($customer_visits as $key => $cus_visit){

            $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/customers/'.$cus_visit->customer_shop_id);
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

        // dd($data['customer_new']);

        return view('leadManager.approval_saleplan_detail', $data);
    }

    public function saleplan_history_detail($id)
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

        return view('leadManager.approval_saleplan_history-detail', $data);
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
                return view('leadManager.create_comment_saleplan', $data);
            }else {
                return view('leadManager.create_comment_saleplan', $data);
            }
    }

    public function comment_customer_new($id, $custsaleplanID, $createID)
    {
        // return $id;

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
                return view('leadManager.create_comment_customer_new', $data);
            }else {
                return view('leadManager.create_comment_customer_new', $data);
            }
    }

    public function create_comment_saleplan(Request $request)
    {

        // $data = SaleplanComment::where('saleplan_id', $request->id)->first();
        // dd($request,$request->createID, $data);
        $data = SaleplanComment::where('saleplan_id', $request->id)->where('created_by', Auth::user()->id)->first();
        if ($data) {

            DB::table('sale_plan_comments')->where('id', $data->id)
            ->update([
                'saleplan_comment_detail' => $request->comment,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $sale_plans = DB::table('sale_plans')->where('id', $request->id)->first();
            return redirect(url('approvalsaleplan_detail', $sale_plans->monthly_plan_id));

        } else {

            DB::table('sale_plan_comments')
            ->insert([
                'saleplan_id' => $request->id,
                'saleplan_comment_detail' => $request->comment,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $sale_plans = DB::table('sale_plans')->where('id', $request->id)->first();
            return redirect(url('approvalsaleplan_detail', $sale_plans->monthly_plan_id));
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

        return redirect(url('approvalsaleplan_detail', $request->monthly_plans_id));

    }

    public function approval_saleplan_confirm_all(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            if ($request->checkapprove) {
                if ($request->approve) {
                    if ($request->CheckAll == "Y") {

                        foreach ($request->checkapprove as $key => $chk) {
                            SalePlan::where('monthly_plan_id', $chk)->update([
                                'sale_plans_status' => 2,
                                'sale_plans_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);

                            DB::table('customer_shops_saleplan')->where('monthly_plan_id', $chk)
                            ->update([
                                'shop_aprove_status' => 2,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);

                    } else {

                        foreach ($request->checkapprove as $key => $chk) {
                            SalePlan::where('monthly_plan_id', $chk)->update([
                                'sale_plans_status' => 2,
                                'sale_plans_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);

                            DB::table('customer_shops_saleplan')->where('monthly_plan_id', $chk)
                            ->update([
                                'shop_aprove_status' => 2,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }

                        $chkSaleplan = SalePlan::where('monthly_plan_id', $chk)
                        ->where('sale_plans_status', 1)->count();

                        $chkCustomer = DB::table('customer_shops_saleplan')
                        ->where('monthly_plan_id', $chk)
                        ->where('shop_aprove_status', 1)->count();

                        if ($chkSaleplan == 0 && $chkCustomer == 0) {
                            MonthlyPlan::where('id', $chk)->update([
                                'status_approve' => 2,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }

                }else { // ไม่อนุมัติ
                    if ($request->CheckAll == "Y") {
                        // return "yy";
                        foreach ($request->checkapprove as $key => $chk) {
                            SalePlan::where('monthly_plan_id', $chk)->update([
                                'sale_plans_status' => 3,
                                'sale_plans_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);

                            DB::table('customer_shops_saleplan')->where('monthly_plan_id', $chk)
                            ->update([
                                'shop_aprove_status' => 3,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 3,
                            'updated_by' => Auth::user()->id,
                        ]);

                        // return back();
                    } else {
                        foreach ($request->checkapprove as $key => $chk) {
                            SalePlan::where('monthly_plan_id', $chk)->update([
                                'sale_plans_status' => 3,
                                'sale_plans_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);

                            DB::table('customer_shops_saleplan')->where('monthly_plan_id', $chk)
                            ->update([
                                'shop_aprove_status' => 3,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                        $chkSaleplan = SalePlan::where('monthly_plan_id', $chk)
                        ->where('sale_plans_status', 1)->count();

                        $chkCustomer = DB::table('customer_shops_saleplan')
                            ->where('monthly_plan_id', $chk)
                            ->where('shop_aprove_status', 1)->count();

                        if ($chkSaleplan == 0 && $chkCustomer == 0) {
                            MonthlyPlan::where('id', $chk)->update([
                                'status_approve' => 3,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                }
            }else{
                DB::rollback();
                // return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
                return response()->json([
                    'status' => 404,
                    'message' => 'กรุณาเลือกรายการอนุมัติ',
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลได้',
            ]);


        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);

        }
    }

    public function approval_saleplan_confirm(Request $request)
    {
        // dd($request);

        if ($request->checkapprove) {
            if ($request->approve) {
                if ($request->CheckAll == "Y") {
                    // return "yy";
                        foreach ($request->checkapprove as $key => $chk) {
                            SalePlan::where('id', $chk)->update([
                                'sale_plans_status' => 2,
                                'sale_plans_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }

                    $month_id = SalePlan::where('id', $chk)->first();
                    $chkSaleplan = SalePlan::where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('sale_plans_status', 1)->count();

                    $chkCustomer = DB::table('customer_shops_saleplan')
                    ->where('monthly_plan_id', $month_id->monthly_plan_id)
                    ->where('shop_aprove_status', 1)->count();
                    // $chkCustomer = Customer::where('monthly_plan_id', $month_id->monthly_plan_id)
                    //     ->where('shop_aprove_status', 1)->count();

                    if ($chkSaleplan == 0 && $chkCustomer == 0) {
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'sale_plans_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }

                } else {
                        foreach ($request->checkapprove as $key => $chk) {
                            SalePlan::where('id', $chk)->update([
                                'sale_plans_status' => 2,
                                'sale_plans_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }

                    $month_id = SalePlan::where('id', $chk)->first();
                    $chkSaleplan = SalePlan::where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('sale_plans_status', 1)->count();

                    $chkCustomer = DB::table('customer_shops_saleplan')
                        ->where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('shop_aprove_status', 1)->count();
                    // $chkCustomer = Customer::where('monthly_plan_id', $month_id->monthly_plan_id)
                    //     ->where('shop_aprove_status', 1)->count();

                    if ($chkSaleplan == 0 && $chkCustomer == 0) {
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                }
            }else {
                if ($request->CheckAll == "Y") {
                    // return "yy";
                    foreach ($request->checkapprove as $key => $chk) {
                        SalePlan::where('id', $chk)->update([
                            'sale_plans_status' => 3,
                            'sale_plans_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }

                    $month_id = SalePlan::where('id', $chk)->first();
                    $chkSaleplan = SalePlan::where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('sale_plans_status', 1)->count();

                    $chkCustomer = DB::table('customer_shops_saleplan')
                        ->where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('shop_aprove_status', 1)->count();
                    // $chkCustomer = Customer::where('monthly_plan_id', $month_id->monthly_plan_id)
                    //     ->where('shop_aprove_status', 1)->count();

                    if ($chkSaleplan == 0 && $chkCustomer == 0) {
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                } else {
                    foreach ($request->checkapprove as $key => $chk) {
                        SalePlan::where('id', $chk)->update([
                            'sale_plans_status' => 3,
                            'sale_plans_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                }
            }
        }
        if ($request->checkapprove_cust) {
            // return $request->checkapprove_cust;
            if ($request->approve) {
                if ($request->CheckAll_cust == "Y") {

                    foreach ($request->checkapprove_cust as $key => $chk) {
                        DB::table('customer_shops_saleplan')->where('monthly_plan_id', $chk)
                        ->update([
                            'shop_aprove_status' => 2,
                            'customer_shop_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                        // Customer::where('id', $chk)->update([
                        //     'shop_aprove_status' => 2,
                        //     'updated_by' => Auth::user()->id,
                        // ]);
                    //}

                    $month_id = SalePlan::where('id', $chk)->first();
                    $chkSaleplan = SalePlan::where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('sale_plans_status', 1)->count();

                    $chkCustomer = DB::table('customer_shops_saleplan')
                        ->where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('shop_aprove_status', 1)->count();
                    // $chkCustomer = Customer::where('monthly_plan_id', $month_id->monthly_plan_id)
                    //     ->where('shop_aprove_status', 1)->count();

                    if ($chkSaleplan == 0 && $chkCustomer == 0) {
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                    }

                } else {
                    foreach ($request->checkapprove_cust as $key => $chk) {
                        DB::table('customer_shops_saleplan')->where('monthly_plan_id', $chk)
                        ->update([
                            'shop_aprove_status' => 2,
                            'customer_shop_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                        // Customer::where('id', $chk)->update([
                        //     'shop_aprove_status' => 2,
                        //     'updated_by' => Auth::user()->id,
                        // ]);
                    // }

                    $month_id = SalePlan::where('id', $chk)->first();
                    $chkSaleplan = SalePlan::where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('sale_plans_status', 1)->count();

                    $chkCustomer = DB::table('customer_shops_saleplan')
                        ->where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('shop_aprove_status', 1)->count();
                    // $chkCustomer = Customer::where('monthly_plan_id', $month_id->monthly_plan_id)
                    //     ->where('shop_aprove_status', 1)->count();

                    if ($chkSaleplan == 0 && $chkCustomer == 0) {
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                    }
                }
            }else { // ไม่อนุมัติลูกค้าใหม่
                if ($request->CheckAll_cust == "Y") {
                    // return "yy";
                    foreach ($request->checkapprove_cust as $key => $chk) {
                        DB::table('customer_shops_saleplan')->where('monthly_plan_id', $chk)
                        ->update([
                            'shop_aprove_status' => 3,
                            'customer_shop_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                        // Customer::where('id', $chk)->update([
                        //     'shop_aprove_status' => 3,
                        //     'updated_by' => Auth::user()->id,
                        // ]);
                    // }

                    $month_id = SalePlan::where('id', $chk)->first();
                    $chkSaleplan = SalePlan::where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('sale_plans_status', 1)->count();

                    $chkCustomer = DB::table('customer_shops_saleplan')
                        ->where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('shop_aprove_status', 1)->count();
                    // $chkCustomer = Customer::where('monthly_plan_id', $month_id->monthly_plan_id)
                    //     ->where('shop_aprove_status', 1)->count();

                    if ($chkSaleplan == 0 && $chkCustomer == 0) {
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                    }
                } else {
                    foreach ($request->checkapprove_cust as $key => $chk) {
                        DB::table('customer_shops_saleplan')->where('monthly_plan_id', $chk)
                        ->update([
                            'shop_aprove_status' => 3,
                            'customer_shop_approve_id' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                        // Customer::where('id', $chk)->update([
                        //     'shop_aprove_status' => 3,
                        //     'updated_by' => Auth::user()->id,
                        // ]);
                    // }
                    $month_id = SalePlan::where('id', $chk)->first();
                    $chkSaleplan = SalePlan::where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('sale_plans_status', 1)->count();

                    $chkCustomer = DB::table('customer_shops_saleplan')
                        ->where('monthly_plan_id', $month_id->monthly_plan_id)
                        ->where('shop_aprove_status', 1)->count();
                    // $chkCustomer = Customer::where('monthly_plan_id', $month_id->monthly_plan_id)
                    //     ->where('shop_aprove_status', 1)->count();

                    if ($chkSaleplan == 0 && $chkCustomer == 0) {
                        MonthlyPlan::where('id', $chk)->update([
                            'status_approve' => 2,
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                    }
                }
            }
        }
        if ($request->checkapprove == '' && $request->checkapprove_cust == '') {
            return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
        }
        return back();
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

        return back();
    }
}
