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

class ApprovalCustomerExceptController extends Controller
{

    public function index()
    {
        $month = MonthlyPlan::whereMonth('month_date', Carbon::now()->format('m'))->first();
        $data['customers'] = DB::table('customer_shops')
        ->join('users', 'customer_shops.created_by', '=', 'users.id')
        ->where('customer_shops.shop_status', 0)
        ->where('customer_shops.shop_aprove_status', 0)
        ->where('users.team_id', Auth::user()->team_id)
        ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
        ->where('customer_shops.monthly_plan_id', $month->id)
        ->select('customer_shops.created_by as shop_created_by')
        ->distinct()->get();
        return view('leadManager.approval_customer_except', $data);
    }

    public function approval_customer_except_detail($id)
    {
        // $data['customer_except'] =  DB::table('customer_shops')
        // ->join('customer_shops_saleplan', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        // ->join('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
        // ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        // ->select(
        //     'province.PROVINCE_NAME',
        //     'users.name' ,
        //     'customer_shops.*')
        // ->where('customer_shops_saleplan.is_monthly_plan', "N")
        // ->where('customer_shops_saleplan.shop_aprove_status', 1)
        // ->where('customer_shops_saleplan.created_by', $id)
        // ->orderBy('id', 'desc')->get();

        $data['customer_except'] = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->whereIn('customer_shops_saleplan.shop_aprove_status', [1, 2, 3])
        ->where('customer_shops_saleplan.is_monthly_plan', "N")
        ->where('customer_shops_saleplan.created_by', $id)
        ->select(
            'province.PROVINCE_NAME',
            'customer_shops.*',
            'customer_shops.id as custid',
            'customer_shops_saleplan.*'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();

        return view('leadManager.approval_customer_except_detail', $data);
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
