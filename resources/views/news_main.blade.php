<div class="row">
    <div class="col-md-12">
        <section class="hk-sec-wrapper">
            <div class="topic-secondgery">รายการข่าวสาร</div>
            <div class="hk-pg-header mb-10" style="margin-top: 30px;">
                <div class="col-sm-12 col-md-12">
                    <span class="form-inline pull-right pull-sm-center">
                        <form action="{{ url('search_news') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <span id="selectdate">
                                ปี/เดือน : <input type="month" id="selectdateFrom" name="selectdateFrom"
                                value="" class="form-control form-control-sm"
                                style="margin-left:10px; margin-right:10px;"/>
                                <select name="tag" id="" class="form-control form-control-sm">
                                    @php
                                        $tags = App\MasterNews::orderBy('id', 'desc')->get();
                                    @endphp
                                    <option value="" disabled selected>เลือกป้ายกำกับ</option>
                                    @foreach ($tags as $value)
                                        <option value="{{$value->id}}">{{$value->name_tag}}</option>
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
                <div class="col-4 col-md-2">
                    <img class="card-img"
                    src="{{ isset($value->news_image) ? asset('public/upload/NewsImage/' . $value->news_image) : '' }}"
                    alt="{{ $value->news_title }}"
                    style="max-width:100%;">
                </div>
                <div class="col-8 col-md-10">
                    <div class="row">
                        <div class="col-md-12"><div class="topic-news">{{$value->news_title}}</div> </div>
                        <div class="col-md-12"><div class="boxnews-date">วันที่ : {{$value->news_date}}</div></div>
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
