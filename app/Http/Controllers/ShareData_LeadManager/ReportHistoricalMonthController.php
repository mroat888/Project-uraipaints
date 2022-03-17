<?php

namespace App\Http\Controllers\ShareData_LeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportHistoricalMonthController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $year_old1 = $year-1;
        $year_old2 = $year-2;

        $array_year = array($year, $year_old1, $year_old2);
        $month_api = array();

        $path_search = "reports/years/".$year.",".$year_old1.",".$year_old2."/months/1,2,3,4,5,6,7,8,9,10,11,12/leaders/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $res_api = $response->json();

        foreach($array_year as $key_year => $value_year){
            $month = 1;
            for($i=0; $i<12; $i++){
                foreach($res_api['data'] as $key => $value){
                    if(($value_year == $value['year']) && ($month == $value['month'])){
                        $month_api[$key_year][$i] =[
                            'year' => $value['year'],
                            'month' => $value['month'],
                            'Sellers' => $value['Sellers'],
                            'customers' => $value['customers'],
                            'sales' => $value['sales'],
                            'credits' => $value['credits'],
                            'netSales' => $value['netSales'],
                            '%Credit' => $value['%Credit'],
                        ];
                    }
                }
                $month++;
            }
        }

        return view('shareData_leadManager.report_historical_month', compact('month_api'));
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
