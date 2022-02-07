<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportVisitCustomerController extends Controller
{
    public function index(){

        $report = array();
        for($i=1; $i<=12; $i++){

            $monthly_plans = DB::table('monthly_plans')
            ->whereYear('month_date', date('Y-m-d'))
            ->whereMonth('month_date', $i)
            ->where('created_by', Auth::user()->id)
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

                $sum_visit = $cus_is_plan + $cus_isnot_plan; // จำนวนการเข้าพบทั้งหมด
                if($sum_visit > 0 ){
                    $percent_success = @round(($cus_visit_success*100)/$sum_visit);
                    $percent_failed = @round(($cus_visit_failed*100)/$sum_visit);
                }else{
                    $percent_success = 0;
                    $percent_failed = 0;
                }

            }else{
                $cus_is_plan = "-";
                $cus_isnot_plan = "-";
                $cus_visit_in_process = "-";
                $cus_visit_success = "-";
                $cus_visit_failed = "-";
                $percent_success = "-";
                $percent_failed = "-";

                $sum_cus_is_plan = "-";
            }

            $report[$i] = [
                'month' => $i, 
                'cus_is_plan' => $cus_is_plan,
                'cus_isnot_plan' => $cus_isnot_plan,
                'cus_visit_in_process' => $cus_visit_in_process,
                'cus_visit_success' => $cus_visit_success,
                'cus_visit_failed' => $cus_visit_failed,
                'percent_success' => $percent_success,
                'percent_failed' => $percent_failed,
            ];

        }

        $data['report'] = $report;
    
        // dd($report);
        return view('reports.report_visitcustomer', compact('report'));
    }
}
