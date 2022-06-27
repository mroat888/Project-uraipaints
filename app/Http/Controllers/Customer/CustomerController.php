<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\ObjectiveCustomer;
use App\CustomerVisit;
use App\ObjectiveSaleplan;
// use App\CustomerVisit;
use App\MonthlyPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiController;

// use DataTables;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['customer_shop'] = DB::table('customer_shops')
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->where('customer_shops.shop_status', 1) // 0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า , 2 = ลบ
            ->where('customer_shops.created_by', Auth::user()->id)
            ->select(
                'province.PROVINCE_NAME',
                'customer_shops.*'
            )
            ->orderBy('customer_shops.id', 'desc')
            ->get();

        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        return view('customer.customer', $data);
    }

    public function customerLead()
    {
        $sql_query = "select `monthly_plans`.*, `province`.`PROVINCE_NAME`, `customer_shops_saleplan_result`.*,
        `customer_shops_saleplan`.*, `customer_shops_saleplan`.`shop_aprove_status` as `saleplan_shop_aprove_status`,
        `customer_shops_saleplan`.`id` as `customer_shops_saleplan_id`,
        `monthly_plans`.`id` as `monthly_plans_id`,
        `customer_shops_saleplan`.`monthly_plan_id` as`saleplan_monthly_plans_id`, 
        `customer_shops`.* from `customer_shops_saleplan`
        join (select * from customer_shops group by id ) customer_shops on `customer_shops`.`id` = `customer_shops_saleplan`.`customer_shop_id`
        join `customer_shops_saleplan_result` on `customer_shops_saleplan_result`.`customer_shops_saleplan_id` = `customer_shops_saleplan`.`id`
        join `monthly_plans` on `monthly_plans`.`id` = `customer_shops_saleplan`.`monthly_plan_id`
        join `province` on `province`.`PROVINCE_ID` = `customer_shops`.`shop_province_id`
        where `customer_shops`.`shop_status` != ? and `customer_shops`.`created_by` = ? ";

        $sql_query_orderby = "order by `customer_shops_saleplan`.`id` desc,
        `customer_shops_saleplan`.`monthly_plan_id` desc";

        
        $customer_shops = $sql_query.$sql_query_orderby;
       // dd($customer_shops);
        $customer_shops = DB::select($customer_shops, [2,Auth::user()->id]);
        // dd($customer_shops);
        

        // -- นับจำนวนร้านค้า ทั้งหมด
        $data['count_customer_all'] = count($customer_shops);

        // -- นับ จำนวนร้านค้า สถานะสำเร็จ
        $sql_query_success = $sql_query." and `customer_shops`.`shop_status` = ? ".$sql_query_orderby;
        $customer_shops_success = DB::select( $sql_query_success, [2,Auth::user()->id, 1]);
        $data['count_customer_success'] = count($customer_shops_success);

        // -- นับ จำนวนร้านค้า สถานะสนใจ
        $customer_shops_result_1 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ".$sql_query_orderby;
        $customer_shops_result_1 = DB::select( $customer_shops_result_1, [2,Auth::user()->id,2]);
        $data['count_customer_result_1'] = count($customer_shops_result_1);

        // -- นับ จำนวนร้านค้า สถานะรอตัดสินใจ
        $customer_shops_result_2 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ".$sql_query_orderby;
        $customer_shops_result_2 = DB::select( $customer_shops_result_2, [2,Auth::user()->id,1]);
        $data['count_customer_result_2'] = count($customer_shops_result_2);

        // -- นับ จำนวนร้านค้า สถานะไม่สนใจ
        $customer_shops_result_3 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ".$sql_query_orderby;
        $customer_shops_result_3 = DB::select( $customer_shops_result_3, [2,Auth::user()->id,0]);
        $data['count_customer_result_3'] = count($customer_shops_result_3);

        $data['customer_shops'] = $customer_shops;
        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();


        return view('customer.lead', $data);
    }

    public function customerLeadSearch(Request $request){

        $data['count_customer_all'] = $request->count_customer_all;
        $data['count_customer_success'] = $request->count_customer_success;
        $data['count_customer_result_1'] = $request->count_customer_result_1;
        $data['count_customer_result_2'] = $request->count_customer_result_2;
        $data['count_customer_result_3'] = $request->count_customer_result_3;

        $sql_query = "select `monthly_plans`.*, `province`.`PROVINCE_NAME`, `customer_shops_saleplan_result`.*,
        `customer_shops_saleplan`.*, `customer_shops_saleplan`.`shop_aprove_status` as `saleplan_shop_aprove_status`,
        `customer_shops_saleplan`.`id` as `customer_shops_saleplan_id`,
        `monthly_plans`.`id` as `monthly_plans_id`,
        `customer_shops`.* from `customer_shops_saleplan`
        left join `customer_shops` on `customer_shops`.`id` = `customer_shops_saleplan`.`customer_shop_id`
        left join `customer_shops_saleplan_result` on `customer_shops_saleplan_result`.`customer_shops_saleplan_id` = `customer_shops_saleplan`.`id`
        left join `monthly_plans` on `monthly_plans`.`id` = `customer_shops_saleplan`.`monthly_plan_id`
        left join `province` on `province`.`PROVINCE_ID` = `customer_shops`.`shop_province_id`
        where `customer_shops`.`shop_status` != ? and `customer_shops`.`created_by` = ? ";

        $sql_query_orderby = "order by `customer_shops_saleplan`.`id` desc,
        `customer_shops_saleplan`.`monthly_plan_id` desc";

        $parameter = [2,Auth::user()->id];

        if(!is_null($request->selectdateFrom)){
            list($year,$month) = explode('-', $request->selectdateFrom);
            $sql_query = $sql_query." and `monthly_plans`.`month_date` LIKE ?
            and `monthly_plans`.`month_date` LIKE ? ";
            $parameter[] = $year.'%';
            $parameter[] = '%'.$month.'%';
            $data['date_filter'] = $request->selectdateFrom;

            // -- นับ จำนวนร้านค้า ทั้งหมด
            $parameter_count_customer_all = $parameter;
            $count_customer_all = $sql_query;
            $count_customer_all = DB::select( $count_customer_all, $parameter_count_customer_all);
            $data['count_customer_all'] = count($count_customer_all);

            // -- นับ จำนวนร้านค้า สถานะสำเร็จ
            $parameter_count_customer_success = $parameter;
            $count_customer_success = $sql_query." and `customer_shops`.`shop_status` = ? ";
            $parameter_count_customer_success[] = 1 ;
            $count_customer_success = DB::select( $count_customer_success, $parameter_count_customer_success);
            $data['count_customer_success'] = count($count_customer_success);

            // -- นับ จำนวนร้านค้า สถานะสนใจ
            $parameter_count_customer_result_1 = $parameter;
            $count_customer_result_1 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
            $parameter_count_customer_result_1[] = 2 ;
            $count_customer_result_1 = DB::select( $count_customer_result_1, $parameter_count_customer_result_1);
            $data['count_customer_result_1'] = count($count_customer_result_1);

           // -- นับ จำนวนร้านค้า สถานะรอตัดสินใจ
           $parameter_count_customer_result_2 = $parameter;
           $count_customer_result_2 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
           $parameter_count_customer_result_2[] = 1 ;
           $count_customer_result_2 = DB::select( $count_customer_result_2, $parameter_count_customer_result_2);
           $data['count_customer_result_2'] = count($count_customer_result_2);

           // -- นับ จำนวนร้านค้า สถานะไม่สนใจ
           $parameter_count_customer_result_3 = $parameter;
           $count_customer_result_3 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
           $parameter_count_customer_result_3[] = 0 ;
           $count_customer_result_3 = DB::select( $count_customer_result_3, $parameter_count_customer_result_3);
           $data['count_customer_result_3'] = count($count_customer_result_3);
        }

        if(!is_null($request->slugradio)){
            if($request->slugradio == "สำเร็จ"){
                $sql_query = $sql_query." and `customer_shops`.`shop_status` = ? ";
                $parameter[] = 1 ;
            }elseif($request->slugradio  == "สนใจ"){
                $sql_query = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
                $parameter[] = 2 ;
            }elseif($request->slugradio  == "รอตัดสินใจ"){
                $sql_query = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
                $parameter[] = 1 ;
            }elseif($request->slugradio  == "ไม่สนใจ"){
                $sql_query = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ";
                $parameter[] = 0 ;
            }
            $data['slugradio_filter'] = $request->slugradio;
        }

        $sql_query = $sql_query.$sql_query_orderby;
        $customer_shops = DB::select( $sql_query, $parameter);
        $data['customer_shops'] = $customer_shops;

        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        return view('customer.lead', $data);
    }

    public function store(Request $request)
    {
        // -- หา ID ของ MonthlyPlan
        if($request->is_monthly_plan == 'N'){ // นอกแผนงาน ทำในระบบ ลูกค้าใหม่ตรงๆ
            list($year,$month,$day) = explode('-',date('Y-m-d'));
            $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)
            ->whereYear('month_date', '=', $year)
            ->whereMonth('month_date', '=', $month)
            ->orderBy('month_date', 'desc')
            ->first();
            $shop_aprove_status = "1";
        }else{ // ในแผนงาน ทำในระบบ แผนงานประจำเดือน
            $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();
            $shop_aprove_status = "0";
        }

        // dd($monthly_plan);

        DB::beginTransaction();
        try {
            if($request->customer_shops_id != ""){ // ถ้ามีการค้นหาร้านค้าที่มีในระบบ

                // $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();
                //-- เพิ่ม monthly_plans
                DB::table('monthly_plans')->where('id', $monthly_plan->id)
                    ->update([
                        'cust_new_amount' => $monthly_plan->cust_new_amount+1,
                        'total_plan' => $monthly_plan->total_plan+1,
                        'outstanding_plan' => ($monthly_plan->total_plan + 1) - $monthly_plan->success_plan,
                    ]);

                // //-- เพิ่ม customer_shops_saleplan
                DB::table('customer_shops_saleplan')
                    ->insert([
                        'customer_shop_id' => $request->customer_shops_id,
                        'customer_shop_objective' => $request->customer_shop_objective,
                        'shop_aprove_status' => $shop_aprove_status,
                        'is_monthly_plan' => $request->is_monthly_plan,
                        'monthly_plan_id' => $monthly_plan->id,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                        'request_approve_at' => Carbon::now(),
                    ]);

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                    'data' => $request,
                ]);

            }else{ // ถ้าไม่มีให้เพิ่มร้านค้าเข้าไปใหม่

                $path = 'upload/CustomerImage';
                $image = '';
                $pathFle = 'upload/CustomerFile';
                $uploadfile = '';

                DB::table('customer_shops')
                ->insert([
                    'monthly_plan_id'     => $monthly_plan->id,
                    'shop_name'           => $request->shop_name,
                    'shop_address'        => $request->shop_address,
                    'shop_province_id'    => $request->province,
                    'shop_amphur_id'      => $request->amphur,
                    'shop_district_id'    => $request->district,
                    'shop_zipcode'        => $request->shop_zipcode,
                    'shop_profile_image'  => $image,
                    'shop_fileupload'     => $uploadfile,
                    'shop_status'         => 0,
                    'shop_saleplan_date'  => Carbon::now()->addMonth(1),
                    'created_by'          => Auth::user()->id,
                    'created_at'          => Carbon::now(),
                ]);

                $sql_shops = DB::table('customer_shops')->orderBy('customer_shops.id', 'desc')->first();

                DB::table('customer_contacts')
                    ->insert([
                        'customer_shop_id' => $sql_shops->id,
                        'customer_contact_name' => $request->contact_name,
                        'customer_contact_phone' => $request->shop_phone,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                    ]);

                //-- เพิ่ม monthly_plans
                DB::table('monthly_plans')->where('id', $monthly_plan->id)
                    ->update([
                        'cust_new_amount' => $monthly_plan->cust_new_amount+1,
                        'total_plan' => $monthly_plan->total_plan+1,
                        'outstanding_plan' => ($monthly_plan->total_plan + 1) - $monthly_plan->success_plan,
                    ]);

                // //-- เพิ่ม customer_shops_saleplan
                DB::table('customer_shops_saleplan')
                    ->insert([
                        'customer_shop_id' => $sql_shops->id,
                        'customer_shop_objective' => $request->customer_shop_objective,
                        'shop_aprove_status' => $shop_aprove_status,
                        'is_monthly_plan' => $request->is_monthly_plan,
                        'monthly_plan_id' => $monthly_plan->id,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                        'request_approve_at' => Carbon::now(),
                    ]);

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                    'data' => $request,
                ]);
            }

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
                'data' => $request,
            ]);
        }


    }

    public function edit($id)
    {
        $dataEdit = DB::table('customer_shops')->where('id', $id)->first();

        $customer_contacts = DB::table('customer_contacts')
            ->where('customer_shop_id', $dataEdit->id)
            ->orderBy('id', 'desc')
            ->first();

        $shop_province = DB::table('province')->get();

        $shop_amphur = DB::table('amphur')
            ->where('PROVINCE_ID', $dataEdit->shop_province_id)
            ->get();

        $shop_district = DB::table('district')
            ->where('AMPHUR_ID', $dataEdit->shop_amphur_id)
            ->get();

        $master_customer_new = DB::table('master_customer_new')->orderBy('id','asc')->get();

        return response()->json([
            'status' => 200,
            'dataEdit' => $dataEdit,
            'customer_contacts' => $customer_contacts,
            'shop_province' => $shop_province,
            'shop_amphur' => $shop_amphur,
            'shop_district' => $shop_district,
            'master_customer_new' => $master_customer_new,
        ]);
    }

    public function update(Request $request)
    {
        //dd($request);
        //$base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
        $path = 'upload/CustomerImage';
        $image = '';
        $pathFile = 'upload/CustomerFile';
        $uploadfile = '';

        if ($request->edit_image != '') {
            if (!empty($request->file('edit_image'))) {

                $data = Customer::find($request->edit_shop_id);

                //ลบรูปเก่า (เพื่ออัพโหลดรูปใหม่แทน)
                if (!empty($data->shop_profile_image)) {
                    $path2 = 'upload/CustomerImage/';
                    unlink(public_path($path2 . $data->shop_profile_image));
                }

                $img = $request->file('edit_image');
                $img_name = 'stores-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }
        }

        if ($request->edit_shop_fileupload != '') {
            if (!empty($request->file('edit_shop_fileupload'))) {

                $datafile = Customer::find($request->edit_shop_id);

                //ลบไฟล์เก่าเพื่ออัพโหลดไฟล์ใหม่แทน
                if (!empty($datafile->shop_fileupload)) {
                    $pathFile2 = 'upload/CustomerFile/';
                    unlink(public_path($pathFile2 . $datafile->shop_fileupload));
                }

                $uploadF = $request->file('edit_shop_fileupload');
                $file_name = 'file-' . time() . '.' . $uploadF->getClientOriginalExtension();
                $save_path2 = $uploadF->move(public_path($pathFile), $file_name);
                $uploadfile = $file_name;
            }
        }


        if ($image != '' && $uploadfile != '') {

            DB::beginTransaction();
            try {
                $data2 = Customer::find($request->edit_shop_id);
                $data2->shop_name           = $request->edit_shop_name;
                $data2->shop_address        = $request->edit_shop_address;
                $data2->shop_province_id    = $request->edit_province;
                $data2->shop_amphur_id      = $request->edit_amphur;
                $data2->shop_district_id    = $request->edit_district;
                $data2->shop_zipcode        = $request->edit_shop_zipcode;
                $data2->shop_profile_image  = $image;
                $data2->shop_fileupload     = $uploadfile;
                $data2->updated_by          = Auth::user()->id;
                $data2->updated_at          = Carbon::now();
                $data2->update();

                DB::table('customer_contacts')
                    ->where('id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_contact_name' => $request->edit_contact_name,
                        'customer_contact_phone' => $request->edit_customer_contact_phone,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } elseif ($image != '' && $uploadfile == '') {
            DB::beginTransaction();
            try {
                $data2 = Customer::find($request->edit_shop_id);
                $data2->shop_name           = $request->edit_shop_name;
                $data2->shop_address        = $request->edit_shop_address;
                $data2->shop_province_id    = $request->edit_province;
                $data2->shop_amphur_id      = $request->edit_amphur;
                $data2->shop_district_id    = $request->edit_district;
                $data2->shop_zipcode        = $request->edit_shop_zipcode;
                $data2->shop_profile_image  = $image;
                $data2->updated_by          = Auth::user()->id;
                $data2->updated_at          = Carbon::now();
                $data2->update();

                DB::table('customer_contacts')
                    ->where('id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_contact_name' => $request->edit_contact_name,
                        'customer_contact_phone' => $request->edit_customer_contact_phone,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } elseif ($image == '' && $uploadfile != '') {
            DB::beginTransaction();
            try {
                $data2 = Customer::find($request->edit_shop_id);
                $data2->shop_name           = $request->edit_shop_name;
                $data2->shop_address        = $request->edit_shop_address;
                $data2->shop_province_id    = $request->edit_province;
                $data2->shop_amphur_id      = $request->edit_amphur;
                $data2->shop_district_id    = $request->edit_district;
                $data2->shop_zipcode        = $request->edit_shop_zipcode;
                $data2->shop_fileupload     = $uploadfile;
                $data2->updated_by          = Auth::user()->id;
                $data2->updated_at          = Carbon::now();
                $data2->update();

                DB::table('customer_contacts')
                    ->where('id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_contact_name' => $request->edit_contact_name,
                        'customer_contact_phone' => $request->edit_customer_contact_phone,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            DB::beginTransaction();
            try {
                $data2 = Customer::find($request->edit_shop_id);
                $data2->shop_name           = $request->edit_shop_name;
                $data2->shop_address        = $request->edit_shop_address;
                $data2->shop_province_id    = $request->edit_province;
                $data2->shop_amphur_id      = $request->edit_amphur;
                $data2->shop_district_id    = $request->edit_district;
                $data2->shop_zipcode        = $request->edit_shop_zipcode;
                $data2->updated_by          = Auth::user()->id;
                $data2->updated_at          = Carbon::now();
                $data2->update();

                DB::table('customer_contacts')
                    ->where('id', $request->edit_cus_contacts_id)
                    ->update([
                        'customer_contact_name' => $request->edit_contact_name,
                        'customer_contact_phone' => $request->edit_customer_contact_phone,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        //echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='lead'; </script>");

        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'data' => $request,
        ]);
    }

    public function show_customer($id)
    {
        // dd($id);

        $data['customer_shops'] = DB::table('customer_shops')
            ->where('id', $id)
            ->first();

        $data['customer_contacts'] = DB::table('customer_contacts')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('id', 'desc')
            ->first();

        $data['customer_history_contacts'] = DB::table('customer_history_contacts')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('id', 'desc')
            ->get();

        $data['customer_shops_saleplan'] = DB::table('customer_shops_saleplan')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('monthly_plan_id', 'desc')
            ->get();

        return view('customer.customer_detail', $data);
    }

    public function show_lead($id)
    {
        // dd($id);

        $data['customer_shops'] = DB::table('customer_shops')
            ->where('id', $id)
            ->first();

        $data['customer_contacts'] = DB::table('customer_contacts')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('id', 'desc')
            ->first();

        $data['customer_history_contacts'] = DB::table('customer_history_contacts')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('id', 'desc')
            ->get();

        $data['customer_shops_saleplan'] = DB::table('customer_shops_saleplan')
            ->where('customer_shop_id', $data['customer_shops']->id)
            ->orderBy('monthly_plan_id', 'asc')
            ->get();

        // $data['customer_shops_saleplan'] = DB::table('customer_shops_saleplan')
        //     ->leftJoin('customer_shop_comments' ,'customer_shop_comments.customer_shops_saleplan_id', 'customer_shops_saleplan.id')
        //     ->leftJoin('customer_shops_saleplan_result', 'customer_shops_saleplan_result.customer_shops_saleplan_id', 'customer_shops_saleplan.id')
        //     ->where('customer_shops_saleplan.customer_shop_id', $data['customer_shops']->id)
        //     ->orderBy('customer_shops_saleplan.monthly_plan_id', 'desc')
        //     ->get();
        // dd($data['customer_shops_saleplan']);

        return view('customer.customer_lead_detail', $data);
    }

    public function lead_to_customer(Request $request)
    {

        DB::beginTransaction();
        try {

            DB::table('customer_shops')
                ->where('id', $request->shop_id)
                ->update([
                    'shop_status' => '1',
                    'updated_by' => Auth::user()->id,
                    'shop_status_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'อัพเดทสถานะสำเร็จ',
        ]);
    }

    public function customer_delete(Request $request)
    {

        DB::beginTransaction();
        try {

            DB::table('customer_shops')
                ->where('id', $request->shop_id_delete)
                ->update([
                    'shop_status' => '3',
                    'deleted_by' => Auth::user()->id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);

            $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

            DB::table('monthly_plans')->where('id', $monthly_plan->id)
            ->update([
                'cust_new_amount' => $monthly_plan->cust_new_amount-1,
                'total_plan' => $monthly_plan->total_plan-1,
                'outstanding_plan' => $monthly_plan->total_plan-1,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลลูกค้าเรียบร้อยแล้ว',
        ]);
    }

    public function customer_shops_saleplan_delete(Request $request){

        DB::beginTransaction();
        try {

            DB::table('customer_shops_saleplan')
                ->where('id', $request->shop_id_delete)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลลูกค้าเรียบร้อยแล้ว',
        ]);

    }


    public function destroy(Request $request)
    {
        // DB::table('customer_shops')
        //     ->where('id', $request->id)
        //     ->update([
        //         'shop_status' => '3',
        //         'deleted_by' => Auth::user()->id,
        //         'deleted_at' => date('Y-m-d H:i:s'),
        //     ]);

        //     $monthly_plan = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

        //     DB::table('monthly_plans')->where('id', $monthly_plan->id)
        //     ->update([
        //         'cust_new_amount' => $monthly_plan->cust_new_amount-1,
        //         'total_plan' => $monthly_plan->total_plan-1,
        //         'outstanding_plan' => $monthly_plan->total_plan-1,
        //     ]);
        // DB::commit();
        // // return back();
        // echo ("<script>alert('ลบข้อมูลสำเร็จ'); location.href='planMonth'; </script>");
    }

    public function fetch_autocomplete()
    {
        $term = Input::get('term');
        $results = array();
        dd($term);
        $query = DB::table('customer_shops')
            ->where('shop_name', 'LIKE', '%' . $term . '%')
            ->get();
        return Response::json($results);
    }

    public function customer_new_checkin(Request $request)
    { // เช็คอิน-เช็คเอ้าท์
       // dd($request);
        DB::beginTransaction();
        try {

            if($request->lat != "" && $request->lon != ""){

                $chk_status = DB::table('customer_shops_saleplan_result')->where('customer_shops_saleplan_id', $request->id)->first();
                // dd($request->id, $chk_status);
                if ($chk_status) {
                    DB::table('customer_shops_saleplan_result')->where('customer_shops_saleplan_id', $request->id)
                    ->update([
                        'cust_result_checkout_date' => Carbon::now(),
                        'cust_result_checkout_latitude' => $request->lat,
                        'cust_result_checkout_longitude' => $request->lon,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => Carbon::now(),
                    ]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'เช็คเอาท์สำเร็จ',
                    ]);
                }else{
                    DB::table('customer_shops_saleplan_result')
                        ->insert([
                            'customer_shops_saleplan_id' => $request->id,
                            'cust_result_checkin_date' => Carbon::now(),
                            'cust_result_checkin_latitude' => $request->lat,
                            'cust_result_checkin_longitude' => $request->lon,
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                        ]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'เช็คอินสำเร็จ',
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'กรุณาเปิดหรือรอ location ก่อนค่ะ',
                ]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // return back();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกได้',
                'data' => $request->id,
            ]);
        }
    }

    public function customer_new_result_get($id)
    {

        $cus_result = DB::table('customer_shops_saleplan')
        ->leftjoin('customer_shops', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
        ->leftjoin('customer_contacts', 'customer_shops.id', 'customer_contacts.customer_shop_id')
        ->leftjoin('customer_shops_saleplan_result', 'customer_shops_saleplan.id', 'customer_shops_saleplan_result.customer_shops_saleplan_id')
        ->leftjoin('master_customer_new', 'customer_shops_saleplan.customer_shop_objective', 'master_customer_new.id')
        ->leftjoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->leftjoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        ->where('customer_shops_saleplan.id', $id)
        ->select(
        'customer_shops_saleplan_result.id as resultID',
        'customer_shops_saleplan_result.cust_result_status',
        'customer_shops_saleplan.id',
        'customer_shops.shop_name',
        'customer_shops.id as shop_id',
        'customer_contacts.customer_contact_name',
        'amphur.AMPHUR_NAME',
        'province.PROVINCE_NAME',
        'master_customer_new.cust_name'
        )->first();

         $api_token = $this->api_token->apiToken();
         $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.Auth::user()->api_identify.'/customers');
         $res_api = $response->json();

        // $customer_api = array();
        foreach ($res_api['data'] as $key => $value) {
            if ($id == $value['identify']) {
                $cust_new_address = $value['amphoe_name']." , ".$value['province_name'];
                $cust_new_name = $value['title']." ".$value['name'];
            }else{
                $cust_new_name = '';
                $cust_new_address = $cus_result->AMPHUR_NAME.", ".$cus_result->PROVINCE_NAME;
            }

        }

        if(!is_null($cus_result)){
            return response()->json([
                'status' => 200,
                'dataResult' => $cus_result,
                'cust_new_name' => $cust_new_name,
                'cust_new_address' => $cust_new_address,
                'id' => $id
            ]);
        }

    }

    public function customer_new_Result(Request $request)
    { // สรุปผลลัพธ์
        // dd($request);
        DB::beginTransaction();
        try {
            if($request->shop_result_status != ""){

                $data = DB::table('customer_shops_saleplan_result')->where('id', $request->cust_result_id)->first();
                if ($data != '') {
                    DB::table('customer_shops_saleplan_result')->where('id', $request->cust_result_id)
                ->update([
                    'cust_result_detail' => $request->shop_result_detail,
                    'cust_result_status' => $request->shop_result_status,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now()
                ]);
                }else{
                    DB::table('customer_shops_saleplan_result')->insert([
                    'customer_shops_saleplan_id' => $request->saleplan_id,
                    'cust_result_detail' => $request->shop_result_detail,
                    'cust_result_status' => $request->shop_result_status,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                }

                // $cust_shops_saleplan_result = DB::table('customer_shops_saleplan_result')->where('id', $request->cust_result_id)->first();
                $cust_shops_saleplan = DB::table('customer_shops_saleplan')->where('id', $request->saleplan_id)->first();
                $customer_name = DB::table('customer_shops')->where('id', $cust_shops_saleplan->customer_shop_id)->first();

                $events = DB::table('events')->where('customer_shops_saleplan_id', $cust_shops_saleplan->id)->first();

                // dd($customer_name->shop_name);

                if(is_null($events)){
                    DB::table('events')
                    ->insert([
                        'title' => $customer_name->shop_name,
                        'start' => Carbon::now(),
                        'end' => Carbon::now(),
                        'customer_shops_saleplan_id' => $cust_shops_saleplan->id,
                        'created_by' => Auth::user()->id
                    ]);
                }

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                ]);

            }else{

                return response()->json([
                    'status' => 404,
                    'message' => 'กรุณาเลือกสรุปผลลัพธ์ด้วยค่ะ',
                ]);

            }

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกได้',
            ]);

        }

    }
    public function fetch_customer_shops(){

    }

    public function fetch_customer_shops_byid($id){

        DB::beginTransaction();
        try {
            $customer_shops = DB::table('customer_shops')->where('id', $id)->first();
            $province_name = "";
            $amphur_name = "";
            $district_name = "";

            if(!is_null($customer_shops->shop_province_id)){
                $province = DB::table('province')->where('PROVINCE_ID',$customer_shops->shop_province_id)->first();
                $province_name = $province->PROVINCE_NAME;
            }

            if(!is_null($customer_shops->shop_amphur_id)){
                $amphur = DB::table('amphur')->where('AMPHUR_ID',$customer_shops->shop_amphur_id)->first();
                $amphur_name = $amphur->AMPHUR_NAME;
            }

            if(!is_null($customer_shops->shop_district_id)){
                $district = DB::table('district')->where('DISTRICT_ID',$customer_shops->shop_district_id)->first();
                $district_name = $district->DISTRICT_NAME;
            }

            $customer_contacts = DB::table('customer_contacts')
                ->where('customer_shop_id', $customer_shops->id)
                ->where('is_active', 'Y')
                ->orderBy('id', 'desc')
                ->first();

            if(!is_null($customer_shops)){
                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                    'customer_shops' => $customer_shops,
                    'province_name' => $province_name,
                    'amphur_name' => $amphur_name,
                    'district_name' => $district_name,
                    'customer_contacts' => $customer_contacts,
                ]);
            }
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกได้',
            ]);

        }

    }


}
