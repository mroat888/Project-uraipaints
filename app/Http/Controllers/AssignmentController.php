<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;
use App\Customer;
use Carbon\Carbon;

class AssignmentController extends Controller
{

    public function index()
    {
        return view('leadManager.add_assignment');
    }

    public function store(Request $request)
    {
        // Assignment::create([
        //     'assign_title' => $request->assign_title,
        //     'sale_plans_title' => $request->sale_plans_title,
        //     'sale_plans_date' => $request->sale_plans_date,
        //     'sale_plans_tags' => $request->sale_plans_tags,
        //     'sale_plans_objective' => $request->sale_plans_objective,
        //     // 'sale_plans_approve_id	' => $request->assign_work_date,
        //     'sale_plans_status' => 1,
        //     'created_by' => Carbon::now(),
        //     // 'updated_by' => $request->assign_work_date,
        // ]);

        // echo ("<script>alert('บันทึกข้อมูลสำเร็จ'); location.href='saleplan'; </script>");
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

    public function searchShop(Request $request)
    {
        if ($request->ajax()) {

            $data = Customer::where('shop_name', $request->search)->first();
        }
            return $data;


    }
}
