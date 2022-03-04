<?php

namespace App\Http\Controllers\ShareData_HeadManager;

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
        $year_old2 = $year-2;

        $path_search = "reports/years/".$year.",".$year_old1.",".$year_old2."/quaters/1,2,3,4/headers/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get('http://49.0.64.92:8020/api/v1/'.$path_search);
        $quarter_api = $response->json();

        $data['year_search'] = array($year, $year_old1, $year_old2);

        foreach($quarter_api['data'] as $key => $value){
            if($value['year'] == $year){
                switch ($value['quater']) {
                    case 1:
                        $data['quarter_api_year']['q1'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 2:
                        $data['quarter_api_year']['q2'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 3:
                        $data['quarter_api_year']['q3'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 4:
                        $data['quarter_api_year']['q4'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                }
            }
            if($value['year'] == $year_old1){
                switch ($value['quater']) {
                    case 1:
                        $data['quarter_api_year_old1']['q1'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 2:
                        $data['quarter_api_year_old1']['q2'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 3:
                        $data['quarter_api_year_old1']['q3'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 4:
                        $data['quarter_api_year_old1']['q4'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                }
            }
            if($value['year'] == $year_old2){
                switch ($value['quater']) {
                    case 1:
                        $data['quarter_api_year_old2']['q1'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 2:
                        $data['quarter_api_year_old2']['q2'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 3:
                        $data['quarter_api_year_old2']['q3'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                    case 4:
                        $data['quarter_api_year_old2']['q4'] = [
                            $value['Sellers'],
                            $value['customers'],
                            number_format($value['sales']),
                            number_format($value['credits']),
                            number_format($value['netSales']),
                            number_format($value['%Credit'])."%",
                            $value['year'],
                            $value['quater'],
                        ];
                    break;
                }
            }
        }

        // dd($data['quarter_api_year_old1']['q1'][2]);

        

        return view('shareData_headManager.report_historical_quarter', $data);
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
