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
use App\Http\Controllers\Api\ApiController;

class ApprovalSalePlanController extends Controller
{
    public function __construct(){
        $this->apicontroller = new ApiController();
    }

    public function index()
    {

        // $data['monthly_plan'] = MonthlyPlan::join('users', 'monthly_plans.created_by', '=', 'users.id')
        //     ->whereIn('monthly_plans.status_approve', [1, 2])->select('users.name', 'monthly_plans.*')->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        $data['monthly_plan'] = DB::table('monthly_plans')
            ->join('users', 'users.id', 'monthly_plans.created_by')
            ->whereIn('monthly_plans.status_approve', [1])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select(
                'users.*',
                'monthly_plans.*'
            )
            ->get();

        // dd($data);
        return view('headManager.approval_saleplan', $data);
        // return $data['monthly_plan'];
    }

    public function approvalsaleplan_detail($id)
    {
        // $id คือรหัสของ monthly_plan
        // return $id;

        // ข้อมูล Sale plan
        $data['list_saleplan'] = DB::table('sale_plans')
        ->where('monthly_plan_id', $id)
        ->whereIn('sale_plans_status', [1, 2, 3])
        ->orderBy('id', 'desc')->get();

        // -----  API Login ----------- //
        $api_token = $this->apicontroller->apiToken(); // API Login
        //--- End Api Login ------------ //
        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $mon_plan = DB::table('monthly_plans')->where('id', $id)->first(); // ค้นหา id ผู้ขออนุมัติ
        $user_api = DB::table('users')->where('id',$mon_plan->created_by)->first(); // ค้นหา user api เพื่อใช้ดึง api
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/sellers/'.$user_api->api_identify.'/customers');
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
        // $data['customer_new'] = DB::table('customer_shops')
        // ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        // ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        // ->whereIn('customer_shops.shop_aprove_status', [1, 2, 3])
        // // ->where('customer_shops.created_by', Auth::user()->id)
        // ->where('customer_shops.monthly_plan_id', $id)
        // ->select(
        //     'province.PROVINCE_NAME',
        //     'customer_shops.*'
        // )
        // ->orderBy('customer_shops.id', 'desc')
        // ->get();

        // ลูกค้าใหม่เปลี่ยนมาใช้อันนี้
        $data['customer_new'] = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->whereIn('customer_shops_saleplan.shop_aprove_status', [1, 2, 3])
        // ->where('customer_shops.created_by', Auth::user()->id)
        ->where('customer_shops_saleplan.monthly_plan_id', $id)
        ->select(
            'province.PROVINCE_NAME',
            'customer_shops.*',
            'customer_shops.id as custid',
            'customer_shops_saleplan.*'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();

        // เยี่ยมลูกค้า

        $customer_visits = DB::table('customer_visits')
            ->where('monthly_plan_id', $id)
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
                        'shop_address' => $res_visit_api['amphoe_name']." ".$res_visit_api['province_name'],
                        'shop_phone' => $res_visit_api['telephone'],
                        'shop_mobile' => $res_visit_api['mobile'],
                    ];
                }
            }
        }

        return view('headManager.approval_saleplan_detail', $data);
    }

    public function search(Request $request){
        // list($year,$month) = explode('-', $request->selectdateTo);
        // $data['monthly_plan'] = DB::table('monthly_plans')
        // ->join('users', 'users.id', 'monthly_plans.created_by')
        // ->where('monthly_plans.status_approve', 1)
        // ->where('users.team_id', Auth::user()->team_id)
        // ->whereYear('month_date', $year)
        // ->whereMonth('month_date', $month)
        // ->select(
        //     'users.*',
        //     'monthly_plans.*'
        // )
        // ->get();

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
        list($year,$month) = explode('-', $request->selectdateTo);
            $data['monthly_plan'] = DB::table('monthly_plans')
            ->join('users', 'users.id', 'monthly_plans.created_by')
            ->whereIn('monthly_plans.status_approve', [1,2])
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->whereYear('month_date', $year)
            ->whereMonth('month_date', $month)
            ->select(
                'users.*',
                'monthly_plans.*'
            )
            ->get();

        return view('headManager.approval_saleplan', $data);
    }

    public function comment_saleplan($id, $createID)
    {
        // return $id;

            $data['data'] = SaleplanComment::where('saleplan_id', $id)->where('created_by', Auth::user()->id)->first();
            $data['saleplanID'] = $id;
            $data['createID'] = $createID;

            $data['title'] = SalePlan::where('id', $id)->first();

            $data['sale_plan_comments'] = DB::table('sale_plan_comments')
            ->where('saleplan_id', $id)
            ->whereNotIn('created_by', [Auth::user()->id])
            ->orderby('created_at', 'desc')
            ->get();
            // dd($data['sale_plan_comments']);

            // return $data;
            if ($data) {
                return view('headManager.create_comment_saleplan', $data);
            }else {
                return view('headManager.create_comment_saleplan', $data);
            }
    }

    public function comment_customer_new($id, $custsaleplanID, $createID)
    {
        // return $id;

            // $data['data'] = CustomerShopComment::where('customer_id', $id)->where('created_by', Auth::user()->id)->first();
            // $data['customerID'] = $id;
            // $data['createID'] = $createID;

            $data['data'] = CustomerShopComment::where('customer_shops_saleplan_id', $custsaleplanID)->where('created_by', Auth::user()->id)->first();
            $data['customerID'] = $id;
            $data['customersaleplanID'] = $custsaleplanID;
            $data['createID'] = $createID;

            $data['customer_shop_comments'] = DB::table('customer_shop_comments')
            ->where('customer_shops_saleplan_id', $custsaleplanID)
            ->whereNotIn('created_by', [Auth::user()->id])
            ->orderby('created_at', 'desc')
            ->get();

            $data['customer'] = Customer::where('id', $id)->first();
            // return $data;
            if ($data) {
                return view('headManager.create_comment_customer_new', $data);
            }else {
                return view('headManager.create_comment_customer_new', $data);
            }
    }

    public function create_comment_saleplan(Request $request)
    {
        // dd($request);
            $data = SaleplanComment::where('saleplan_id', $request->id)->where('created_by', Auth::user()->id)->first();
            if ($data) {
                // $dataEdit = SaleplanComment::where('saleplan_id', $request->id)->update([
                //     'saleplan_comment_detail' => $request->comment,
                //     'updated_by' => Auth::user()->id,
                // ]);
                DB::table('sale_plan_comments')->where('id', $data->id)
                ->update([
                    'saleplan_comment_detail' => $request->comment,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                return redirect(url('head/approvalsaleplan_detail', $request->createID));

            } else {
                // SaleplanComment::create([
                //     'saleplan_id' => $request->id,
                //     'saleplan_comment_detail' => $request->comment,
                //     'created_by' => Auth::user()->id,
                // ]);
                DB::table('sale_plan_comments')
                ->insert([
                    'saleplan_id' => $request->id,
                    'saleplan_comment_detail' => $request->comment,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                return redirect(url('head/approvalsaleplan_detail', $request->createID));
            }

    }

    public function create_comment_customer_new(Request $request)
    {
        // dd($request);

        $data = DB::table('customer_shop_comments')
        ->where('customer_shops_saleplan_id', $request->cust_shops_saleplan_id)
        ->where('created_by', Auth::user()->id)
        ->first();

        if ($data) {
            DB::table('customer_shop_comments')
            ->where('customer_shops_saleplan_id', $request->cust_shops_saleplan_id)
            ->update([
                'customer_comment_detail' => $request->comment,
                'updated_by' => Auth::user()->id,
                'updated_at'=> date('Y-m-d H:i:s')
            ]);
        } else {
            DB::table('customer_shop_comments')
            ->insert([
                'customer_shops_saleplan_id' => $request->cust_shops_saleplan_id,
                'customer_id' => $request->customer_shops_id,
                'customer_comment_detail' => $request->comment,
                'created_by' => Auth::user()->id,
                'created_at'=> date('Y-m-d H:i:s')
            ]);
        }

        return redirect(url('head/approvalsaleplan_detail', $request->monthly_plans_id));

    }
}
