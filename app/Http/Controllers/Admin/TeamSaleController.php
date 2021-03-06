<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TeamSaleController extends Controller
{

    public function index(){
        $teamSales = DB::table('master_team_sales')->orderBy('id', 'asc')->get();
        return view('admin.team_sales', compact('teamSales'));
    }

    public function add_index(){
        $teamSales = DB::table('master_team_sales')->orderBy('id', 'asc')->get();
        return view('admin.add_team_sales', compact('teamSales'));
    }

    public function teamSales_detail($id){
        $teamSalesDetail = DB::table('users')->join('master_team_sales', 'users.team_id', 'master_team_sales.id')
        ->join('master_permission', 'users.status', 'master_permission.id')
        ->where(function($query) use ($id) {
            $query->where('users.team_id', $id)
                  ->orWhere('users.team_id', 'like', $id.',%')
                  ->orWhere('users.team_id', 'like', '%,'.$id);
        })
        ->select('users.*', 'master_team_sales.team_name', 'master_permission.permission_name')
        ->get();

        return view('admin.team_sales_detail', compact('teamSalesDetail'));
    }

    public function store(Request $request){
        $check_name = DB::table('master_team_sales')
        ->where('team_name', $request->team_name)
        ->first();

        if($check_name != null){
            $message = "ไม่สามารถบันทึกได้ ชื่อทีมซ้ำค่ะ";
            return response()->json([
                'status' => 404,
                'message' => $message,
            ]);
        }else{
            DB::beginTransaction();
            try{
                DB::table('master_team_sales')
                ->insert([
                    'team_name' => $request->team_name,
                    'team_api' => $request->team_api,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => 404,
                    'message' => "ไม่สามารถบันทึกได้ค่ะ",
                ]);
            }
        }
    }

    public function edit($id){
        $teamSales = DB::table('master_team_sales')->where('id', $id)->first();
        return response()->json([
            'status' => 200,
            'data' => $teamSales,
        ]);
    }

    public function update(Request $request){

        DB::beginTransaction();
        try{
            DB::table('master_team_sales')->where('id', $request->team_id_edit)
            ->update([
                'team_name' => $request->team_name_edit,
                'team_api' => $request->team_api_edit,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => "ไม่สามารถบันทึกได้ค่ะ",
            ]);
        }
    }


}
