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

        $data['list_approval']  = DB::table('assignments')
            ->leftJoin('assignments_comments', 'assignments.id', 'assignments_comments.assign_id')
            ->leftJoin('api_customers', 'api_customers.identify', 'assignments.assign_shop')
            ->where('assignments.created_by', Auth::user()->id)
            ->where(function($query) {
                    $query->orWhere('assignments.parent_id', '!=', 'parent')
                        ->orWhere('assignments.parent_id', null);
            })
            ->whereNotIn('assignments.assign_status', [3]) // สถานะการอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน, 4=ให้แก้ไขงาน)
            ->select(
                'assignments.*', 
                'assignments_comments.assign_id', 
                'api_customers.title as customer_title', 'api_customers.name as customer_name'
            )
            ->orderBy('assignments.assign_request_date', 'desc')
            ->groupBy('assignments.id')
            ->get();

        $data['assignments'] = Assignment::join('users', 'assignments.assign_emp_id', 'users.id')
            ->where('assignments.assign_emp_id', Auth::user()->id)
            ->where('assignments.assign_status', 3)->select('assignments.*', 'users.name')
            ->orderBy('assignments.id', 'desc')
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
        ->where('monthly_plans.status_approve', 2)
        ->orderBy('month_date', 'desc')
        ->first();

        $api_token = $this->api_token->apiToken();
        $data['api_token'] = $api_token;

        // $response = Http::post(env("API_LINK").'api/auth/login', [
        //     'username' => env("API_USER"),
        //     'password' => env("API_PASS"),
        // ]);
        // $res = $response->json();
        // $api_token = $res['data'][0]['access_token'];

        // dd($api_token);

        $response = Http::withToken($api_token)
        ->get(env("API_LINK").env('API_PATH_VER').'/sellers/'.Auth::user()->api_identify.'/dashboards', [
            'year' => $year,
            'month' => $month
        ]);
        $data['res_api'] = $response->json();

        

        $response_bdates = Http::withToken($api_token)
        ->get(env("API_LINK").env('API_PATH_VER').'/bdates/sellers/'.Auth::user()->api_identify.'/customers');
        $data['res_bdates_api'] = $response_bdates->json();

        

        $data['count_sale_plans_result'] = 0;      // -- นับจำนวน slaeplans
        $data['count_shops_saleplan_result'] = 0;  // -- นับจำนวน ลูกค้าใหม่
        $data['count_isit_results_result'] = 0;    // -- นับจำนวน ลูกค้าเยี่ยม
        $data['count_sale_plans_amount'] = 0;
        $data['count_shops_saleplan_amount'] = 0;
        $data['count_isit_amount']  =0 ;

        // dd($data['monthly_plan']);

        if(!is_null($data['monthly_plan'])){ // ตรวจสอบไม่เป็นค่าว่าง
            // -- นับจำนวน slaeplans
            $sale_plans = DB::table('sale_plans')->where('monthly_plan_id', $data['monthly_plan']->id)->where('sale_plans_status', 2)->get();

            if(!is_null($sale_plans)){
                $data['count_sale_plans_amount'] = $sale_plans->count();
                foreach($sale_plans as $sp_value){
                    $check_result = DB::table('sale_plan_results')->where('sale_plan_id', $sp_value->id)->first();
                    if(!is_null($check_result)){
                        $data['count_sale_plans_result'] = $data['count_sale_plans_result'] + 1;
                    }
                }
            }

            // -- นับจำนวน ลูกค้าใหม่
            $customer_shops_saleplan = DB::table('customer_shops_saleplan')->where('monthly_plan_id', $data['monthly_plan']->id)->get();

            if(!is_null($customer_shops_saleplan)){
                $data['count_shops_saleplan_amount'] = $customer_shops_saleplan->count();
                foreach($customer_shops_saleplan as $sp_value){
                    $check_result = DB::table('customer_shops_saleplan_result')->where('customer_shops_saleplan_id', $sp_value->id)->first();
                    if(!is_null($check_result)){
                        $data['count_shops_saleplan_result'] = $data['count_shops_saleplan_result'] + 1;
                    }
                }
            }

            // -- นับจำนวน ลูกค้าเยี่ยม
            $customer_visits = DB::table('customer_visits')->where('monthly_plan_id', $data['monthly_plan']->id)->get();
            // dd($customer_visits);
            if(!is_null($customer_visits)){
                $data['count_isit_amount'] = $customer_visits->count();
                foreach($customer_visits as $sp_value){
                    $check_result = DB::table('customer_visit_results')->where('customer_visit_id', $sp_value->id)->first();
                    if(!is_null($check_result)){
                        $data['count_isit_results_result'] = $data['count_isit_results_result'] + 1;
                    }
                }
            }
        }

        // -- Chat
        $dayinmonth = date("t");
        $data['day_month'] = "";
        $data['amtsale_current'] = "";
        $data['amtsale_previous'] = "";
        $noc=0;
        $nop=0;

        for($i=1; $i <= $dayinmonth; $i++){
            if($i < $dayinmonth){
                $data['day_month'] .= $i.",";
            }else{
                $data['day_month'] .= $i;
            }

            if(isset($data['res_api']['data'][4]['DaysSalesCurrent'][$noc]['DayNo'])){ // ปีปัจจุบัน

                if($data['res_api']['data'][4]['DaysSalesCurrent'][$noc]['DayNo'] == $i){
                    // $data['amtsale_current'] .= $data['res_api']['data'][4]['DaysSalesCurrent'][$noc]['totalAmtSale'].",";
                    $data['amtsale_current'] .= $data['res_api']['data'][4]['DaysSalesCurrent'][$noc]['sales'].",";
                }else{
                    $noc--;
                    if($i < $dayinmonth){
                        $data['amtsale_current'] .= "0,";
                    }else{
                        $data['amtsale_current'] .= "0";
                    }
                }

            }else{
                if($i < $dayinmonth){
                    $data['amtsale_current'] .= "0,";
                }else{
                    $data['amtsale_current'] .= "0";
                }
            }

            if(isset($data['res_api']['data'][5]['DaysSalesPrevious'][$nop]['DayNo'])){ // ปีที่แล้ว

                if($data['res_api']['data'][5]['DaysSalesPrevious'][$nop]['DayNo'] == $i){
                    // $data['amtsale_previous'] .= $data['res_api']['data'][5]['DaysSalesPrevious'][$nop]['totalAmtSale'].",";
                    $data['amtsale_previous'] .= $data['res_api']['data'][5]['DaysSalesPrevious'][$nop]['sales'].",";
                }else{
                    $nop--;
                    if($i < $dayinmonth){
                        $data['amtsale_previous'] .= "0,";
                    }else{
                        $data['amtsale_previous'] .= "0";
                    }
                }

            }else{
                if($i < $dayinmonth){
                    $data['amtsale_previous'] .= "0,";
                }else{
                    $data['amtsale_previous'] .= "0";
                }
            }

            $noc++;
            $nop++;
            // -- จบ Chat
        }

        // dd($data['res_api']['data'][5]['DaysSalesPrevious'], $data['amtsale_previous'], $data['day_month']);

        return view('saleman.dashboard', $data);
    }
}
