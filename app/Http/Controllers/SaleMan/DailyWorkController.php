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
use App\Http\Controllers\Api\ApiController;
use App\NewsBanner;

class DailyWorkController extends Controller
{
    public function __construct()
    {
        $this->api_token = new ApiController();
    }

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

        // -- ข้อมูล แผนงานงาน Saleplan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->leftjoin('sale_plan_comments', 'sale_plans.id', 'sale_plan_comments.saleplan_id')
        ->where('sale_plans.monthly_plan_id', $data['monthly_plan']->id)
        ->where('sale_plans.created_by', Auth::user()->id)
        ->where('sale_plans.sale_plans_status', 2)
        ->select('sale_plans.*', 'sale_plan_comments.saleplan_id')->distinct()
        ->orderBy('sale_plans.id', 'desc')->get();

        // -- ข้อมูลลูกค้าใหม่ // ลูกค้าใหม่เปลี่ยนมาใช้อันนี้
        $data['customer_new'] = DB::table('customer_shops_saleplan')
        ->leftJoin('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->leftjoin('customer_shops_saleplan_result', 'customer_shops_saleplan_result.customer_shops_saleplan_id', 'customer_shops_saleplan.id')
        ->join('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->join('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->where('customer_shops_saleplan.created_by', Auth::user()->id)
        ->where('customer_shops_saleplan.monthly_plan_id', $data['monthly_plan']->id)
        ->where('customer_shops_saleplan.shop_aprove_status', 2)
        ->select(
            'province.PROVINCE_NAME',
            'amphur.AMPHUR_NAME',
            'customer_shops.*',
            'customer_shops.id as cust_shop_id',
            'customer_shops_saleplan_result.*',
            'customer_shops_saleplan.*',
            'master_customer_new.cust_name'
        )
        ->orderBy('customer_shops_saleplan.id', 'desc')
        ->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/sellers/'.Auth::user()->api_identify.'/customers');
        $res_api = $response->json();

        $data['customer_api'] = array();
        $data['InMonthDays'] = 0;
        $data['ShopInMonthDays'] = 0;
        foreach ($res_api['data'] as $key => $value) {
            $data['customer_api'][$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['amphoe_name']." , ".$value['province_name'],
            ];

            if($value['InMonthDays'] != 0){
                $data['ShopInMonthDays'] += 1;
                $data['InMonthDays'] += $value['InMonthDays'];
            }

        }

        $data['total_shop'] = $res_api['records'];


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
                        // 'shop_address' => $res_visit_api['address1']." ".$res_visit_api['adrress2'],
                        'shop_address' => $res_visit_api['amphoe_name']." , ".$res_visit_api['province_name'],
                        'shop_phone' => $res_visit_api['telephone'],
                        'shop_mobile' => $res_visit_api['mobile'],
                        'focusdate' => $res_visit_api['focusdate'],
                        'visit_status' => $cus_visit->cust_visit_status,
                        'visit_checkin_date' => $cus_visit->cust_visit_checkin_date,
                        'visit_checkout_date' => $cus_visit->cust_visit_checkout_date,
                    ];
                }
            }

        }


        $data['list_approval'] = RequestApproval::where('created_by', Auth::user()->id)->whereMonth('assign_request_date', Carbon::now()->format('m'))->get();

        $data['customer_shop'] = Customer::where('shop_status', 0)
        // ->where(function($query) use ($auth_team) {
        //     for ($i = 0; $i < count($auth_team); $i++){
        //         $query->orWhere('created_by', $auth_team[$i])
        //             ->orWhere('created_by', 'like', $auth_team[$i].',%')
        //             ->orWhere('created_by', 'like', '%,'.$auth_team[$i]);
        //     }
        // })
        ->whereMonth('created_at', Carbon::now()
        ->format('m'))
        ->get();

        $data['assignments'] = Assignment::where('assign_emp_id', Auth::user()->id)->whereMonth('assign_work_date', Carbon::now()->format('m'))->get();

        $data['notes'] = Note::where('employee_id', Auth::user()->id)->whereMonth('note_date', Carbon::now()->format('m'))->get();

        $data['list_news_a'] = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->first();
        $data['list_banner'] = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->get();


        return view('saleman.dailyWork', $data);
    }

}
