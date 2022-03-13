<?php

namespace App\Http\Controllers\HeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportVisitCustomerController extends Controller
{
    public function index(){

        // $user_team = DB::table('users')
        // ->whereIn('status',[1,2,3])
        // ->where('team_id', Auth::user()->team_id)
        // ->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $user_team = DB::table('users')
        ->whereIn('status',[1,2,3])
        ->where(function($query) use ($auth_team) {
            for ($i = 0; $i < count($auth_team); $i++){
                $query->orWhere('team_id', $auth_team[$i])
                    ->orWhere('team_id', 'like', $auth_team[$i].',%')
                    ->orWhere('team_id', 'like', '%,'.$auth_team[$i]);
            }
        })
        ->get();

        $report = array();
        $summary_report = array();

        $sum_cus_is_plan = 0;
        $sum_cus_isnot_plan = 0;
        $sum_cus_visit_in_process = 0 ; 
        $sum_cus_visit_success = 0;
        $sum_cus_visit_failed = 0;
        $sum_visit = 0;

        for($i=1; $i<=12; $i++){

            $sum_cus_is_plan_month = 0;
            $sum_cus_isnot_plan_month = 0;
            $sum_cus_visit_in_process_month = 0 ; 
            $sum_cus_visit_success_month = 0;
            $sum_cus_visit_failed_month = 0;
            $sum_visit_month = 0;

            foreach($user_team as $team){
                $monthly_plans = DB::table('monthly_plans')
                ->whereYear('month_date', date('Y-m-d'))
                ->whereMonth('month_date', $i)
                ->where('created_by', $team->id)
                ->first();

                if(!is_null($monthly_plans)){

                    $cus_is_plan = DB::table('customer_visits')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('is_monthly_plan', 'Y')
                    ->count();

                    $cus_isnot_plan = DB::table('customer_visits')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->where('is_monthly_plan', 'N')
                    ->count();

                    // --
                    $customer_visits = DB::table('customer_visits')
                    ->where('monthly_plan_id', $monthly_plans->id)
                    ->get();

                    $cus_visit_success = 0;
                    $cus_visit_failed = 0;
                    $cus_visit_in_process = 0;

                    foreach($customer_visits as $value){
                        $customer_visit_results = DB::table('customer_visit_results')
                        ->where('customer_visit_id', $value->id)
                        ->first();
                        if(!is_null($customer_visit_results)){
                            if($customer_visit_results->cust_visit_status == 1){
                                $cus_visit_success++;
                            }else if($customer_visit_results->cust_visit_status == 2){
                                $cus_visit_failed++;
                            }
                        }
                    }
                    
                    $cus_visit_in_process = ($cus_is_plan + $cus_isnot_plan) - ($cus_visit_success + $cus_visit_failed);

                    //--- ผลรวม สรุปเดือน
                    $sum_cus_is_plan_month = $sum_cus_is_plan_month + $cus_is_plan;
                    $sum_cus_isnot_plan_month = $sum_cus_isnot_plan_month + $cus_isnot_plan;
                    $sum_cus_visit_in_process_month = $sum_cus_visit_in_process_month + $cus_visit_in_process; 
                    $sum_cus_visit_success_month = $sum_cus_visit_success_month + $cus_visit_success;
                    $sum_cus_visit_failed_month = $sum_cus_visit_failed_month + $cus_visit_failed;
    
                    $sum_visit_month = $sum_cus_is_plan_month + $sum_cus_isnot_plan_month; // จำนวนการเข้าพบทั้งหมด

                    //-- รายละเอียด
                    $sum_visit = $cus_is_plan + $cus_isnot_plan;
                    if($sum_visit > 0 ){
                        $percent_success = @round(($cus_visit_success*100)/$sum_visit);
                        $percent_failed = @round(($cus_visit_failed*100)/$sum_visit);
                    }else{
                        $percent_success = 0;
                        $percent_failed = 0;
                    }

                    $report_detail[$i][] = [
                        'saleman' => $team->name,
                        'team_id' => $team->team_id,
                        'cus_is_plan' => $cus_is_plan,
                        'cus_isnot_plan' => $cus_isnot_plan,
                        'cus_visit_in_process' => $cus_visit_in_process,
                        'cus_visit_success' => $cus_visit_success,
                        'cus_visit_failed' => $cus_visit_failed,
                        'percent_success' => $percent_success,
                        'percent_failed' => $percent_failed,
                    ];
                    //-- จบ รายละเอียด
                    
                }

            }

            if($sum_visit_month > 0 ){
                $percent_success = @round(($sum_cus_visit_success_month*100)/$sum_visit_month);
                $percent_failed = @round(($sum_cus_visit_failed_month*100)/$sum_visit_month);
            }else{
                $percent_success = 0;
                $percent_failed = 0;
            }

            $report[$i] = [
                'month' => $i, 
                'cus_is_plan' => $sum_cus_is_plan_month,
                'cus_isnot_plan' => $sum_cus_isnot_plan_month,
                'cus_visit_in_process' => $sum_cus_visit_in_process_month,
                'cus_visit_success' => $sum_cus_visit_success_month,
                'cus_visit_failed' => $sum_cus_visit_failed_month,
                'percent_success' => $percent_success,
                'percent_failed' => $percent_failed,
            ];

            //--- ผลรวม สรุป footer
            $sum_cus_is_plan = $sum_cus_is_plan + $sum_cus_is_plan_month;
            $sum_cus_isnot_plan = $sum_cus_isnot_plan + $sum_cus_isnot_plan_month;
            $sum_cus_visit_in_process = $sum_cus_visit_in_process + $sum_cus_visit_in_process_month ; 
            $sum_cus_visit_success = $sum_cus_visit_success + $sum_cus_visit_success_month;
            $sum_cus_visit_failed = $sum_cus_visit_failed + $sum_cus_visit_failed_month;
            $sum_visit = $sum_visit + $sum_visit_month;

        }
        
        if($sum_visit > 0 ){
            $sum_percent_success = @round(($sum_cus_visit_success*100)/$sum_visit);
            $sum_percent_failed = @round(($sum_cus_visit_failed*100)/$sum_visit);
        }else{
            $sum_percent_success = 0;
            $sum_percent_failed = 0;
        }

        $summary_report = [
            'sum_cus_is_plan' => $sum_cus_is_plan,
            'sum_cus_isnot_plan' => $sum_cus_isnot_plan,
            'sum_cus_visit_in_process' => $sum_cus_visit_in_process,
            'sum_cus_visit_success' => $sum_cus_visit_success,
            'sum_cus_visit_failed' => $sum_cus_visit_failed,
            'sum_percent_success' => $sum_percent_success,
            'sum_percent_failed' => $sum_percent_failed,
        ];

        // dd($report_detail);

        return view('reports.report_visitcustomer_head', compact('report', 'summary_report', 'report_detail'));
    }
}
