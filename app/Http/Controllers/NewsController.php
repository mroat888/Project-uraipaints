<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
use App\NewsBanner;
use App\NewsGallery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function frontend_news()
    {
        // $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        // ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        // ->orderBy('id', 'desc')->first();
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->paginate(10);
        // $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        // ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        // ->orderBy('id', 'desc')->get();
        return view('saleman.news', compact('list_news'));
    }

    public function lead_frontend_news()
    {
        // $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        // ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        // ->orderBy('id', 'desc')->first();
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->paginate(10);
        // $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        // ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        // ->orderBy('id', 'desc')->get();
        return view('leadManager.news', compact('list_news'));
    }

    public function head_frontend_news()
    {
        // $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        // ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        // ->orderBy('id', 'desc')->first();
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->paginate(10);
        // $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        // ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        // ->orderBy('id', 'desc')->get();
        return view('headManager.news', compact('list_news'));
    }

    public function admin_frontend_news()
    {
        // $list_news_a = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        // ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        // ->orderBy('id', 'desc')->first();
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->paginate(10);
        // $list_banner = NewsBanner::where('date', '<=', Carbon::today()->format('Y-m-d'))
        // ->where('date_last', '>=', Carbon::today()->format('Y-m-d'))
        // ->orderBy('id', 'desc')->get();
        return view('admin.fontendNews', compact('list_news'));
    }

    public function news_detail($id)
    {
        $data = News::where('id', $id)->first();
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();

        return view('saleman.news_detail', compact('data', 'gallerys'));
    }

    public function lead_news_detail($id)
    {
        $data = News::where('id', $id)->first();

        return view('leadManager.news_detail', compact('data'));
    }

    public function head_news_detail($id)
    {
        $data = News::where('id', $id)->first();
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();

        return view('headManager.news_detail', compact('data', 'gallerys'));
    }

    public function admin_news_detail($id)
    {
        $data = News::where('id', $id)->first();

        return view('admin.news_detail', compact('data'));
    }

    public function index()
    {
        $list_news = News::where('status', "N")->orderBy('status_pin', 'desc')->orderBy('news_date', 'desc')->get();
        return view('admin.news', compact('list_news'));
    }

    public function gallery($id)
    {
        $newsID = News::find($id);
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.news_gallery', compact('newsID', 'gallerys'));
    }

    public function view_detail($id)
    {
        $data = News::find($id);
        $gallerys = NewsGallery::where('news_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.news_view_detail', compact('data', 'gallerys'));
    }

    public function search_news_status_usage(Request $request)
    {
        if ($request->status_usage != '') {
            $list_news = News::where('status_usage', $request->status_usage)->where('status', "N")
            ->orderBy('status_usage', 'desc')->orderBy('id', 'desc')->get();
            return view('admin.news', compact('list_news'));
        }else{
            $list_news = News::where('status', "N")->orderBy('status_usage', 'desc')->orderBy('id', 'desc')->get();
            return view('admin.news', compact('list_news'));
        }
    }

    public function search_news(Request $request)
    {
        // return $request->selectdateFrom;
        if ($request->tag) {
            $list_news = News::where('status', "N")
            ->where('news_date', 'LIKE', $request->selectdateFrom.'%')
            ->where('news_tags', 'LIKE', '%'.$request->tag.'%')
            ->orderBy('id', 'desc')->paginate(10);
        }else{
            $list_news = News::where('status', "N")
            ->where('news_date', 'LIKE', $request->selectdateFrom.'%')
            ->orderBy('id', 'desc')->paginate(10);
        }


        return view('saleman.news', compact('list_news'));

    }

    // public function index_banner()
    // {
    //     $list_banner = NewsBanner::orderBy('id', 'desc')->get();
    //     return view('admin.news_banner', compact('list_banner'));
    // }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

        $path = 'upload/NewsImage';
        $image = '';
        if (!empty($request->file('news_image'))) {
            $img = $request->file('news_image');
            $img_name = 'news-' . time() . '.' . $img->getClientOriginalExtension();
            $save_path = $img->move(public_path($path), $img_name);
            $image = $img_name;
        }


        News::create([
            'news_date' => $request->news_date,
            'news_title' => $request->news_title,
            'ref_number' => $request->ref_number,
            'news_detail' => $request->news_detail,
            'news_tags' => implode( ',', $request->news_tags),
            'news_image' => $image,
            'url'        => $request->url,
            'status'     => "N",
            'status_share' => $request->status_share,
            'status_pin' => 0,
            'created_by'   => Auth::user()->id,
            'updated_at'   => Carbon::now(),

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

        foreach ($request->news_gallery as $key => $gallery) {

            $path = 'upload/NewsGallery';
            $image = '';
            $img_name = '';
            $img = '';
            if (!empty($request->news_gallery[$key])) {
                $img = $request->news_gallery[$key];
                $img_name = 'gallery-' . time(). $key. '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;

            }

            NewsGallery::create([
                'news_id' => $request->news_id,
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
        $dataEdit = News::join('master_note', 'news_promotions.news_tags', 'master_note.id')
        ->where('news_promotions.id', $id)->select('news_promotions.*', 'master_note.name_tag')->first();
        $master_note = DB::table('master_note')->get();

        $data = array(
            'dataEdit'     => $dataEdit,
            'master_note'  => $master_note
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
        if ($request->news_image_edit != '') {
            $path = 'upload/NewsImage';
            $image = '';
            $data = News::find($request->id);

            if (!empty($request->file('news_image_edit'))) {
                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->news_image)) {
                    $path2 = 'upload/NewsImage/';
                    unlink(public_path($path2) . $data->news_image);
                }

                $img = $request->file('news_image_edit');
                $img_name = 'news-' . time() . '.' . $img->getClientOriginalExtension();
                $save_path = $img->move(public_path($path), $img_name);
                $image = $img_name;


                $data2 = News::find($request->id);
                $data2->news_date         = $request->news_date_edit;
                $data2->news_title        = $request->news_title_edit;
                $data2->ref_number        = $request->ref_number;
                $data2->news_detail       = $request->news_detail_edit;
                $data2->news_tags         = implode( ',', $request->news_tags);
                $data2->news_image        = $image;
                $data2->url               = $request->url_edit;
                $data2->status_share      = $request->status_share_edit;
                $data2->status_pin        = $request->status_pin;
                $data2->updated_by        = Auth::user()->id;
                $data2->updated_at        = Carbon::now();
                $data2->update();
                DB::commit();
            }
        } else {

            $data2 = News::find($request->id);
            $data2->news_date         = $request->news_date_edit;
            $data2->news_title        = $request->news_title_edit;
            $data2->ref_number        = $request->ref_number;
            $data2->news_detail       = $request->news_detail_edit;
            $data2->news_tags         = implode( ',', $request->news_tags);
            $data2->url               = $request->url_edit;
            $data2->status_share      = $request->status_share_edit;
            $data2->status_pin        = $request->status_pin;
            $data2->updated_by        = Auth::user()->id;
            $data2->updated_at        = Carbon::now();
            $data2->update();
            DB::commit();
        }

        return back();
    }

    public function gallery_update(Request $request)
    {
            $path = 'upload/NewsGallery';
            $image = '';
            $data = NewsGallery::find($request->id);

            if (!empty($request->file('news_gallery'))) {
                //ลบรูปเก่าเพื่ออัพโหลดรูปใหม่แทน
                if (!empty($data->image)) {
                    $path2 = 'upload/NewsGallery/';
                    unlink(public_path($path2) . $data->image);
                }

                $img = $request->file('news_gallery');
                $img_name = 'news-' . time() . '.' . $img->getClientOriginalExtension();
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

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = News::where('id', $request->news_id_delete)->first();
            if (!empty($data->news_image)) {
                $path1 = 'public/upload/NewsImage/';
                unlink($path1 . $data->news_image);
            }

        $data2 = NewsGallery::where('news_id', $request->news_id_delete)->get();
        foreach ($data2 as $value) {
        if (!empty($value->image)) {
            $path2 = 'public/upload/NewsGallery/';
            unlink($path2 . $value->image);

            NewsGallery::find($value->id)->delete();
        }
    }

        News::where('id', $request->news_id_delete)->delete();
        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function gallery_destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = NewsGallery::find($request->gallery_id_delete);
            if (!empty($data->image)) {
                $path1 = 'public/upload/NewsGallery/';
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

    public function banner_destroy($id)
    {
        $data = NewsBanner::where('id', $id)->get();
        foreach ($data as $value) {
            if (!empty($value->banner)) {
                $path1 = 'public/upload/NewsBanner/';
                unlink($path1 . $value->banner);
            }
        }
        NewsBanner::where('id', $id)->delete();
        return back();
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
