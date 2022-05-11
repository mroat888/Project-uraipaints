<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChangeCustomerController extends Controller
{

    public function index()
    {
        $data_customer_new = DB::table('customer_shops_saleplan')
        ->leftjoin('customer_shops', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
        ->join('amphur', 'amphur.AMPHUR_ID', 'customer_shops.shop_amphur_id')
        ->join('province', 'province.PROVINCE_ID', 'customer_shops.shop_province_id')
        ->join('users', 'customer_shops_saleplan.created_by', 'users.id')
        ->where('customer_shops_saleplan.shop_aprove_status', 2)
        ->where('customer_shops.shop_status', 0)
        ->select('customer_shops_saleplan.*',
        'users.name as saleman', 'customer_shops.shop_name', 'customer_shops.shop_status',
        'province.PROVINCE_NAME',
        'amphur.AMPHUR_NAME',)->get();

        $data = array(
            'data_customer_new'  => $data_customer_new,
        );

        return view('admin.change_customer_status', $data);
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
