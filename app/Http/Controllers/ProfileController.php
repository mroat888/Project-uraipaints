<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->apicontroller = new ApiController();
    }

    public function index()
    {
        $edit_user = DB::table('users')->join('master_permission', 'users.status', 'master_permission.id')
        ->join('master_team_sales', 'users.team_id', 'master_team_sales.id')
        ->where('users.id', Auth::user()->id)
        ->select('users.*', 'master_permission.permission_name', 'master_team_sales.team_name')->first();

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
        return view('saleman.user_profile', compact('edit_user', 'sellers_api'));
    }

    public function lead_index()
    {
        $edit_user = DB::table('users')->join('master_permission', 'users.status', 'master_permission.id')
        ->join('master_team_sales', 'users.team_id', 'master_team_sales.id')
        ->where('users.id', Auth::user()->id)
        ->select('users.*', 'master_permission.permission_name', 'master_team_sales.team_name')->first();

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
        return view('leadManager.user_profile', compact('edit_user', 'sellers_api'));
    }

    public function head_index()
    {
        $edit_user = DB::table('users')->join('master_permission', 'users.status', 'master_permission.id')
        ->join('master_team_sales', 'users.team_id', 'master_team_sales.id')
        ->where('users.id', Auth::user()->id)
        ->select('users.*', 'master_permission.permission_name', 'master_team_sales.team_name')->first();

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
        return view('headManager.user_profile', compact('edit_user', 'sellers_api'));
    }

    public function admin_index()
    {
        $edit_user = DB::table('users')->join('master_permission', 'users.status', 'master_permission.id')
        ->join('master_team_sales', 'users.team_id', 'master_team_sales.id')
        ->where('users.id', Auth::user()->id)
        ->select('users.*', 'master_permission.permission_name', 'master_team_sales.team_name')->first();

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
        return view('admin.user_profile', compact('edit_user', 'sellers_api'));
    }

    public function update(Request $request)
    {
        $user_chkid = DB::table('users')
        ->where('id', $request->edit_tuser_id)
        ->first();


        if(($user_chkid->email == $request->edit_temail) && ($user_chkid->api_identify == $request->edit_sel_api_identify)){
            DB::table('users')
            ->where('id', 1)
            ->update([
                'name' => $request->edit_tname,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);

            if ($request->edit_tpassword != '') {
                DB::table('users')
                    ->where('id', $request->edit_tuser_id)
                    ->update([
                        'password' => Hash::make($request->edit_tpassword),
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

            if($user_check_email != null){

                if($user_check_email->email == $user_chkid->email){
                    // $message = "อีเมลเดิมค่ะ";

                    $user_check_api_identify = DB::table('users')
                    ->where('api_identify', $request->edit_sel_api_identify)
                    ->first();
                    if($user_check_api_identify != null){
                        if($user_check_api_identify->api_identify == $user_chkid->api_identify){
                            DB::table('users')
                            ->where('id', $request->edit_tuser_id)
                            ->update([
                                'name' => $request->edit_tname,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' =>  Auth::user()->id,
                            ]);
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
                        DB::table('users')
                        ->where('id', $request->edit_tuser_id)
                        ->update([
                            'name' => $request->edit_tname,
                            'email' => $request->edit_temail,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' =>  Auth::user()->id,
                        ]);

                        if ($request->edit_tpassword != '') {
                            DB::table('users')
                                ->where('id', $request->edit_tuser_id)
                                ->update([
                                    'password' => Hash::make($request->edit_tpassword),
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
                DB::table('users')
                ->where('id', $request->edit_tuser_id)
                ->update([
                    'name' => $request->edit_tname,
                    'email' => $request->edit_temail,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' =>  Auth::user()->id,
                ]);

                if ($request->edit_tpassword != '') {
                    DB::table('users')
                        ->where('id', $request->edit_tuser_id)
                        ->update([
                            'password' => Hash::make($request->edit_tpassword),
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

    public function destroy($id)
    {
        //
    }
}
