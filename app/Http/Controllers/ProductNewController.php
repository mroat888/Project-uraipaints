<?php

namespace App\Http\Controllers;

use App\News;
use App\NewsBanner;
use App\ProductNew;
use App\ProductNewGallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductNewController extends Controller
{

    public function index()
    {
        $product_new = ProductNew::orderBy('status_usage', 'desc')->orderBy('id', 'desc')->get();
        return view('admin.product_new', compact('product_new'));
    }

    public function gallery($id)
    {
        $productID = ProductNew::find($id);
        $gallerys = ProductNewGallery::where('product_new_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.product_new_gallery', compact('productID', 'gallerys'));
    }

    public function search_news_status_usage(Request $request)
    {
        if ($request->status_usage != '') {
            $product_new = ProductNew::where('status_usage', $request->status_usage)
            ->orderBy('status_usage', 'desc')->orderBy('id', 'desc')->get();
            return view('admin.product_new', compact('product_new'));
        }else{
            $product_new = ProductNew::orderBy('status_usage', 'desc')->orderBy('id', 'desc')->get();
            return view('admin.product_new', compact('product_new'));
        }
    }

    public function product_new_detail($id)
    {
        $data_product = ProductNew::where('id', $id)->first();
        $gallerys = ProductNewGallery::where('product_new_id', $id)->orderBy('id', 'desc')->get();

        if (Auth::user()->status == 1) {
            return view('saleman.product_new_detail', compact('data_product', 'gallerys'));
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_new_detail', compact('data_product', 'gallerys'));
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_new_detail', compact('data_product', 'gallerys'));
        }
    }

    public function frontend_product_new()
    {
        $list_product_new = ProductNew::orderBy('id', 'desc')->paginate(10);
        return view('saleman.product_new', compact('list_product_new'));
    }

    public function lead_frontend_product_new()
    {
        $list_product_new = ProductNew::orderBy('id', 'desc')->paginate(10);
        return view('leadManager.product_new', compact('list_product_new'));
    }

    public function head_frontend_product_new()
    {
        $list_product_new = ProductNew::orderBy('id', 'desc')->paginate(10);
        return view('headManager.product_new', compact('list_product_new'));
    }

    public function admin_frontend_product_new()
    {
        $list_product_new = ProductNew::orderBy('id', 'desc')->paginate(10);
        return view('admin.frontendProduct_new', compact('list_product_new'));
    }

    public function search_product_new(Request $request)
    {
        $list_product_new = ProductNew::where('product_title', 'LIKE', '%'.$request->search.'%')->orderBy('id', 'desc')->paginate(10);

        if (Auth::user()->status == 1) {
            return view('saleman.product_new', compact('list_product_new'));
        }elseif (Auth::user()->status == 2) {
            return view('leadManager.product_new', compact('list_product_new'));
        }elseif (Auth::user()->status == 3) {
            return view('headManager.product_new', compact('list_product_new'));
        }
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            if ($request->image != '') {
                $path = 'upload/ProductNewImage';
                $image = '';
            if (!empty($request->file('image'))) {
                $img = $request->file('image');
                $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }

            DB::table('product_new')
            ->insert([
                'product_title'       => $request->product_title,
                'product_detail'      => $request->product_detail,
                'product_url'         => $request->product_url,
                'product_image'       => $image,
                // 'product_status'      => 1,
                'created_by'          => Auth::user()->id,
                'created_at'          => Carbon::now(),
                'updated_by'          => Auth::user()->id,
                'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_new')
                ->insert([
                    'product_title'       => $request->product_title,
                    'product_detail'      => $request->product_detail,
                    'product_url'         => $request->product_url,
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

    public function edit($id)
    {
        $dataEdit = ProductNew::find($id);
        $data = array(
            'dataEdit'  => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $path = 'upload/ProductNewImage';
            $image = '';

            if ($request->image_edit != '') {
                if (!empty($request->file('image_edit'))) {

                    $data = ProductNew::find($request->id);

                    //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                    if (!empty($data->product_image)) {
                        $path2 = 'upload/ProductNewImage/';
                        unlink(public_path($path2 . $data->product_image));
                    }

                    $img = $request->file('image_edit');
                    $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                    $save_path = $img->move(public_path($path), $img_name);
                    $image = $img_name;
                }
                DB::table('product_new')->where('id',$request->id)
                ->update([
                'product_title'       => $request->product_title_edit,
                'product_detail'      => $request->product_detail_edit,
                'product_url'         => $request->product_url_edit,
                'product_image'       => $image,
                'updated_by'          => Auth::user()->id,
                'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_new')->where('id',$request->id)
                ->update([
                    'product_title'       => $request->product_title_edit,
                    'product_detail'      => $request->product_detail_edit,
                    'product_url'         => $request->product_url_edit,
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

    public function destroy($id)
    {
        $data = ProductNew::where('id', $id)->first();
            if (!empty($data->product_image)) {
                $path2 = 'public/upload/ProductNewImage/';
                unlink($path2 . $data->product_image);
            }

            ProductNew::where('id', $id)->delete();
        return back();
    }

    public function update_status_use($id){
        $chk = DB::table('product_new')->where('id', $id)->first();

        if ($chk->status_usage == 1) {
            DB::table('product_new')->where('id', $chk->id)
            ->update([
                'status_usage' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }else {
            DB::table('product_new')->where('id', $chk->id)
            ->update([
                'status_usage' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }
        return back();
    }

    public function gallery_store(Request $request)
    {
        // dd($request->news_gallery);
        DB::beginTransaction();
        try {

        foreach ($request->news_gallery as $key => $gallery) {

            $path = 'upload/ProductNewGallery';
            $image = '';
            $img_name = '';
            $img = '';
            if (!empty($request->news_gallery[$key])) {
                $img = $request->news_gallery[$key];
                $img_name = 'gallery-' . time(). $key. '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;

            }

            ProductNewGallery::create([
                'product_new_id' => $request->productID_id,
                'image' => $image,
                'path' => $path,
                'created_by'   => Auth::user()->id,
            ]);


                // echo $image;

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
        $dataEdit = ProductNewGallery::find($id);

        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function gallery_update(Request $request)
    {
            $path = 'upload/ProductNewGallery';
            $image = '';
            $data = ProductNewGallery::find($request->id);

            if (!empty($request->file('news_gallery'))) {
                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->image)) {
                    $path2 = 'upload/ProductNewGallery/';
                    unlink(public_path($path2) . $data->image);
                }

                $img = $request->file('news_gallery');
                $img_name = 'gallery-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;


                $data2 = ProductNewGallery::find($request->id);
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

            $data = ProductNewGallery::find($request->gallery_id_delete);
            if (!empty($data->image)) {
                $path1 = 'public/upload/ProductNewGallery/';
                unlink($path1 . $data->image);
            }

        ProductNewGallery::find($request->gallery_id_delete)->delete();
        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function view_detail($id)
    {
        $data_product = ProductNew::find($id);
        $gallerys = ProductNewGallery::where('product_new_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.product_new_view_detail', compact('data_product', 'gallerys'));
    }

}
