<?php

namespace App\Http\Controllers\SaleMan;

use App\Assignment;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MonthlyPlan;
use App\Note;
use App\RequestApproval;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


class DashboardController extends Controller
{
    public function index(){
        //ตรวจสอบเดือนของแผนงานประจำเดือน

        $data['list_approval'] = RequestApproval::where('created_by', Auth::user()->id)->whereMonth('assign_request_date', Carbon::now()->format('m'))->get();

        $data['assignments'] = Assignment::where('assign_emp_id', Auth::user()->id)->whereMonth('assign_work_date', Carbon::now()->format('m'))->get();

        $data['notes'] = Note::where('employee_id', Auth::user()->id)->whereMonth('note_date', Carbon::now()->format('m'))->get();

        $data['customer_shop'] = Customer::where('created_by', Auth::user()->id)->where('shop_status', 0)->whereMonth('created_at', Carbon::now()->format('m'))->get();

        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('month_date', 'desc')->first();

        if ($data['monthly_plan']) {
            $date = Carbon::parse($data['monthly_plan']->month_date)->format('Y-m');
            $dateNow = Carbon::today()->addMonth(1)->format('Y-m');
            if ($date != $dateNow) {
                $plans = new MonthlyPlan;
                $plans->month_date     = Carbon::now()->addMonth(1);
                $plans->created_by     = Auth::user()->id;
                $plans->created_at     = Carbon::now();
                $plans->save();
            }
        }else{
            $plans = new MonthlyPlan;
            $plans->month_date      = Carbon::now()->addMonth(1);
            $plans->created_by      = Auth::user()->id;
            $plans->created_at      = Carbon::now();
            $plans->save();
        }

        // -----  API Login ----------- //
        $response = Http::post('http://49.0.64.92:8020/api/auth/login', [
            'username' => 'apiuser',
            'password' => 'testapi',
        ]);

        $res = $response->json();
        $api_token = $res['data'][0]['access_token'];
        $data['api_token'] = $res['data'][0]['access_token'];
        //--- End Api Login ------------ //

        $response = Http::withToken($api_token)
        ->get('http://49.0.64.92:8020/api/v1/sellers/'.Auth::user()->api_identify.'/dashboards', [
            'year' => '2021',
            'month' => '12'
        ]);
        $res_api = $response->json();

        // dd($res_api);

        return view('saleman.dashboard', $data);
    }
}
