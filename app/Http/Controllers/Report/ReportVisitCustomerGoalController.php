<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportVisitCustomerGoalController extends Controller
{
    public function index(){

        $report = array();
        $summary_report = array();

        $sum_count_shop = 0;
        $sum_count_shop_noplan = 0;
        $sum_inout_shop_saleplan = 0 ; //-- รวมตามแผนและนอกแผน
        $sum_result_failed = 0;
        $sum_result_in_process = 0;
        $sum_result_success = 0;
        $sum_shop_updatestatus = 0;


        for($i=1; $i<=12; $i++){
            $monthly_plans = DB::table('monthly_plans')
            ->whereYear('month_date', date('Y-m-d'))
            ->whereMonth('month_date', $i)
            ->where('created_by', Auth::user()->id)
            ->first();

            if(!is_null($monthly_plans)){

                $count_shop = DB::table('customer_shops_saleplan')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('shop_aprove_status', 2)
                    ->where('is_monthly_plan', 'Y')
                    ->count();

                $count_shop_noplan = DB::table('customer_shops_saleplan')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('shop_aprove_status', 2)
                    ->where('is_monthly_plan', 'N')
                    ->count();

                $count_shop_updatestatus = DB::table('customer_shops')
                    ->join('customer_shops_saleplan', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
                    ->where('customer_shops_saleplan.monthly_plan_id', $monthly_plans->id)
                    ->where('customer_shops.shop_status', 1) // สถานะลูกค้า (0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า ,2 = ลบออก)
                    ->count();

                $cus_result_failed = DB::table('customer_shops_saleplan_result')
                    ->Leftjoin('customer_shops_saleplan', 'customer_shops_saleplan.id', 'customer_shops_saleplan_result.customer_shops_saleplan_id')
                    ->where('customer_shops_saleplan.monthly_plan_id', $monthly_plans->id)
                    ->where('customer_shops_saleplan_result.cust_result_status' , 0) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                    ->count();

                $cus_result_in_process = DB::table('customer_shops_saleplan_result')
                    ->Leftjoin('customer_shops_saleplan', 'customer_shops_saleplan.id', 'customer_shops_saleplan_result.customer_shops_saleplan_id')
                    ->where('customer_shops_saleplan.monthly_plan_id', $monthly_plans->id)
                    ->where('customer_shops_saleplan_result.cust_result_status' , 1) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                    ->count();

                $cus_result_success = DB::table('customer_shops_saleplan_result')
                    ->Leftjoin('customer_shops_saleplan', 'customer_shops_saleplan.id', 'customer_shops_saleplan_result.customer_shops_saleplan_id')
                    ->where('customer_shops_saleplan.monthly_plan_id', $monthly_plans->id)
                    ->where('customer_shops_saleplan_result.cust_result_status' , 2) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                    ->count();

                $inout_shop_saleplan = $count_shop + $count_shop_noplan; // รวมตามแผนและนอกแผน

                if($inout_shop_saleplan > 0 ){
                    $percent_success = @round(($cus_result_success*100)/$inout_shop_saleplan);
                    $percent_failed = @round((($cus_result_failed+$cus_result_in_process)*100)/$inout_shop_saleplan);
                }else{
                    $percent_success = 0;
                    $percent_failed = 0;
                }


                //--- ผลรวม
                $sum_count_shop = $sum_count_shop + $count_shop;
                $sum_count_shop_noplan = $sum_count_shop_noplan + $count_shop_noplan;
                $sum_inout_shop_saleplan = $sum_inout_shop_saleplan + $inout_shop_saleplan; // รวมตามแผนและนอกแผน
                $sum_result_failed = $sum_result_failed + $cus_result_failed;
                $sum_result_in_process = $sum_result_in_process + $cus_result_in_process;
                $sum_result_success = $sum_result_success + $cus_result_success;
                $sum_shop_updatestatus = $sum_shop_updatestatus + $count_shop_updatestatus;

            }else{
                $count_shop = "-";
                $count_shop_noplan = "-";
                $cus_result_failed = "-";
                $cus_result_in_process = "-";
                $cus_result_success = "-";
                $count_shop_updatestatus = "-";
                $percent_success = "-";
                $percent_failed = "-";
            }

            $report[$i] = [
                'month' => $i,
                'count_shop' => $count_shop,
                'count_shop_noplan' => $count_shop_noplan,
                'cus_result_failed' => $cus_result_failed,
                'cus_result_in_process' => $cus_result_in_process,
                'cus_result_success' => $cus_result_success,
                'count_shop_updatestatus' => $count_shop_updatestatus,
                'percent_success' => $percent_success,
                'percent_failed' => $percent_failed,
            ];
        }

        // -- ผมรวม Precent
        if($sum_inout_shop_saleplan > 0 ){
            $sum_percent_success = @round(($sum_result_success*100)/$sum_inout_shop_saleplan);
            $sum_percent_failed = @round((($sum_result_failed+$sum_result_in_process)*100)/$sum_inout_shop_saleplan);
        }else{
            $sum_percent_success = 0;
            $sum_percent_failed = 0;
        }

        $summary_report = [
            'sum_count_shop' => $sum_count_shop,
            'sum_count_shop_noplan' => $sum_count_shop_noplan,
            'sum_result_failed' => $sum_result_failed,
            'sum_result_in_process' => $sum_result_in_process,
            'sum_result_success' => $sum_result_success,
            'sum_shop_updatestatus' => $sum_shop_updatestatus,
            'sum_percent_success' => $sum_percent_success,
            'sum_percent_failed' => $sum_percent_failed,
        ];


        return view('reports.report_visitcustomer_goal', compact('report', 'summary_report'));
    }

    public function search(Request $request){

        $data['sel_year'] = $request->sel_year;
        $sel_year = $data['sel_year']."-01-01";

        $report = array();
        $summary_report = array();

        $sum_count_shop = 0;
        $sum_count_shop_noplan = 0;
        $sum_inout_shop_saleplan = 0 ; //-- รวมตามแผนและนอกแผน
        $sum_result_failed = 0;
        $sum_result_in_process = 0;
        $sum_result_success = 0;
        $sum_shop_updatestatus = 0;


        for($i=1; $i<=12; $i++){
            $monthly_plans = DB::table('monthly_plans')
            ->whereYear('month_date', $sel_year)
            ->whereMonth('month_date', $i)
            ->where('created_by', Auth::user()->id)
            ->first();

            if(!is_null($monthly_plans)){

                $count_shop = DB::table('customer_shops_saleplan')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('shop_aprove_status', 2)
                    ->where('is_monthly_plan', 'Y')
                    ->count();

                $count_shop_noplan = DB::table('customer_shops_saleplan')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('shop_aprove_status', 2)
                    ->where('is_monthly_plan', 'N')
                    ->count();

                $count_shop_updatestatus = DB::table('customer_shops')
                    ->join('customer_shops_saleplan', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
                    ->where('customer_shops_saleplan.monthly_plan_id', $monthly_plans->id)
                    ->where('customer_shops.shop_status', 1) // สถานะลูกค้า (0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า ,2 = ลบออก)
                    ->count();

                $cus_result_failed = DB::table('customer_shops_saleplan_result')
                    ->Leftjoin('customer_shops_saleplan', 'customer_shops_saleplan.id', 'customer_shops_saleplan_result.customer_shops_saleplan_id')
                    ->where('customer_shops_saleplan.monthly_plan_id', $monthly_plans->id)
                    ->where('customer_shops_saleplan_result.cust_result_status' , 0) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                    ->count();

                $cus_result_in_process = DB::table('customer_shops_saleplan_result')
                    ->Leftjoin('customer_shops_saleplan', 'customer_shops_saleplan.id', 'customer_shops_saleplan_result.customer_shops_saleplan_id')
                    ->where('customer_shops_saleplan.monthly_plan_id', $monthly_plans->id)
                    ->where('customer_shops_saleplan_result.cust_result_status' , 1) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                    ->count();

                $cus_result_success = DB::table('customer_shops_saleplan_result')
                    ->Leftjoin('customer_shops_saleplan', 'customer_shops_saleplan.id', 'customer_shops_saleplan_result.customer_shops_saleplan_id')
                    ->where('customer_shops_saleplan.monthly_plan_id', $monthly_plans->id)
                    ->where('customer_shops_saleplan_result.cust_result_status' , 2) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                    ->count();

                $inout_shop_saleplan = $count_shop + $count_shop_noplan; // รวมตามแผนและนอกแผน

                if($inout_shop_saleplan > 0 ){
                    $percent_success = @round(($cus_result_success*100)/$inout_shop_saleplan);
                    $percent_failed = @round((($cus_result_failed+$cus_result_in_process)*100)/$inout_shop_saleplan);
                }else{
                    $percent_success = 0;
                    $percent_failed = 0;
                }


                //--- ผลรวม
                $sum_count_shop = $sum_count_shop + $count_shop;
                $sum_count_shop_noplan = $sum_count_shop_noplan + $count_shop_noplan;
                $sum_inout_shop_saleplan = $sum_inout_shop_saleplan + $inout_shop_saleplan; // รวมตามแผนและนอกแผน
                $sum_result_failed = $sum_result_failed + $cus_result_failed;
                $sum_result_in_process = $sum_result_in_process + $cus_result_in_process;
                $sum_result_success = $sum_result_success + $cus_result_success;
                $sum_shop_updatestatus = $sum_shop_updatestatus + $count_shop_updatestatus;

            }else{
                $count_shop = "-";
                $count_shop_noplan = "-";
                $cus_result_failed = "-";
                $cus_result_in_process = "-";
                $cus_result_success = "-";
                $count_shop_updatestatus = "-";
                $percent_success = "-";
                $percent_failed = "-";
            }

            $data['report'][$i] = [
                'month' => $i,
                'count_shop' => $count_shop,
                'count_shop_noplan' => $count_shop_noplan,
                'cus_result_failed' => $cus_result_failed,
                'cus_result_in_process' => $cus_result_in_process,
                'cus_result_success' => $cus_result_success,
                'count_shop_updatestatus' => $count_shop_updatestatus,
                'percent_success' => $percent_success,
                'percent_failed' => $percent_failed,
            ];
        }

        // -- ผมรวม Precent
        if($sum_inout_shop_saleplan > 0 ){
            $sum_percent_success = @round(($sum_result_success*100)/$sum_inout_shop_saleplan);
            $sum_percent_failed = @round((($sum_result_failed+$sum_result_in_process)*100)/$sum_inout_shop_saleplan);
        }else{
            $sum_percent_success = 0;
            $sum_percent_failed = 0;
        }

        $data['summary_report'] = [
            'sum_count_shop' => $sum_count_shop,
            'sum_count_shop_noplan' => $sum_count_shop_noplan,
            'sum_result_failed' => $sum_result_failed,
            'sum_result_in_process' => $sum_result_in_process,
            'sum_result_success' => $sum_result_success,
            'sum_shop_updatestatus' => $sum_shop_updatestatus,
            'sum_percent_success' => $sum_percent_success,
            'sum_percent_failed' => $sum_percent_failed,
        ];


        return view('reports.report_visitcustomer_goal', $data);
    }
}
