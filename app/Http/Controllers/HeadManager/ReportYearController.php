<?php

namespace App\Http\Controllers\HeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Http;

class ReportYearController extends Controller
{
    public function index(){
        $report = array();
        $users = DB::table('users')->where('status',1)->where('team_id', Auth::user()->team_id)->get();

        //-- ตัวแปรผลรวม ลูกค้าเยี่ยม
        $sum_cust_visits_amount = 0;
        $sum_cus_visit_in_process = 0;
        $sum_cus_visit_success = 0;
        $sum_cus_visit_failed = 0;
        $sum_percent_custvisit_success = 0;
        $sum_percent_custvisit_failed = 0;

        //-- ตัวแปรผลรวม ลูกค้าใหม่
        $sum_cust_new_amount = 0;
        $sum_cus_new_in_process = 0;
        $sum_cus_new_success = 0;
        $sum_cus_new_failed = 0;
        $sum_percent_custnew_success = 0;
        $sum_percent_custnew_failed = 0;

        //-- ตัวแปรผลรวม แผนงาน saleplan
        $sum_sale_plans_amount = 0;
        $sum_sale_plans_in_process = 0;
        $sum_sale_plans_success = 0;
        $sum_sale_plans_failed = 0;
        $sum_percent_saleplans_success = 0;
        $sum_percent_saleplans_failed = 0;

        if(!is_null($users)){
            foreach($users as $user){

                $monthly_plans = DB::table('monthly_plans')
                    ->where('created_by', $user->id)
                    ->whereYear('month_date', date('Y-m-d'))
                    ->select(
                        'monthly_plans.*',
                        // DB::raw("SUM(cust_visits_amount) as total_cust_visits_amount"),
                        // DB::raw("SUM(cust_new_amount) as total_custnew_amount"),
                        // DB::raw("SUM(sale_plan_amount) as total_saleplan_amount"),
                    )
                    ->get();

                $cust_visits_amount = 0;    // จำนวนลูกค้าเยี่ยม
                $cus_visit_success = 0;     // ลูกค้าเยียม สำเร็จ
                $cus_visit_failed = 0;      // ลูกค้าเยียม ไม่สำเร็จ
                $cus_visit_in_process = 0;  // ลูกค้าเยียม ยังไม่ดำเนินการ
                $percent_custvisit_success = 0; // ลูกค้าเยียม เปอร์เซ็นต์สำเร็จ
                $percent_custvisit_failed = 0;  // ลูกค้าเยียม เปอร์เซ็นต์ไม่สำเร็จ

                $cust_new_amount = 0;       // จำนวนลูกค้าใหม่
                $cust_new_success = 0;     // ลูกค้าเยียม สำเร็จ
                $cust_new_failed = 0;      // ลูกค้าเยียม ไม่สำเร็จ
                $cust_new_in_process = 0;  // ลูกค้าเยียม ยังไม่ดำเนินการ
                $percent_custnew_success = 0; // ลูกค้าเยียม เปอร์เซ็นต์สำเร็จ
                $percent_custnew_failed = 0;  // ลูกค้าเยียม เปอร์เซ็นต์ไม่สำเร็จ

                $sale_plans_amount = 0;       // จำนวนแผนงาน Sale paln
                $sale_plans_success = 0;     // แผนงาน Sale paln สำเร็จ
                $sale_plans_failed = 0;      // แผนงาน Sale paln ไม่สำเร็จ
                $sale_plans_in_process = 0;  // แผนงาน Sale paln ยังไม่ดำเนินการ
                $percent_saleplans_success = 0; // แผนงาน Sale paln เปอร์เซ็นต์สำเร็จ
                $percent_saleplans_failed = 0;  // แผนงาน Sale paln เปอร์เซ็นต์ไม่สำเร็จ
            
                if(!is_null($monthly_plans)){
                    foreach($monthly_plans as $monthly_plans_value){

                        // รายงานลูกค้าเยี่ยม
                        $customer_visits = DB::table('customer_visits')
                            ->where('monthly_plan_id', $monthly_plans_value->id)
                            ->get();

                        if(!is_null($customer_visits)){

                            $cust_visits_amount += $customer_visits->count();

                            foreach($customer_visits as $value){
                                $customer_visit_results = DB::table('customer_visit_results')
                                ->where('customer_visit_id', $value->id)
                                ->first();
                                if(!is_null($customer_visit_results)){
                                    if((!is_null($customer_visit_results->cust_visit_checkin_date)) && (!is_null($customer_visit_results->cust_visit_checkout_date))){
                                        $cus_visit_success++;
                                    }else if((!is_null($customer_visit_results->cust_visit_checkin_date)) && (is_null($customer_visit_results->cust_visit_checkout_date))){
                                        $cus_visit_failed++;
                                    }
                                }
                            }

                            $cus_visit_in_process = $cust_visits_amount - ($cus_visit_success + $cus_visit_failed);
                            if($cust_visits_amount > 0 ){
                                $percent_custvisit_success = @round(($cus_visit_success*100)/$cust_visits_amount);
                                $percent_custvisit_failed = @round(($cus_visit_failed*100)/$cust_visits_amount);
                            }else{
                                $percent_custvisit_success = 0;
                                $percent_custvisit_failed = 0;
                            }
                            
                        }else{
                            $cust_visits_amount += 0;
                        }
                        // จบ รายงานลูกค้าเยี่ยม

                        
                        // รายงานลูกค้าใหม่
                        $customer_shops_saleplan = DB::table('customer_shops_saleplan')
                            ->where('monthly_plan_id', $monthly_plans_value->id)
                            ->where('shop_aprove_status', 2)
                            ->get();

                        if(!is_null($customer_shops_saleplan)){

                            $cust_new_amount += $customer_shops_saleplan->count();

                            foreach($customer_shops_saleplan as $value){
                                $customer_shops_saleplan_result = DB::table('customer_shops_saleplan_result')
                                ->where('customer_shops_saleplan_id', $value->id)
                                ->first();
                                if(!is_null($customer_shops_saleplan_result)){
                                    if((!is_null($customer_shops_saleplan_result->cust_result_checkin_date)) && (!is_null($customer_shops_saleplan_result->cust_result_checkout_date))){
                                        $cust_new_success++;
                                    }else if((!is_null($customer_shops_saleplan_result->cust_result_checkin_date)) && (is_null($customer_shops_saleplan_result->cust_result_checkout_date))){
                                        $cust_new_failed++;
                                    }
                                } 
                            }

                            $cust_new_in_process = $cust_new_amount - ($cust_new_success + $cust_new_failed);
                            if($cust_new_amount > 0 ){
                                $percent_custnew_success = @round(($cust_new_success*100)/$cust_new_amount);
                                $percent_custnew_failed = @round(($cust_new_failed*100)/$cust_new_amount);
                            }else{
                                $percent_custnew_success = 0;
                                $percent_custnew_failed = 0;
                            }

                        }else{
                            $cust_new_amount += 0 ;
                        }
                        // จบ รายงานลูกค้าใหม่

                        // รายงานแผนงาน Saleplan
                        $sale_plans = DB::table('sale_plans')
                            ->where('monthly_plan_id', $monthly_plans_value->id)
                            ->where('sale_plans_status', 2) // สถานะอนุมัติ (0=ฉบับร่าง ,1 = ส่งอนุมัติ , 2 = อนุมัติ , 3= ปฎิเสธ))	
                            ->get();
                        if(!is_null($sale_plans)){

                            $sale_plans_amount += $sale_plans->count(); // เปลี่ยนมาใช้ตัวนี้นับ

                            foreach($sale_plans as $value){
                                $sale_plan_results = DB::table('sale_plan_results')
                                ->where('sale_plan_id', $value->id)
                                ->first();
                                if(!is_null($sale_plan_results)){
                                    if((!is_null($sale_plan_results->sale_plan_checkin_date)) && (!is_null($sale_plan_results->sale_plan_checkout_date))){
                                        $sale_plans_success++;
                                    }else if((!is_null($sale_plan_results->sale_plan_checkin_date)) && (is_null($sale_plan_results->sale_plan_checkout_date))){
                                        $sale_plans_failed++;
                                    }
                                } 
                            }

                            $sale_plans_in_process = $sale_plans_amount - ($sale_plans_success + $sale_plans_failed);
                            if($sale_plans_amount > 0 ){
                                $percent_saleplans_success = @round(($sale_plans_success*100)/$sale_plans_amount);
                                $percent_saleplans_failed = @round(($sale_plans_failed*100)/$sale_plans_amount);
                            }else{
                                $percent_saleplans_success = 0;
                                $percent_saleplans_failed = 0;
                            }

                        }else{
                            $sale_plans_amount += 0 ;
                        }
                        // จบ รายงานแผนงาน Saleplan
                    }
                }

                $report[] = [
                    'user_name' => $user->name,
                    'cust_visits_amount' => $cust_visits_amount,
                    'cus_visit_in_process' => $cus_visit_in_process,
                    'cus_visit_success' => $cus_visit_success,
                    'cus_visit_failed' => $cus_visit_failed,
                    'percent_custvisit_success' => $percent_custvisit_success,
                    'percent_custvisit_failed' => $percent_custvisit_failed,
                    'cust_new_amount' => $cust_new_amount,
                    'cust_new_in_process' => $cust_new_in_process,
                    'cust_new_success' => $cust_new_success,
                    'cust_new_failed' => $cust_new_failed,
                    'percent_custnew_success' => $percent_custnew_success,
                    'percent_custnew_failed' => $percent_custnew_failed,
                    'sale_plans_amount' => $sale_plans_amount,
                    'sale_plans_in_process' => $sale_plans_in_process,
                    'sale_plans_success' => $sale_plans_success,
                    'sale_plans_failed' => $sale_plans_failed,
                    'percent_saleplans_success' => $percent_saleplans_success,
                    'percent_saleplans_failed' => $percent_saleplans_failed,
                ];

                // รวม รายงานลูกค้าเยี่ยม
                $sum_cust_visits_amount += $cust_visits_amount;
                $sum_cus_visit_in_process += $cus_visit_in_process;
                $sum_cus_visit_success += $cus_visit_success;
                $sum_cus_visit_failed += $cus_visit_failed;

                // รวม รายงานลูกค้าใหม่
                $sum_cust_new_amount += $cust_new_amount ;
                $sum_cus_new_in_process += $cust_new_in_process;
                $sum_cus_new_success += $cust_new_success;
                $sum_cus_new_failed += $cust_new_failed;

                // รวม รายงานแผนงาน saleplan
                $sum_sale_plans_amount += $sale_plans_amount;
                $sum_sale_plans_in_process += $sale_plans_in_process;
                $sum_sale_plans_success += $sale_plans_success;
                $sum_sale_plans_failed += $sale_plans_failed;
            }
        }

        //-- คำนวเปอร์เซ็นต์
        if($sum_cust_visits_amount > 0 ){ // ลูกค้าเยี่ยม
            $sum_percent_custvisit_success = @round(($sum_cus_visit_success*100)/$sum_cust_visits_amount);
            $sum_percent_custvisit_failed = @round(($sum_cus_visit_failed*100)/$sum_cust_visits_amount);
        }else{
            $sum_percent_custvisit_success = 0;
            $sum_percent_custvisit_failed = 0;
        }

        if($sum_cust_new_amount > 0 ){ // ลูกค้าใหม่
            $sum_percent_custnew_success = @round(($sum_cus_new_success*100)/$sum_cust_new_amount);
            $sum_percent_custnew_failed = @round(($sum_cus_new_failed*100)/$sum_cust_new_amount);
        }else{
            $sum_percent_custnew_success = 0;
            $sum_percent_custnew_failed = 0;
        }

        if($sum_sale_plans_amount > 0 ){ // แผนงาน sale plan
            $sum_percent_saleplans_success = @round(($sum_sale_plans_success*100)/$sum_sale_plans_amount);
            $sum_percent_saleplans_failed = @round(($sum_sale_plans_failed*100)/$sum_sale_plans_amount);
        }else{
            $sum_percent_saleplans_success = 0;
            $sum_percent_saleplans_failed = 0;
        }


        $report_footer[] = [
            'sum_cust_visits_amount' => $sum_cust_visits_amount,
            'sum_cus_visit_in_process' => $sum_cus_visit_in_process,
            'sum_cus_visit_success' => $sum_cus_visit_success,
            'sum_cus_visit_failed' => $sum_cus_visit_failed,
            'sum_percent_custvisit_success' => $sum_percent_custvisit_success,
            'sum_percent_custvisit_failed' => $sum_percent_custvisit_failed,
            'sum_cust_new_amount' => $sum_cust_new_amount,
            'sum_cus_new_in_process' => $sum_cus_new_in_process, 
            'sum_cus_new_success' => $sum_cus_new_success,
            'sum_cus_new_failed' => $sum_cus_new_failed, 
            'sum_percent_custnew_success' => $sum_percent_custnew_success,
            'sum_percent_custnew_failed' => $sum_percent_custnew_failed,
            'sum_sale_plans_amount' => $sum_sale_plans_amount,
            'sum_sale_plans_in_process' => $sum_sale_plans_in_process,
            'sum_sale_plans_success' => $sum_sale_plans_success,
            'sum_sale_plans_failed' => $sum_sale_plans_failed,
            'sum_percent_saleplans_success' => $sum_percent_saleplans_success,
            'sum_percent_saleplans_failed' => $sum_percent_saleplans_failed,
        ];

       //dd($report);

        return view('reports.report_year_head', compact('report','report_footer'));
    }

}
