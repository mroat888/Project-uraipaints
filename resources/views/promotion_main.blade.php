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
            <div class="topichead-bgred">รายการโปรโมชั่น</div>
            <div class="hk-pg-header mb-10" style="margin-top: 30px;">
                <div class="col-sm-12 col-md-12">
                    <span class="form-inline pull-right pull-sm-center">
                        @php
                            switch(Auth::user()->status){
                                case 1 : $action_search = "search_promotion";
                                    break;
                                case 2 : $action_search = "lead/search_promotion";
                                    break;
                                case 3 : $action_search = "head/search_promotion";
                                    break;
                            }
                            if(isset($search_data)){
                                $search_data = $search_data;
                            }else{
                                $search_data = "";
                            }
                        @endphp
                        <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <span id="selectdate">
                                ปี/เดือน : <input type="month" id="selectdateFrom" name="selectdateFrom"
                                value="{{ $search_data }}" class="form-control form-control-sm"
                                style="margin-left:10px; margin-right:10px;"/>
                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                            </span>
                        </form>
                    </span>

                </div>
            </div>
            @foreach ($list_promotion as $value)
            <div class="row items-news">
                <div class="col-md-2">
                    <img class="card-img img_1"
                    src="{{ isset($value->news_image) ? asset('public/upload/PromotionImage/' . $value->news_image) : '' }}"
                    alt="{{ $value->news_title }}"
                    style="max-width:100%;">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12"><h5><strong>{{$value->news_title}}</strong></h5></div>
                        <div class="col-md-12">
                            <span style="font-size:12px;">วันที่เริ่ม : {{$value->news_date}}</span>
                            <span style="font-size:12px;" class="ml-10">วันที่สิ้นสุด : {{$value->news_date_last}}</span>
                        </div>
                        <div class="col-md-12"><p>
                            @if(strlen($value->news_detail) > 679)
                                {{ substr($value->news_detail,0,680) }} ...
                            @else
                                {{ $value->news_detail }}
                            @endif
                        </p></div>
                        @if (Auth::user()->status == 1)
                        <div class="col-md-12 mt-2"><a href="{{ url('promotion_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 2)
                        <div class="col-md-12 mt-2"><a href="{{ url('lead/promotion_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 3)
                        <div class="col-md-12 mt-2"><a href="{{ url('head/promotion_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 4)
                        <div class="col-md-12 mt-2"><a href="{{ url('admin/promotion_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>
                        @endif
                        {{-- <div class="col-md-12 mt-5"><a href="{{ url('promotion_detail', $value->id) }}" style="font-size:14px; font-weight: bold; color:brown;">ดูรายละเอียดเพิ่มเติม</a></div> --}}

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
            {{ $list_promotion->appends(Request::all())->links() }}
        </div>
    </div>
</div>
