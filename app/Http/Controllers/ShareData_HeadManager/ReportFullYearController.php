<?php

namespace App\Http\Controllers\ShareData_HeadManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ReportFullYearController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        list($year,$month,$day) = explode('-',date('Y-m-d'));
        $path_search = "reports/years/".$year."/headers"."/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $data['yearseller_api'] = $response->json();

        // สินค้า Top Group
        $path_search_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdgroups?sortorder=DESC"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search_top);
        $data['grouptop_api'] = $response->json();

        $sum_group_sales = 0;
        $sum_group_credits = 0;
        $sum_group_netSales = 0;
        $sum_group_customers = 0;
        $sum_group_Sellers = 0;

        foreach($data['grouptop_api']['data'] as $key => $value){
            $sum_group_sales += $value['sales'];
            $sum_group_credits += $value['credits'];
            $sum_group_netSales += $value['netSales'];
            $sum_group_customers += $value['customers'];
            $sum_group_Sellers += $value['Sellers'];
        }

        $sum_group_persentcredit = ($sum_group_credits*100)/$sum_group_sales;
        $data['summary_group_api'] = [
            'sum_group_sales' => $sum_group_sales,
            'sum_group_credits' => $sum_group_credits,
            'sum_group_netSales' => $sum_group_netSales,
            'sum_group_customers' => $sum_group_customers,
            'sum_group_Sellers' => $sum_group_Sellers,
            'sum_group_persentcredit' => $sum_group_persentcredit,
        ];

        // สินค้า Top SubGroup
        $path_search_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdsubgroups?sortorder=DESC"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search_top);
        $data['subgrouptop_api'] = $response->json();

        $sum_subgroup_sales = 0;
        $sum_subgroup_credits = 0;
        $sum_subgroup_netSales = 0;
        $sum_subgroup_customers = 0;
        $sum_subgroup_Sellers = 0;

        foreach($data['grouptop_api']['data'] as $key => $value){
            $sum_subgroup_sales += $value['sales'];
            $sum_subgroup_credits += $value['credits'];
            $sum_subgroup_netSales += $value['netSales'];
            $sum_subgroup_customers += $value['customers'];
            $sum_subgroup_Sellers += $value['Sellers'];
        }

        $sum_subgroup_persentcredit = ($sum_subgroup_credits*100)/$sum_subgroup_sales;
        $data['summary_subgroup_api'] = [
            'sum_subgroup_sales' => $sum_subgroup_sales,
            'sum_subgroup_credits' => $sum_subgroup_credits,
            'sum_subgroup_netSales' => $sum_subgroup_netSales,
            'sum_subgroup_customers' => $sum_subgroup_customers,
            'sum_subgroup_Sellers' => $sum_subgroup_Sellers,
            'sum_subgroup_persentcredit' => $sum_subgroup_persentcredit,
        ];

        // สินค้า Top Product List
        $path_search_top = "reports/years/".$year."/headers/".Auth::user()->api_identify."/pdlists?sortorder=DESC"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search_top);
        $data['pdlisttop_api'] = $response->json();

        $sum_pdlist_sales = 0;
        $sum_pdlist_credits = 0;
        $sum_pdlist_netSales = 0;
        $sum_pdlist_customers = 0;
        $sum_pdlist_Sellers = 0;

        foreach($data['pdlisttop_api']['data'] as $key => $value){
            $sum_pdlist_sales += $value['sales'];
            $sum_pdlist_credits += $value['credits'];
            $sum_pdlist_netSales += $value['netSales'];
            $sum_pdlist_customers += $value['customers'];
            $sum_pdlist_Sellers += $value['Sellers'];
        }

        $sum_pdlist_persentcredit = ($sum_pdlist_credits*100)/$sum_pdlist_sales;
        $data['summary_pdlist_api'] = [
            'sum_pdlist_sales' => $sum_subgroup_sales,
            'sum_pdlist_credits' => $sum_subgroup_credits,
            'sum_pdlist_netSales' => $sum_subgroup_netSales,
            'sum_pdlist_customers' => $sum_subgroup_customers,
            'sum_pdlist_Sellers' => $sum_pdlist_Sellers,
            'sum_pdlist_persentcredit' => $sum_pdlist_persentcredit,
        ];

        // dd($yearleader_api);

        return view('shareData_headManager.report_full_year', $data);
    }

    public function search(Request $request)
    {

        $path_search = "reports/years/".$request->sel_year."/headers"."/".Auth::user()->api_identify;
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search);
        $data['yearseller_api'] = $response->json();

        // สินค้า Top Group
        $path_search_top = "reports/years/".$request->sel_year."/headers/".Auth::user()->api_identify."/pdgroups?sortorder=DESC"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search_top);
        $data['grouptop_api'] = $response->json();

        $sum_group_sales = 0;
        $sum_group_credits = 0;
        $sum_group_netSales = 0;
        $sum_group_customers = 0;
        $sum_group_Sellers = 0;

        foreach($data['grouptop_api']['data'] as $key => $value){
            $sum_group_sales += $value['sales'];
            $sum_group_credits += $value['credits'];
            $sum_group_netSales += $value['netSales'];
            $sum_group_customers += $value['customers'];
            $sum_group_Sellers += $value['Sellers'];
        }

        $sum_group_persentcredit = ($sum_group_credits*100)/$sum_group_sales;
        $data['summary_group_api'] = [
            'sum_group_sales' => $sum_group_sales,
            'sum_group_credits' => $sum_group_credits,
            'sum_group_netSales' => $sum_group_netSales,
            'sum_group_customers' => $sum_group_customers,
            'sum_group_Sellers' => $sum_group_Sellers,
            'sum_group_persentcredit' => $sum_group_persentcredit,
        ];

        // สินค้า Top SubGroup
        $path_search_top = "reports/years/".$request->sel_year."/headers/".Auth::user()->api_identify."/pdsubgroups?sortorder=DESC"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search_top);
        $data['subgrouptop_api'] = $response->json();

        $sum_subgroup_sales = 0;
        $sum_subgroup_credits = 0;
        $sum_subgroup_netSales = 0;
        $sum_subgroup_customers = 0;
        $sum_subgroup_Sellers = 0;

        foreach($data['grouptop_api']['data'] as $key => $value){
            $sum_subgroup_sales += $value['sales'];
            $sum_subgroup_credits += $value['credits'];
            $sum_subgroup_netSales += $value['netSales'];
            $sum_subgroup_customers += $value['customers'];
            $sum_subgroup_Sellers += $value['Sellers'];
        }

        $sum_subgroup_persentcredit = ($sum_subgroup_credits*100)/$sum_subgroup_sales;
        $data['summary_subgroup_api'] = [
            'sum_subgroup_sales' => $sum_subgroup_sales,
            'sum_subgroup_credits' => $sum_subgroup_credits,
            'sum_subgroup_netSales' => $sum_subgroup_netSales,
            'sum_subgroup_customers' => $sum_subgroup_customers,
            'sum_subgroup_Sellers' => $sum_subgroup_Sellers,
            'sum_subgroup_persentcredit' => $sum_subgroup_persentcredit,
        ];

        // สินค้า Top Product List
        $path_search_top = "reports/years/".$request->sel_year."/headers/".Auth::user()->api_identify."/pdlists?sortorder=DESC"; 
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/'.$path_search_top);
        $data['pdlisttop_api'] = $response->json();

        $sum_pdlist_sales = 0;
        $sum_pdlist_credits = 0;
        $sum_pdlist_netSales = 0;
        $sum_pdlist_customers = 0;
        $sum_pdlist_Sellers = 0;

        foreach($data['pdlisttop_api']['data'] as $key => $value){
            $sum_pdlist_sales += $value['sales'];
            $sum_pdlist_credits += $value['credits'];
            $sum_pdlist_netSales += $value['netSales'];
            $sum_pdlist_customers += $value['customers'];
            $sum_pdlist_Sellers += $value['Sellers'];
        }

        $sum_pdlist_persentcredit = ($sum_pdlist_credits*100)/$sum_pdlist_sales;
        $data['summary_pdlist_api'] = [
            'sum_pdlist_sales' => $sum_subgroup_sales,
            'sum_pdlist_credits' => $sum_subgroup_credits,
            'sum_pdlist_netSales' => $sum_subgroup_netSales,
            'sum_pdlist_customers' => $sum_subgroup_customers,
            'sum_pdlist_Sellers' => $sum_pdlist_Sellers,
            'sum_pdlist_persentcredit' => $sum_pdlist_persentcredit,
        ];
 
        // dd($yearleader_api);

        return view('shareData_headManager.report_full_year', $data);
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
