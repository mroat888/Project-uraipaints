<?php

namespace App\Http\Controllers\HeadManager;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\MonthlyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ImportantDayController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        list($year,$month,$day) = explode("-",date("Y-m-d"));
        $data['monthly_plan'] = MonthlyPlan::where('created_by', Auth::user()->id)
        ->whereYear('month_date', $year)
        ->whereMonth('month_date', $month)
        ->where('monthly_plans.status_approve', 2)
        ->orderBy('month_date', 'desc')
        ->first();

        $api_token = $this->api_token->apiToken();
        $data['api_token'] = $api_token;
        $response = Http::withToken($api_token)
        // ->get(env("API_LINK").'api/v1/sellers/'.Auth::user()->api_identify.'/dashboards', [
        //     'year' => $year,
        //     'month' => $month
        // ]);
        ->get(env("API_LINK").env("API_PATH_VER").'/bdates/saleheaders/'.Auth::user()->api_identify.'/customers');
        $data['res_api'] = $response->json();
        return view('headManager.important_day_detail', $data);
    }

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
