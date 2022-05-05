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

        $data['customer_shops'] = DB::table('customer_shops_saleplan')
            ->leftJoin('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
            ->leftJoin('customer_shops_saleplan_result', 'customer_shops_saleplan_result.customer_shops_saleplan_id', 'customer_shops_saleplan.id')
            ->leftJoin('monthly_plans', 'monthly_plans.id', 'customer_shops_saleplan.monthly_plan_id')
            ->leftJoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->leftJoin('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
            ->where('customer_shops.shop_status', '!=' ,2) // 0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า , 2 = ลบ
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select(
                'monthly_plans.*',
                'province.PROVINCE_NAME',
                'customer_shops_saleplan_result.*',
                'customer_shops_saleplan.*',
                'customer_shops_saleplan.shop_aprove_status as saleplan_shop_aprove_status',
                'customer_shops.*'
            )
            ->orderBy('customer_shops_saleplan.id', 'desc')
            ->get();

        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

  
        // $auth_team_id = explode(',',Auth::user()->team_id);
        // $auth_team = array();
        // foreach($auth_team_id as $value){
        //     $auth_team[] = $value;
        // }
        // $data['customers'] = DB::table('customer_shops_saleplan')
        //     ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        //     ->join('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
        //     ->where('customer_shops.shop_status', 0)
        //     // ->whereIn('customer_shops_saleplan.shop_aprove_status', [1, 2, 3]) // ส่งขออนุมัติ
        //     ->where(function($query) use ($auth_team) {
        //         for ($i = 0; $i < count($auth_team); $i++){
        //             $query->orWhere('users.team_id', $auth_team[$i])
        //                 ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
        //                 ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
        //         }
        //     })
        //     ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        //     ->where('customer_shops_saleplan.is_monthly_plan', 'N')
        //     ->select('customer_shops_saleplan.created_by as shop_created_by')
        //     ->distinct()->get();

        // $customers = count($data['customers']);
        // $sale = count($data['customer_shops']);

        // dd($customers, $sale);
        

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
            
        // $data['customer_except'] = DB::table('customer_shops_saleplan')
        // ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        // ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        // ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        // ->whereIn('customer_shops_saleplan.shop_aprove_status', [1, 2, 3])
        // ->where('customer_shops_saleplan.is_monthly_plan', "N")
        // ->where('customer_shops_saleplan.created_by', $id)
        // ->select(
        //     'province.PROVINCE_NAME',
        //     'customer_shops.*',
        //     'customer_shops.id as custid',
        //     'customer_shops_saleplan.*'
        // )
        // ->orderBy('customer_shops.id', 'desc')
        // ->get();

        return view('headManager.approval_customer_except_detail', $data);
    }

    public function search(Request $request){

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }  

        $customer_shops = DB::table('customer_shops_saleplan')
            ->leftJoin('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
            ->leftJoin('customer_shops_saleplan_result', 'customer_shops_saleplan_result.customer_shops_saleplan_id', 'customer_shops_saleplan.id')
            ->leftJoin('monthly_plans', 'monthly_plans.id', 'customer_shops_saleplan.monthly_plan_id')
            ->leftJoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->leftJoin('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
            ->where('customer_shops.shop_status', '!=' ,2) // 0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า , 2 = ลบ
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            });

            if(!is_null($request->selectdateFrom)){
                list($year,$month) = explode('-', $request->selectdateFrom);
                $customer_shops = $customer_shops->whereYear('monthly_plans.month_date',$year)
                ->whereMonth('monthly_plans.month_date', $month);
                $data['date_filter'] = $request->selectdateFrom;
            }
    
            if(!is_null($request->slugradio)){
                if($request->slugradio == "สำเร็จ"){
                    $customer_shops = $customer_shops->where('customer_shops.shop_status', 1);
                }elseif($request->slugradio  == "สนใจ"){
                    $customer_shops = $customer_shops->where('customer_shops_saleplan_result.cust_result_status', 2);
                }elseif($request->slugradio  == "รอตัดสินใจ"){
                    $customer_shops = $customer_shops->where('customer_shops_saleplan_result.cust_result_status', 1);
                }elseif($request->slugradio  == "ไม่สนใจ"){
                    $customer_shops = $customer_shops->where('customer_shops_saleplan_result.cust_result_status', 0);
                }
                $data['slugradio_filter'] = $request->slugradio;
            }

            $customer_shops = $customer_shops->select(
                'monthly_plans.*',
                'province.PROVINCE_NAME',
                'customer_shops_saleplan_result.*',
                'customer_shops_saleplan.*',
                'customer_shops_saleplan.shop_aprove_status as saleplan_shop_aprove_status',
                'customer_shops.*'
            )
            ->orderBy('customer_shops_saleplan.id', 'desc')
            ->get();

        $data['customer_shops'] = $customer_shops;

        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        return view('headManager.approval_customer_except', $data);
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
