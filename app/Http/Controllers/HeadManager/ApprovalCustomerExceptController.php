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
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }  

        $sql_query = "select `monthly_plans`.*, `province`.`PROVINCE_NAME`, `customer_shops_saleplan_result`.*, 
        `customer_shops_saleplan`.*, `customer_shops_saleplan`.`shop_aprove_status` as `saleplan_shop_aprove_status`, 
        `customer_shops_saleplan`.`id` as `customer_shops_saleplan_id`, 
        `monthly_plans`.`id` as `monthly_plans_id`, 
        `customer_shops`.* from `customer_shops_saleplan` 
        left join `customer_shops` on `customer_shops`.`id` = `customer_shops_saleplan`.`customer_shop_id` 
        left join `customer_shops_saleplan_result` on `customer_shops_saleplan_result`.`customer_shops_saleplan_id` = `customer_shops_saleplan`.`id` 
        left join `monthly_plans` on `monthly_plans`.`id` = `customer_shops_saleplan`.`monthly_plan_id` 
        left join `province` on `province`.`PROVINCE_ID` = `customer_shops`.`shop_province_id` 
        left join `users` on `customer_shops_saleplan`.`created_by` = `users`.`id` 
        where `customer_shops`.`shop_status` != ? and `users`.`status` = ? ";

        $parameter = [2, 1];
        $sql_query_where_team = "";

        for ($i = 0; $i < count($auth_team); $i++){
            if($i == 0){
                $sql_query_where_team .= " and (`users`.`team_id` = ?  or `users`.`team_id` like ? or `users`.`team_id` like ? ";
            }else{
                $sql_query_where_team .= "or `users`.`team_id` = ?  or `users`.`team_id` like ? or `users`.`team_id` like ? ";
            }

            $parameter[] = $auth_team[$i];
            $parameter[] = $auth_team[$i].',%';
            $parameter[] = '%'.$auth_team[$i];
        }
        $sql_query_where_team .= ") ";

        $sql_query_orderby = "order by `customer_shops_saleplan`.`id` desc, 
        `customer_shops_saleplan`.`monthly_plan_id` desc";

        $sql_query = $sql_query.$sql_query_where_team;
        $customer_shops = DB::select( $sql_query.$sql_query_orderby, $parameter);

        $data['customer_shops'] = $customer_shops;
        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        // -- นับจำนวนร้านค้า ทั้งหมด
        $data['count_customer_all'] = count($customer_shops); 

        // -- นับ จำนวนร้านค้า สถานะสำเร็จ
        $parameter_count_customer_success = $parameter;
        $count_customer_success = $sql_query." and `customer_shops`.`shop_status` = ? ".$sql_query_orderby;
        $parameter_count_customer_success[] = 1 ;
        $count_customer_success = DB::select( $count_customer_success, $parameter_count_customer_success);
        $data['count_customer_success'] = count($count_customer_success);

         // -- นับ จำนวนร้านค้า สถานะสนใจ
        $parameter_count_customer_result_1 = $parameter;
        $count_customer_result_1 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ".$sql_query_orderby;
        $parameter_count_customer_result_1[] = 2 ;
        $count_customer_result_1 = DB::select( $count_customer_result_1, $parameter_count_customer_result_1);
        $data['count_customer_result_1'] = count($count_customer_result_1);

        // -- นับ จำนวนร้านค้า สถานะรอตัดสินใจ
        $parameter_count_customer_result_2 = $parameter;
        $count_customer_result_2 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
        $parameter_count_customer_result_2[] = 1 ;
        $count_customer_result_2 = DB::select( $count_customer_result_2, $parameter_count_customer_result_2);
        $data['count_customer_result_2'] = count($count_customer_result_2);

        // -- นับ จำนวนร้านค้า สถานะไม่สนใจ
        $parameter_count_customer_result_3 = $parameter;
        $count_customer_result_3 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
        $parameter_count_customer_result_3[] = 0 ;
        $count_customer_result_3 = DB::select( $count_customer_result_3, $parameter_count_customer_result_3);
        $data['count_customer_result_3'] = count($count_customer_result_3);


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
        
        // dd($data);
        
        return view('headManager.approval_customer_except', $data);
    }

    public function search(Request $request){

        $parameter = array();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }  

        $sql_query = "select `monthly_plans`.*, `province`.`PROVINCE_NAME`, `customer_shops_saleplan_result`.*, 
        `customer_shops_saleplan`.*, `customer_shops_saleplan`.`shop_aprove_status` as `saleplan_shop_aprove_status`, 
        `customer_shops_saleplan`.`id` as `customer_shops_saleplan_id`, 
        `monthly_plans`.`id` as `monthly_plans_id`, 
        `customer_shops`.* from `customer_shops_saleplan` 
        left join `customer_shops` on `customer_shops`.`id` = `customer_shops_saleplan`.`customer_shop_id` 
        left join `customer_shops_saleplan_result` on `customer_shops_saleplan_result`.`customer_shops_saleplan_id` = `customer_shops_saleplan`.`id` 
        left join `monthly_plans` on `monthly_plans`.`id` = `customer_shops_saleplan`.`monthly_plan_id` 
        left join `province` on `province`.`PROVINCE_ID` = `customer_shops`.`shop_province_id` 
        left join `users` on `customer_shops_saleplan`.`created_by` = `users`.`id` 
        where `customer_shops`.`shop_status` != ? and `users`.`status` = ? ";

        $parameter = [2, 1];
        $sql_query_where_team = "";

        $sql_query_orderby = "order by `customer_shops_saleplan`.`id` desc, 
        `customer_shops_saleplan`.`monthly_plan_id` desc";


        if(!is_null($request->selectteam_sales)){ //-- ทีมขาย
            $team = $request->selectteam_sales;

            $sql_query_where_team .= " and (`users`.`team_id` = ?  or `users`.`team_id` like ? or `users`.`team_id` like ?) ";
            $parameter[] = $team;
            $parameter[] = $team.',%';
            $parameter[] = '%'.$team;
            
            $sql_query .= $sql_query_where_team;
            $data['selectteam_sales'] = $request->selectteam_sales;
        }else{
            for ($i = 0; $i < count($auth_team); $i++){
                if($i == 0){
                    $sql_query_where_team .= "and (`users`.`team_id` = ?  or `users`.`team_id` like ? or `users`.`team_id` like ? ";
                }else{
                    $sql_query_where_team .= "or `users`.`team_id` = ?  or `users`.`team_id` like ? or `users`.`team_id` like ? ";
                }

                $parameter[] = $auth_team[$i];
                $parameter[] = $auth_team[$i].',%';
                $parameter[] = '%'.$auth_team[$i];
            }
            $sql_query_where_team .= ")";
            $sql_query .= $sql_query_where_team;
        }

        if(!is_null($request->selectdateFrom)){ //-- วันที่
            list($year,$month) = explode('-', $request->selectdateFrom);
            $sql_query = $sql_query." and `monthly_plans`.`month_date` LIKE ? 
            and `monthly_plans`.`month_date` LIKE ? ";
            $parameter[] = $year.'%';
            $parameter[] = '%'.$month.'%';
            $data['date_filter'] = $request->selectdateFrom;      
        }

        if(!is_null($request->selectusers)){ //-- ผู้แทนขาย
            $sql_query = $sql_query." and `customer_shops_saleplan`.`created_by` = ? ";
            $parameter[] = $request->selectusers ;
            $data['selectusers'] = $request->selectusers;
        }



        // --------- การ นับจำนวน แสดงในกล่องสถานะ ----------------

        $sql_query_count = $sql_query;
        $customer_shops_all = DB::select( $sql_query_count, $parameter);

        // -- นับจำนวนร้านค้า ทั้งหมด
        $data['count_customer_all'] = count($customer_shops_all); 

        // -- นับ จำนวนร้านค้า สถานะสำเร็จ
        $parameter_count_customer_success = $parameter;
        $count_customer_success = $sql_query." and `customer_shops`.`shop_status` = ? ";
        $parameter_count_customer_success[] = 1 ;
        $count_customer_success = DB::select( $count_customer_success, $parameter_count_customer_success);
        $data['count_customer_success'] = count($count_customer_success);

         // -- นับ จำนวนร้านค้า สถานะสนใจ
        $parameter_count_customer_result_1 = $parameter;
        $count_customer_result_1 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
        $parameter_count_customer_result_1[] = 2 ;
        $count_customer_result_1 = DB::select( $count_customer_result_1, $parameter_count_customer_result_1);
        $data['count_customer_result_1'] = count($count_customer_result_1);

        // -- นับ จำนวนร้านค้า สถานะรอตัดสินใจ
        $parameter_count_customer_result_2 = $parameter;
        $count_customer_result_2 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
        $parameter_count_customer_result_2[] = 1 ;
        $count_customer_result_2 = DB::select( $count_customer_result_2, $parameter_count_customer_result_2);
        $data['count_customer_result_2'] = count($count_customer_result_2);

        // -- นับ จำนวนร้านค้า สถานะไม่สนใจ
        $parameter_count_customer_result_3 = $parameter;
        $count_customer_result_3 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
        $parameter_count_customer_result_3[] = 0 ;
        $count_customer_result_3 = DB::select( $count_customer_result_3, $parameter_count_customer_result_3);
        $data['count_customer_result_3'] = count($count_customer_result_3);

        // --------- จบ การ นับจำนวน แสดงในกล่องสถานะ ----------------
        

        if(!is_null($request->slugradio)){
            if($request->slugradio == "สำเร็จ"){
                $sql_query = $sql_query." and `customer_shops`.`shop_status` = ? ";
                $parameter[] = 1 ;
            }elseif($request->slugradio  == "สนใจ"){
                $sql_query = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
                $parameter[] = 2 ;
            }elseif($request->slugradio  == "รอตัดสินใจ"){
                $sql_query = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
                $parameter[] = 1 ;
            }elseif($request->slugradio  == "ไม่สนใจ"){
                $sql_query = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
                $parameter[] = 0 ;
            }
            $data['slugradio_filter'] = $request->slugradio;
        }


        $sql_query = $sql_query.$sql_query_orderby;
        $customer_shops = DB::select( $sql_query, $parameter);
        $data['customer_shops'] = $customer_shops;

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

        return view('headManager.approval_customer_except', $data);
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
