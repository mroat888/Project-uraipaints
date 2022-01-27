<?php

namespace App\Http\Controllers\SaleMan;

use App\Assignment;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SalePlan;
use App\CustomerVisit;
use App\Note;
use App\RequestApproval;
use App\MonthlyPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DailyWorkController extends Controller
{
    public function index()
    {
        // หาเดือนปัจจุบัน
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

            list($year,$month,$day) = explode("-",date("Y-m-d"));
            $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)
            ->whereYear('month_date', $year)
            ->whereMonth('month_date', $month)
            ->orderBy('month_date', 'desc')
            ->first();
        }
        // -- จบ ถ้า monthly_plan ไม่มีเดือนปัจจุบัน ให้สร้างขึ้นมาใหม่ -----------


        // -----  API Login ----------- //
        $response = Http::post('http://49.0.64.92:8020/api/auth/login', [
            'username' => 'apiuser',
            'password' => 'testapi',
        ]);

        $res = $response->json();
        $api_token = $res['data'][0]['access_token'];
        $data['api_token'] = $res['data'][0]['access_token'];
        //--- End Api Login ------------ //

        // $data['list_saleplan'] = SalePlan::leftjoin('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
        // ->select(
        //     'customer_shops.shop_name' ,
        //     'sale_plans.*')
        //     ->where('sale_plans.monthly_plan_id', $monthly_plan->id)
        // ->where('sale_plans.created_by', Auth::user()->id)
        // ->orderBy('sale_plans.id', 'desc')->get();

        // $data['customer_shop'] = Customer::where('monthly_plan_id', $monthly_plan->id)
        // ->where('shop_status', 0)
        // ->get();


        // -- ข้อมูล แผนงานงาน Saleplan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->where('sale_plans.monthly_plan_id', $data['monthly_plan']->id)
        ->where('sale_plans.created_by', Auth::user()->id)
        ->where('sale_plans_status', 2)
        ->orderBy('id', 'desc')->get();

        
        // -- ข้อมูลลูกค้าใหม่ 
        $data['customer_new'] = DB::table('customer_shops')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->where('customer_shops.created_by', Auth::user()->id)
        ->where('customer_shops.monthly_plan_id', $data['monthly_plan']->id)
        ->where('customer_shops.shop_aprove_status', 2)
        ->select(
            'province.PROVINCE_NAME',
            'customer_shops.*'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();


        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/customers');
        $res_api = $response->json();

        $data['customer_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['customer_api'][$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
            ];
        }

        // ---- สร้างข้อมูล เยี่ยมลูกค้า โดย link กับ api ------- //
        $customer_visits = CustomerVisit::where('customer_visits.created_by', Auth::user()->id)
        ->leftjoin('customer_visit_results', 'customer_visits.id', '=', 'customer_visit_results.customer_visit_id')
        ->select(
            'customer_visit_results.cust_visit_status',
            'customer_visit_results.cust_visit_checkin_date',
            'customer_visit_results.cust_visit_checkout_date',
            'customer_visit_results.customer_visit_id',
            'customer_visits.*',
        )
        ->where('customer_visits.monthly_plan_id', $data['monthly_plan']->id)
        ->orderBy('customer_visits.id', 'desc')
        ->get();

        $data['customer_visit_api'] = array();
        foreach($customer_visits as $key => $cus_visit){

            foreach ($res_api['data'] as $key_api => $value_api) {
                $res_visit_api = $res_api['data'][$key_api];
                if($cus_visit->customer_shop_id == $res_visit_api['identify']){ 
                    $data['customer_visit_api'][$key_api] =
                    [
                        'id' => $cus_visit->id,
                        'identify' => $res_visit_api['identify'],
                        'shop_name' => $res_visit_api['title']." ".$res_visit_api['name'],
                        'shop_address' => $res_visit_api['address1']." ".$res_visit_api['adrress2'],
                        'shop_phone' => $res_visit_api['telephone'],
                        'shop_mobile' => $res_visit_api['mobile'],
                        'visit_status' => $cus_visit->cust_visit_status,
                        'visit_checkin_date' => $cus_visit->cust_visit_checkin_date,
                        'visit_checkout_date' => $cus_visit->cust_visit_checkout_date,
                    ];
                }
            }

        }

        // $data['list_visit'] = CustomerVisit::leftjoin('customer_shops', 'customer_visits.customer_shop_id', '=', 'customer_shops.id')
        // ->leftjoin('customer_contacts', 'customer_shops.id', '=', 'customer_contacts.customer_shop_id')
        // ->leftjoin('province', 'customer_shops.shop_province_id', '=', 'province.PROVINCE_CODE')
        // ->leftjoin('customer_visit_results', 'customer_visits.id', '=', 'customer_visit_results.customer_visit_id')
        // ->select(
        //     'province.PROVINCE_NAME',
        //     'customer_contacts.customer_contact_name',
        //     'customer_visit_results.cust_visit_status',
        //     'customer_visit_results.cust_visit_checkin_date',
        //     'customer_visit_results.cust_visit_checkout_date',
        //     'customer_visit_results.customer_visit_id',
        //     'customer_shops.shop_name',
        //     'customer_visits.*'
        // )
        // ->where('customer_visits.created_by', Auth::user()->id)
        // ->where('customer_visits.monthly_plan_id', $monthly_plan->id)
        // ->orderBy('customer_visits.id', 'desc')->get();

        
        $data['list_approval'] = RequestApproval::where('created_by', Auth::user()->id)->whereMonth('assign_request_date', Carbon::now()->format('m'))->get();

        $data['assignments'] = Assignment::where('assign_emp_id', Auth::user()->id)->whereMonth('assign_work_date', Carbon::now()->format('m'))->get();

        $data['notes'] = Note::where('employee_id', Auth::user()->id)->whereMonth('note_date', Carbon::now()->format('m'))->get();

        


        return view('saleman.dailyWork', $data);
    }

}
