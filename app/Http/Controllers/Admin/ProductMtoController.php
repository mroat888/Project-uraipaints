<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\ProductMTO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductMtoController extends Controller
{

    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['product_mto'] = ProductMTO::orderBy('status', 'desc')->orderBy('id', 'desc')->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        $data['groups'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['groups'][$key] =
            [
                'id' => $value['identify'],
                'group_name' => $value['name'],
            ];
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        $data['brands'] = array();
        foreach ($res_api2['data'] as $key => $value) {
            $data['brands'][$key] =
            [
                'id' => $value['identify'],
                'brand_name' => $value['name'],
            ];
        }

        return view('admin.product_mto', $data);
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            if ($request->image != '') {
                $path = 'upload/ProductMTO';
                $image = '';
            if (!empty($request->file('image'))) {
                $img = $request->file('image');
                $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }

            DB::table('product_mto')
            ->insert([
                'category_id'         => $request->category_id,
                'brand_id'            => $request->brand_id,
                'description'         => $request->description,
                'url'                 => $request->url,
                'image'               => $image,
                'created_by'          => Auth::user()->id,
                'created_at'          => Carbon::now(),
                'updated_by'          => Auth::user()->id,
                'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_mto')
                ->insert([
                    'category_id'         => $request->category_id,
                    'brand_id'            => $request->brand_id,
                    'description'         => $request->description,
                    'url'                 => $request->url,
                    'created_by'          => Auth::user()->id,
                    'created_at'          => Carbon::now(),
                    'updated_by'          => Auth::user()->id,
                    'updated_at'          => Carbon::now(),
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                'data' => $request,
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
                'data' => $request,
            ]);
        }
    }

    public function update_status_use($id){
        $chk = DB::table('product_mto')->where('id', $id)->first();

        if ($chk->status == 1) {
            DB::table('product_mto')->where('id', $chk->id)
            ->update([
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }else {
            DB::table('product_mto')->where('id', $chk->id)
            ->update([
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }
        return back();
    }

    public function edit($id)
    {
        $dataEdit = ProductMTO::find($id);

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        $editGroups = array();
        foreach ($res_api['data'] as $key => $value) {
            $editGroups[$key] =
            [
                'id' => $value['identify'],
                'group_name' => $value['name'],
            ];
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        $editBrands = array();
        foreach ($res_api2['data'] as $key => $value) {
            $editBrands[$key] =
            [
                'id' => $value['identify'],
                'brand_name' => $value['name'],
            ];
        }

        $data = array(
            'dataEdit'  => $dataEdit,
            'editGroups'  => $editGroups,
            'editBrands'  => $editBrands,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $path = 'upload/ProductMTO';
            $image = '';

            if ($request->image_edit != '') {
                if (!empty($request->file('image_edit'))) {

                    $data = ProductMTO::find($request->id);

                    //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                    if (!empty($data->product_image)) {
                        $path2 = 'upload/ProductMTO/';
                        unlink(public_path($path2 . $data->product_image));
                    }

                    $img = $request->file('image_edit');
                    $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                    $save_path = $img->move(public_path($path), $img_name);
                    $image = $img_name;
                }
                DB::table('product_mto')->where('id',$request->id)
                ->update([
                    'category_id'         => $request->category_id,
                    'brand_id'            => $request->brand_id,
                    'description'         => $request->description_edit,
                    'url'                 => $request->url_edit,
                    'image'               => $image,
                    'updated_by'          => Auth::user()->id,
                    'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_mto')->where('id',$request->id)
                ->update([
                    'category_id'         => $request->category_id,
                    'brand_id'            => $request->brand_id,
                    'description'         => $request->description_edit,
                    'url'                 => $request->url_edit,
                    'updated_by'          => Auth::user()->id,
                    'updated_at'          => Carbon::now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $data = ProductMTO::where('id', $request->mto_id_delete)->first();
            if (!empty($data->image)) {
                $path2 = 'public/upload/ProductMTO/';
                unlink($path2 . $data->image);
            }

            ProductMTO::where('id', $request->mto_id_delete)->delete();
        return back();
    }

    public function search(Request $request)
    {
        $data['product_mto'] = DB::table('product_mto');

        if ($request->status_usage != '') {
            $data['product_mto'] = $data['product_mto']->where('status', $request->status_usage);
        }

        if ($request->brand != '') {
            $data['product_mto'] = $data['product_mto']->where('brand_id', $request->brand);
        }

        if ($request->category != '') {
            $data['product_mto'] = $data['product_mto']->where('category_id', $request->category);
        }

        $data['product_mto'] = $data['product_mto']->orderBy('status', 'desc')->orderBy('id', 'desc')->get();

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        $data['groups'] = array();
        foreach ($res_api['data'] as $key => $value) {
            $data['groups'][$key] =
            [
                'id' => $value['identify'],
                'group_name' => $value['name'],
            ];
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        $data['brands'] = array();
        foreach ($res_api2['data'] as $key => $value) {
            $data['brands'][$key] =
            [
                'id' => $value['identify'],
                'brand_name' => $value['name'],
            ];
        }

        return view('admin.product_mto', $data);
    }

    public function view_detail($id)
    {
        $data_product = ProductMTO::find($id);

        $api_token = $this->api_token->apiToken();
        $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/groups');
        $res_api = $response->json();

        $dataGroups = array();
        foreach ($res_api['data'] as $key => $value) {
            $dataGroups[$key] =
            [
                'id' => $value['identify'],
                'group_name' => $value['name'],
            ];
        }

        $response2 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/brands');
        $res_api2 = $response2->json();

        $dataBrands = array();
        foreach ($res_api2['data'] as $key => $value) {
            $dataBrands[$key] =
            [
                'id' => $value['identify'],
                'brand_name' => $value['name'],
            ];
        }

        $data = array(
            'data_product'  => $data_product,
            'dataGroups'  => $dataGroups,
            'dataBrands'  => $dataBrands,
        );
        return view('admin.product_mto_view_detail', $data);
    }
}
