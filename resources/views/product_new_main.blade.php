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
            <div class="topichead-bgred">รายการสินค้าใหม่</div>
            <div class="hk-pg-header mb-10" style="margin-top: 30px;">
                <div class="col-sm-12 col-md-12">
                    <span class="form-inline pull-right pull-sm-center">

                        <form action="{{ url('search_product_new') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <span>
                                <input type="text" name="search" placeholder="ค้นหาชื่อสินค้า" class="form-control" style="margin-left:10px; margin-right:10px;"/>
                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm">ค้นหา</button>
                            </span>
                        </form>
                    </span>

                </div>
            </div>
            @foreach ($list_product_new as $value)
            <div class="row items-news">
                <div class="col-md-6">
                    <img class="card-img img_1"
                    src="{{ isset($value->product_image) ? asset('public/upload/ProductNewImage/' . $value->product_image) : '' }}"
                    alt="{{ $value->product_title }}"
                    style="max-width:100%;">
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12"><div class="topic-news">{{$value->product_title}}</div></div>
                        {{-- <div class="col-md-12"><div class="boxnews-date">วันที่ : {{$value->product_date}}</div></div>
                        <div class="col-md-12"><div class="shortdesc-news">
                            @if(strlen($value->product_detail) > 679)
                                {{ substr($value->product_detail,0,680) }} ...
                            @else
                                {{ $value->product_detail }}
                            @endif
                        </div></div> --}}

                        @if (Auth::user()->status == 1)
                        <div class="col-md-12 mt-2"><a href="{{ url('product_new_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 2)
                        <div class="col-md-12 mt-2"><a href="{{ url('lead/product_new_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 3)
                        <div class="col-md-12 mt-2"><a href="{{ url('head/product_new_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 4)
                        <div class="col-md-12 mt-2"><a href="{{ url('admin/product_new_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>
                        @endif
                        {{-- <div class="col-md-12"><a href="{{ $value->url }}" class="btn-morenews">อ่านต่อ</a></div> --}}

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
            {{ $list_product_new->appends(Request::all())->links() }}
        </div>
    </div>
</div>
