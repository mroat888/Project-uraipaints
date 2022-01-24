<?php

namespace App\Http\Controllers\SaleMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MonthlyPlan;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(){
        //ตรวจสอบเดือนของแผนงานประจำเดือน
        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)->orderBy('id', 'desc')->first();

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

        return view('saleman.dashboard');
    }
}
