<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductNew;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductNewController extends Controller
{

    public function index()
    {
        $product_new = ProductNew::orderBy('id', 'desc')->get();
        return view('admin.product_new', compact('product_new'));
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
            ]);
            }else{
                DB::table('product_new')
                ->insert([
                    'product_title'       => $request->product_title,
                    'product_detail'      => $request->product_detail,
                    'product_url'         => $request->product_url,
                    'created_by'          => Auth::user()->id,
                    'created_at'          => Carbon::now(),
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
}
