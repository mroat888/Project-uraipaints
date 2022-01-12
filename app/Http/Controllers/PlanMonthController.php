<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SalePlan;
use App\CustomerVisit;
use App\ObjectiveSaleplan;
use Illuminate\Support\Facades\Auth;

class PlanMonthController extends Controller
{

    public function index()
    {
        $data['customer_new'] = DB::table('customer_shops')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->where('customer_shops.shop_status', 0) // 0 = ลูกค้าใหม่ , 1 = ลูกค้าเป้าหมาย , 2 = ทะเบียนลูกค้า , 3 = ลบ
        ->select(
            'province.PROVINCE_NAME' ,
            'customer_shops.*'
        )
        ->orderBy('customer_shops.id', 'desc')
        ->get();

        $data['list_saleplan'] = DB::table('sale_plans')->join('customer_shops', 'sale_plans.customer_shop_id', '=', 'customer_shops.id')
        ->select(
            'customer_shops.shop_name' ,
            'sale_plans.*')
        ->where('sale_plans.created_by', Auth::user()->id)
        ->orderBy('id', 'desc')->get();

        $data['list_visit'] = CustomerVisit::join('customer_shops', 'customer_visits.customer_shop_id', '=', 'customer_shops.id')
        ->join('customer_contacts', 'customer_shops.id', '=', 'customer_contacts.customer_shop_id')
        ->join('province', 'customer_shops.shop_province_id', '=', 'province.PROVINCE_CODE')
        ->select('customer_shops.shop_name','customer_visits.id',
        'customer_visits.customer_visit_date', 'province.PROVINCE_NAME',
        'customer_contacts.customer_contact_name')
        ->where('customer_visits.created_by', Auth::user()->id)
        ->orderBy('id', 'desc')->get();

        $data['objective'] = ObjectiveSaleplan::all();

        return view('saleman.planMonth', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
