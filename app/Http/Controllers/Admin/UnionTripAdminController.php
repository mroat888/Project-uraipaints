<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use PDF;

class UnionTripAdminController extends Controller
{
    public function __construct()
    {
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $trip_header = DB::table('trip_header')
            ->join('users', 'trip_header.created_by', '=', 'users.id')
            ->select(
                'trip_header.*',
                'users.name',
                'users.status',
            )
            ->where('trip_header.trip_status', 2) // สถานะอนุมัติ
            ->orderBy('trip_header.id', 'desc')
            ->get();

        $data['trip_header'] = $trip_header; 

        $data['team_sales'] = DB::table('master_team_sales')->get();
        $data['users'] = DB::table('users')->where('status', 3)->get(); // เฉพาะผู้จัดการฝ่าย
        
        return view('admin.approval_trip', $data); 
    }

    public function search(Request $request)
    {
        $trip_header = DB::table('trip_header')
            ->join('users', 'trip_header.created_by', '=', 'users.id')
            ->select(
                'trip_header.*',
                'users.name',
                'users.status',
            );

        if(!is_null($request->selectstatus_trip)){
            $trip_header = $trip_header->where('trip_header.trip_status', $request->selectstatus_trip);
        }else{
            $trip_header = $trip_header->whereNotIn('trip_header.trip_status', [0,1]);
        }

        if(!is_null($request->selectteam_sales)){
            $team = $request->selectteam_sales;
            $trip_header = $trip_header->where(function($query) use ($team) {
                $query->orWhere('users.team_id', $team)
                    ->orWhere('users.team_id', 'like', $team.',%')
                    ->orWhere('users.team_id', 'like', '%,'.$team);
                });
        }

        if(!is_null($request->selectdateFrom)){
            list($year,$month) = explode('-', $request->selectdateFrom);
            $trip_header =  $trip_header->whereMonth('trip_header.request_approve_at', $month)
                ->whereYear('trip_header.request_approve_at', $year);
        }

        $trip_header =  $trip_header->orderBy('trip_header.id', 'desc')->get();

        $data['trip_header'] = $trip_header; 

        $data['team_sales'] = DB::table('master_team_sales')->get();
        $data['users'] = DB::table('users')->where('status', 3)->get(); // เฉพาะผู้จัดการฝ่าย

        return view('admin.approval_trip', $data); 
    }


    public function approval_trip_confirm_all(Request $request)
    {
        DB::beginTransaction();
        try {
            $count_checkapprove = count($request->checkapprove);

            if(!is_null($request->approve)){

                if($request->approve == "complate"){ // ปิดทริป
                    for($i=0;$i<$count_checkapprove; $i++){
                        DB::table('trip_header')->where('id', $request->checkapprove[$i])
                        ->update([
                            'trip_status' => 4,
                            'end_approve_at' => date('Y-m-d H:i:s'),
                            'end_approve_id' => Auth::user()->id,
                        ]);
                    }
                }else if($request->approve == "pdf"){ // สร้าง pdf
                    dd("PDF");
                }else if($request->approve == "excle"){ // สร้าง excle
                    dd("excle");
                }else if($request->approve == "seandmail"){ // ส่งอีเมล
                    dd("seandmail");
                }

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
}
