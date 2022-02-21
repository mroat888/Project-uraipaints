<div class="row">
    <div class="col-md-12">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">ข้อมูลสินค้าใหม่</h5>
            <p class="mb-40">ข้อมูลสินค้าใหม่ประจำวัน</p>
            @foreach ($list_product_new as $value)
            <div class="row">
                <div class="col-md-4">
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
