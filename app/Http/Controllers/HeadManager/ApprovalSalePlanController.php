<?php

namespace App\Http\Controllers\HeadManager;

use App\Assignment;
use App\AssignmentComment;
use App\Customer;
use App\CustomerShopComment;
use App\CustomerVisit;
use App\Http\Controllers\Controller;
use App\MonthlyPlan;
use App\SalePlan;
use App\SaleplanComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApprovalSalePlanController extends Controller
{

    public function index()
    {

        $data['monthly_plan'] = MonthlyPlan::join('users', 'monthly_plans.created_by', '=', 'users.id')
            ->where('monthly_plans.status_approve', 1)->select('users.name', 'monthly_plans.*')->get();


        return view('HeadManager.approval_saleplan', $data);
        // return $data['monthly_plan'];
    }

    public function approvalsaleplan_detail($id)
    {
        // $id คือรหัสของ monthly_plan
        // return $id;

        // -----  API Login ----------- //
        $response = Http::post('http://49.0.64.92:8020/api/auth/login', [
            'username' => 'apiuser',
            'password' => 'testapi',
        ]);
        $res = $response->json();
        $api_token = $res['data'][0]['access_token'];
        $data['api_token'] = $res['data'][0]['access_token'];
        //--- End Api Login ------------ //

        // ข้อมูล Sale plan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->where('monthly_plan_id', $id)
        // ->where('sale_plans.created_by', Auth::user()->id)
        ->whereIn('sale_plans_status', [1, 2, 3])
        ->orderBy('id', 'desc')->get();

        // $data['list_saleplan'] = DB::table('sale_plans')
        //     ->leftjoin('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
        //     ->leftjoin('users', 'sale_plans.created_by', '=', 'users.id')
        //     ->leftjoin('sale_plan_results', 'sale_plans.id', '=', 'sale_plan_results.sale_plan_id')
        //     ->where('sale_plans.sale_plans_status', 1)
        //     ->where('sale_plans.monthly_plan_id', $id)
        //     ->select(
        //         'users.name',
        //         'sale_plan_results.sale_plan_status',
        //         'customer_shops.shop_name',
        //         'customer_shops.shop_saleplan_date',
        //         'sale_plans.*'
        //     )
        //     ->orderBy('id', 'desc')->get();

        // -----  API ลูกค้าที่ sale ดูแล ----------- //
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

        // -- ข้อมูลลูกค้าใหม่
        $data['customer_new'] = DB::table('customer_shops')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->whereIn('customer_shops.shop_aprove_status', [1, 2, 3])
        // ->where('customer_shops.created_by', Auth::user()->id)
        ->where('customer_shops.monthly_plan_id', $id)
        ->select(
            'province.PROVINCE_NAME',
            'customer_shops.*'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();

        // เยี่ยมลูกค้า
        $customer_visits = CustomerVisit::where('customer_visits.created_by', Auth::user()->id)
            ->where('customer_visits.monthly_plan_id', $id)
            ->select('customer_visits.*')
            ->orderBy('id', 'desc')->get();

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
                    ];
                }
            }
        }

        return view('HeadManager.approval_saleplan_detail', $data);
    }

    public function comment_saleplan($id, $createID)
    {
        // return $id;

            $data['data'] = SaleplanComment::where('saleplan_id', $id)->where('created_by', Auth::user()->id)->first();
            $data['saleplanID'] = $id;
            $data['createID'] = $createID;

            $data['title'] = SalePlan::where('id', $id)->first();

            // return $data;
            if ($data) {
                return view('HeadManager.create_comment_saleplan', $data);
            }else {
                return view('HeadManager.create_comment_saleplan', $data);
            }
    }

    public function comment_customer_new($id, $createID)
    {
        // return $id;

            $data['data'] = CustomerShopComment::where('customer_id', $id)->where('created_by', Auth::user()->id)->first();
            $data['customerID'] = $id;
            $data['createID'] = $createID;

            $data['customer'] = Customer::where('id', $id)->first();
            // return $data;
            if ($data) {
                return view('HeadManager.create_comment_customer_new', $data);
            }else {
                return view('HeadManager.create_comment_customer_new', $data);
            }
    }

    public function create_comment_saleplan(Request $request)
    {
        // dd($request);
            $data = SaleplanComment::where('saleplan_id', $request->id)->where('created_by', Auth::user()->id)->first();
            if ($data) {
               $dataEdit = SaleplanComment::where('saleplan_id', $request->id)->update([
                    'saleplan_comment_detail' => $request->comment,
                    'updated_by' => Auth::user()->id,
                ]);
                return redirect(url('head/approvalsaleplan_detail', $request->createID));

            } else {
                SaleplanComment::create([
                    'saleplan_id' => $request->id,
                    'saleplan_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                ]);
                return redirect(url('head/approvalsaleplan_detail', $request->createID));
            }

    }

    public function create_comment_customer_new(Request $request)
    {
        // dd($request);

            $data = CustomerShopComment::where('customer_id', $request->id)->where('created_by', Auth::user()->id)->first();
            // return $request->id;
            if ($data) {
               $dataEdit = CustomerShopComment::where('customer_id', $request->id)->update([
                    'customer_comment_detail' => $request->comment,
                    'updated_by' => Auth::user()->id,
                ]);

            } else {
                CustomerShopComment::create([
                    'customer_id' => $request->id,
                    'customer_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                ]);
            }

            return redirect(url('head/approvalsaleplan_detail', $request->createID));

    }
}
