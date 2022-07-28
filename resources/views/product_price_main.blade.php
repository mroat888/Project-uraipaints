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
            <div class="topic-secondgery">รายการใบราคา</div>
            <div class="hk-pg-header mb-10" style="margin-top: 30px;">
                <div class="col-sm-12 col-md-12">
                    <span class="form-inline pull-right pull-sm-center">

                        @if (Auth::user()->status == 1)
                            <form action="{{url('search-product_price')}}" method="POST" enctype="multipart/form-data">

                            @elseif (Auth::user()->status == 2)
                            <form action="{{url('lead/search-product_price')}}" method="POST" enctype="multipart/form-data">

                                @elseif (Auth::user()->status == 3)
                                <form action="{{url('head/search-product_price')}}" method="POST" enctype="multipart/form-data">
                            @endif
                            @csrf

                            <select name="category" class="form-control" aria-label=".form-select-lg example">
                                <option value="" selected>หมวดสินค้า</option>
                                @if(isset($groups) && !is_null($groups))
                                    @foreach ($groups as $key => $value)
                                        <option value="{{$groups[$key]['id']}}">{{$groups[$key]['group_name']}}</option>
                                    @endforeach
                                @endif
                            </select>

                            <span>
                                <input type="text" name="search" placeholder="ค้นหาชื่อสินค้า" class="form-control" style="margin-left:10px; margin-right:10px;"/>
                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm">ค้นหา</button>
                            </span>
                        </form>
                    </span>

                </div>
            </div>
            @foreach ($product_price as $value)
            <div class="row items-news">
                <div class="col-md-6">
                    <img class="card-img img_1"
                    src="{{ isset($value->image) ? asset('public/upload/ProductPrice/' . $value->image) : '' }}"
                    alt="{{ $value->name }}"
                    style="max-width:100%;">
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12"><div class="topic-news">{{$value->name}}</div></div>
                        {{-- <div class="col-md-12"><div class="boxnews-date">วันที่ : {{$value->product_date}}</div></div>
                        <div class="col-md-12"><div class="shortdesc-news">
                            @if(strlen($value->product_detail) > 679)
                                {{ substr($value->product_detail,0,680) }} ...
                            @else
                                {{ $value->product_detail }}
                            @endif
                        </div></div> --}}

                        @if (Auth::user()->status == 1)
                        <div class="col-md-12 mt-2"><a href="{{ url('view_product_price_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 2)
                        <div class="col-md-12 mt-2"><a href="{{ url('lead/view_product_price_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 3)
                        <div class="col-md-12 mt-2"><a href="{{ url('head/view_product_price_detail', $value->id) }}" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a></div>

                        @endif
                        {{-- <div class="col-md-12"><a href="{{ $value->url }}" class="btn-morenews">อ่านต่อ</a></div> --}}

                    </div>
                </div>
                <div class="col-md-12 text-right" style="font-size: 14px;"><div class="news-update">อัพเดตวันที่ : {{Carbon\Carbon::parse($value->updated_at)->addYear(543)->format('d/m/Y')}}</div></div>
            </div>

            @endforeach
        </section>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div style="float:right;">
            {{-- {{ $product_price->appends(Request::all())->links() }} --}}
        </div>
    </div>
</div>
