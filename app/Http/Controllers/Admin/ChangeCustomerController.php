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

        $sql_query = "select `monthly_plans`.*, `province`.`PROVINCE_NAME`, `customer_shops_saleplan_result`.*, 
        `customer_shops_saleplan`.*, `customer_shops_saleplan`.`shop_aprove_status` as `saleplan_shop_aprove_status`, 
        `customer_shops`.* from `customer_shops_saleplan` 
        left join `customer_shops` on `customer_shops`.`id` = `customer_shops_saleplan`.`customer_shop_id` 
        left join `customer_shops_saleplan_result` on `customer_shops_saleplan_result`.`customer_shops_saleplan_id` = `customer_shops_saleplan`.`id` 
        left join `monthly_plans` on `monthly_plans`.`id` = `customer_shops_saleplan`.`monthly_plan_id` 
        left join `province` on `province`.`PROVINCE_ID` = `customer_shops`.`shop_province_id` 
        left join `users` on `customer_shops_saleplan`.`created_by` = `users`.`id`";
        $sql_query .= "where `customer_shops`.`shop_status` != ? "; // 0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า , -> 2 = ลบ
        $sql_query .= "and `users`.`status` = ? "; // สถานะ ->1 = salemam, 2 = lead , 3 = head , 4 = admin

        $parameter = [2, 1];

        $sql_query_orderby = "order by `customer_shops_saleplan`.`id` desc, 
        `customer_shops_saleplan`.`monthly_plan_id` desc";

        $customer_shops = DB::select( $sql_query.$sql_query_orderby, $parameter);
        $data['customer_shops'] = $customer_shops;
        $data['province'] = DB::table('province')->get();
        $data['customer_contacts'] = DB::table('customer_contacts')->orderBy('id', 'desc')->get();

        // -- นับจำนวนร้านค้า ทั้งหมด
        $data['count_customer_all'] = count($customer_shops); 

        // -- นับ จำนวนร้านค้า สถานะสำเร็จ
        $parameter_count_customer_success = $parameter;
        $count_customer_success = $sql_query." and `customer_shops`.`shop_status` = ? ".$sql_query_orderby;
        $parameter_count_customer_success[] = 1 ;
        $count_customer_success = DB::select( $count_customer_success, $parameter_count_customer_success);
        $data['count_customer_success'] = count($count_customer_success);

         // -- นับ จำนวนร้านค้า สถานะสนใจ
        $parameter_count_customer_result_1 = $parameter;
        $count_customer_result_1 = $sql_query." and `customer_shops_saleplan_result`.`cust_result_status` = ? ".$sql_query_orderby;
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


        $data['users'] = DB::table('users')->get();
        $data['team_sales'] = DB::table('master_team_sales')->get();

        return view('admin.change_customer_status', $data);
    }

    public function show($id)
    {
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

    public function customerLeadSearch(Request $request){

        $parameter = array();

        $sql_query = "select `monthly_plans`.*, `province`.`PROVINCE_NAME`, `customer_shops_saleplan_result`.*, 
        `customer_shops_saleplan`.*, `customer_shops_saleplan`.`shop_aprove_status` as `saleplan_shop_aprove_status`, 
        `customer_shops`.* from `customer_shops_saleplan` 
        left join `customer_shops` on `customer_shops`.`id` = `customer_shops_saleplan`.`customer_shop_id` 
        left join `customer_shops_saleplan_result` on `customer_shops_saleplan_result`.`customer_shops_saleplan_id` = `customer_shops_saleplan`.`id` 
        left join `monthly_plans` on `monthly_plans`.`id` = `customer_shops_saleplan`.`monthly_plan_id` 
        left join `province` on `province`.`PROVINCE_ID` = `customer_shops`.`shop_province_id` 
        left join `users` on `customer_shops_saleplan`.`created_by` = `users`.`id`";
        $sql_query .= "where `customer_shops`.`shop_status` != ? "; // 0 = ลูกค้าใหม่ , 1 = ทะเบียนลูกค้า , -> 2 = ลบ
        $sql_query .= "and `users`.`status` = ? "; // สถานะ ->1 = salemam, 2 = lead , 3 = head , 4 = admin

        $parameter = [2, 1];
        $sql_query_where_team = "";

        $sql_query_orderby = "order by `customer_shops_saleplan`.`id` desc, 
        `customer_shops_saleplan`.`monthly_plan_id` desc";

        if(!is_null($request->selectteam_sales)){ //-- ทีมขาย
            $team = $request->selectteam_sales;

            $sql_query_where_team .= "and `users`.`team_id` = ? ";
            $parameter[] = $team;
            
            $sql_query .= $sql_query_where_team;
            $data['selectteam_sales'] = $request->selectteam_sales;
        }

        if(!is_null($request->selectdateFrom)){ //-- วันที่
            list($year,$month) = explode('-', $request->selectdateFrom);
            $sql_query = $sql_query." and `monthly_plans`.`month_date` LIKE ? 
            and `monthly_plans`.`month_date` LIKE ? ";
            $parameter[] = $year.'%';
            $parameter[] = '%'.$month.'%';
            $data['date_filter'] = $request->selectdateFrom;      
        }

        // dd($request->selectdateFrom, $sql_query);

        if(!is_null($request->selectusers)){ //-- ผู้แทนขาย
            $sql_query = $sql_query." and `customer_shops_saleplan`.`created_by` = ? ";
            $parameter[] = $request->selectusers ;
            $data['selectusers'] = $request->selectusers;
        }

        // --------- การ นับจำนวน แสดงในกล่องสถานะ ----------------

        $sql_query_count = $sql_query;
        $customer_shops_all = DB::select( $sql_query_count, $parameter);

        // -- นับจำนวนร้านค้า ทั้งหมด
        $data['count_customer_all'] = count($customer_shops_all); 

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

        // --------- จบ การ นับจำนวน แสดงในกล่องสถานะ ----------------
        

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


        $data['users'] = DB::table('users')->get();
        $data['team_sales'] = DB::table('master_team_sales')->get();

        return view('admin.change_customer_status', $data);

    }
}
