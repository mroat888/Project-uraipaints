<div class="row">
    <div class="col-md-12">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">ข้อมูลสินค้าใหม่</h5>
            <p class="mb-40">ข้อมูลสินค้าใหม่ประจำวัน</p>
            @foreach ($list_product_new as $value)
            <div class="row">
                <div class="col-md-2">
                    <img class="card-img"
                    src="{{ isset($value->product_image) ? asset('public/upload/ProductNewImage/' . $value->product_image) : '' }}"
                    alt="{{ $value->product_title }}"
                    style="max-width:100%;">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12"><h5><strong>{{$value->product_title}}</strong></h5></div>
                        <div class="col-md-12"><span style="font-size:12px;">วันที่ : {{$value->product_date}}</span></div>
                        <div class="col-md-12"><p>
                            @if(strlen($value->product_detail) > 679)
                                {{ substr($value->product_detail,0,680) }} ...
                            @else
                                {{ $value->product_detail }}
                            @endif
                        </p></div>

                        @if (Auth::user()->status == 1)
                        <div class="col-md-12 mt-2"><a href="{{ url('product_new_detail', $value->id) }}" style="font-size:14px; font-weight: bold; color:brown;">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 2)
                        <div class="col-md-12 mt-2"><a href="{{ url('lead/product_new_detail', $value->id) }}" style="font-size:14px; font-weight: bold; color:brown;">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 3)
                        <div class="col-md-12 mt-2"><a href="{{ url('head/product_new_detail', $value->id) }}" style="font-size:14px; font-weight: bold; color:brown;">ดูรายละเอียดเพิ่มเติม</a></div>

                        @elseif (Auth::user()->status == 4)
                        <div class="col-md-12 mt-2"><a href="{{ url('admin/product_new_detail', $value->id) }}" style="font-size:14px; font-weight: bold; color:brown;">ดูรายละเอียดเพิ่มเติม</a></div>
                        @endif
                        {{-- <div class="col-md-12"><a href="{{ $value->url }}" style="font-size:14px; font-weight: bold; color:brown;">อ่านต่อ</a></div> --}}

                    </div>
                </div>
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
