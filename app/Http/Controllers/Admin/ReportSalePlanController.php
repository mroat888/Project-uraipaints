<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MonthlyPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportSalePlanController extends Controller
{
    public function index(){
        $report = array();
        $summary_report = array();

        $sum_count_saleplan = 0;
        $sum_result_failed = 0;
        $sum_result_in_process = 0;
        $sum_result_success = 0;
        $sum_saleplan_updatestatus = 0;

        $users_saleman = DB::table('users')
        ->whereIn('status', [1,2,3])
        // ->where('team_id', Auth::user()->team_id)
        ->get();

        for($i=1; $i<=12; $i++){

            $count_saleplan_month = 0;
            $saleplan_result_failed_month = 0;
            $saleplan_result_in_process_month = 0;
            $saleplan_result_success_month = 0;
            $count_saleplan_updatestatusmonth = 0;

            foreach($users_saleman as $saleman){
                $monthly_plans = DB::table('monthly_plans')
                ->whereYear('month_date', date('Y-m-d'))
                ->whereMonth('month_date', $i)
                ->where('created_by', $saleman->id)
                ->first();

                if(!is_null($monthly_plans)){

                    $count_saleplan = DB::table('sale_plans')
                        ->where('monthly_plan_id', $monthly_plans->id)
                        ->where('sale_plans_status', 2) // สถานะอนุมัติ (0=ฉบับร่าง ,1 = ส่งอนุมัติ , 2 = อนุมัติ , 3= ปฎิเสธ))
                        ->count();

                    $count_saleplan_updatestatus = DB::table('sale_plans')
                        ->where('monthly_plan_id', $monthly_plans->id)
                        ->where('status_result', 3) // สถานะ (0 = ยังไม่ทำ, 1 = เช็คอิน, 2 = เช็คเอ้าท์, 3 = สรุปผลแล้ว)
                        ->count();

                    $saleplan_result_failed = DB::table('sale_plans')
                        ->join('sale_plan_results', 'sale_plans.id', 'sale_plan_results.sale_plan_id')
                        ->where('sale_plans.monthly_plan_id', $monthly_plans->id)
                        ->where('sale_plan_results.sale_plan_status' , 0) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                        ->count();

                    $saleplan_result_in_process = DB::table('sale_plans')
                    ->join('sale_plan_results', 'sale_plans.id', 'sale_plan_results.sale_plan_id')
                    ->where('sale_plans.monthly_plan_id', $monthly_plans->id)
                        ->where('sale_plan_results.sale_plan_status' , 1) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                        ->count();

                    $saleplan_result_success = DB::table('sale_plans')
                    ->join('sale_plan_results', 'sale_plans.id', 'sale_plan_results.sale_plan_id')
                    ->where('sale_plans.monthly_plan_id', $monthly_plans->id)
                        ->where('sale_plan_results.sale_plan_status' , 2) // 0 = ไม่สนใจ | 1 = รอตัดสินใจ | 2 = สนใจ
                        ->count();

                    //--- ผลรวม สรุปเดือน
                    $count_saleplan_month = $count_saleplan_month + $count_saleplan ;
                    $saleplan_result_failed_month = $saleplan_result_failed_month + $saleplan_result_failed;
                    $saleplan_result_in_process_month = $saleplan_result_in_process_month + $saleplan_result_in_process;
                    $saleplan_result_success_month = $saleplan_result_success_month + $saleplan_result_success;
                    $count_saleplan_updatestatusmonth = $count_saleplan_updatestatusmonth + $count_saleplan_updatestatus;
                    
                }
            }

                if($count_saleplan_month > 0 ){
                    $percent_success = @round(($saleplan_result_success_month*100)/$count_saleplan_month);
                    $percent_failed = @round((($saleplan_result_failed_month+$saleplan_result_in_process_month)*100)/$count_saleplan_month);
                }else{
                    $percent_success = 0;
                    $percent_failed = 0;
                }
                $report[$i] = [
                    'month' => $i,
                    'count_saleplan' => $count_saleplan_month,
                    'saleplan_result_failed' => $saleplan_result_failed_month,
                    'saleplan_result_in_process' => $saleplan_result_in_process_month,
                    'saleplan_result_success' => $saleplan_result_success_month,
                    'count_saleplan_updatestatus' => $count_saleplan_updatestatusmonth,
                    'percent_success' => $percent_success,
                    'percent_failed' => $percent_failed,
                ];

                //--- ผลรวม footer
                $sum_count_saleplan = $sum_count_saleplan + $count_saleplan_month;
                $sum_result_failed = $sum_result_failed + $saleplan_result_failed_month;
                $sum_result_in_process = $sum_result_in_process + $saleplan_result_in_process_month;
                $sum_result_success = $sum_result_success + $saleplan_result_success_month;
                $sum_shop_updatestatus = $sum_saleplan_updatestatus + $count_saleplan_updatestatusmonth;
        }

        // -- ผมรวม Precent
        if($count_saleplan_month > 0 ){
            $sum_percent_success = @round(($saleplan_result_in_process_month*100)/$count_saleplan_month);
            $sum_percent_failed = @round((($saleplan_result_failed_month+$saleplan_result_in_process_month)*100)/$count_saleplan_month);
        }else{
            $sum_percent_success = 0;
            $sum_percent_failed = 0;
        }

        $summary_report = [
            'sum_count_saleplan' => $sum_count_saleplan,
            'sum_result_failed' => $sum_result_failed,
            'sum_result_in_process' => $sum_result_in_process,
            'sum_result_success' => $sum_result_success,
            'sum_shop_updatestatus' => $sum_shop_updatestatus,
            'sum_percent_success' => $percent_success,
            'sum_percent_failed' => $percent_failed,
        ];

        return view('reports.report_saleplan_admin', compact('report', 'summary_report'));
    }
}
