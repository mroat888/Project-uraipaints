<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductProperty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductPropertyController extends Controller
{

    public function index()
    {
        $propertys = ProductProperty::orderBy('id', 'desc')->get();
        return view('admin.product_property', compact('propertys'));
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            if ($request->image != '') {
                $path = 'upload/ProductPropertyImage';
                $image = '';
            if (!empty($request->file('image'))) {
                $img = $request->file('image');
                $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }

            DB::table('product_property')
            ->insert([
                'property_title'       => $request->property_title,
                'property_detail'      => $request->property_detail,
                'property_url'         => $request->property_url,
                'property_image'       => $image,
                'created_by'          => Auth::user()->id,
                'created_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_property')
                ->insert([
                    'property_title'       => $request->property_title,
                    'property_detail'      => $request->property_detail,
                    'property_url'         => $request->property_url,
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
        $dataEdit = ProductProperty::find($id);
        $data = array(
            'dataEdit'  => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $path = 'upload/ProductPropertyImage';
            $image = '';

            if ($request->image_edit != '') {
                if (!empty($request->file('image_edit'))) {

                    $data = ProductProperty::find($request->id);

                    //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                    if (!empty($data->property_image)) {
                        $path2 = 'upload/ProductPropertyImage/';
                        unlink(public_path($path2 . $data->property_image));
                    }

                    $img = $request->file('image_edit');
                    $img_name = 'img-' . time() . '.' . $img->getClientOriginalExtension();
                    $save_path = $img->move(public_path($path), $img_name);
                    $image = $img_name;
                }
                DB::table('product_property')->where('id',$request->id)
                ->update([
                'property_title'       => $request->property_title_edit,
                'property_detail'      => $request->property_detail_edit,
                'property_url'         => $request->property_url_edit,
                'property_image'       => $image,
                'updated_by'          => Auth::user()->id,
                'updated_at'          => Carbon::now(),
            ]);
            }else{
                DB::table('product_property')->where('id',$request->id)
                ->update([
                    'property_title'       => $request->property_title_edit,
                    'property_detail'      => $request->property_detail_edit,
                    'property_url'         => $request->property_url_edit,
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
        $data = ProductProperty::where('id', $id)->first();
            if (!empty($data->property_image)) {
                $path2 = 'public/upload/ProductPropertyImage/';
                unlink($path2 . $data->property_image);
            }

            ProductProperty::where('id', $id)->delete();
        return back();
    }
}
