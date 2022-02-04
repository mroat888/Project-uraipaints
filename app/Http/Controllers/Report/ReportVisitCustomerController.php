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

                foreach($customer_visits as $value){
                    $customer_visit_results = DB::table('customer_visit_results')
                    ->where('customer_visit_id', $value->id)
                    ->first();
                }
                // --

            }else{
                $cus_is_plan = "-";
                $cus_isnot_plan = "-";
            }

            $report[$i] = [
                'month' => $i, 
                'cus_is_plan' => $cus_is_plan,
                'cus_isnot_plan' => $cus_isnot_plan,
            ];

        }

        $data['report'] = $report;
        
        // dd($report);
        return view('reports.report_visitcustomer', compact('report'));
    }
}
