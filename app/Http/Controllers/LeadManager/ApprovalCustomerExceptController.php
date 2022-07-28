<?php

namespace App\Http\Controllers\LeadManager;

use App\Customer;
use App\CustomerShopComment;
use App\Http\Controllers\Controller;
use App\MonthlyPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\ChangeCustomerController;

class ApprovalCustomerExceptController extends Controller
{

    public function __construct(){
        $this->ChangeCustomerController= new ChangeCustomerController();
    }

    public function index()
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        $data['customers'] = DB::table('customer_shops_saleplan')
            ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
            ->leftJoin('customer_contacts', 'customer_shops.id', 'customer_contacts.customer_shop_id')
            ->join('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
            ->leftJoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->leftJoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
            ->leftJoin('monthly_plans', 'monthly_plans.id', 'customer_shops_saleplan.monthly_plan_id')
            ->where('customer_shops.shop_status', 0)
            ->where('customer_shops_saleplan.shop_aprove_status', 1) // ส่งขออนุมัติ
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where('customer_shops_saleplan.is_monthly_plan', 'N')
            ->select('customer_shops_saleplan.*',
            'users.name',
            'customer_shops.shop_name',
            'province.PROVINCE_NAME',
            'amphur.AMPHUR_NAME',
            'customer_contacts.customer_contact_name')
            // ->distinct()
            ->get();


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

        return view('leadManager.approval_customer_except', $data);
    }

    public function search(Request $request)
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $customer_shops = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->leftJoin('customer_contacts', 'customer_shops.id', 'customer_contacts.customer_shop_id')
        ->join('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
        ->leftJoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->leftJoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        ->leftJoin('monthly_plans', 'monthly_plans.id', 'customer_shops_saleplan.monthly_plan_id')
        ->where('customer_shops.shop_status', 0)
        ->where('customer_shops_saleplan.shop_aprove_status', 1) // ส่งขออนุมัติ
        ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        ->where('customer_shops_saleplan.is_monthly_plan', 'N')
        ->select('customer_shops_saleplan.*',
        'users.name',
        'customer_shops.shop_name',
        'province.PROVINCE_NAME',
        'amphur.AMPHUR_NAME',
        'customer_contacts.customer_contact_name');

        // ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        // ->leftJoin('customer_contacts', 'customer_shops.id', 'customer_contacts.customer_shop_id')
        // ->join('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
        // ->leftJoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        // ->leftJoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        // ->leftJoin('monthly_plans', 'monthly_plans.id', 'customer_shops_saleplan.monthly_plan_id')
        // ->where('customer_shops.shop_status', 0)
        // ->where('customer_shops_saleplan.shop_aprove_status', 1) // ส่งขออนุมัติ

        if(!is_null($request->selectteam_sales)){ //-- ทีมขาย
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

        if(!is_null($request->selectdateFrom)){ //-- วันที่
            list($year,$month) = explode('-', $request->selectdateFrom);
            $customer_shops = $customer_shops->whereYear('monthly_plans.month_date',$year)
            ->whereMonth('monthly_plans.month_date', $month);
            $data['date_filter'] = $request->selectdateFrom;
        }

        if(!is_null($request->selectusers)){ //-- ผู้แทนขาย
            $customer_shops = $customer_shops
                ->where('customer_shops_saleplan.created_by', $request->selectusers);
            $data['selectusers'] = $request->selectusers;
        }

        $customer_shops = $customer_shops
        ->select('customer_shops_saleplan.*',
            'users.name',
            'customer_shops.shop_name',
            'province.PROVINCE_NAME',
            'amphur.AMPHUR_NAME',
            'customer_contacts.customer_contact_name')

            ->get();

        $data['customers'] = $customer_shops;

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

        return view('leadManager.approval_customer_except', $data);
    }

    public function approval_customer_except_detail($id)
    {
        $data['customer_except'] = DB::table('customer_shops_saleplan')
        ->leftjoin('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->leftjoin('customer_contacts', 'customer_shops.id', 'customer_contacts.customer_shop_id')
        ->leftjoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->leftjoin('users', 'customer_shops.created_by', 'users.id')
        ->leftjoin('monthly_plans', 'customer_shops_saleplan.monthly_plan_id', 'monthly_plans.id') // เดือนที่เพิ่มลูกค้า
        ->leftjoin('master_objective_saleplans', 'customer_shops_saleplan.customer_shop_objective', 'master_objective_saleplans.id') // วัตถุประสงค์
        ->where('customer_shops_saleplan.id', $id)
        ->select(
            'province.PROVINCE_NAME',
            'customer_shops.shop_status',
            'customer_shops.shop_profile_image',
            'customer_shops.shop_name',
            'customer_shops.shop_address',
            'customer_shops.id as custid',
            'customer_contacts.customer_contact_name',
            'customer_contacts.customer_contact_phone',
            'users.name',
            'monthly_plans.month_date',
            'master_objective_saleplans.masobj_title',
            'customer_shops_saleplan.*'
        )
        ->first();

        $data['customer_shops_saleplan'] = DB::table('customer_shops_saleplan')
            ->where('customer_shop_id', $data['customer_except']->custid)
            ->orderBy('monthly_plan_id', 'asc')
            ->get();

        return view('leadManager.approval_customer_except_detail', $data);
    }

    public function customer_history()
    {
        $request = "";
        // $data = $this->query_customer_except_history($request);

        $data = $this->ChangeCustomerController->fetch_customer_lead($request);

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

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
        
        return view('leadManager.approval-customer-except-history', $data);
    }

    public function search_history(Request $request)
    {
        if(!is_null($request->slugradio)){
            $data = $this->ChangeCustomerController->fetch_customer_lead($request);
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
        }else{
            $request = "";
            $data = $this->ChangeCustomerController->fetch_customer_lead($request);
        }
        
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

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

        return view('leadManager.approval-customer-except-history', $data);
    }
    
    public function approval_customer_except_history_detail($id)
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

        return view('leadManager.approval_customer_except_history_detail', $data);
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
            return view('leadManager.create_comment_customer_except', $data);
        }else {
            return view('leadManager.create_comment_customer_except', $data);
        }
    }

    public function show_comment_customer_except($id, $custsaleplanID, $createID)
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
            return view('leadManager.show_comment_customer_except', $data);
        }else {
            return view('leadManager.show_comment_customer_except', $data);
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

        return redirect(url('lead/approval_customer_except_detail', $data2->created_by));

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
                            // return $chk;
                            DB::table('customer_shops_saleplan')->where('id', $chk)
                            ->where('is_monthly_plan', "N")
                            ->update([
                                'shop_aprove_status' => 2,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'approve_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                            DB::table('customer_shops')->where('shop_status', 0)
                            ->where('id', $request->customer_shop_id)
                            ->update([
                                'shop_aprove_status' => 2,
                                // 'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                        }

                    } else {

                        foreach ($request->checkapprove as $key => $chk) {
                            // return $chk;
                            DB::table('customer_shops_saleplan')->where('id', $chk)
                            ->where('is_monthly_plan', "N")
                            ->update([
                                'shop_aprove_status' => 2,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'approve_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                            DB::table('customer_shops')->where('shop_status', 0)
                            ->where('id', $request->customer_shop_id)
                            ->update([
                                'shop_aprove_status' => 2,
                                // 'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                        }

                    }

                }else { // ไม่อนุมัติ
                    if ($request->CheckAll == "Y") {
                        // return "yy";
                        foreach ($request->checkapprove as $key => $chk) {

                            DB::table('customer_shops_saleplan')->where('id', $chk)
                            ->where('is_monthly_plan', "N")
                            ->update([
                                'shop_aprove_status' => 3,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'approve_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                            DB::table('customer_shops')->where('shop_status', 0)
                            ->where('id', $request->customer_shop_id)
                            ->update([
                                'shop_aprove_status' => 3,
                                // 'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                        }

                        // return back();
                    } else {
                        foreach ($request->checkapprove as $key => $chk) {

                            DB::table('customer_shops_saleplan')->where('id', $chk)
                            ->where('is_monthly_plan', "N")
                            ->update([
                                'shop_aprove_status' => 3,
                                'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'approve_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                            DB::table('customer_shops')->where('shop_status', 0)
                            ->where('id', $request->customer_shop_id)
                            ->update([
                                'shop_aprove_status' => 3,
                                // 'customer_shop_approve_id' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
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
}
