<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class UnionTripApproveController extends Controller
{
    public function __construct()
    {
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }

        $data['trip_header'] = DB::table('trip_header')
            ->join('users', 'trip_header.created_by', '=', 'users.id')
            ->select(
                'trip_header.*',
                'users.name'
            )
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->where('users.status', '1') // เฉพาะ saleman
            ->where('trip_header.trip_status', '1') // สถานส่งขออนุมัติ
            ->orderBy('trip_header.id', 'desc')
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


        switch  (Auth::user()->status){
            case 2 :    return view('leadManager.approval_trip', $data); 
                break;
            case 3 :    return view('headManager.approval_trip', $data); 
                break;
            case 4 :   
                break;
        }
    }

    public function approval_trip_confirm_all(Request $request)
    {
        DB::beginTransaction();
        try {
            $count_checkapprove = count($request->checkapprove);

            if(!is_null($request->approve)){
                $trip_status = 2; // อนุมัติ
            }else{
                $trip_status = 3; // ปฎิเสธ
            }

            for($i=0;$i<$count_checkapprove; $i++){
                DB::table('trip_header')->where('id', $request->checkapprove[$i])
                ->update([
                    'trip_status' => $trip_status,
                    'approve_at' => date('Y-m-d H:i:s'),
                    'approve_id' => Auth::user()->id,
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }

    public function trip_retrospective(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::table('trip_header')->where('id', $request->restros_id)
            ->update([
                'trip_status' => '0',
                'approve_at' => date('Y-m-d H:i:s'),
                'approve_id' => Auth::user()->id,
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
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }

    public function trip_showdetail($id)
    {
        
    }

}
