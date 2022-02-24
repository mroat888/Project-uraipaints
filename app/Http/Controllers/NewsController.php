<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
use App\NewsBanner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function frontend_news()
    {
        $list_news_a = NewsBanner::orderBy('id', 'desc')->first();
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->paginate(10);
        $list_banner = NewsBanner::orderBy('id', 'desc')->get();
        return view('saleman.news', compact('list_news', 'list_banner', 'list_news_a'));
    }

    public function lead_frontend_news()
    {
        $list_news_a = NewsBanner::orderBy('id', 'desc')->first();
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->paginate(10);
        $list_banner = NewsBanner::orderBy('id', 'desc')->get();
        return view('leadManager.news', compact('list_news', 'list_banner', 'list_news_a'));
    }

    public function head_frontend_news()
    {
        $list_news_a = NewsBanner::orderBy('id', 'desc')->first();
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->paginate(10);
        $list_banner = NewsBanner::orderBy('id', 'desc')->get();
        return view('headManager.news', compact('list_news', 'list_banner', 'list_news_a'));
    }

    public function admin_frontend_news()
    {
        $list_news_a = NewsBanner::orderBy('id', 'desc')->first();
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->paginate(10);
        $list_banner = NewsBanner::orderBy('id', 'desc')->get();
        return view('admin.fontendNews', compact('list_news', 'list_banner', 'list_news_a'));
    }

    public function index()
    {
        $list_news = News::where('status', "N")->orderBy('id', 'desc')->get();
        return view('admin.news', compact('list_news'));
    }

    public function index_banner()
    {
        $list_banner = NewsBanner::orderBy('id', 'desc')->get();
        return view('admin.news_banner', compact('list_banner'));
    }

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
            'news_detail' => $request->news_detail,
            'news_image' => $image,
            'url'       => $request->url,
            'status'    => "N",
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
                $data2->news_detail       = $request->news_detail_edit;
                $data2->news_image        = $image;
                $data2->url               = $request->url_edit;
                $data2->updated_by        = Auth::user()->id;
                $data2->updated_at        = Carbon::now();
                $data2->update();
                DB::commit();
            }
        } else {

            $data2 = News::find($request->id);
            $data2->news_date         = $request->news_date_edit;
            $data2->news_title        = $request->news_title_edit;
            $data2->news_detail       = $request->news_detail_edit;
            $data2->url               = $request->url_edit;
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
                $path1 = 'public/upload/NewsImage/';
                unlink($path1 . $value->news_image);
            }
        }
        News::where('id', $id)->delete();
        return back();
    }

    public function banner_store(Request $request)
    {
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
            'detail' => $request->detail,
            'banner' => $image,
            'created_by' => Auth::user()->id,

        ]);

        return back();
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
                $data2->detail              = $request->detail;
                $data2->banner            = $image;
                $data2->updated_by        = Auth::user()->id;
                $data2->updated_at        = Carbon::now();
                $data2->update();
                DB::commit();
            }
        } else {

            $data2 = NewsBanner::find($request->id);
            $data2->date              = $request->date;
            $data2->detail              = $request->detail;
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
}
