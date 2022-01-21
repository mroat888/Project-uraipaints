<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SalePlan;
use App\CustomerVisit;
use App\ObjectiveSaleplan;
use App\MonthlyPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PlanMonthController extends Controller
{

    public function index()
    {
    
        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('id', 'desc')->get();
        $data['monthly_plan_next'] = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('id', 'desc')->first();

        $data['objective'] = ObjectiveSaleplan::all();

        $data['customer_new'] = DB::table('customer_shops')
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
            ->where('customer_shops.created_by', Auth::user()->id)
            ->where('customer_shops.monthly_plan_id', $data['monthly_plan_next']->id)
            ->select(
                'province.PROVINCE_NAME',
                'customer_shops.*'
            )
            ->orderBy('customer_shops.id', 'desc')
            ->get();

        $data['list_saleplan'] = DB::table('sale_plans')
            ->join('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
            ->leftjoin('sale_plan_results', 'sale_plans.id', '=', 'sale_plan_results.sale_plan_id')
            ->select(
                'sale_plan_results.sale_plan_status',
                'customer_shops.shop_name',
                'sale_plans.*'
            )
            ->where('sale_plans.monthly_plan_id', $data['monthly_plan_next']->id) 
            ->where('sale_plans.created_by', Auth::user()->id)
            ->orderBy('id', 'desc')->get();

        $data['list_visit'] = CustomerVisit::where('customer_visits.created_by', Auth::user()->id)
            ->where('customer_visits.monthly_plan_id', $data['monthly_plan_next']->id) 
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();
            

        // -----  API
        $response = Http::post('http://49.0.64.92:8020/api/auth/login', [
            'username' => 'apiuser',
            'password' => 'testapi',
        ]);
        $res = $response->json();
        $api_token = $res['data'][0]['access_token'];

        $response = Http::get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/customers', [
            'token' => $api_token,
        ]);
        $res_api = $response->json();
        // $res_api = $res['data'];

        $data['customer_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['customer_api'][$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
            ];
        }

        // -----  END API


        // ---- สร้างข้อมูล เยี่ยมลูกค้า โดย link กับ api
        $customer_visits = CustomerVisit::where('customer_visits.created_by', Auth::user()->id)
            ->where('customer_visits.monthly_plan_id', $data['monthly_plan_next']->id) 
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();

        $data['customer_visit_api'] = array();
        foreach($customer_visits as $key => $cus_visit){

            // $response_visit = Http::get('http://49.0.64.92:8020/api/v1/customers/search', [
            $response_visit = Http::get('http://49.0.64.92:8020/api/v1/customers/'.$cus_visit->customer_shop_id, [
                // 'name' => $cus_visit->customer_shop_id,
                'token' => $api_token,
            ]);
            $res_visit_api = $response_visit->json();

            $data['customer_visit_api'][$key] = 
            [
                'id' => $cus_visit->id,
                'id' => $cus_visit->customer_shop_id,
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['address1']." ".$value['adrress2'],
                'shop_phone' => $value['telephone'],
                'shop_mobile' => $value['mobile'],
            ];
        }

       // dd($data);
        return view('saleman.planMonth', $data);
    }

    public function approve($id)
    { // ส่งอนุมัติให้ผู้จัดการเขต
        // dd($id); //

            $request_approval = SalePlan::where('monthly_plan_id', $id)->first();
            $request_approval->sale_plans_status   = 1;
            $request_approval->updated_by   = Auth::user()->id;
            $request_approval->updated_at   = Carbon::now();
            $request_approval->update();

            $request_approval_month = MonthlyPlan::find($id);
            $request_approval_month->status_approve   = 1;
            $request_approval_month->updated_by   = Auth::user()->id;
            $request_approval_month->updated_at   = Carbon::now();
            $request_approval_month->update();

        return back();
    }
}
