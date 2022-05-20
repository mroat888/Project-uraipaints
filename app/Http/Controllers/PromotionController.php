<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsBanner;
use App\NewsGallery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{

    public function frontend_promotion()
    {
        $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->first();

        $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->get();

        $list_promotion = News::where('status', "P")->orderBy('id', 'desc')->paginate(10);

        return view('saleman.promotions', compact('list_promotion', 'list_news_a', 'list_banner'));
    }

    public function lead_frontend_promotion()
    {
        $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->first();

        $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->get();

        $list_promotion = News::where('status', "P")->orderBy('id', 'desc')->paginate(10);

        return view('leadManager.promotions', compact('list_promotion', 'list_news_a', 'list_banner'));
    }

    public function head_frontend_promotion()
    {
        $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->first();

        $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->get();

        $list_promotion = News::where('status', "P")->orderBy('id', 'desc')->paginate(10);

        return view('headManager.promotions', compact('list_promotion', 'list_news_a', 'list_banner'));
    }

    // public function admin_frontend_promotion()
    // {
    //     $list_promotion = News::where('status', "P")->orderBy('id', 'desc')->paginate(10);
    //     return view('admin.fontendPromotions', compact('list_promotion'));
    // }

    public function search_promotion(Request $request)
    {
        // return $request->selectdateFrom;
            $list_promotion = News::where('status', "P")
            ->where('news_date', 'LIKE', $request->selectdateFrom.'%')
            ->orderBy('id', 'desc')->paginate(10);

            $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->first();

        $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->get();


        return view('saleman.promotions', compact('list_promotion', 'list_news_a', 'list_banner'));

    }

    public function lead_search_promotion(Request $request)
    {
        // return $request->selectdateFrom;
            $list_promotion = News::where('status', "P")
            ->where('news_date', 'LIKE', $request->selectdateFrom.'%')
            ->orderBy('id', 'desc')->paginate(10);

            $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->first();

        $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->get();


        return view('leadManager.promotions', compact('list_promotion', 'list_news_a', 'list_banner'));

    }

    public function head_search_promotion(Request $request)
    {
        // return $request->selectdateFrom;
            $list_promotion = News::where('status', "P")
            ->where('news_date', 'LIKE', $request->selectdateFrom.'%')
            ->orderBy('id', 'desc')->paginate(10);

            $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->first();

        $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        ->orderBy('id', 'desc')->get();


        return view('headManager.promotions', compact('list_promotion', 'list_news_a', 'list_banner'));

    }

    public function index()
    {
        $list_promotion = News::where('status', "P")->orderBy('status_promotion', 'desc')->orderBy('news_date_last', 'asc')->get();
        return view('admin.pomotions', compact('list_promotion'));
    }

    public function view_detail($id)
    {
        $data = News::find($id);
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.promotion_view_detail', compact('data', 'gallerys'));
    }

    public function gallery($id)
    {
        $promotionID = News::find($id);
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.promotion_gallery', compact('promotionID', 'gallerys'));
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

    public function gallery_store(Request $request)
    {
        // dd($request->news_gallery);
        DB::beginTransaction();
        try {

        foreach ($request->promotion_gallery as $key => $gallery) {

            $path = 'upload/PromotionGallery';
            $image = '';
            $img_name = '';
            $img = '';
            if (!empty($request->promotion_gallery[$key])) {
                $img = $request->promotion_gallery[$key];
                $img_name = 'gallery-' . time(). $key. '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;

            }

            NewsGallery::create([
                'news_id' => $request->promotion_id,
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

    public function edit($id)
    {
        $dataEdit = News::find($id);
        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function gallery_edit($id)
    {
        $dataEdit = NewsGallery::find($id);

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

    public function gallery_update(Request $request)
    {
            $path = 'upload/PromotionGallery';
            $image = '';
            $data = NewsGallery::find($request->id);

            if (!empty($request->file('promotion_gallery'))) {
                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->image)) {
                    $path2 = 'upload/PromotionGallery/';
                    unlink(public_path($path2) . $data->image);
                }

                $img = $request->file('promotion_gallery');
                $img_name = 'gallery-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;


                $data2 = NewsGallery::find($request->id);
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

            $data = NewsGallery::find($request->gallery_id_delete);
            if (!empty($data->image)) {
                $path1 = 'public/upload/PromotionGallery/';
                unlink($path1 . $data->image);
            }

        NewsGallery::find($request->gallery_id_delete)->delete();
        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function index_banner()
    {
        $list_banner = NewsBanner::orderBy('id', 'desc')->get();
        return view('admin.promotion_banner', compact('list_banner'));
    }

    public function banner_store(Request $request)
    {
        DB::beginTransaction();
        try {

            $path = 'upload/NewsBanner';
            $image = '';
            if (!empty($request->file('banner'))) {
                $img = $request->file('banner');
                $img_name = 'banner-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;
            }

            NewsBanner::create([
                'date' => $request->date,
                'date_last' => $request->date_last,
                'detail' => $request->detail,
                'banner' => $image,
                'created_by' => Auth::user()->id,

            ]);

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

    public function banner_edit($id)
    {
        $dataEdit = NewsBanner::find($id);
        $data = array(
            'dataEdit'     => $dataEdit,
        );
        echo json_encode($data);
    }

    public function banner_update(Request $request)
    {
        if ($request->banner != '') {
            $path = 'upload/NewsBanner';
            $image = '';
            $data = NewsBanner::find($request->id);

            if (!empty($request->file('banner'))) {
                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->banner)) {
                    $path2 = 'public/upload/NewsBanner/';
                    unlink($path2 . $data->banner);
                }

                $img = $request->file('banner');
                $img_name = 'banner-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;


                $data2 = NewsBanner::find($request->id);
                $data2->date              = $request->date;
                $data2->date_last         = $request->date_last;
                $data2->detail            = $request->detail;
                $data2->banner            = $image;
                $data2->updated_by        = Auth::user()->id;
                $data2->updated_at        = Carbon::now();
                $data2->update();
                DB::commit();
            }
        } else {

            $data2 = NewsBanner::find($request->id);
            $data2->date              = $request->date;
            $data2->date_last         = $request->date_last;
            $data2->detail            = $request->detail;
            $data2->updated_by        = Auth::user()->id;
            $data2->updated_at        = Carbon::now();
            $data2->update();
            DB::commit();
        }

        return back();
    }

    public function banner_destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = NewsBanner::where('id', $request->promotion_id_delete)->get();
        foreach ($data as $value) {
            if (!empty($value->banner)) {
                $path1 = 'public/upload/NewsBanner/';
                unlink($path1 . $value->banner);
            }
        }
        NewsBanner::where('id', $request->promotion_id_delete)->delete();
        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function promotion_detail($id)
    {
        $data = News::where('id', $id)->first();
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();

        return view('saleman.promotions_detail', compact('data', 'gallerys'));
    }

    public function lead_promotion_detail($id)
    {
        $data = News::where('id', $id)->first();
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();

        return view('leadManager.promotions_detail', compact('data', 'gallerys'));
    }

    public function head_promotion_detail($id)
    {
        $data = News::where('id', $id)->first();
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();

        return view('headManager.promotions_detail', compact('data', 'gallerys'));
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

    public function update_status_use($id){
        $chk = DB::table('news_promotions')->where('id', $id)->first();

        if ($chk->status_usage == 1) {
            DB::table('news_promotions')->where('id', $chk->id)
            ->update([
                'status_usage' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }else {
            DB::table('news_promotions')->where('id', $chk->id)
            ->update([
                'status_usage' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
            ]);
        }
        return back();
    }


}
