<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Api\ApiController;
use App\User;

class UserPermissionController extends Controller
{
    public function __construct()
    {
        $this->apicontroller = new ApiController();
    }

    public function index(){
        $users = DB::table('users')->get();
        $master_permission = DB::table('master_permission')->get();
        $master_team = DB::table('master_team_sales')->get();

        $res_api = $this->apicontroller->getAllSellers();
        $sellers_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $sellers_api[$key] =
            [
                'id' => $value['identify'],
                // 'emp_id' => $value['employee_id'],
                'name' => $value['name'],
            ];
        }
        // -----  END API

        // dd($users);

        return view('admin.user_permission', compact('users', 'master_permission', 'sellers_api', 'master_team'));
    }

    public function store(Request $request)
    {
        if(isset($request->sel_api_identify) && !is_null($request->sel_api_identify)){
            $user_check_email = DB::table('users')
            ->where('email', $request->temail)
            ->orWhere('api_identify', $request->sel_api_identify)
            ->first();
        
            $res_api = $this->apicontroller->getAllSellers();

            foreach ($res_api['data'] as $key => $value) {
                if ($request->sel_api_identify == $value['identify']) {
                    $emp_id = $value['employee_id'];
                }
            }
            $sel_api_identify = $request->sel_api_identify;
        }else{
            $user_check_email = 'visitor';
            $sel_api_identify = null;
            $emp_id = null;
        }

        if($user_check_email != null && $user_check_email != "visitor"){
            $message = "อีเมลหรือชื่อพนักงานซ้ำค่ะ";
            return response()->json([
                'status' => 404,
                'message' => $message,
            ]);
        }else{
            
            DB::beginTransaction();
            try{
                if($request->tpassword != ""){
                    $password_staff = Hash::make($request->tpassword);
                }else{
                    $password_staff = "";
                }
                if(!is_null($request->sel_team)){
                    $sel_team = implode( ',', $request->sel_team);
                }else{
                    $sel_team = null;
                }
                // dd($sel_team, $password_staff);
                // dd($request, $emp_id, $sel_api_identify, $sel_team, $password_staff);
                if ($request->image != '') {
                        $path = 'upload/UserSignature';
                        $image = '';
                    if (!empty($request->file('image'))) {
                        $img = $request->file('image');
                        $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                        $save_path = $img->move(public_path($path), $img_name);
                        $image = $img_name;

                        DB::table('users')->insert([
                            'name' => $request->tname,
                            'email' => $request->temail,
                            'password' => $password_staff,
                            'api_identify' => $sel_api_identify,
                            'api_employee_id' => $emp_id,
                            'status' => $request->sel_status,
                            'team_id' => $sel_team,
                            'signature' => $image,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => Auth::user()->id,
                        ]);
                    }
                }else{
                    DB::table('users')->insert([
                        'name' => $request->tname,
                        'email' => $request->temail,
                        'password' => $password_staff,
                        'api_identify' => $sel_api_identify,
                        'api_employee_id' => $emp_id,
                        'status' => $request->sel_status,
                        'team_id' => $sel_team,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id,
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

            $message = "บันทึกข้อมูลสำเร็จ";
        }
        return response()->json([
            'status' => 200,
            'message' => 'บันทึกข้อมูลสำเร็จ',
        ]);
    }

    public function edit($id){
        $users = DB::table('users')->where('id', $id)->first();
        $master_permission = DB::table('master_permission')->get();
        $master_teamsale = DB::table('master_team_sales')->get();

        // -----  API
        $res_api = $this->apicontroller->getAllSellers();

        $sellers_api = array();
        foreach ($res_api['data'] as $key => $value) {
            $sellers_api[$key] =
            [
                'id' => $value['identify'],
                'name' => $value['name'],
            ];
        }
        // -----  END API

        return response()->json([
            'status' => 200,
            'dataUser' => $users,
            'master_permission' => $master_permission,
            'sellers_api' => $sellers_api,
            'master_teamsale' => $master_teamsale,
        ]);
    }

    public function update(Request $request)
    {
        $user_chkid = DB::table('users')
        ->where('id', $request->edit_tuser_id)
        ->first();
        // dd($request->edit_tuser_id, $user_chkid->email, $request->edit_temail, $user_chkid->api_identify, $request->edit_sel_api_identify);

        if(!is_null($request->edit_sel_api_identify) && $request->edit_sel_api_identify != ""){
            $res_api = $this->apicontroller->getAllSellers();
            $emp_id = null;
            foreach ($res_api['data'] as $key => $value) {
                if ($request->edit_sel_api_identify == $value['identify']) {
                    $emp_id = $value['employee_id'];
                }
            }
        }else{
            $emp_id = null;
        }

        if(!is_null($request->edit_sel_team) && $request->edit_sel_team != ""){
            $sel_team = implode( ',', $request->edit_sel_team);
        }else{
            $sel_team = null;
        }

        if(($user_chkid->email == $request->edit_temail) && ($user_chkid->api_identify == $request->edit_sel_api_identify)){

            if ($request->image != '') {
                $path = 'upload/UserSignature';
                $image = '';
                if (!empty($request->file('image'))) {

                    $data = User::find($request->id);

                        //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                        if (!empty($data->signature)) {
                            $path2 = 'upload/UserSignature/';
                            unlink(public_path($path2 . $data->signature));
                        }
                        

                    $img = $request->file('image');
                    $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                    $save_path = $img->move(public_path($path), $img_name);
                    $image = $img_name;

                        DB::table('users')->where('id', $request->edit_tuser_id)->update([
                        'name' => $request->edit_tname,
                        'status' => $request->edit_sel_status,
                        // 'team_id' => implode( ',', $request->edit_sel_team),
                        'team_id' => $sel_team,
                        'api_employee_id' => $emp_id,
                        'signature' => $image,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' =>  Auth::user()->id,
                    ]);

                }
            }else {
                DB::table('users')
                ->where('id', $request->edit_tuser_id)
                ->update([
                    'name' => $request->edit_tname,
                    'status' => $request->edit_sel_status,
                    // 'team_id' => implode( ',', $request->edit_sel_team),
                    'team_id' => $sel_team,
                    'api_employee_id' => $emp_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' =>  Auth::user()->id,
                ]);
            }

            $message = "บันทึกข้อมูลสำเร็จ";

        }else{
            
            $user_check_email = DB::table('users')
            ->where('email', $request->edit_temail)
            ->orWhere('api_identify', $request->edit_sel_api_identify)
            ->first();
            // dd($request->edit_sel_api_identify, $user_check_email);
            if($user_check_email != null){

                if($user_check_email->email == $user_chkid->email){
                    // $message = "อีเมลเดิมค่ะ";

                    $user_check_api_identify = DB::table('users')
                    ->where('api_identify', $request->edit_sel_api_identify)
                    ->first();
                    if($user_check_api_identify != null){
                        if($user_check_api_identify->api_identify == $user_chkid->api_identify){

                            if ($request->image != '') {
                                $path = 'upload/UserSignature';
                                $image = '';
                                if (!empty($request->file('image'))) {
                                    $data = User::find($request->id);

                                    //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                                    if (!empty($data->signature)) {
                                        $path2 = 'upload/UserSignature/';
                                        unlink(public_path($path2 . $data->signature));
                                    }
                                    $img = $request->file('image');
                                    $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                                    $save_path = $img->move(public_path($path), $img_name);
                                    $image = $img_name;

                                    DB::table('users')->where('id', $request->edit_tuser_id)
                                    ->update([
                                        'name' => $request->edit_tname,
                                        'email' => $request->edit_temail,
                                        'status' => $request->edit_sel_status,
                                        // 'team_id' => $request->edit_sel_team,
                                        // 'team_id' => implode( ',', $request->edit_sel_team),
                                        'team_id' => $sel_team,
                                        'api_employee_id' => $emp_id,
                                        'api_identify' => $request->edit_sel_api_identify,
                                        'signature' => $image,
                                        'updated_at' => date('Y-m-d H:i:s'),
                                        'updated_by' =>  Auth::user()->id,
                                    ]);
                                }
                            }else {
                                DB::table('users')->where('id', $request->edit_tuser_id)
                                ->update([
                                    'name' => $request->edit_tname,
                                    'email' => $request->edit_temail,
                                    'status' => $request->edit_sel_status,
                                    // 'team_id' => $request->edit_sel_team,
                                    // 'team_id' => implode( ',', $request->edit_sel_team),
                                    'team_id' => $sel_team,
                                    'api_employee_id' => $emp_id,
                                    'api_identify' => $request->edit_sel_api_identify,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    'updated_by' =>  Auth::user()->id,
                                ]);
                            }

                            $message = "บันทึกข้อมูลสำเร็จ";
                            return response()->json([
                                'status' => 200,
                                'message' => $message,
                            ]);
                        }else{
                            $message = "ชื่อพนักงานซ้ำค่ะ";
                            return response()->json([
                                'status' => 404,
                                'message' => $message,
                            ]);
                        }
                    }else{ // ถ้า api_identify ซ้ำ ไม่ให้บันทึก

                        if ($request->image != '') {
                            $path = 'upload/UserSignature';
                            $image = '';
                            if (!empty($request->file('image'))) {
                                $data = User::find($request->id);

                                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                                if (!empty($data->signature)) {
                                    $path2 = 'upload/UserSignature/';
                                    unlink(public_path($path2 . $data->signature));
                                }

                                $img = $request->file('image');
                                $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                                $save_path = $img->move(public_path($path), $img_name);
                                $image = $img_name;

                                DB::table('users')->where('id', $request->edit_tuser_id)->update([
                                    'name' => $request->edit_tname,
                                    'email' => $request->edit_temail,
                                    'status' => $request->edit_sel_status,
                                    // 'team_id' => $request->edit_sel_team,
                                    // 'team_id' => implode( ',', $request->edit_sel_team),
                                    'team_id' => $sel_team,
                                    'api_identify' => $request->edit_sel_api_identify,
                                    'api_employee_id' => $emp_id,
                                    'signature' => $image,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    'updated_by' =>  Auth::user()->id,
                                ]);
                            }
                        }else {
                            DB::table('users')->where('id', $request->edit_tuser_id)->update([
                                'name' => $request->edit_tname,
                                'email' => $request->edit_temail,
                                'status' => $request->edit_sel_status,
                                // 'team_id' => $request->edit_sel_team,
                                // 'team_id' => implode( ',', $request->edit_sel_team),
                                'team_id' => $sel_team,
                                'api_identify' => $request->edit_sel_api_identify,
                                'api_employee_id' => $emp_id,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' =>  Auth::user()->id,
                            ]);
                        }

                        $message = "บันทึกข้อมูลสำเร็จ";
                        return response()->json([
                            'status' => 200,
                            'message' => $message,
                        ]);
                    }
                }else{
                    $message = "อีเมลซ้ำค่ะ";
                    return response()->json([
                        'status' => 404,
                        'message' => $message,
                    ]);
                }

            }else{  // กรณีเปลี่ยนทั้งอีเมล และชื่อพนักงาน ไม่ซ้ำกัน

                if ($request->image != '') {
                    $path = 'upload/UserSignature';
                    $image = '';
                if (!empty($request->file('image'))) {

                    $data = User::find($request->id);

                    //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                    if (!empty($data->signature)) {
                        $path2 = 'upload/UserSignature/';
                        unlink(public_path($path2 . $data->signature));
                    }

                    $img = $request->file('image');
                    $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                    $save_path = $img->move(public_path($path), $img_name);
                    $image = $img_name;

                    DB::table('users')->where('id', $request->edit_tuser_id)->update([
                    'name' => $request->edit_tname,
                    'email' => $request->edit_temail,
                    'status' => $request->edit_sel_status,
                    // 'team_id' => $request->edit_sel_team,
                    // 'team_id' => implode( ',', $request->edit_sel_team),
                    'team_id' => $sel_team,
                    'api_identify' => $request->edit_sel_api_identify,
                    'api_employee_id' => $emp_id,
                    'signature' => $image,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' =>  Auth::user()->id,
                ]);
                }
            }else {
                DB::table('users')->where('id', $request->edit_tuser_id)->update([
                    'name' => $request->edit_tname,
                    'email' => $request->edit_temail,
                    'status' => $request->edit_sel_status,
                    // 'team_id' => $request->edit_sel_team,
                    // 'team_id' => implode( ',', $request->edit_sel_team),
                    'team_id' => $sel_team,
                    'api_identify' => $request->edit_sel_api_identify,
                    'api_employee_id' => $emp_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' =>  Auth::user()->id,
                ]);
            }

                $message = "บันทึกข้อมูลสำเร็จ";
            }

        }

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);


    }

    public function update_status_use($id){
        $chk = DB::table('users')->where('id', $id)->first();

        if ($chk->status_use == 1) {
            DB::table('users')->where('id', $chk->id)
            ->update([
                'status_use' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }else {
            DB::table('users')->where('id', $chk->id)
            ->update([
                'status_use' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }
        return back();
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = DB::table('users')->where('id', $request->permission_id_delete)->first();
            if (!empty($data->signature)) {
                $path2 = 'public/upload/UserSignature/';
                unlink($path2 . $data->signature);
            }

            DB::table('users')->where('id', $request->permission_id_delete)->delete();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
        ]);
    }
}
