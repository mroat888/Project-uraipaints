<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChangeCustomerController extends Controller
{

    public function index()
    {
        $request = "";
        $data = $this->fetch_customer_lead($request);

        $data['users'] = DB::table('users')->get();
        $data['team_sales'] = DB::table('master_team_sales')->get();

        return view('admin.change_customer_status', $data);
    }

    public function customerLeadSearch(Request $request)
    {
        if(!is_null($request->selectdateFrom)){
            $data = $this->fetch_customer_lead($request);
        }elseif(!is_null($request->slugradio)){
            $data = $this->fetch_customer_lead($request);
            if($request->slugradio == "สำเร็จ"){
                if(isset($data['customer_shops_success_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_success_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }elseif($request->slugradio  == "สนใจ"){
                if(isset($data['customer_shops_result_1_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_result_1_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }elseif($request->slugradio  == "รอตัดสินใจ"){
                if(isset($data['customer_shops_result_2_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_result_2_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }elseif($request->slugradio  == "ไม่สนใจ"){
                if(isset($data['customer_shops_result_3_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_result_3_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }elseif($request->slugradio  == "รอดำเนินการ"){
                if(isset($data['customer_shops_pending_table'])){
                    $data['customer_shops_table'] = $data['customer_shops_pending_table'];
                }else{
                    $data['customer_shops_table'] = null;
                }
            }
        }else{
            $request = "";
            $data = $this->fetch_customer_lead($request);
        }
        
        // $data['count_customer_all'] = $request->count_customer_all;
        // $data['count_customer_success'] = $request->count_customer_success;
        // $data['count_customer_result_1'] = $request->count_customer_result_1;
        // $data['count_customer_result_2'] = $request->count_customer_result_2;
        // $data['count_customer_result_3'] = $request->count_customer_result_3;
        // $data['count_customer_pending'] = $request->count_customer_pending;
        

        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();


        $data['users'] = DB::table('users')->get();
        $data['team_sales'] = DB::table('master_team_sales')->get();

        return view('admin.change_customer_status', $data);

    }

    public function fetch_customer_lead($request)
    {
        $customer_shops = DB::table('customer_shops')
            ->select(
                'customer_shops.*',
                'users.name as shop_create_by',
                'customer_shops.created_at as shop_create_at',
                'province.PROVINCE_NAME'
            )
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->join('users', 'users.id', 'customer_shops.created_by')
            ->where('customer_shops.shop_status', '!=' ,2); // ไม่อยู่ในสถานะลบ
        
            if(!empty($request)){
                if(!is_null($request->selectdateFrom)){
                    list($year, $month) = explode('-', $request->selectdateFrom);
                    $customer_shops = $customer_shops
                        ->whereMonth('customer_shops.created_at', $month)
                        ->whereYear('customer_shops.created_at', $year);
                }
            }

        $customer_shops = $customer_shops->orderby('customer_shops.id', 'desc')->get();

        // -- นับจำนวนร้านค้า ทั้งหมด
        $data['count_customer_all'] = count($customer_shops);
    
        $data['count_customer_success'] = 0;
        $data['count_customer_result_1'] = 0;
        $data['count_customer_result_2'] = 0;

        $data['count_customer_result_3'] = 0;
        $data['count_customer_pending'] = 0;

        //-- นับจำนวนสถานะต่างๆ
        foreach($customer_shops as $key => $value){

            $customer_shops_saleplan = DB::table('customer_shops_saleplan')
                ->select(
                    'customer_shops_saleplan.*', 
                    'customer_shops_saleplan.shop_aprove_status as saleplan_shop_aprove_status',
                    'monthly_plans.id as monthly_plans_id',
                    'monthly_plans.month_date',
                    'customer_shops_saleplan_result.id as result_id',
                    'customer_shops_saleplan_result.cust_result_status as cust_result_status'
                )
                ->leftJoin('customer_shops_saleplan_result', 'customer_shops_saleplan_result.customer_shops_saleplan_id', 'customer_shops_saleplan.id')
                ->join('monthly_plans', 'monthly_plans.id', 'customer_shops_saleplan.monthly_plan_id')
                ->whereIn('customer_shops_saleplan.shop_aprove_status', [2,3])
                ->where('customer_shops_saleplan.customer_shop_id', $value->id)
                ->orderby('customer_shops_saleplan.id', 'desc')
                ->first();
  
                if(!is_null($customer_shops_saleplan)){
                    // $data['count_customer_all']++;
                    $data['customer_shops_table'][] = [
                        'id' => $value->id,
                        'shop_name' => $value->shop_name,
                        'PROVINCE_NAME' => $value->PROVINCE_NAME,
                        'shop_profile_image' => $value->shop_profile_image,
                        'shops_saleplan_id' => $customer_shops_saleplan->id,
                        'monthly_plans_id' => $customer_shops_saleplan->monthly_plans_id,
                        'month_date' => $customer_shops_saleplan->month_date,
                        'result_id' => $customer_shops_saleplan->result_id,
                        'shop_status' => $value->shop_status,
                        'cust_result_status' => $customer_shops_saleplan->cust_result_status,
                        'approve_at' => $customer_shops_saleplan->approve_at,
                        'saleplan_shop_aprove_status' => $customer_shops_saleplan->saleplan_shop_aprove_status,
                        'shop_create_by' => $value->shop_create_by,
                        'shop_create_at' => $value->shop_create_at,
                    ];
                    if($value->shop_status == 1){
                        $data['count_customer_success']++;
                        $data['customer_shops_success_table'][] = [
                            'id' => $value->id,
                            'shop_name' => $value->shop_name,
                            'PROVINCE_NAME' => $value->PROVINCE_NAME,
                            'shop_profile_image' => $value->shop_profile_image,
                            'shops_saleplan_id' => $customer_shops_saleplan->id,
                            'monthly_plans_id' => $customer_shops_saleplan->monthly_plans_id,
                            'month_date' => $customer_shops_saleplan->month_date,
                            'result_id' => $customer_shops_saleplan->result_id,
                            'shop_status' => $value->shop_status,
                            'cust_result_status' => $customer_shops_saleplan->cust_result_status,
                            'approve_at' => $customer_shops_saleplan->approve_at,
                            'saleplan_shop_aprove_status' => $customer_shops_saleplan->saleplan_shop_aprove_status,
                            'shop_create_by' => $value->shop_create_by,
                            'shop_create_at' => $value->shop_create_at,
                        ];
                    }else{
                      
                        // if(isset($customer_shops_saleplan->cust_result_status)){
                            // dd($customer_shops_saleplan->cust_result_status);
                            if(!is_null($customer_shops_saleplan->cust_result_status)){
                                if($customer_shops_saleplan->cust_result_status == 2){ /*  สนใจ	 */
                                    $data['count_customer_result_1']++;
                                    $data['customer_shops_result_1_table'][] = [
                                        'id' => $value->id,
                                        'shop_name' => $value->shop_name,
                                        'PROVINCE_NAME' => $value->PROVINCE_NAME,
                                        'shop_profile_image' => $value->shop_profile_image,
                                        'shops_saleplan_id' => $customer_shops_saleplan->id,
                                        'monthly_plans_id' => $customer_shops_saleplan->monthly_plans_id,
                                        'month_date' => $customer_shops_saleplan->month_date,
                                        'result_id' => $customer_shops_saleplan->result_id,
                                        'shop_status' => $value->shop_status,
                                        'cust_result_status' => $customer_shops_saleplan->cust_result_status,
                                        'approve_at' => $customer_shops_saleplan->approve_at,
                                        'saleplan_shop_aprove_status' => $customer_shops_saleplan->saleplan_shop_aprove_status,
                                        'shop_create_by' => $value->shop_create_by,
                                        'shop_create_at' => $value->shop_create_at,
                                    ];
                                }elseif($customer_shops_saleplan->cust_result_status == 1){ /* รอตัดสินใจ */
                                    $data['count_customer_result_2']++;
                                    $data['customer_shops_result_2_table'][] = [
                                        'id' => $value->id,
                                        'shop_name' => $value->shop_name,
                                        'PROVINCE_NAME' => $value->PROVINCE_NAME,
                                        'shop_profile_image' => $value->shop_profile_image,
                                        'shops_saleplan_id' => $customer_shops_saleplan->id,
                                        'monthly_plans_id' => $customer_shops_saleplan->monthly_plans_id,
                                        'month_date' => $customer_shops_saleplan->month_date,
                                        'result_id' => $customer_shops_saleplan->result_id,
                                        'shop_status' => $value->shop_status,
                                        'cust_result_status' => $customer_shops_saleplan->cust_result_status,
                                        'approve_at' => $customer_shops_saleplan->approve_at,
                                        'saleplan_shop_aprove_status' => $customer_shops_saleplan->saleplan_shop_aprove_status,
                                        'shop_create_by' => $value->shop_create_by,
                                        'shop_create_at' => $value->shop_create_at,
                                    ];
                                }elseif($customer_shops_saleplan->cust_result_status == 0){ /* ไม่สนใจ */
                                    $data['count_customer_result_3']++;
                                    $data['customer_shops_result_3_table'][] = [
                                        'id' => $value->id,
                                        'shop_name' => $value->shop_name,
                                        'PROVINCE_NAME' => $value->PROVINCE_NAME,
                                        'shop_profile_image' => $value->shop_profile_image,
                                        'shops_saleplan_id' => $customer_shops_saleplan->id,
                                        'monthly_plans_id' => $customer_shops_saleplan->monthly_plans_id,
                                        'month_date' => $customer_shops_saleplan->month_date,
                                        'result_id' => $customer_shops_saleplan->result_id,
                                        'shop_status' => $value->shop_status,
                                        'cust_result_status' => $customer_shops_saleplan->cust_result_status,
                                        'approve_at' => $customer_shops_saleplan->approve_at,
                                        'saleplan_shop_aprove_status' => $customer_shops_saleplan->saleplan_shop_aprove_status,
                                        'shop_create_by' => $value->shop_create_by,
                                        'shop_create_at' => $value->shop_create_at,
                                    ];
                                }
                            }else{
                                $data['count_customer_pending']++; /* รอดำเนินการ */
                                $data['customer_shops_pending_table'][] = [
                                    'id' => $value->id,
                                    'shop_name' => $value->shop_name,
                                    'PROVINCE_NAME' => $value->PROVINCE_NAME,
                                    'shop_profile_image' => $value->shop_profile_image,
                                    'shops_saleplan_id' => $customer_shops_saleplan->id,
                                    'monthly_plans_id' => $customer_shops_saleplan->monthly_plans_id,
                                    'month_date' => $customer_shops_saleplan->month_date,
                                    'result_id' => $customer_shops_saleplan->result_id,
                                    'shop_status' => $value->shop_status,
                                    'cust_result_status' => $customer_shops_saleplan->cust_result_status,
                                    'approve_at' => $customer_shops_saleplan->approve_at,
                                    'saleplan_shop_aprove_status' => $customer_shops_saleplan->saleplan_shop_aprove_status,
                                    'shop_create_by' => $value->shop_create_by,
                                    'shop_create_at' => $value->shop_create_at,
                                ];
                            }
                        //}
                    }
                }else{
                    $data['count_customer_pending']++; /* รอดำเนินการ */
                    $data['customer_shops_pending_table'][] = [
                        'id' => $value->id,
                        'shop_name' => $value->shop_name,
                        'PROVINCE_NAME' => $value->PROVINCE_NAME,
                        'shop_profile_image' => $value->shop_profile_image,
                        'shops_saleplan_id' => '',
                        'monthly_plans_id' => '',
                        'month_date' => '',
                        'result_id' => '',
                        'shop_status' => $value->shop_status,
                        'cust_result_status' => '',
                        'cust_result_status' => '',
                        'approve_at' => '',
                        'saleplan_shop_aprove_status' => '',
                        
                    ];
                }
            

        }
        //-- จบ นับจำนวนสถานะต่างๆ

        //-- ใช้ในส่วน Insert ดึงทะเบียนลูกค้า
        $data['customer_shops'] = DB::table('customer_shops')
            ->select(
                'customer_shops.*',
                'province.PROVINCE_NAME'
            )
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->where('customer_shops.shop_status', '=' ,0) //-- ลูกค้าใหม่ยังไม่ได้เปลี่ยนเป็นทะเบียนลูกค้า
            ->where('customer_shops.created_by',Auth::user()->id)
            ->orderby('customer_shops.id', 'desc')
            ->get();

        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        return $data;

    }


    public function show($id){
        $dataCustomer = DB::table('customer_shops_saleplan')
        ->leftjoin('customer_shops', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
        ->leftjoin('customer_contacts', 'customer_shops.id', 'customer_contacts.customer_shop_id')
        ->leftjoin('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        ->leftjoin('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->leftjoin('district', 'district.DISTRICT_ID', 'customer_shops.shop_district_id')
        ->where('customer_shops.id', $id)
        ->select('customer_shops.*',
        'customer_contacts.customer_contact_name',
        'customer_contacts.customer_contact_phone',
        'province.PROVINCE_NAME as province',
        'amphur.AMPHUR_NAME as amphur',
        'district.DISTRICT_NAME as district')
        ->first();


        $data = array(
            'dataCustomer'  => $dataCustomer,
        );
        echo json_encode($data);
    }

    public function update_status(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
            try {
                DB::table('customer_shops')->where('id', $request->shop_id)->update([
                    'mrp_identify' => $request->mrp_identify,
                    'shop_status' => $request->status,
                    'shop_status_at' => Carbon::now(),
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now(),
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                'data' => $request,
            ]);
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

    public function approval_customer_except_detail($id){
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

        return view('admin.approval_customer_except_detail', $data);
    }
}
