<?php

namespace App\Http\Controllers\ShareData_LeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportHistoricalQuarterController extends Controller
{

    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $year = $year+0;
        $year_old1 = $year-1;

        $path_search = "reports/years/".$year.",".$year_old1."/quaters/1,2,3,4/leaders/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/'.$path_search);
        $quarter_api = $response->json();

        $data['year_search'] = array($year, $year_old1);

        $data['sum_present'] = array();
        $data['total_year'] = array();

        $sum_pre_q1 = 0;
        $sum_pre_q2 = 0;
        $sum_pre_q3 = 0;
        $sum_pre_q4 = 0;

        // dd($quarter_api['data']);
        if($quarter_api['code'] == 200){

            foreach($data['year_search'] as $key_year => $year_search ){
                $total_year = 0;
                $sum_netSales_q1 = 0;
                $sum_netSales_q2 = 0;
                $sum_netSales_q3 = 0;
                $sum_netSales_q4 = 0;

                foreach($quarter_api['data'] as $key => $value){
                    
                    if($value['year'] == $year_search){

                        switch ($value['quater']) {
                            case 1:
                                $data['quarter_api_year'][$key_year]['q1'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $sum_netSales_q1 = $sum_netSales_q1 + $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 2:
                                $data['quarter_api_year'][$key_year]['q2'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $sum_netSales_q2 = $sum_netSales_q2 + $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 3:
                                $data['quarter_api_year'][$key_year]['q3'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $sum_netSales_q3 = $sum_netSales_q3 + $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                            case 4:
                                $data['quarter_api_year'][$key_year]['q4'] = [
                                    $value['Sellers'],
                                    $value['customers'],
                                    $value['sales'],
                                    $value['credits'],
                                    $value['netSales'],
                                    $value['%Credit'],
                                    $value['year'],
                                    $value['quater'],
                                ];
                                $sum_netSales_q4 = $sum_netSales_q4 + $value['netSales'];
                                $total_year += $value['netSales'];
                            break;
                        }
                        
                    }

                }
                
                $data['total_year'][] = [
                    'total_year' => $total_year,
                ];
            }
        }


        // dd($data);

        

        return view('shareData_leadManager.report_historical_quarter', $data);
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
