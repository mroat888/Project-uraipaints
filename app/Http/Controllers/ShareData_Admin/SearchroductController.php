<?php

namespace App\Http\Controllers\ShareData_Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class SearchroductController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/groups?sortorder=DESC/');
        $groups_api = $response->json();

        return view('shareData_admin.search_product', compact('groups_api'));
    }

    public function search(Request $request){

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/groups?sortorder=DESC/');
        $groups_api = $response->json();

        // dd($pdglists_api);

        $product_api = null;

        if(!is_null($request->sel_pdglists)){
            $api_token = $this->api_token->apiToken();
            $response = Http::withToken($api_token)->get(env("API_LINK").'api/v1/pdglists/'.$request->sel_pdglists.'/products');
            if($response['code'] == 200){
                $product_api = $response->json();
            }
        }

        return view('shareData_admin.search_product', compact('groups_api', 'product_api'));

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
