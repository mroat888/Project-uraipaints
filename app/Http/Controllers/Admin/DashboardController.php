<?php

namespace App\Http\Controllers\Admin;

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
        ->whereYear('month_date', $year)
        ->whereMonth('month_date', $month)
        ->select(
            'monthly_plans.*'
        )
        ->get();

        $data['count_monthly_plans'] = 0;
        $data['count_cust_new_amount'] = 0;
        $data['count_cust_visits_amount'] = 0;

        // -- นับจำนวน slaeplans
        $data['count_sale_plans_result'] = 0;
        $data['count_shops_saleplan_result'] = 0;
        $data['count_visit_results_result'] = 0;
        foreach($monthly_plans as $monthly_plan){
            // $data['count_monthly_plans'] = $data['count_monthly_plans'] + $monthly_plan->sale_plan_amount ; // 	จำนวนแผนงาน
            // $data['count_cust_new_amount'] = $data['count_cust_new_amount'] + $monthly_plan->cust_new_amount ; // จำนวนลูกค้าใหม่
            // $data['count_cust_visits_amount'] = $data['count_cust_visits_amount'] + $monthly_plan->cust_visits_amount ; // จำนวนลูกค้าติดต่อ

            // -- นับจำนวน slaeplans
            $sale_plans = DB::table('sale_plans')->where('monthly_plan_id', $monthly_plan->id)->get();
            $sale_plans = DB::table('sale_plans')
                ->where('monthly_plan_id', $monthly_plan->id)
                ->where('sale_plans_status', 2)
                ->get();
            $data['count_monthly_plans'] = $data['count_monthly_plans'] + $sale_plans->count() ; // 	จำนวนแผนงาน
            foreach($sale_plans as $sp_value){
                $check_result = DB::table('sale_plan_results')->where('sale_plan_id', $sp_value->id)->first();
                if(!is_null($check_result)){
                    $data['count_sale_plans_result'] = $data['count_sale_plans_result'] +1 ;
                }
            }

            // -- นับจำนวน ลูกค้าใหม่
            $customer_shops_saleplan = DB::table('customer_shops_saleplan')
                ->where('monthly_plan_id', $monthly_plan->id)
                ->where('shop_aprove_status', 2)
                ->get();
            $data['count_cust_new_amount'] = $data['count_cust_new_amount'] + $customer_shops_saleplan->count() ; // จำนวนลูกค้าใหม่
            foreach($customer_shops_saleplan as $sp_value){
                $check_result = DB::table('customer_shops_saleplan_result')->where('customer_shops_saleplan_id', $sp_value->id)->first();
                if(!is_null($check_result)){
                    $data['count_shops_saleplan_result'] = $data['count_shops_saleplan_result'] + 1;
                }
            }

            // -- นับจำนวน ลูกค้าเยี่ยม
            $customer_visits = DB::table('customer_visits')->where('monthly_plan_id', $monthly_plan->id)->get();
            $data['count_cust_visits_amount'] = $data['count_cust_visits_amount'] + $customer_visits->count() ;
            foreach($customer_visits as $sp_value){
                $check_result = DB::table('customer_visit_results')->where('customer_visit_id', $sp_value->id)->first();
                if(!is_null($check_result)){
                    $data['count_visit_results_result'] = $data['count_visit_results_result'] + 1;
                }
            }

        }

        $data['list_approval'] = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->whereMonth('assignments.assign_request_date', Carbon::now()->format('m'))
            ->whereIn('assignments.assign_status', [1,2])
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->get();


        $data['assignments'] = DB::table('assignments')
            ->whereMonth('assign_work_date', Carbon::now()->format('m'))
            ->where('assign_status', 3)
            ->get();

        $data['notes'] = Note::whereMonth('note_date', Carbon::now()->format('m'))->get();
        $data['customer_shop'] = Customer::where('shop_status', 0)->whereMonth('created_at', Carbon::now()->format('m'))->get();

        $api_token = $this->api_token->apiToken();
        $data['api_token'] = $api_token;

        //-- หาจำนวนร้านค้าใน ทีม
        // $user_teams = DB::table('users')->where('status', 1)->get();
        $user_teams = DB::table('users')->whereIn('status', [1,2,3])->get();

        $data['sum_CustTotal'] = 0;
        $data['sum_ActiveTotal'] = 0;
        $data['sum_InactiveTotal'] = 0;
        $data['sum_FotalCustomers'] = 0;
        $data['sum_TotalDays'] = 0;

        $data['sum_totalAmtSale_Previous'] = 0; // เป้ายอดขายปีที่แล้ว
        $data['sum_totalAmtSale'] = 0; // เป้ายอดขายปีปัจจุบัน

        // -- Chat
        $dayinmonth = date("t");
        $data['day_month'] = "";
        $data['amtsale_current'] = "";
        $data['amtsale_previous'] = "";
        $noc=0;
        $nop=0;
        $check_looo_once = 'Y';
        $sum_amtsale_current = array();
        $sum_amtsale_previous = array();
        $data['amtsale_current'] = "";
        $data['amtsale_previous'] = "";

        $response = Http::withToken($api_token)
        ->get(env("API_LINK").env('API_PATH_VER').'/admin-dashboards', [
            'year' => $year,
            'month' => $month
        ]);
        $res_api = $response->json();

        if(!is_null($res_api) && $res_api['code'] == 200){
            $data['res_api'] = $res_api;
        }
        // $response_bdates = Http::withToken($api_token)
        // ->get(env("API_LINK").env('API_PATH_VER').'/bdates/saleheaders/'.Auth::user()->api_identify.'/customers');
        // $data['res_bdates_api'] = $response_bdates->json();

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
           
        }
        // -- จบ Chat


        // if(!is_null($user_teams)){
        //     foreach($user_teams as $team){

        //         $response = Http::withToken($api_token)
        //         ->get('http://49.0.64.92:8020/api/v1/sellers/'.$team->api_identify.'/dashboards', [
        //             'year' => $year,
        //             'month' => $month
        //         ]);
        //         $res_api = $response->json();

        //         if(!empty($res_api["data"][0]["Customers"])){
        //             $Customers_check_data = count($res_api["data"][0]["Customers"]);
        //             if($Customers_check_data > 0){
        //                 $data['sum_CustTotal'] = $data['sum_CustTotal'] + $res_api["data"][0]["Customers"][0]["CustTotal"]; // ร้านค้าทั้งหมด
        //                 $data['sum_ActiveTotal'] = $data['sum_ActiveTotal'] + $res_api["data"][0]["Customers"][0]["ActiveTotal"]; // ร้านที่ Active
        //                 $data['sum_InactiveTotal'] = $data['sum_InactiveTotal'] + $res_api["data"][0]["Customers"][0]["InactiveTotal"]; // ร้านที่ Active
        //             }
        //         }

        //         // if(!empty($res_api["data"][1]["FocusDates"])){
        //         //     $FocusDates_check_data = count($res_api["data"][1]["FocusDates"]);
        //         //     if($FocusDates_check_data > 0){
        //         //         $data['sum_FotalCustomers'] = $data['sum_FotalCustomers'] + $res_api["data"][1]["FocusDates"][0]["TotalCustomers"];
        //         //         $data['sum_TotalDays'] = $data['sum_TotalDays'] + $res_api["data"][1]["FocusDates"][0]["TotalDays"];
        //         //     }
        //         // }

        //         // //-- เปรียบเทียบยอดขาย ปีที่แล้วกับปีปัจจุบัน ในเดือน
        //         // if(!empty($res_api["data"][3]["SalesPrevious"])){
        //         //     $SalesPrevious_check_data = count($res_api["data"][3]["SalesPrevious"]);
        //         //     if($SalesPrevious_check_data > 0){
        //         //         $SalesPrevious = $res_api["data"][3]["SalesPrevious"];
        //         //         $data['sum_totalAmtSale_Previous'] = $data['sum_totalAmtSale_Previous'] + $SalesPrevious[0]["totalAmtSale"]; // เป้ายอดขายปีที่แล้ว
        //         //     }
        //         // }

        //         // if(!empty($res_api["data"][2]["SalesCurrent"])){
        //         //     $SalesCurrent_check_data = count($res_api["data"][2]["SalesCurrent"]);
        //         //     if($SalesCurrent_check_data > 0){
        //         //         $SalesCurrent = $res_api["data"][2]["SalesCurrent"];
        //         //         $data['sum_totalAmtSale'] = $data['sum_totalAmtSale'] + $SalesCurrent[0]["totalAmtSale"]; // ยอดที่ทำได้ปีนี้
        //         //     }
        //         // }

        //         //-- Chat
        //         // if($check_looo_once == 'Y'){
        //         //     for($i=1; $i <= $dayinmonth; $i++){
        //         //         if($i < $dayinmonth){
        //         //             $data['day_month'] .= $i.",";
        //         //         }else{
        //         //             $data['day_month'] .= $i;
        //         //         }
        //         //     }
        //         // }
        //         // $noc=0;
        //         // $nop=0;
        //         // for($i=1; $i <= $dayinmonth; $i++){

        //         //     if(empty($sum_amtsale_current[$i])){
        //         //         $sum_amtsale_current[$i] = 0;
        //         //     }else{
        //         //         $sum_amtsale_current[$i] += 0;
        //         //     }

        //         //     if(empty($sum_amtsale_previous[$i])){
        //         //         $sum_amtsale_previous[$i] = 0;
        //         //     }else{
        //         //         $sum_amtsale_previous[$i] += 0;
        //         //     }

        //         //     if(isset($res_api['data'][4]['DaysSalesCurrent'][$nop]['DayNo'])){ // ปีปัจจุบัน
        //         //         if($res_api['data'][4]['DaysSalesCurrent'][$nop]['DayNo'] == $i){
        //         //             $sum_amtsale_current[$i] +=  $res_api['data'][4]['DaysSalesCurrent'][$nop]['totalAmtSale'];
        //         //         }else{
        //         //             $nop--;
        //         //         }
        //         //     }

        //         //     if(isset($res_api['data'][5]['DaysSalesPrevious'][$nop]['DayNo'])){ // ปีที่แล้ว
        //         //         if($res_api['data'][5]['DaysSalesPrevious'][$nop]['DayNo'] == $i){
        //         //             $sum_amtsale_previous[$i] +=  $res_api['data'][5]['DaysSalesPrevious'][$nop]['totalAmtSale'];
        //         //         }else{
        //         //             $nop--;
        //         //         }
        //         //     }

        //         //     $nop++;
        //         // }
        //         // $check_looo_once = 'N';

        //     }
        // }

        // //-- Chat
        // // for($i=1; $i <= $dayinmonth; $i++){
        // //     if($i < $dayinmonth){
        // //         $data['amtsale_current'] .= $sum_amtsale_current[$i].",";
        // //         $data['amtsale_previous'] .= $sum_amtsale_previous[$i].",";
        // //     }else{
        // //         $data['amtsale_current'] .= $sum_amtsale_current[$i];
        // //         $data['amtsale_previous'] .= $sum_amtsale_previous[$i];
        // //     }
        // // }


        return view('admin.dashboard', $data);

    }

}
