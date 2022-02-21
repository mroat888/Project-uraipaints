<?php

namespace App\Http\Controllers\LeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Assignment;
use App\Customer;
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
        
        list($year,$month,$day) = explode("-",date("Y-m-d"));
        $monthly_plans = DB::table('monthly_plans')
        ->join('users', 'users.id', 'monthly_plans.created_by')
        ->where('monthly_plans.status_approve', 2)
        ->where('users.team_id', Auth::user()->team_id)
        ->select(
            'monthly_plans.*'
        )
        ->get();

        $data['count_monthly_plans'] = 0;
        // -- นับจำนวน slaeplans
        $data['count_sale_plans_result'] = 0;
        $data['count_cust_new_amount'] = 0;
        $data['count_cust_visits_amount'] = 0;
        foreach($monthly_plans as $monthly_plan){
            $data['count_monthly_plans'] = $data['count_monthly_plans'] + $monthly_plan->sale_plan_amount ; // 	จำนวนแผนงาน
            $data['count_cust_new_amount'] = $data['count_cust_new_amount'] + $monthly_plan->cust_new_amount ; // จำนวนลูกค้าใหม่
            $data['count_cust_visits_amount'] = $data['count_cust_visits_amount'] + $monthly_plan->cust_visits_amount ; // จำนวนลูกค้าติดต่อ

            // -- นับจำนวน slaeplans
            $sale_plans = DB::table('sale_plans')->where('monthly_plan_id', $monthly_plan->id)->get();       
            foreach($sale_plans as $sp_value){
                $check_result = DB::table('sale_plan_results')->where('sale_plan_id', $sp_value->id)->first();
                if(!is_null($check_result)){
                    $data['count_sale_plans_result'] = $data['count_sale_plans_result'] + 1;
                }
            }

            // -- นับจำนวน ลูกค้าใหม่
            $data['count_shops_saleplan_result'] = 0;
            $customer_shops_saleplan = DB::table('customer_shops_saleplan')->where('monthly_plan_id', $monthly_plan->id)->get();
            foreach($customer_shops_saleplan as $sp_value){
                $check_result = DB::table('customer_shops_saleplan_result')->where('customer_shops_saleplan_id', $sp_value->id)->first();
                if(!is_null($check_result)){
                    $data['count_shops_saleplan_result'] = $data['count_shops_saleplan_result'] + 1;
                }
            }

            // -- นับจำนวน ลูกค้าเยี่ยม
            $data['count_isit_results_result'] = 0;
            $customer_visits = DB::table('customer_visits')->where('monthly_plan_id', $monthly_plan->id)->get();
            foreach($customer_visits as $sp_value){
                $check_result = DB::table('customer_visit_results')->where('customer_visit_id', $sp_value->id)->first();
                if(!is_null($check_result)){
                    $data['count_isit_results_result'] = $data['count_isit_results_result'] + 1;
                }
            }

        }

        $monthly_plans = DB::table('monthly_plans')
        ->join('users', 'users.id', 'monthly_plans.created_by')
        ->where('monthly_plans.status_approve', 2)
        ->where('users.team_id', Auth::user()->team_id)
        ->select(
            'monthly_plans.*'
        )
        ->get();

        $data['list_approval'] = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->where('users.team_id', Auth::user()->team_id)
            ->whereMonth('assignments.assign_request_date', Carbon::now()->format('m'))
            ->whereIn('assignments.assign_status', [0,1,2])
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();


        $data['assignments'] = DB::table('assignments')
            ->where('created_by', Auth::user()->id)
            ->whereMonth('assign_work_date', Carbon::now()->format('m'))
            ->where('assign_status', 3)
            ->get();
        
        $data['notes'] = Note::where('employee_id', Auth::user()->id)->whereMonth('note_date', Carbon::now()->format('m'))->get();
        $data['customer_shop'] = Customer::where('created_by', Auth::user()->team_id)->where('shop_status', 0)->whereMonth('created_at', Carbon::now()->format('m'))->get();

        $api_token = $this->api_token->apiToken();
        $data['api_token'] = $api_token;

        //-- หาจำนวนร้านค้าใน ทีม
        $user_teams = DB::table('users')->where('team_id', Auth::user()->team_id)->get();

        $data['sum_CustTotal'] = 0;
        $data['sum_ActiveTotal'] = 0;
        $data['sum_InactiveTotal'] = 0;
        $data['sum_FotalCustomers'] = 0;
        $data['sum_TotalDays'] = 0;

        $data['sum_totalAmtSale_Previous'] = 0; // เป้ายอดขายปีที่แล้ว
        $data['sum_totalAmtSale'] = 0; // เป้ายอดขายปีปัจจุบัน

        foreach($user_teams as $team){
            $response = Http::withToken($api_token)
            ->get('http://49.0.64.92:8020/api/v1/sellers/'.$team->api_identify.'/dashboards', [
                'year' => $year,
                'month' => $month
            ]);
            $res_api = $response->json(); 

            $data['sum_CustTotal'] = $data['sum_CustTotal'] + $res_api["data"][0]["Customers"][0]["CustTotal"]; // ร้านค้าทั้งหมด
            $data['sum_ActiveTotal'] = $data['sum_ActiveTotal'] + $res_api["data"][0]["Customers"][0]["ActiveTotal"]; // ร้านที่ Active
            $data['sum_InactiveTotal'] = $data['sum_InactiveTotal'] + $res_api["data"][0]["Customers"][0]["InactiveTotal"]; // ร้านที่ Active
            
            $FocusDates_count = count($res_api["data"][1]["FocusDates"]);
            if($FocusDates_count > 0){
                $data['sum_FotalCustomers'] = $data['sum_FotalCustomers'] + $res_api["data"][1]["FocusDates"][0]["TotalCustomers"];
                $data['sum_TotalDays'] = $data['sum_TotalDays'] + $res_api["data"][1]["FocusDates"][0]["TotalDays"];
            }

            $response = Http::withToken($api_token) // ดึงข้อมูลปีที่แล้ว
            ->get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/dashboards', [
                'year' => $year-1,
                'month' => $month
            ]);
            $res_api_previous = $response->json();

            //-- เปรียบเทียบยอดขาย ปีที่แล้วกับปีปัจจุบัน ในเดือน
            $SalesPrevious = $res_api_previous["data"][3]["SalesPrevious"];
            $data['sum_totalAmtSale_Previous'] = $data['sum_totalAmtSale_Previous'] + $SalesPrevious[0]["totalAmtSale"]; // เป้ายอดขายปีที่แล้ว

            $SalesCurrent = $res_api["data"][2]["SalesCurrent"];
            $data['sum_totalAmtSale'] = $data['sum_totalAmtSale'] + $SalesCurrent[0]["totalAmtSale"]; // ยอดที่ทำได้ปีนี้

        }


        
        
        // dd($data['list_approval']);
        return view('leadManager.dashboard', $data);
    }
}