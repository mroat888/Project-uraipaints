<?php

namespace App\Http\Controllers\SaleMan;

use App\Assignment;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MonthlyPlan;
use App\Note;
use App\RequestApproval;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiController;

class DashboardController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){
        //ตรวจสอบเดือนของแผนงานประจำเดือน

        // $data['list_approval'] = RequestApproval::where('created_by', Auth::user()->id)->whereMonth('assign_request_date', Carbon::now()->format('m'))->get();
        $data['list_approval'] = DB::table('assignments')
            ->where('created_by', Auth::user()->id)
            ->whereMonth('assign_request_date', Carbon::now()->format('m'))
            ->whereIn('assign_status', [0,1,2])
            ->get();

        // $data['assignments'] = Assignment::where('assign_emp_id', Auth::user()->id)->whereMonth('assign_work_date', Carbon::now()->format('m'))->get();
        $data['assignments'] = DB::table('assignments')
            ->where('assign_emp_id', Auth::user()->id)
            ->whereMonth('assign_work_date', Carbon::now()->format('m'))
            ->where('assign_status', 3)
            ->get();

        $data['notes'] = Note::where('employee_id', Auth::user()->id)->whereMonth('note_date', Carbon::now()->format('m'))->get();

        $data['customer_shop'] = Customer::where('created_by', Auth::user()->id)->where('shop_status', 0)->whereMonth('created_at', Carbon::now()->format('m'))->get();


        // -- ตรวจสอบเพิ่ม sale plan เดือนปัจจุบัน
            list($year,$month,$day) = explode("-",date("Y-m-d"));
            $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)
            ->whereYear('month_date', $year)
            ->whereMonth('month_date', $month)
            ->orderBy('month_date', 'desc')
            ->first();

            // -- ถ้า monthly_plan ไม่มีเดือนปัจจุบัน ให้สร้างขึ้นมาใหม่
            if(is_null($data['monthly_plan'])){
                DB::table('monthly_plans')
                ->insert([
                    'month_date' => date("Y-m-d"),
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
            }
        // -- จบ  ตรวจสอบเพิ่ม sale plan เดือนปัจจุบัน

        //-- ตรวจสอบและเพิ่มเดือน monthly_plan 
        $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();
        if ($monthly_plan) {
            $date = Carbon::parse($monthly_plan->month_date)->format('Y-m');
            $dateNow = Carbon::today()->addMonth(1)->format('Y-m');
            if ($date != $dateNow) {
                $plans = new MonthlyPlan;
                $plans->month_date     = Carbon::now()->addMonth(1);
                $plans->created_by     = Auth::user()->id;
                $plans->created_at     = Carbon::now();
                $plans->save();
            }
        }else{
            $plans = new MonthlyPlan;
            $plans->month_date      = Carbon::now()->addMonth(1);
            $plans->created_by      = Auth::user()->id;
            $plans->created_at      = Carbon::now();
            $plans->save();
        }
        // --- จบ

        list($year,$month,$day) = explode("-",date("Y-m-d"));
        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)
        ->whereYear('month_date', $year)
        ->whereMonth('month_date', $month)
        ->orderBy('month_date', 'desc')
        ->first();

        $api_token = $this->api_token->apiToken();
        $data['api_token'] = $api_token;
        $response = Http::withToken($api_token)
        ->get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/dashboards', [
            'year' => $year,
            'month' => $month
        ]);
        $data['res_api'] = $response->json();

        $response = Http::withToken($api_token)
        ->get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/dashboards', [
            'year' => $year-1,
            'month' => $month
        ]);
        $data['res_api_previous'] = $response->json();

        // -- นับจำนวน slaeplans
        $data['count_sale_plans_result'] = 0;
        $sale_plans = DB::table('sale_plans')->where('monthly_plan_id', $data['monthly_plan']->id)->get();

        foreach($sale_plans as $sp_value){
            $check_result = DB::table('sale_plan_results')->where('sale_plan_id', $sp_value->id)->first();
            if(!is_null($check_result)){
                $data['count_sale_plans_result'] = $data['count_sale_plans_result'] + 1;
            }
        }

        // -- นับจำนวน ลูกค้าใหม่
        $data['count_shops_saleplan_result'] = 0;
        $customer_shops_saleplan = DB::table('customer_shops_saleplan')->where('monthly_plan_id', $data['monthly_plan']->id)->get();
        foreach($customer_shops_saleplan as $sp_value){
            $check_result = DB::table('customer_shops_saleplan_result')->where('customer_shops_saleplan_id', $sp_value->id)->first();
            if(!is_null($check_result)){
                $data['count_shops_saleplan_result'] = $data['count_shops_saleplan_result'] + 1;
            }
        }

        // -- นับจำนวน ลูกค้าเยี่ยม
        $data['count_isit_results_result'] = 0;
        $customer_visits = DB::table('customer_visits')->where('monthly_plan_id', $data['monthly_plan']->id)->get();
        foreach($customer_visits as $sp_value){
            $check_result = DB::table('customer_visit_results')->where('customer_visit_id', $sp_value->id)->first();
            if(!is_null($check_result)){
                $data['count_isit_results_result'] = $data['count_isit_results_result'] + 1;
            }
        }


        // dd($data);

        return view('saleman.dashboard', $data);
    }
}
