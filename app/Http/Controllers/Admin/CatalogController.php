<?php

namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\ProductNew;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CatalogController extends Controller
{

    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['product_catalog'] = Catalog::orderBy('id', 'desc')->get();

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

        $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
        $res_api3 = $response3->json();

        $data['pdglists'] = array();
        foreach ($res_api3['data'] as $key => $value) {
            $data['pdglists'][$key] =
            [
                'id' => $value['identify'],
                'pdglist_name' => $value['name'],
            ];
        }

        return view('admin.catalog', $data);
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            if ($request->image != '') {
                $path = 'upload/Catalog';
                $image = '';
            if (!empty($request->file('image'))) {
                $img = $request->file('image');
                $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }

            DB::table('product_catalog')
            ->insert([
                'category_id'         => $request->category_id,
                'brand_id'            => $request->brand_id,
                'product_list'        => $request->product_list,
                'description'         => $request->description,
                'url'                 => $request->url,
                'image'               => $image,
                'created_by'          => Auth::user()->id,
                'created_at'          => Carbon::now(),
                'updated_by'          => Auth::user()->id,
                'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_catalog')
                ->insert([
                    'category_id'         => $request->category_id,
                    'brand_id'            => $request->brand_id,
                    'product_list'        => $request->product_list,
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
        $chk = DB::table('product_catalog')->where('id', $id)->first();

        if ($chk->status == 1) {
            DB::table('product_catalog')->where('id', $chk->id)
            ->update([
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }else {
            DB::table('product_catalog')->where('id', $chk->id)
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
        $dataEdit = Catalog::find($id);

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

        $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
        $res_api3 = $response3->json();

        $editPdglists = array();
        foreach ($res_api3['data'] as $key => $value) {
            $editPdglists[$key] =
            [
                'id' => $value['identify'],
                'pdglist_name' => $value['name'],
            ];
        }

        $data = array(
            'dataEdit'  => $dataEdit,
            'editGroups'  => $editGroups,
            'editBrands'  => $editBrands,
            'editPdglists'  => $editPdglists,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $path = 'upload/Catalog';
            $image = '';

            if ($request->image_edit != '') {
                if (!empty($request->file('image_edit'))) {

                    $data = ProductNew::find($request->id);

                    //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                    if (!empty($data->product_image)) {
                        $path2 = 'upload/Catalog/';
                        unlink(public_path($path2 . $data->product_image));
                    }

                    $img = $request->file('image_edit');
                    $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                    $save_path = $img->move(public_path($path), $img_name);
                    $image = $img_name;
                }
                DB::table('product_catalog')->where('id',$request->id)
                ->update([
                    'category_id'         => $request->category_id,
                    'brand_id'            => $request->brand_id,
                    'product_list'        => $request->product_list,
                    'description'         => $request->description_edit,
                    'url'                 => $request->url_edit,
                    'image'               => $image,
                    'updated_by'          => Auth::user()->id,
                    'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_catalog')->where('id',$request->id)
                ->update([
                    'category_id'         => $request->category_id,
                    'brand_id'            => $request->brand_id,
                    'product_list'        => $request->product_list,
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

    public function search(Request $request)
    {
        $data['product_catalog'] = DB::table('product_catalog');

        if ($request->status_usage != '') {
            $data['product_catalog'] = $data['product_catalog']->where('status', $request->status_usage);
        }

        if ($request->brand != '') {
            $data['product_catalog'] = $data['product_catalog']->where('brand_id', $request->brand);
        }

        if ($request->category != '') {
            $data['product_catalog'] = $data['product_catalog']->where('category_id', $request->category);
        }

        $data['product_catalog'] = $data['product_catalog']->orderBy('status', 'desc')->orderBy('id', 'desc')->get();

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

        $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
        $res_api3 = $response3->json();

        $data['pdglists'] = array();
        foreach ($res_api3['data'] as $key => $value) {
            $data['pdglists'][$key] =
            [
                'id' => $value['identify'],
                'pdglist_name' => $value['name'],
            ];
        }

        return view('admin.catalog', $data);
    }

    public function view_detail($id)
    {
        $dataEdit = Catalog::find($id);

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

        $response3 = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/pdglists');
        $res_api3 = $response3->json();

        $editPdglists = array();
        foreach ($res_api3['data'] as $key => $value) {
            $editPdglists[$key] =
            [
                'id' => $value['identify'],
                'pdglist_name' => $value['name'],
            ];
        }

        $data = array(
            'dataEdit'  => $dataEdit,
            'editGroups'  => $editGroups,
            'editBrands'  => $editBrands,
            'editPdglists'  => $editPdglists,
        );
        echo json_encode($data);
    }

    public function destroy(Request $request)
    {
        $data = Catalog::where('id', $request->catalog_id_delete)->first();
            if (!empty($data->image)) {
                $path2 = 'public/upload/Catalog/';
                unlink($path2 . $data->image);
            }

            Catalog::where('id', $request->catalog_id_delete)->delete();
        return back();
    }
}
