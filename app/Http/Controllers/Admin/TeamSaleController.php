<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Http;

class TeamSaleController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index(){
        $data['teamSales'] = DB::table('master_team_sales')->orderBy('id', 'asc')->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/salezones');
        $res_api = $response->json();

        if(!is_null($res_api) && $res_api['code'] == 200){
           foreach($res_api['data'] as $key => $value){
                $data['salezones_api'][] = [
                    'identify' => $value['identify'],
                    'description' => $value['description'],
                    'saleleader_id' => $value['saleleader_id'],
                    'employee_name' => $value['employee_name'],
                    'employee_id' => $value['employee_id'],
                    'mobile_no' => $value['mobile_no'],
                    'area_info' => $value['area_info'],
                    'team_info' => $value['team_info']
                ];
           }
        }

        return view('admin.team_sales', $data);
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
