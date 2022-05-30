<style>
    .img_1 {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  /* width: 150px;
  height: 150px; */
    }
</style>
<div class="row">
    <div class="col-md-12">
        <section class="hk-sec-wrapper">
            <div class="topic-secondgery">รายการข่าวสาร</div>
            <div class="hk-pg-header mb-10" style="margin-top: 30px;">
                <div class="col-sm-12 col-md-12">

                    <span class="form-inline pull-right pull-sm-center">
                        @php
                            switch(Auth::user()->status){
                                case 1 : $action_search = "search_news";
                                    break;
                                case 2 : $action_search = "lead/search_news";
                                    break;
                                case 3 : $action_search = "head/search_news";
                                    break;
                            }
                        @endphp
                        <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <span id="selectdate">
                                @php
                                    if(isset($search_data)){
                                        $search_data = $search_data;
                                    }else{
                                        $search_data = "";
                                    }

                                    if(isset($search_tag)){
                                        $search_tag = $search_tag;
                                    }else{
                                        $search_tag = "";
                                    }
                                @endphp
                                ปี/เดือน : <input type="month" id="selectdateFrom" name="selectdateFrom"
                                value="{{ $search_data }}" class="form-control form-control-sm"
                                style="margin-left:10px; margin-right:10px;"/>
                                <select name="tag" id="" class="form-control form-control-sm">
                                    @php
                                        $tags = App\MasterNews::orderBy('id', 'desc')->get();
                                    @endphp
                                    <option value="">เลือกป้ายกำกับ</option>
                                    @foreach ($tags as $value)
                                        @if($search_tag == $value->id)
                                            <option value="{{$value->id}}" selected>{{$value->name_tag}}</option>
                                        @else
                                            <option value="{{$value->id}}">{{$value->name_tag}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                            </span>
                        </form>
                    </span>

                </div>
            </div>
            @foreach ($list_news as $value)
            <div class="row items-news">
                <div class="col-4 col-md-6">
                    <img class="card-img img_1" src="{{ isset($value->news_image) ? asset('public/upload/NewsImage/' . $value->news_image) : '' }}"
                    alt="{{ $value->news_title }}"
                    style="max-width:100%;">
                </div>
                <div class="col-8 col-md-6">
                    <div class="row">
                        <div class="col-md-12"><div class="topic-news">{{$value->news_title}}</div> </div>
                        <div class="col-md-12"><div class="boxnews-date">
                            @php
                                list($year,$month,$day) = explode("-", $value->news_date);
                                $news_date = $day."/".$month."/".$year;
                            @endphp
                            วันที่ : {{ $news_date }}
                        </div></div>
                        <div class="col-md-12"><div class="shortdesc-news">
                            @if(strlen($value->news_detail) > 679)
                                {{ substr($value->news_detail,0,680) }} ...
                            @else
                                {{ $value->news_detail }}
                            @endif
                        </div></div>
                        @if (Auth::user()->status == 1)
                        <div class="col-md-12 mt-2"><a href="{{ url('news_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 2)
                        <div class="col-md-12 mt-2"><a href="{{ url('lead/news_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 3)
                        <div class="col-md-12 mt-2"><a href="{{ url('head/news_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 4)
                        <div class="col-md-12 mt-2"><a href="{{ url('admin/news_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>
                        @endif
                    </div>

                </div>
                <div class="col-md-12 text-right" style="font-size: 14px;"><div class="news-update">อัพเดตวันที่ : {{$value->updated_at->format('d/m/Y')}}</div></div>
            </div>
            @endforeach
        </section>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div style="float:right;">
            {{ $list_news->appends(Request::all())->links() }}
        </div>
    </div>
</div>
