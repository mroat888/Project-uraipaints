<?php

namespace App\Http\Controllers\HeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Http;

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

        // $user_team = DB::table('users')
        // ->whereIN('status',[1,2,3])
        // ->where('team_id', Auth::user()->team_id)
        // ->get();
        
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $user_team = DB::table('users')
        ->whereIN('status',[1,2,3])
        ->where(function($query) use ($auth_team) {
            for ($i = 0; $i < count($auth_team); $i++){
                $query->orWhere('team_id', $auth_team[$i])
                    ->orWhere('team_id', 'like', $auth_team[$i].',%')
                    ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
            }
        })
        ->get();
        

        for($i=1; $i<=12; $i++){

            $sum_count_shop_month = 0;
            $sum_count_shop_noplan_month  = 0;
            $sum_inout_shop_saleplan_month = 0; // รวมตามแผนและนอกแผน
            $sum_cus_result_failed_month = 0;
            $sum_cus_result_in_process_month =0;
            $sum_cus_result_success_month = 0;
            $sum_count_shop_updatestatus_month = 0;
            
            foreach($user_team as $team){
                $monthly_plans = DB::table('monthly_plans')
                ->whereYear('month_date', date('Y-m-d'))
                ->whereMonth('month_date', $i)
                ->where('created_by', $team->id)
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

                    //--- ผลรวม สรุปเดือน
                    $sum_count_shop_month = $sum_count_shop_month + $count_shop;
                    $sum_count_shop_noplan_month = $sum_count_shop_noplan_month + $count_shop_noplan;
                    $sum_inout_shop_saleplan_month = $sum_inout_shop_saleplan_month + $inout_shop_saleplan; // รวมตามแผนและนอกแผน               
                    $sum_cus_result_failed_month = $sum_cus_result_failed_month + $cus_result_failed;
                    $sum_cus_result_in_process_month = $sum_cus_result_in_process_month + $cus_result_in_process;
                    $sum_cus_result_success_month = $sum_cus_result_success_month + $cus_result_success;
                    $sum_count_shop_updatestatus_month = $sum_count_shop_updatestatus_month + $count_shop_updatestatus;

                    // -- รายละเอียด
                    if($inout_shop_saleplan > 0 ){
                        $percent_success = @round(($cus_result_success*100)/$inout_shop_saleplan);
                        $percent_failed = @round((($cus_result_failed+$cus_result_in_process)*100)/$inout_shop_saleplan);
                    }else{
                        $percent_success = 0;
                        $percent_failed = 0;
                    }
                    $report_detail[$i][] = [
                        'saleman' => $team->name,
                        'team_id' => $team->team_id,
                        'count_shop' => $count_shop,
                        'count_shop_noplan' => $count_shop_noplan,
                        'count_inout_shop_saleplan' => $inout_shop_saleplan,
                        'cus_result_failed' => $cus_result_failed,
                        'cus_result_in_process' => $cus_result_in_process,
                        'cus_result_success' => $cus_result_success,
                        'count_shop_updatestatus' => $count_shop_updatestatus,
                        'percent_success' => $percent_success,
                        'percent_failed' => $percent_failed,
                    ];
                     //-- จบ รายละเอียด
                }
          
            }

                if($sum_inout_shop_saleplan_month > 0 ){
                    $percent_success = @round(($sum_cus_result_success_month*100)/$sum_inout_shop_saleplan_month);
                    $percent_failed = @round((($sum_cus_result_failed_month+$sum_cus_result_in_process_month)*100)/$sum_inout_shop_saleplan_month);
                }else{
                    $percent_success = 0;
                    $percent_failed = 0;
                }

                $report[$i] = [
                    'month' => $i,
                    'count_shop' => $sum_count_shop_month,
                    'count_shop_noplan' => $sum_count_shop_noplan_month,
                    'count_inout_shop_saleplan' => $sum_inout_shop_saleplan_month,
                    'cus_result_failed' => $sum_cus_result_failed_month,
                    'cus_result_in_process' => $sum_cus_result_in_process_month,
                    'cus_result_success' => $sum_cus_result_success_month,
                    'count_shop_updatestatus' => $sum_count_shop_updatestatus_month,
                    'percent_success' => $percent_success,
                    'percent_failed' => $percent_failed,
                ];

                //--- ผลรวม สรุป footer
                $sum_count_shop = $sum_count_shop + $sum_count_shop_month;
                $sum_count_shop_noplan = $sum_count_shop_noplan + $sum_count_shop_noplan_month;
                $sum_inout_shop_saleplan = $sum_inout_shop_saleplan + $sum_inout_shop_saleplan_month; // รวมตามแผนและนอกแผน
                $sum_result_failed = $sum_result_failed + $sum_cus_result_failed_month;
                $sum_result_in_process = $sum_result_in_process + $sum_cus_result_in_process_month;
                $sum_result_success = $sum_result_success + $sum_cus_result_success_month;
                $sum_shop_updatestatus = $sum_shop_updatestatus + $sum_count_shop_updatestatus_month;
        }

        // dd($report);
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

       //  dd($report_detail);
        return view('reports.report_visitcustomer_goal_head', compact('report', 'summary_report', 'report_detail'));
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
      
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $user_team = DB::table('users')
        ->whereIN('status',[1,2,3])
        ->where(function($query) use ($auth_team) {
            for ($i = 0; $i < count($auth_team); $i++){
                $query->orWhere('team_id', $auth_team[$i])
                    ->orWhere('team_id', 'like', $auth_team[$i].',%')
                    ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
            }
        })
        ->get();
        

        for($i=1; $i<=12; $i++){

            $sum_count_shop_month = 0;
            $sum_count_shop_noplan_month  = 0;
            $sum_inout_shop_saleplan_month = 0; // รวมตามแผนและนอกแผน
            $sum_cus_result_failed_month = 0;
            $sum_cus_result_in_process_month =0;
            $sum_cus_result_success_month = 0;
            $sum_count_shop_updatestatus_month = 0;
            
            foreach($user_team as $team){
                $monthly_plans = DB::table('monthly_plans')
                ->whereYear('month_date', $sel_year)
                ->whereMonth('month_date', $i)
                ->where('created_by', $team->id)
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

                    //--- ผลรวม สรุปเดือน
                    $sum_count_shop_month = $sum_count_shop_month + $count_shop;
                    $sum_count_shop_noplan_month = $sum_count_shop_noplan_month + $count_shop_noplan;
                    $sum_inout_shop_saleplan_month = $sum_inout_shop_saleplan_month + $inout_shop_saleplan; // รวมตามแผนและนอกแผน               
                    $sum_cus_result_failed_month = $sum_cus_result_failed_month + $cus_result_failed;
                    $sum_cus_result_in_process_month = $sum_cus_result_in_process_month + $cus_result_in_process;
                    $sum_cus_result_success_month = $sum_cus_result_success_month + $cus_result_success;
                    $sum_count_shop_updatestatus_month = $sum_count_shop_updatestatus_month + $count_shop_updatestatus;

                    // -- รายละเอียด
                    if($inout_shop_saleplan > 0 ){
                        $percent_success = @round(($cus_result_success*100)/$inout_shop_saleplan);
                        $percent_failed = @round((($cus_result_failed+$cus_result_in_process)*100)/$inout_shop_saleplan);
                    }else{
                        $percent_success = 0;
                        $percent_failed = 0;
                    }
                    $data['report_detail'][$i][] = [
                        'saleman' => $team->name,
                        'team_id' => $team->team_id,
                        'count_shop' => $count_shop,
                        'count_shop_noplan' => $count_shop_noplan,
                        'count_inout_shop_saleplan' => $inout_shop_saleplan,
                        'cus_result_failed' => $cus_result_failed,
                        'cus_result_in_process' => $cus_result_in_process,
                        'cus_result_success' => $cus_result_success,
                        'count_shop_updatestatus' => $count_shop_updatestatus,
                        'percent_success' => $percent_success,
                        'percent_failed' => $percent_failed,
                    ];
                     //-- จบ รายละเอียด
                }
          
            }

                if($sum_inout_shop_saleplan_month > 0 ){
                    $percent_success = @round(($sum_cus_result_success_month*100)/$sum_inout_shop_saleplan_month);
                    $percent_failed = @round((($sum_cus_result_failed_month+$sum_cus_result_in_process_month)*100)/$sum_inout_shop_saleplan_month);
                }else{
                    $percent_success = 0;
                    $percent_failed = 0;
                }

                $data['report'][$i] = [
                    'month' => $i,
                    'count_shop' => $sum_count_shop_month,
                    'count_shop_noplan' => $sum_count_shop_noplan_month,
                    'count_inout_shop_saleplan' => $sum_inout_shop_saleplan_month,
                    'cus_result_failed' => $sum_cus_result_failed_month,
                    'cus_result_in_process' => $sum_cus_result_in_process_month,
                    'cus_result_success' => $sum_cus_result_success_month,
                    'count_shop_updatestatus' => $sum_count_shop_updatestatus_month,
                    'percent_success' => $percent_success,
                    'percent_failed' => $percent_failed,
                ];

                //--- ผลรวม สรุป footer
                $sum_count_shop = $sum_count_shop + $sum_count_shop_month;
                $sum_count_shop_noplan = $sum_count_shop_noplan + $sum_count_shop_noplan_month;
                $sum_inout_shop_saleplan = $sum_inout_shop_saleplan + $sum_inout_shop_saleplan_month; // รวมตามแผนและนอกแผน
                $sum_result_failed = $sum_result_failed + $sum_cus_result_failed_month;
                $sum_result_in_process = $sum_result_in_process + $sum_cus_result_in_process_month;
                $sum_result_success = $sum_result_success + $sum_cus_result_success_month;
                $sum_shop_updatestatus = $sum_shop_updatestatus + $sum_count_shop_updatestatus_month;
        }

        // dd($report);
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

       //  dd($report_detail);
        return view('reports.report_visitcustomer_goal_head', $data);
    }

}
