<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SalePlan;
use App\CustomerVisit;
use App\ObjectiveSaleplan;
use App\MonthlyPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PlanMonthController extends Controller
{

    public function index()
    {
        $data['customer_new'] = DB::table('customer_shops')
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
            ->where('customer_shops.created_by', Auth::user()->id)
            ->select(
                'province.PROVINCE_NAME',
                'customer_shops.*'
            )
            ->orderBy('customer_shops.id', 'desc')
            ->get();

        // return $data['customer_new']->count();

        $date_cust_new = 0;
        $result_cust = 0;
        $remain_cust = 0;
        foreach ($data['customer_new'] as $value) {
            $date = Carbon::parse($value->created_at)->format('Y-m');
            $dateNow = Carbon::today()->format('Y-m');
            if ($date == $dateNow) {
                if ($value->shop_status == 1) {
                    $result_cust++;
                } else {
                    $remain_cust++;
                }
                $date_cust_new++;
            }
        }



        $data['list_saleplan'] = DB::table('sale_plans')
        ->join('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
        ->leftjoin('sale_plan_results', 'sale_plans.id', '=', 'sale_plan_results.sale_plan_id')
            ->select(
                'sale_plan_results.sale_plan_status',
                'customer_shops.shop_name',
                'sale_plans.*'
            )
            ->where('sale_plans.created_by', Auth::user()->id)
            ->orderBy('id', 'desc')->get();

        $date_plan = 0;
        $result_plan = 0;
        $remain_plan = 0;
        foreach ($data['list_saleplan'] as $value) {
            $date = Carbon::parse($value->sale_plans_date)->format('Y-m');
            $dateNow = Carbon::today()->format('Y-m');
            if ($date == $dateNow) {
                if ($value->sale_plan_status == 3) {
                    $result_plan++;
                } else {
                    $remain_plan++;
                }
                $date_plan++;
            }
        }


        $data['list_visit'] = CustomerVisit::join('customer_shops', 'customer_visits.customer_shop_id', '=', 'customer_shops.id')
            ->join('customer_contacts', 'customer_shops.id', '=', 'customer_contacts.customer_shop_id')
            ->join('province', 'customer_shops.shop_province_id', '=', 'province.PROVINCE_CODE')
            ->leftjoin('customer_visit_results', 'customer_visits.id', '=', 'customer_visit_results.customer_visit_id')
            ->select(
                'province.PROVINCE_NAME',
                'customer_contacts.customer_contact_name',
                'customer_visit_results.cust_visit_status',
                'customer_shops.shop_name',
                'customer_visits.*'
            )
            ->where('customer_visits.created_by', Auth::user()->id)
            ->orderBy('id', 'desc')->get();

        $cust_visits = 0;
        foreach ($data['list_visit'] as $value) {
            $date = Carbon::parse($value->customer_visit_date)->format('Y-m');
            $dateNow = Carbon::today()->format('Y-m');
            if ($date == $dateNow) {
                $cust_visits++;
            }
        }

        $data['objective'] = ObjectiveSaleplan::all();

        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)->get(); //ตรวจสอบเดือนของแผนงานประจำเดือน
        if ($data['monthly_plan']->count() > 0) {
            foreach ($data['monthly_plan'] as $value) {
                $date = Carbon::parse($value->month_date)->format('Y-m');
                // return $date;
                $dateNow = Carbon::today()->addMonth(1)->format('Y-m');
                if ($date == $dateNow) {

                    // $data2 = MonthlyPlan::find($id);
                    $value->sale_plan_amount    = $date_plan;
                    $value->cust_new_amount     = $date_cust_new;
                    $value->cust_visits_amount  = $cust_visits;
                    $value->total_plan          = $date_plan + $date_cust_new;
                    $value->success_plan        = $result_plan + $result_cust;
                    $value->outstanding_plan    = $remain_plan + $remain_cust;
                    $value->updated_by          = Auth::user()->id;
                    $value->updated_at          = Carbon::now();
                    $value->update();

                    $data['monthly_plan_id'] = $value->id;
                    $data['sale_plan_amount'] = $value->sale_plan_amount;
                    $data['cust_new_amount'] = $value->cust_new_amount;
                    $data['cust_visits_amount'] = $value->cust_visits_amount;
                } else {
                    $plans = new MonthlyPlan;
                    $plans->month_date          = Carbon::now()->addMonth(1);
                    $plans->sale_plan_amount    = $date_plan;
                    $plans->cust_new_amount     = $date_cust_new;
                    $plans->cust_visits_amount  = $cust_visits;
                    $plans->total_plan          = $date_plan + $date_cust_new;
                    $plans->success_plan        = $result_plan + $result_cust;
                    $plans->outstanding_plan    = $remain_plan + $remain_cust;
                    $plans->created_by          = Auth::user()->id;
                    $plans->created_at          = Carbon::now();
                    $plans->save();

                    $data['monthly_plan_id'] = $plans->id;
                    $data['sale_plan_amount'] = $plans->sale_plan_amount;
                    $data['cust_new_amount'] = $plans->cust_new_amount;
                    $data['cust_visits_amount'] = $plans->cust_visits_amount;
                }
            }
        } else {
            $plans = new MonthlyPlan;
            $plans->month_date          = Carbon::now()->addMonth(1);
            $plans->sale_plan_amount    = $date_plan;
            $plans->cust_new_amount     = $date_cust_new;
            $plans->cust_visits_amount  = $cust_visits;
            $plans->total_plan          = $date_plan + $date_cust_new;
            $plans->success_plan        = $result_plan + $result_cust;
            $plans->outstanding_plan    = $remain_plan + $remain_cust;
            $plans->created_by          = Auth::user()->id;
            $plans->created_at          = Carbon::now();
            $plans->save();

            $data['monthly_plan_id'] = $plans->id;
            $data['sale_plan_amount'] = $plans->sale_plan_amount;
            $data['cust_new_amount'] = $plans->cust_new_amount;
            $data['cust_visits_amount'] = $plans->cust_visits_amount;
        }

        return view('saleman.planMonth', $data);
    }

    public function approve($id)
    {
        // dd($id);

            $request_approval = SalePlan::where('monthly_plan_id', $id)->first();
            $request_approval->sale_plans_status   = 1;
            $request_approval->updated_by   = Auth::user()->id;
            $request_approval->updated_at   = Carbon::now();
            $request_approval->update();

            $request_approval_month = MonthlyPlan::find($id);
            $request_approval_month->status_approve   = 1;
            $request_approval_month->updated_by   = Auth::user()->id;
            $request_approval_month->updated_at   = Carbon::now();
            $request_approval_month->update();

        return back();
    }
}
