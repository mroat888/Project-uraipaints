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
        $dt = date("Y-m-d", strtotime("+1 month")); // บวกเดือนเพิ่ม 1 เดือน
        list($year, $month, $day) = explode("-",$dt);

        $data['year'] = $year ;
        $data['month'] = $month ;

        $data['date_filter'] = $data['year']."-".$data['month'];

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['monthly_plan'] = DB::table('monthly_plans')
            ->leftJoin('users', 'users.id', 'monthly_plans.created_by')
            ->leftJoin('monthly_plan_result', 'monthly_plan_result.monthly_plan_id', 'monthly_plans.id')
            ->whereIn('monthly_plans.status_approve', [1,2,4])
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
                'monthly_plan_result.*',
                'monthly_plans.*'
            )
            ->get();

        $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();

        return view('headManager.approval_saleplan', $data);
    }

    public function search(Request $request)
    {
        // dd($request);

        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $monthly_plan = DB::table('monthly_plans')
            ->leftJoin('users', 'users.id', 'monthly_plans.created_by')
            ->leftJoin('monthly_plan_result', 'monthly_plan_result.monthly_plan_id', 'monthly_plans.id')
            ->whereIn('monthly_plans.status_approve', [1,2,4])
            ->select(
                'users.*',
                'monthly_plan_result.*',
                'monthly_plans.*'
            );

            if(!is_null($request->selectdateFrom)){ //-- วันที่
                list($year,$month) = explode('-', $request->selectdateFrom);
                $monthly_plan = $monthly_plan->whereYear('monthly_plans.month_date',$year)
                ->whereMonth('monthly_plans.month_date', $month);
                $data['date_filter'] = $request->selectdateFrom;
            }

            if(!is_null($request->selectteam_sales)){ //-- ทีมขาย
                $team = $request->selectteam_sales;
                $monthly_plan = $monthly_plan
                    ->where(function($query) use ($team) {
                        $query->orWhere('users.team_id', $team)
                            ->orWhere('users.team_id', 'like', $team.',%')
                            ->orWhere('users.team_id', 'like', '%,'.$team);
                    });
                $data['selectteam_sales'] = $request->selectteam_sales;
            }else{
                $monthly_plan = $monthly_plan
                ->where(function($query) use ($auth_team) {
                    for ($i = 0; $i < count($auth_team); $i++){
                        $query->orWhere('users.team_id', $auth_team[$i])
                            ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                            ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                    }
                });
            }

            $monthly_plan = $monthly_plan->get();

            $data['monthly_plan'] = $monthly_plan;

            $data['team_sales'] = DB::table('master_team_sales')
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('id', $auth_team[$i])
                        ->orWhere('id', 'like', $auth_team[$i].',%')
                        ->orWhere('id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->get();


        return view('headManager.approval_saleplan', $data);
    }

    public function approvalsaleplan_detail_close($id){
        // ข้อมูล Sale plan
        $data['list_saleplan'] = DB::table('sale_plans')
            ->where('monthly_plan_id', $id)
            ->whereIn('sale_plans_status', [2, 3, 4])
            ->orderBy('id', 'desc')->get();

        // -----  API  //
        $api_token = $this->apicontroller->apiToken(); // API Login
        $data['api_token'] = $api_token;
        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $mon_plan = DB::table('monthly_plans')->where('id', $id)->first(); // ค้นหา id ผู้ขออนุมัติ
        $user_api = DB::table('users')->where('id',$mon_plan->created_by)->first(); // ค้นหา user api เพื่อใช้ดึง api

        list($year,$month,$day) = explode('-', $mon_plan->month_date);
        $month = $month + 0; //-- ทำให้เป็นตัวเลข เพื่อตัดเลข 0 ด้านหน้าออก

        $path_search = "reports/sellers/".$user_api->api_identify."/closesaleplans?years=".$year."&months=".$month;
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
        $res_api = $response->json();

        $data['saleplan_api'] = $res_api['data'];

        $data['mon_plan'] = $mon_plan;
        $data['sale_name'] = DB::table('users')->where('id',$mon_plan->created_by)->select('name')->first(); // ชื่อเซลล์


        // ลูกค้าใหม่
        $data['customer_new'] = DB::table('customer_shops_saleplan')
        ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
        ->join('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
        ->join('monthly_plans', 'monthly_plans.id', 'customer_shops_saleplan.monthly_plan_id')
        ->join('users', 'users.id', 'customer_shops.created_by')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->whereIn('customer_shops.shop_status', [0,1,2]) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->whereIn('customer_shops_saleplan.shop_aprove_status', [2, 3])
        // ->where('customer_shops.created_by', Auth::user()->id)
        ->where('customer_shops_saleplan.monthly_plan_id', $id)
        ->select(
            'users.*',
            'monthly_plans.*',
            'province.PROVINCE_NAME',
            'customer_shops.*',
            'customer_shops.id as custid',
            'customer_shops_saleplan.*',
            'master_customer_new.cust_name'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();

        return view('headManager.approval_saleplan_detail_close', $data);
    }

    public function approvalsaleplan_detail($id)
    {
        // $id คือรหัสของ monthly_plan
        // return $id;

        // ข้อมูล Sale plan
        $data['list_saleplan'] = DB::table('sale_plans')->join('master_objective_saleplans', 'sale_plans.sale_plans_objective', 'master_objective_saleplans.id')
        ->where('sale_plans.monthly_plan_id', $id)
        // ->where('sale_plans.created_by', Auth::user()->id)
        ->whereIn('sale_plans.sale_plans_status', [1, 2, 3])->select('sale_plans.*', 'master_objective_saleplans.masobj_title')
        ->orderBy('sale_plans.id', 'desc')->get();

        // -----  API Login ----------- //
        $api_token = $this->apicontroller->apiToken(); // API Login
        //--- End Api Login ------------ //
        // -----  API ลูกค้าที่ sale ดูแล ----------- //
        $mon_plan = DB::table('monthly_plans')->where('id', $id)->first(); // ค้นหา id ผู้ขออนุมัติ
        $user_api = DB::table('users')->where('id',$mon_plan->created_by)->first(); // ค้นหา user api เพื่อใช้ดึง api
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.$user_api->api_identify.'/customers');
        $res_api = $response->json();

        $data['monthly_plans'] = $mon_plan;


        $data['customer_api'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['customer_api'][$key] =
            [
                'id' => $value['identify'],
                'shop_name' => $value['title']." ".$value['name'],
                'shop_address' => $value['amphoe_name']." ".$value['province_name'],
            ];
        }

        // ลูกค้าใหม่
        $data['customer_new'] = DB::table('customer_shops_saleplan')
            ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
            ->join('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->leftjoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
            ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
            ->whereIn('customer_shops_saleplan.shop_aprove_status', [1, 2, 3])
            // ->where('customer_shops.created_by', Auth::user()->id)
            ->where('customer_shops_saleplan.monthly_plan_id', $id)
            ->select(
                'province.PROVINCE_NAME',
                'amphur.AMPHUR_NAME',
                'customer_shops.*',
                'customer_shops.id as custid',
                'customer_shops_saleplan.*',
                'master_customer_new.cust_name'
            )
            ->orderBy('customer_shops.id', 'desc')
            ->get();

        // เยี่ยมลูกค้า

        // $customer_visits = DB::table('customer_visits')
        //     ->where('monthly_plan_id', $id)
        //     ->select('customer_visits.*')
        //     ->orderBy('id', 'desc')->get();

        // $data['customer_visit_api'] = array();

        // foreach($customer_visits as $key => $cus_visit){

        //     $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/customers/'.$cus_visit->customer_shop_id);
        //     $res_visit_api = $response->json();
        //     // dd($res_visit_api);
        //     if($res_visit_api['code'] == 200){
        //         foreach ($res_visit_api['data'] as $key_api => $value_api) {
        //             $res_visit_api = $res_visit_api['data'][$key_api];
        //             $data['customer_visit_api'][] =
        //             [
        //                 'id' => $cus_visit->id,
        //                 'identify' => $res_visit_api['identify'],
        //                 'shop_name' => $res_visit_api['title']." ".$res_visit_api['name'],
        //                 'shop_address' => $res_visit_api['amphoe_name']." , ".$res_visit_api['province_name'],
        //                 'shop_phone' => $res_visit_api['telephone'],
        //                 'shop_mobile' => $res_visit_api['mobile'],
        //                 'focusdate' => $res_visit_api['focusdate'],
        //                 'monthly_plan_id' => $cus_visit->monthly_plan_id,
        //             ];
        //         }
        //     }
        // }

        $data['sale_name'] = DB::table('users')->where('id',$mon_plan->created_by)->select('name')->first(); // ชื่อเซลล์

        return view('headManager.approval_saleplan_detail', $data);
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
