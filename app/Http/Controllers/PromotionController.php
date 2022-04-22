<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsBanner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{

    public function frontend_promotion()
    {
        $list_promotion = News::where('status', "P")->orderBy('id', 'desc')->paginate(10);
        return view('saleman.promotions', compact('list_promotion'));
    }

    public function lead_frontend_promotion()
    {
        $list_promotion = News::where('status', "P")->orderBy('id', 'desc')->paginate(10);
        return view('leadManager.promotions', compact('list_promotion'));
    }

    public function head_frontend_promotion()
    {
        $list_promotion = News::where('status', "P")->orderBy('id', 'desc')->paginate(10);
        return view('headManager.promotions', compact('list_promotion'));
    }

    public function admin_frontend_promotion()
    {
        $list_promotion = News::where('status', "P")->orderBy('id', 'desc')->paginate(10);
        return view('admin.fontendPromotions', compact('list_promotion'));
    }

    public function index()
    {
        $list_promotion = News::where('status', "P")->orderBy('status_promotion', 'desc')->orderBy('news_date_last', 'asc')->get();
        return view('admin.pomotions', compact('list_promotion'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $path = 'upload/PromotionImage';
            $image = '';
            if (!empty($request->file('news_image'))) {
                $img = $request->file('news_image');
                $img_name = 'p-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }


            News::create([
                'news_date' => $request->news_date,
                'news_date_last' => $request->news_date_last,
                'news_title' => $request->news_title,
                'news_detail' => $request->news_detail,
                'news_image' => $image,
                'url'       => $request->url,
                'status'    => "P",
                'status_share' => $request->status_share,
                'created_by' => Auth::user()->id,

            ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'บันทึกข้อมูลสำเร็จ',
                'data' => $img_name,
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
        $dataEdit = News::find($id);
        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        if ($request->news_image != '') {
            $path = 'upload/PromotionImage';
            $image = '';
            $data = News::find($request->id);

            if (!empty($request->file('news_image'))) {
                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->news_image)) {
                    $path2 = 'public/upload/PromotionImage/';
                    unlink($path2 . $data->news_image);
                }

                $img = $request->file('news_image');
                $img_name = 'p-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;


                $data2 = News::find($request->id);
                $data2->news_date         = $request->news_date;
                $data2->news_date_last    = $request->news_date_last;
                $data2->news_title        = $request->news_title;
                $data2->news_detail       = $request->news_detail;
                $data2->news_image        = $image;
                $data2->url               = $request->url;
                $data2->status_share      = $request->status_share;
                $data2->updated_by        = Auth::user()->id;
                $data2->updated_at        = Carbon::now();
                $data2->update();
                DB::commit();
            }
        } else {

            $data2 = News::find($request->id);
            $data2->news_date         = $request->news_date;
            $data2->news_date_last    = $request->news_date_last;
            $data2->news_title        = $request->news_title;
            $data2->news_detail       = $request->news_detail;
            $data2->url               = $request->url;
            $data2->status_share      = $request->status_share;
            $data2->updated_by        = Auth::user()->id;
            $data2->updated_at        = Carbon::now();
            $data2->update();
            DB::commit();
        }
        return back();
    }


    public function destroy($id)
    {
        $data = News::where('id', $id)->get();
        foreach ($data as $value) {
            if (!empty($value->news_image)) {
                $path1 = 'public/upload/PromotionImage/';
                unlink($path1 . $value->news_image);
            }
        }
        News::where('id', $id)->delete();
        return back();
    }

    public function promotion_detail($id)
    {
        $data = News::where('id', $id)->first();

        return view('saleman.promotions_detail', compact('data'));
    }

    public function lead_promotion_detail($id)
    {
        $data = News::where('id', $id)->first();

        return view('leadManager.promotions_detail', compact('data'));
    }

    public function head_promotion_detail($id)
    {
        $data = News::where('id', $id)->first();

        return view('headManager.promotions_detail', compact('data'));
    }

    public function admin_promotion_detail($id)
    {
        $data = News::where('id', $id)->first();

        return view('admin.promotions_detail', compact('data'));
    }

    public function search_promotion_status_promotion(Request $request)
    {
        if ($request->status_promotion != '') {
            $list_promotion = News::where('status', "P")->where('status_promotion', $request->status_promotion)
            ->orderBy('status_usage', 'desc')->orderBy('id', 'desc')->get();
            return view('admin.pomotions', compact('list_promotion'));
        }else{
            $list_promotion = News::where('status', "P")->orderBy('status_usage', 'desc')->orderBy('id', 'desc')->get();
            return view('admin.pomotions', compact('list_promotion'));
        }
    }


}
