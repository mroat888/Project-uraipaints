<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\ProductPrice;
use App\ProductPriceGallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductPriceController extends Controller
{
    public function __construct(){
        $this->api_token = new ApiController();
    }

    public function index()
    {
        $data['product_price'] = ProductPrice::orderBy('status', 'desc')->orderBy('id', 'desc')->get();

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

        return view('admin.product_price', $data);
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            if ($request->image != '') {
                $path = 'upload/ProductPrice';
                $image = '';
            if (!empty($request->file('image'))) {
                $img = $request->file('image');
                $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }

            DB::table('product_price')
            ->insert([
                'category_id'         => $request->category_id,
                'name'            => $request->name,
                'description'         => $request->description,
                'url'                 => $request->url,
                'image'               => $image,
                'created_by'          => Auth::user()->id,
                'created_at'          => Carbon::now(),
                'updated_by'          => Auth::user()->id,
                'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_price')
                ->insert([
                    'category_id'         => $request->category_id,
                    'name'            => $request->name,
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
        $chk = DB::table('product_price')->where('id', $id)->first();

        if ($chk->status == 1) {
            DB::table('product_price')->where('id', $chk->id)
            ->update([
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }else {
            DB::table('product_price')->where('id', $chk->id)
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
        $dataEdit = ProductPrice::find($id);

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

        $data = array(
            'dataEdit'  => $dataEdit,
            'editGroups'  => $editGroups,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $path = 'upload/ProductPrice';
            $image = '';

            if ($request->image_edit != '') {
                if (!empty($request->file('image_edit'))) {

                    $data = ProductPrice::find($request->id);

                    //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                    if (!empty($data->product_image)) {
                        $path2 = 'upload/ProductPrice/';
                        unlink(public_path($path2 . $data->product_image));
                    }

                    $img = $request->file('image_edit');
                    $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                    $save_path = $img->move(public_path($path), $img_name);
                    $image = $img_name;
                }
                DB::table('product_price')->where('id',$request->id)
                ->update([
                    'category_id'         => $request->category_id,
                    'name'            => $request->name,
                    'description'         => $request->description_edit,
                    'url'                 => $request->url_edit,
                    'image'               => $image,
                    'updated_by'          => Auth::user()->id,
                    'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_price')->where('id',$request->id)
                ->update([
                    'category_id'         => $request->category_id,
                    'name'            => $request->name,
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
        $data = ProductPrice::where('id', $request->price_id_delete)->first();
            if (!empty($data->image)) {
                $path2 = 'public/upload/ProductPrice/';
                unlink($path2 . $data->image);
            }

            ProductPrice::where('id', $request->price_id_delete)->delete();
        return back();
    }

    public function search(Request $request)
    {
        $data['product_price'] = DB::table('product_price');

        if ($request->status_usage != '') {
            $data['product_price'] = $data['product_price']->where('status', $request->status_usage);
        }

        if ($request->brand != '') {
            $data['product_price'] = $data['product_price']->where('name', $request->brand);
        }

        if ($request->category != '') {
            $data['product_price'] = $data['product_price']->where('category_id', $request->category);
        }

        $data['product_price'] = $data['product_price']->orderBy('status', 'desc')->orderBy('id', 'desc')->get();

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

        return view('admin.product_price', $data);
    }

    public function view_detail($id)
    {
        $data['product_price'] = ProductPrice::where('id', $id)->first();
        $data['gallerys'] = ProductPriceGallery::where('product_price_id', $id)->orderBy('id', 'desc')->get();

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

        return view('admin.product_price_view_detail', $data);
    }

    public function gallery($id)
    {
        $data['product_price'] = ProductPrice::where('id', $id)->first();
        $data['gallerys'] = ProductPriceGallery::where('product_price_id', $id)->orderBy('id', 'desc')->get();

        return view('admin.product_price_gallery', $data);
    }

    public function gallery_store(Request $request)
    {
        // dd($request->price_gallery);
        DB::beginTransaction();
        try {

        foreach ($request->price_gallery as $key => $gallery) {

            $path = 'upload/ProductPriceGallery';
            $image = '';
            $img_name = '';
            $img = '';
            if (!empty($request->price_gallery[$key])) {
                $img = $request->price_gallery[$key];
                $img_name = 'gallery-' . time(). $key. '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;

            }

            ProductPriceGallery::create([
                'product_price_id' => $request->productID_id,
                'image' => $image,
                'path' => $path,
                'created_by'   => Auth::user()->id,
            ]);

        }
        // return back();

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                // 'data' => $img_name,
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
                // 'data' => $request,
            ]);
        }
    }

    public function gallery_edit($id)
    {
        $dataEdit = ProductPriceGallery::find($id);

        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function gallery_update(Request $request)
    {
            $path = 'upload/ProductPriceGallery';
            $image = '';
            $data = ProductPriceGallery::find($request->id);

            if (!empty($request->file('price_gallery'))) {
                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->image)) {
                    $path2 = 'upload/ProductPriceGallery/';
                    unlink(public_path($path2) . $data->image);
                }

                $img = $request->file('price_gallery');
                $img_name = 'gallery-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;


                $data2 = ProductPriceGallery::find($request->id);
                $data2->image             = $image;
                $data2->updated_by        = Auth::user()->id;
                $data2->updated_at        = Carbon::now();
                $data2->update();
                DB::commit();
            }

        return back();
    }

    public function gallery_destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = ProductPriceGallery::find($request->gallery_id_delete);
            if (!empty($data->image)) {
                $path1 = 'public/upload/ProductPriceGallery/';
                unlink($path1 . $data->image);
            }

        ProductPriceGallery::find($request->gallery_id_delete)->delete();
        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
        ]);
    }
}
