<?php

namespace App\Http\Controllers\SaleMan;

use App\Assignment;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SalePlan;
use App\CustomerVisit;
use App\Note;
use App\RequestApproval;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DailyWorkController extends Controller
{
    public function index()
    {
        $data['list_approval'] = RequestApproval::where('created_by', Auth::user()->id)->whereMonth('assign_request_date', Carbon::now()->format('m'))->get();

        $data['assignments'] = Assignment::where('assign_emp_id', Auth::user()->id)->whereMonth('assign_work_date', Carbon::now()->format('m'))->get();

        $data['notes'] = Note::where('employee_id', Auth::user()->id)->whereMonth('note_date', Carbon::now()->format('m'))->get();

        $data['customer_shop'] = Customer::where('created_by', Auth::user()->id)->where('shop_status', 0)->whereMonth('created_at', Carbon::now()->format('m'))->get();

        $data['list_saleplan'] = SalePlan::join('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
        ->select(
            'customer_shops.shop_name' ,
            'sale_plans.*')
        ->where('sale_plans.created_by', Auth::user()->id)
        ->orderBy('id', 'desc')->get();

        $data['customer_new'] = DB::table('customer_shops')
            ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
            ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
            ->where('customer_shops.created_by', Auth::user()->id)
            ->select(
                'province.PROVINCE_NAME',
                'customer_shops.*'
            )
            ->orderBy('customer_shops.id', 'desc')
            ->get();

            $data['list_visit'] = CustomerVisit::leftjoin('customer_shops', 'customer_visits.customer_shop_id', '=', 'customer_shops.id')
            ->leftjoin('customer_contacts', 'customer_shops.id', '=', 'customer_contacts.customer_shop_id')
            ->leftjoin('province', 'customer_shops.shop_province_id', '=', 'province.PROVINCE_CODE')
            ->leftjoin('customer_visit_results', 'customer_visits.id', '=', 'customer_visit_results.customer_visit_id')
            ->select(
                'province.PROVINCE_NAME',
                'customer_contacts.customer_contact_name',
                'customer_visit_results.cust_visit_status',
                'customer_visit_results.cust_visit_checkin_date',
                'customer_visit_results.cust_visit_checkout_date',
                'customer_visit_results.customer_visit_id',
                'customer_shops.shop_name',
                'customer_visits.*'
            )
            ->where('customer_visits.created_by', Auth::user()->id)
            ->orderBy('customer_visits.id', 'desc')->get();

        return view('saleman.dailyWork', $data);
    }

}
