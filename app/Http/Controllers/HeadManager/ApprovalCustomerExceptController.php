<?php

namespace App\Http\Controllers\HeadManager;

use App\Customer;
use App\CustomerShopComment;
use App\Http\Controllers\Controller;
use App\MonthlyPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalCustomerExceptController extends Controller
{

    public function index()
    {
        $request = "";
        $data = $this->query_customer_except_history($request);
        return view('headManager.approval_customer_except', $data);
    }

    public function search(Request $request)
    {

        if(!is_null($request->slugradio)){

            $data = $this->query_customer_except_history($request);

            if($request->slugradio == "สำเร็จ"){
                if(isset($data['customer_shops_success_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_success_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }elseif($request->slugradio  == "สนใจ"){
                if(isset($data['customer_shops_result_1_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_result_1_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }elseif($request->slugradio  == "รอตัดสินใจ"){
                if(isset($data['customer_shops_result_2_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_result_2_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }elseif($request->slugradio  == "ไม่สนใจ"){
                if(isset($data['customer_shops_result_3_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_result_3_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }elseif($request->slugradio  == "รอดำเนินการ"){
                if(isset($data['customer_shops_pending_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_pending_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }
            $data['slugradio_filter'] = $request->slugradio;
        }else{
            $data = $this->query_customer_except_history($request);
            $data['customer_shops_table'] = $data['customer_shops_table'];
        }

        return view('headManager.approval_customer_except', $data);
    }

    public function query_customer_except_history($request)
    {
        $parameter = array();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $customer_shops = DB::table('customer_shops_saleplan')
            ->select('monthly_plans.*', 'monthly_plans.id as monthly_plans_id','province.PROVINCE_NAME', 'amphur.AMPHUR_NAME', 'customer_shops_saleplan_result.*', 
            'customer_shops_saleplan.*', 'customer_shops_saleplan.shop_aprove_status as saleplan_shop_aprove_status', 
            'users.name as saleman_name', 'customer_shops.created_at as shop_created_at', 
            'customer_shops_saleplan.approve_at as approve_at', 'customer_shops.*')
            ->leftjoin('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
            ->leftjoin('customer_shops_saleplan_result', 'customer_shops_saleplan_result.customer_shops_saleplan_id', 'customer_shops_saleplan.id')
            ->leftjoin('monthly_plans', 'monthly_plans.id', 'customer_shops_saleplan.monthly_plan_id')
            ->leftjoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->leftjoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
            ->leftjoin('users', 'users.id', 'customer_shops_saleplan.created_by')
            ->where('customer_shops.shop_status', '!=', '2') // 0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า , -> 2 = ลบ
            ->where('users.status', '1') // สถานะ ->1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->whereIn('customer_shops_saleplan.shop_aprove_status', ['2','3']);

        if(isset($request->selectteam_sales) && !is_null($request->selectteam_sales)){ //-- ทีมขาย
            $team = $request->selectteam_sales;
            $customer_shops = $customer_shops
                ->where(function($query) use ($team) {
                    $query->orWhere('users.team_id', $team)
                        ->orWhere('users.team_id', 'like', $team.',%')
                        ->orWhere('users.team_id', 'like', '%,'.$team);
                });
            $data['selectteam_sales'] = $request->selectteam_sales;
        }else{
            $customer_shops = $customer_shops
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            });
        }

        if(isset($request->selectdateFrom) && !is_null($request->selectdateFrom)){ //-- วันที่
            list($year,$month) = explode('-', $request->selectdateFrom);
            $customer_shops = $customer_shops->whereYear('monthly_plans.month_date',$year)
            ->whereMonth('monthly_plans.month_date', $month);
            $data['date_filter'] = $request->selectdateFrom;
        }

        if(isset($request->selectusers) && !is_null($request->selectusers)){ //-- ผู้แทนขาย
            $customer_shops = $customer_shops
                ->where('customer_shops_saleplan.created_by', $request->selectusers);
            $data['selectusers'] = $request->selectusers;
        }

        $customer_shops = $customer_shops->orderBy('customer_shops_saleplan.id', 'desc')
        ->orderBy('customer_shops_saleplan.monthly_plan_id', 'desc')
        ->get();

        $customers_shop = $customer_shops;

       // dd($customer_shops);

        // --------- การ นับจำนวน แสดงในกล่องสถานะ ----------------
        $data['count_customer_all'] = 0; // -- นับจำนวนร้านค้า ทั้งหมด
        $data['count_customer_success'] = 0; // -- นับ จำนวนร้านค้า สถานะสำเร็จ
        $data['count_customer_result_1'] = 0;  // -- นับ จำนวนร้านค้า สถานะสนใจ
        $data['count_customer_result_2'] = 0; // -- นับ จำนวนร้านค้า สถานะรอตัดสินใจ
        $data['count_customer_result_3'] = 0;  // -- นับ จำนวนร้านค้า สถานะไม่สนใจ

        $data['count_customer_pending'] = 0; // -- นับ จำนวนร้านค้า รอดำเนินการ

        foreach($customer_shops as $key => $shop){
            list($shop_date, $shop_time) = explode(' ',$shop->shop_created_at);
            list($year, $month, $day) = explode("-", $shop_date);
            $shop_date = $day."/".$month."/".$year;

            if(isset($shop->approve_at)){
                list($date, $approve_time) = explode(' ', $shop->approve_at);
                list($year, $month, $day) = explode("-", $date);
                $approve_date = $day."/".$month."/".$year;
            }else{
                $approve_date = "-";
            }

            $data['count_customer_all']++;
            $data['customer_shops_table'][] = [
                'id' => $shop->id,
                'shop_date' => $shop_date,
                'shop_profile_image' => $shop->shop_profile_image,
                'approve_date' => $approve_date,
                'saleman_name' => $shop->saleman_name,
                'shop_name' => $shop->shop_name,
                'shop_address' => $shop->AMPHUR_NAME." ".$shop->PROVINCE_NAME,
                'PROVINCE_NAME' => $shop->PROVINCE_NAME,
                'saleplan_shop_aprove_status' => $shop->saleplan_shop_aprove_status,
                'cust_result_status' => $shop->cust_result_status,
                'shop_status' => $shop->shop_status,
                'customer_shops_saleplan_id' => $shop->customer_shops_saleplan_id,
                'monthly_plans_id' => $shop->monthly_plans_id,
            ];

            if($shop->shop_status == 1){
                $data['count_customer_success']++;
                $data['customer_shops_success_table'][] = [
                    'id' => $shop->id,
                    'shop_date' => $shop_date,
                    'shop_profile_image' => $shop->shop_profile_image,
                    'approve_date' => $approve_date,
                    'saleman_name' => $shop->saleman_name,
                    'shop_name' => $shop->shop_name,
                    'shop_address' => $shop->AMPHUR_NAME." ".$shop->PROVINCE_NAME,
                    'PROVINCE_NAME' => $shop->PROVINCE_NAME,
                    'saleplan_shop_aprove_status' => $shop->saleplan_shop_aprove_status,
                    'cust_result_status' => $shop->cust_result_status,
                    'shop_status' => $shop->shop_status,
                    'customer_shops_saleplan_id' => $shop->customer_shops_saleplan_id,
                    'monthly_plans_id' => $shop->monthly_plans_id,
                ];
            }else if(is_null($shop->shop_result_status)){
                $data['count_customer_pending']++;
                $data['customer_shops_pending_table'][] = [
                    'id' => $shop->id,
                    'shop_date' => $shop_date,
                    'shop_profile_image' => $shop->shop_profile_image,
                    'approve_date' => $approve_date,
                    'saleman_name' => $shop->saleman_name,
                    'shop_name' => $shop->shop_name,
                    'shop_address' => $shop->AMPHUR_NAME." ".$shop->PROVINCE_NAME,
                    'PROVINCE_NAME' => $shop->PROVINCE_NAME,
                    'saleplan_shop_aprove_status' => $shop->saleplan_shop_aprove_status,
                    'cust_result_status' => $shop->cust_result_status,
                    'shop_status' => $shop->shop_status,
                    'customer_shops_saleplan_id' => $shop->customer_shops_saleplan_id,
                    'monthly_plans_id' => $shop->monthly_plans_id,
                ];
            }else{
                if($shop->shop_result_status == 2){ /* สนใจ */
                    $data['count_customer_result_1']++;
                    $data['customer_shops_result_1_table'][] = [
                        'id' => $shop->id,
                        'shop_date' => $shop_date,
                        'shop_profile_image' => $shop->shop_profile_image,
                        'approve_date' => $approve_date,
                        'saleman_name' => $shop->saleman_name,
                        'shop_name' => $shop->shop_name,
                        'shop_address' => $shop->AMPHUR_NAME." ".$shop->PROVINCE_NAME,
                        'PROVINCE_NAME' => $shop->PROVINCE_NAME,
                        'saleplan_shop_aprove_status' => $shop->saleplan_shop_aprove_status,
                        'cust_result_status' => $shop->cust_result_status,
                        'shop_status' => $shop->shop_status,
                        'customer_shops_saleplan_id' => $shop->customer_shops_saleplan_id,
                        'monthly_plans_id' => $shop->monthly_plans_id,
                    ];
                }else if($shop->shop_result_status == 1){ /*  รอตัดสินใจ	 */
                    $data['count_customer_pending']++;
                    $data['customer_shops_result_2_table'][] = [
                        'id' => $shop->id,
                        'shop_date' => $shop_date,
                        'shop_profile_image' => $shop->shop_profile_image,
                        'approve_date' => $approve_date,
                        'saleman_name' => $shop->saleman_name,
                        'shop_name' => $shop->shop_name,
                        'shop_address' => $shop->AMPHUR_NAME." ".$shop->PROVINCE_NAME,
                        'PROVINCE_NAME' => $shop->PROVINCE_NAME,
                        'saleplan_shop_aprove_status' => $shop->saleplan_shop_aprove_status,
                        'cust_result_status' => $shop->cust_result_status,
                        'shop_status' => $shop->shop_status,
                        'customer_shops_saleplan_id' => $shop->customer_shops_saleplan_id,
                        'monthly_plans_id' => $shop->monthly_plans_id,
                    ];
                }else if($shop->shop_result_status == 0){ /*  ไม่สนใจ	 */
                    $data['count_customer_result_3']++;
                    $data['customer_shops_result_3_table'][] = [
                        'id' => $shop->id,
                        'shop_date' => $shop_date,
                        'shop_profile_image' => $shop->shop_profile_image,
                        'approve_date' => $approve_date,
                        'saleman_name' => $shop->saleman_name,
                        'shop_name' => $shop->shop_name,
                        'shop_address' => $shop->AMPHUR_NAME." ".$shop->PROVINCE_NAME,
                        'PROVINCE_NAME' => $shop->PROVINCE_NAME,
                        'saleplan_shop_aprove_status' => $shop->saleplan_shop_aprove_status,
                        'cust_result_status' => $shop->cust_result_status,
                        'shop_status' => $shop->shop_status,
                        'customer_shops_saleplan_id' => $shop->customer_shops_saleplan_id,
                        'monthly_plans_id' => $shop->monthly_plans_id,
                    ];
                }
            }
        }

        // --------- จบ การ นับจำนวน แสดงในกล่องสถานะ ----------------

        $data['users'] = DB::table('users')
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();
        $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        return $data;

    }

    public function approval_customer_except_detail($id)
    {
        $data['customer_shops'] = DB::table('customer_shops')
            ->where('id', $id)
            ->first();

        $data['customer_contacts'] = DB::table('customer_contacts')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('id', 'desc')
            ->first();

        $data['customer_history_contacts'] = DB::table('customer_history_contacts')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('id', 'desc')
            ->get();

        $data['customer_shops_saleplan'] = DB::table('customer_shops_saleplan')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('monthly_plan_id', 'asc')
            ->get();
            
        return view('headManager.approval_customer_except_detail', $data);
    }

    public function comment_customer_except($id, $custsaleplanID, $createID)
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
            return view('headManager.create_comment_customer_except', $data);
        }else {
            return view('headManager.create_comment_customer_except', $data);
        }
    }



    public function create_comment_customer_except(Request $request)
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

        $data2 = DB::table('customer_shops_saleplan')
        ->where('id', $request->cust_shops_saleplan_id)
        ->first();

        return redirect(url('head/approval_customer_except_detail', $data2->created_by));

    }

    public function comment_customer_new_except($shop_id, $shops_saleplan_id, $monthly_plans_id){
        $data['shop_id'] = $shop_id;
        $data['shops_saleplan_id'] = $shops_saleplan_id;
        $data['monthly_plans_id'] = $monthly_plans_id;

        $data['data'] = CustomerShopComment::where('customer_shops_saleplan_id', $shops_saleplan_id)
        ->where('created_by', Auth::user()->id)->first();

        $data['customer'] = DB::table('customer_shops')->where('id', $shop_id)->first();

        $data['customer_shop_comments'] = DB::table('customer_shop_comments')
        ->where('customer_shops_saleplan_id', $shops_saleplan_id)
        ->whereNotIn('created_by', [Auth::user()->id])
        ->orderby('created_at', 'desc')
        ->get();

        return view('headManager.create_comment_customer_new_except', $data);

    }

    public function comment_customer_new_except_update(Request $request){
        // dd($request);

        $data = DB::table('customer_shop_comments')
        ->where('customer_shops_saleplan_id', $request->shops_saleplan_id)
        ->where('created_by', Auth::user()->id)
        ->first();

        if ($data) {
            DB::table('customer_shop_comments')
            ->where('customer_shops_saleplan_id', $request->shops_saleplan_id)
            ->update([
                'customer_comment_detail' => $request->comment,
                'updated_by' => Auth::user()->id,
                'updated_at'=> date('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('customer_shop_comments')
            ->insert([
                'customer_shops_saleplan_id' => $request->shops_saleplan_id,
                'customer_id' => $request->shop_id,
                'customer_comment_detail' => $request->comment,
                'created_by' => Auth::user()->id,
                'created_at'=> date('Y-m-d H:i:s')
            ]);
        }

        return redirect(url('head/approval-customer-except'));
    }


    public function approval_customer_confirm_all(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            if ($request->checkapprove) {
                if ($request->approve) {
                    if ($request->CheckAll == "Y") {

                        foreach ($request->checkapprove as $key => $chk) {

                            DB::table('customer_shops_saleplan')->where('monthly_plan_id', $request->monthly_plan_id)
                            ->where('created_by', $chk)
                            ->update([
                                'shop_aprove_status' => 2,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                            DB::table('customer_shops')->where('shop_status', 0)
                            ->where('monthly_plan_id', $request->monthly_plan_id)
                            ->where('created_by', $chk)
                            ->update([
                                'shop_aprove_status' => 2,
                                // 'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }

                    } else {

                        foreach ($request->checkapprove as $key => $chk) {

                            DB::table('customer_shops_saleplan')->where('monthly_plan_id', $request->monthly_plan_id)->where('created_by', $chk)
                            ->update([
                                'shop_aprove_status' => 2,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                            DB::table('customer_shops')->where('shop_status', 0)
                            ->where('monthly_plan_id', $request->monthly_plan_id)
                            ->where('created_by', $chk)
                            ->update([
                                'shop_aprove_status' => 2,
                                // 'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }

                    }

                }else { // ไม่อนุมัติ
                    if ($request->CheckAll == "Y") {
                        // return "yy";
                        foreach ($request->checkapprove as $key => $chk) {

                            DB::table('customer_shops_saleplan')->where('monthly_plan_id', $request->monthly_plan_id)->where('created_by', $chk)
                            ->update([
                                'shop_aprove_status' => 3,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                            DB::table('customer_shops')->where('shop_status', 0)
                            ->where('monthly_plan_id', $request->monthly_plan_id)
                            ->where('created_by', $chk)
                            ->update([
                                'shop_aprove_status' => 3,
                                // 'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }

                        // return back();
                    } else {
                        foreach ($request->checkapprove as $key => $chk) {

                            DB::table('customer_shops_saleplan')->where('monthly_plan_id', $request->monthly_plan_id)->where('created_by', $chk)
                            ->update([
                                'shop_aprove_status' => 3,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                            DB::table('customer_shops')->where('shop_status', 0)
                            ->where('monthly_plan_id', $request->monthly_plan_id)
                            ->where('created_by', $chk)
                            ->update([
                                'shop_aprove_status' => 3,
                                // 'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                    }
                }
            }else{
                return back()->with('error', "กรุณาเลือกรายการอนุมัติ");
            }

            DB::commit();
            return back();

        } catch (\Exception $e) {

            DB::rollback();
            return back();

        }
    }
}
