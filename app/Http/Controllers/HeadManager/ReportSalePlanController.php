<?php

namespace App\Http\Controllers\HeadManager;

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

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        $users_saleman = DB::table('users')
            ->whereIn('status', [1,2,3])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
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
                    
                    // -- รายละเอียด
                    if($count_saleplan > 0 ){
                        $percent_success = @round(($saleplan_result_success*100)/$count_saleplan);
                        $percent_failed = @round((($saleplan_result_failed+$saleplan_result_in_process)*100)/$count_saleplan);
                    }else{
                        $percent_success = 0;
                        $percent_failed = 0;
                    }
                    $report_detail[$i][] = [
                        'saleman' => $saleman->name,
                        'team_id' => $saleman->team_id,
                        'count_saleplan' => $count_saleplan,
                        'count_saleplan_updatestatus' => $count_saleplan_updatestatus,
                        'saleplan_result_in_process' => $saleplan_result_in_process,
                        'saleplan_result_failed' => $saleplan_result_failed,
                        'saleplan_result_success' => $saleplan_result_success,
                        'percent_success' => $percent_success,
                        'percent_failed' => $percent_failed
                    ];
                    //-- จบ รายละเอียด

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

        return view('reports.report_saleplan_head', compact('report', 'summary_report', 'report_detail'));
    }

    public function search(Request $request){
        
        $data['sel_year'] = $request->sel_year;
        $sel_year = $data['sel_year']."-01-01";
  
        $report = array();
        $summary_report = array();

        $sum_count_saleplan = 0;
        $sum_result_failed = 0;
        $sum_result_in_process = 0;
        $sum_result_success = 0;
        $sum_saleplan_updatestatus = 0;

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $users_saleman = DB::table('users')
            ->whereIn('status', [1,2,3])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        for($i=1; $i<=12; $i++){

            $count_saleplan_month = 0;
            $saleplan_result_failed_month = 0;
            $saleplan_result_in_process_month = 0;
            $saleplan_result_success_month = 0;
            $count_saleplan_updatestatusmonth = 0;

            foreach($users_saleman as $saleman){
                $monthly_plans = DB::table('monthly_plans')
                ->whereYear('month_date', $sel_year)
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

                    
                    // -- รายละเอียด
                    if($count_saleplan > 0 ){
                        $percent_success = @round(($saleplan_result_success*100)/$count_saleplan);
                        $percent_failed = @round((($saleplan_result_failed+$saleplan_result_in_process)*100)/$count_saleplan);
                        
                    }else{
                        $percent_success = 0;
                        $percent_failed = 0;
                    }
                
                    $data['report_detail'][$i][] = [
                        'saleman' => $saleman->name,
                        'team_id' => $saleman->team_id,
                        'count_saleplan' => $count_saleplan,
                        'count_saleplan_updatestatus' => $count_saleplan_updatestatus,
                        'saleplan_result_in_process' => $saleplan_result_in_process,
                        'saleplan_result_failed' => $saleplan_result_failed,
                        'saleplan_result_success' => $saleplan_result_success,
                        'percent_success' => $percent_success,
                        'percent_failed' => $percent_failed
                    ];
                    //-- จบ รายละเอียด
                
                }
            }

                if($count_saleplan_month > 0 ){
                    $percent_success = @round(($saleplan_result_success_month*100)/$count_saleplan_month);
                    $percent_failed = @round((($saleplan_result_failed_month+$saleplan_result_in_process_month)*100)/$count_saleplan_month);
                }else{
                    $percent_success = 0;
                    $percent_failed = 0;
                }
                $data['report'][$i] = [
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

        $data['summary_report'] = [
            'sum_count_saleplan' => $sum_count_saleplan,
            'sum_result_failed' => $sum_result_failed,
            'sum_result_in_process' => $sum_result_in_process,
            'sum_result_success' => $sum_result_success,
            'sum_shop_updatestatus' => $sum_shop_updatestatus,
            'sum_percent_success' => $percent_success,
            'sum_percent_failed' => $percent_failed,
        ];

        // dd($report_detail);
        return view('reports.report_saleplan_head', $data);
    }


    public function reportsalepaln(){
        list($year,$month,$day) = explode("-",date("Y-m-d"));

        $data['search_year'] = $year;
        $data['search_month'] = $month;
        
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['users_saleman'] = DB::table('users')
            ->whereIn('status', [1]) //-- เฉพาะ sale
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        $data['monthly_plans_status'] = array();
        $data['monthly_plans_total'] = array();
        $data['monthly_plans_success'] = array();
        $data['monthly_plans_balance'] = array();
        $data['monthly_plans_present'] = array();

        $data['count_saleplan'] = array();
        $data['count_sale_success'] = array();
        $data['count_customer_new'] = array();
        $data['count_customer_new_success'] = array();
        $data['count_customer_visits'] = array();
        $data['count_customer_visits_success'] = array();

        $sum_monthly_plans_total = 0;
        $sum_monthly_plans_success = 0;
        $sum_monthly_plans_balance = 0;
        $sum_count_saleplan = 0;
        $sum_count_sale_success = 0;
        $sum_count_customer_new = 0;
        $sum_count_customer_new_success = 0;
        $sum_count_customer_visits = 0;
        $sum_count_customer_visits_success = 0;

        foreach($data['users_saleman'] as $key_saleman => $saleman){
            $monthly_plans = DB::table('monthly_plans')
                ->whereYear('month_date', $year)
                ->whereMonth('month_date', $month)
                ->where('created_by', $saleman->id)
                ->first();

            $data['count_saleplan'][$key_saleman] = 0;
            $data['count_sale_success'][$key_saleman] = 0;
            $data['count_customer_new'][$key_saleman] = 0;
            $data['count_customer_new_success'][$key_saleman] = 0;
            $data['count_customer_visits'][$key_saleman] = 0;
            $data['count_customer_visits_success'][$key_saleman] = 0;
            
            if(!empty($monthly_plans)){

                // -- Sale plan
                $sale_plans = DB::table('sale_plans')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('sale_plans_status', 2) //อนุมัติแล้ว สถานะอนุมัติ (0=ฉบับร่าง ,1 = ส่งอนุมัติ , 2 = อนุมัติ , 3= ปฎิเสธ))
                    ->get();

                $data['count_saleplan'][$key_saleman] = $sale_plans->count();
                $data['count_sale_success'][$key_saleman] = 0;

                if(!empty($sale_plans)){
                    foreach($sale_plans as $key => $value){
                        $count_sale= DB::table('sale_plan_results')
                            ->where('sale_plan_id', $value->id)
                            ->whereNotNull('sale_plan_checkin_date')
                            ->whereNotNull('sale_plan_checkout_date')
                            ->count();
                        $data['count_sale_success'][$key_saleman] += $count_sale;
                    }
                }
                // -- จบ Sale plan

                // -- ลูกค้าใหม่
                $customer_shops_saleplan = DB::table('customer_shops_saleplan')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('shop_aprove_status', 2) //อนุมัติแล้ว สถานะอนุมัติ (0=ฉบับร่าง ,1 = ส่งอนุมัติ , 2 = อนุมัติ , 3= ปฎิเสธ))
                    ->get();

                $data['count_customer_new'][$key_saleman] = $customer_shops_saleplan->count();
                $data['count_customer_new_success'][$key_saleman] = 0;

                if(!empty($customer_shops_saleplan)){
                    foreach($customer_shops_saleplan as $key => $value){
                        $count_customer_new= DB::table('customer_shops_saleplan_result')
                            ->where('customer_shops_saleplan_id', $value->id)
                            ->whereNotNull('cust_result_checkin_date')
                            ->whereNotNull('cust_result_checkout_date')
                            ->count();
                        $data['count_customer_new_success'][$key_saleman] += $count_customer_new;
                    }
                }
                // -- จบ ลูกค้าใหม่

                // -- ลูกค้าเยี่ยม           
                $customer_visits = DB::table('customer_visits')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->get();

                $data['count_customer_visits'][$key_saleman] = $customer_visits->count();
                $data['count_customer_visits_success'][$key_saleman] = 0;

                if(!empty($customer_visits)){
                    foreach($customer_visits as $key => $value){
                        $count_customer_new= DB::table('customer_visit_results')
                            ->where('customer_visit_id', $value->id)
                            ->whereNotNull('cust_visit_checkin_date')
                            ->whereNotNull('cust_visit_checkout_date')
                            ->count();
                        $data['count_customer_visits_success'][$key_saleman] += $count_customer_new;
                    }
                }
                // -- จบ ลูกค้าเยี่ยม

                //-- monthly_plans
                $data['monthly_plans_status'][$key_saleman] = $monthly_plans->status_approve;
                $data['monthly_plans_total'][$key_saleman] = $data['count_saleplan'][$key_saleman] + 
                                                                $data['count_customer_new'][$key_saleman] + 
                                                                $data['count_customer_visits'][$key_saleman];
                $data['monthly_plans_success'][$key_saleman] = $data['count_sale_success'][$key_saleman] +
                                                                $data['count_customer_new_success'][$key_saleman] + 
                                                                $data['count_customer_visits_success'][$key_saleman];
                $data['monthly_plans_balance'][$key_saleman] = $data['monthly_plans_total'][$key_saleman] - $data['monthly_plans_success'][$key_saleman];
                
                if($data['monthly_plans_success'][$key_saleman] != 0 && $data['monthly_plans_total'][$key_saleman] != 0){
                    $data['monthly_plans_present'][$key_saleman] = ($data['monthly_plans_success'][$key_saleman]*100)/$data['monthly_plans_total'][$key_saleman];
                }else{
                    $data['monthly_plans_present'][$key_saleman] = 0;
                }
                
                //-- จบ monthly_plans
            }else{
                $data['monthly_plans_status'][$key_saleman] = "";
                $data['monthly_plans_total'][$key_saleman] = 0;
                $data['monthly_plans_success'][$key_saleman] = 0;
                $data['monthly_plans_balance'][$key_saleman] = 0;
                $data['monthly_plans_present'][$key_saleman] = 0;
            }

            $sum_monthly_plans_total += $data['monthly_plans_total'][$key_saleman];
            $sum_monthly_plans_success += $data['monthly_plans_success'][$key_saleman];
            $sum_monthly_plans_balance += $data['monthly_plans_balance'][$key_saleman];
            $sum_count_saleplan += $data['count_saleplan'][$key_saleman];
            $sum_count_sale_success += $data['count_sale_success'][$key_saleman];
            $sum_count_customer_new += $data['count_customer_new'][$key_saleman];
            $sum_count_customer_new_success += $data['count_customer_new_success'][$key_saleman];
            $sum_count_customer_visits += $data['count_customer_visits'][$key_saleman];
            $sum_count_customer_visits_success += $data['count_customer_visits_success'][$key_saleman];
        }

        if($sum_monthly_plans_success != 0 && $sum_monthly_plans_total != 0){
            $sum_monthly_plans_present = ($sum_monthly_plans_success*100)/$sum_monthly_plans_total;
        }else{
            $sum_monthly_plans_present = 0;
        }

        $data['summary'] = [
            'sum_monthly_plans_total' => $sum_monthly_plans_total,
            'sum_monthly_plans_success' => $sum_monthly_plans_success,
            'sum_monthly_plans_balance' => $sum_monthly_plans_balance,
            'sum_monthly_plans_present' => $sum_monthly_plans_present,
            'sum_count_saleplan' => $sum_count_saleplan,
            'sum_count_sale_success' => $sum_count_sale_success,
            'sum_count_customer_new' => $sum_count_customer_new,
            'sum_count_customer_new_success' => $sum_count_customer_new_success,
            'sum_count_customer_visits' => $sum_count_customer_visits,
            'sum_count_customer_visits_success' => $sum_count_customer_visits_success,
        ];

        // dd($data['summary']);
        return view('reports.report_saleplan_head', $data);
    }

    public function reportsalepaln_search(Request $request){
        // dd($request);
        list($year,$month,$day) = explode("-",date("Y-m-d"));
        $month = $request->sel_month;

        $data['search_year'] = $year;
        $data['search_month'] = $month;
        
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['users_saleman'] = DB::table('users')
            ->whereIn('status', [1]) //-- เฉพาะ sale
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('team_id', $auth_team[$i])
                        ->orWhere('team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        $data['monthly_plans_status'] = array();
        $data['monthly_plans_total'] = array();
        $data['monthly_plans_success'] = array();
        $data['monthly_plans_balance'] = array();
        $data['monthly_plans_present'] = array();

        $data['count_saleplan'] = array();
        $data['count_sale_success'] = array();
        $data['count_customer_new'] = array();
        $data['count_customer_new_success'] = array();
        $data['count_customer_visits'] = array();
        $data['count_customer_visits_success'] = array();

        $sum_monthly_plans_total = 0;
        $sum_monthly_plans_success = 0;
        $sum_monthly_plans_balance = 0;
        $sum_count_saleplan = 0;
        $sum_count_sale_success = 0;
        $sum_count_customer_new = 0;
        $sum_count_customer_new_success = 0;
        $sum_count_customer_visits = 0;
        $sum_count_customer_visits_success = 0;

        foreach($data['users_saleman'] as $key_saleman => $saleman){
            $monthly_plans = DB::table('monthly_plans')
                ->whereYear('month_date', $year)
                ->whereMonth('month_date', $month)
                ->where('created_by', $saleman->id)
                ->first();

            $data['count_saleplan'][$key_saleman] = 0;
            $data['count_sale_success'][$key_saleman] = 0;
            $data['count_customer_new'][$key_saleman] = 0;
            $data['count_customer_new_success'][$key_saleman] = 0;
            $data['count_customer_visits'][$key_saleman] = 0;
            $data['count_customer_visits_success'][$key_saleman] = 0;
            
            if(!empty($monthly_plans)){

                // -- Sale plan
                $sale_plans = DB::table('sale_plans')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('sale_plans_status', 2) //อนุมัติแล้ว สถานะอนุมัติ (0=ฉบับร่าง ,1 = ส่งอนุมัติ , 2 = อนุมัติ , 3= ปฎิเสธ))
                    ->get();

                $data['count_saleplan'][$key_saleman] = $sale_plans->count();
                $data['count_sale_success'][$key_saleman] = 0;

                if(!empty($sale_plans)){
                    foreach($sale_plans as $key => $value){
                        $count_sale= DB::table('sale_plan_results')
                            ->where('sale_plan_id', $value->id)
                            ->whereNotNull('sale_plan_checkin_date')
                            ->whereNotNull('sale_plan_checkout_date')
                            ->count();
                        $data['count_sale_success'][$key_saleman] += $count_sale;
                    }
                }
                // -- จบ Sale plan

                // -- ลูกค้าใหม่
                $customer_shops_saleplan = DB::table('customer_shops_saleplan')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('shop_aprove_status', 2) //อนุมัติแล้ว สถานะอนุมัติ (0=ฉบับร่าง ,1 = ส่งอนุมัติ , 2 = อนุมัติ , 3= ปฎิเสธ))
                    ->get();

                $data['count_customer_new'][$key_saleman] = $customer_shops_saleplan->count();
                $data['count_customer_new_success'][$key_saleman] = 0;

                if(!empty($customer_shops_saleplan)){
                    foreach($customer_shops_saleplan as $key => $value){
                        $count_customer_new= DB::table('customer_shops_saleplan_result')
                            ->where('customer_shops_saleplan_id', $value->id)
                            ->whereNotNull('cust_result_checkin_date')
                            ->whereNotNull('cust_result_checkout_date')
                            ->count();
                        $data['count_customer_new_success'][$key_saleman] += $count_customer_new;
                    }
                }
                // -- จบ ลูกค้าใหม่

                // -- ลูกค้าเยี่ยม           
                $customer_visits = DB::table('customer_visits')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->get();

                $data['count_customer_visits'][$key_saleman] = $customer_visits->count();
                $data['count_customer_visits_success'][$key_saleman] = 0;

                if(!empty($customer_visits)){
                    foreach($customer_visits as $key => $value){
                        $count_customer_new= DB::table('customer_visit_results')
                            ->where('customer_visit_id', $value->id)
                            ->whereNotNull('cust_visit_checkin_date')
                            ->whereNotNull('cust_visit_checkout_date')
                            ->count();
                        $data['count_customer_visits_success'][$key_saleman] += $count_customer_new;
                    }
                }
                // -- จบ ลูกค้าเยี่ยม

                //-- monthly_plans
                $data['monthly_plans_status'][$key_saleman] = $monthly_plans->status_approve;
                $data['monthly_plans_total'][$key_saleman] = $data['count_saleplan'][$key_saleman] + 
                                                                $data['count_customer_new'][$key_saleman] + 
                                                                $data['count_customer_visits'][$key_saleman];
                $data['monthly_plans_success'][$key_saleman] = $data['count_sale_success'][$key_saleman] +
                                                                $data['count_customer_new_success'][$key_saleman] + 
                                                                $data['count_customer_visits_success'][$key_saleman];
                $data['monthly_plans_balance'][$key_saleman] = $data['monthly_plans_total'][$key_saleman] - $data['monthly_plans_success'][$key_saleman];
                
                if($data['monthly_plans_success'][$key_saleman] != 0 && $data['monthly_plans_total'][$key_saleman] != 0){
                    $data['monthly_plans_present'][$key_saleman] = ($data['monthly_plans_success'][$key_saleman]*100)/$data['monthly_plans_total'][$key_saleman];
                }else{
                    $data['monthly_plans_present'][$key_saleman] = 0;
                }
                
                //-- จบ monthly_plans
            }else{
                $data['monthly_plans_status'][$key_saleman] = "";
                $data['monthly_plans_total'][$key_saleman] = 0;
                $data['monthly_plans_success'][$key_saleman] = 0;
                $data['monthly_plans_balance'][$key_saleman] = 0;
                $data['monthly_plans_present'][$key_saleman] = 0;
            }

            $sum_monthly_plans_total += $data['monthly_plans_total'][$key_saleman];
            $sum_monthly_plans_success += $data['monthly_plans_success'][$key_saleman];
            $sum_monthly_plans_balance += $data['monthly_plans_balance'][$key_saleman];
            $sum_count_saleplan += $data['count_saleplan'][$key_saleman];
            $sum_count_sale_success += $data['count_sale_success'][$key_saleman];
            $sum_count_customer_new += $data['count_customer_new'][$key_saleman];
            $sum_count_customer_new_success += $data['count_customer_new_success'][$key_saleman];
            $sum_count_customer_visits += $data['count_customer_visits'][$key_saleman];
            $sum_count_customer_visits_success += $data['count_customer_visits_success'][$key_saleman];
        }

        if($sum_monthly_plans_success != 0 && $sum_monthly_plans_total != 0){
            $sum_monthly_plans_present = ($sum_monthly_plans_success*100)/$sum_monthly_plans_total;
        }else{
            $sum_monthly_plans_present = 0;
        }

        $data['summary'] = [
            'sum_monthly_plans_total' => $sum_monthly_plans_total,
            'sum_monthly_plans_success' => $sum_monthly_plans_success,
            'sum_monthly_plans_balance' => $sum_monthly_plans_balance,
            'sum_monthly_plans_present' => $sum_monthly_plans_present,
            'sum_count_saleplan' => $sum_count_saleplan,
            'sum_count_sale_success' => $sum_count_sale_success,
            'sum_count_customer_new' => $sum_count_customer_new,
            'sum_count_customer_new_success' => $sum_count_customer_new_success,
            'sum_count_customer_visits' => $sum_count_customer_visits,
            'sum_count_customer_visits_success' => $sum_count_customer_visits_success,
        ];

        // dd($data['summary']);
        return view('reports.report_saleplan_head', $data);
    }


}
