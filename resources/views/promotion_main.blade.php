<div class="row">
    <div class="col-md-12">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">ข้อมูลโปรโมชั่น</h5>
            <p class="mb-40">ข้อมูลโปรโมชั่นประจำวัน</p>
            @foreach ($list_promotion as $value)
            <div class="row">
                <div class="col-md-4">
                    <img class="card-img"
                    src="{{ isset($value->news_image) ? asset('public/upload/PromotionImage/' . $value->news_image) : '' }}"
                    alt="{{ $value->news_title }}"
                    style="max-width:100%;">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12"><h5><strong>{{$value->news_title}}</strong> <span class="badge badge-danger badge-pill">{{$value->status_promotion}}</span></h5></div>
                        <div class="col-md-12"><span style="font-size:12px;">วันที่ : {{$value->news_date}}</span></div>
                        <div class="col-md-12"><p>
                            @if(strlen($value->news_detail) > 679)
                                {{ substr($value->news_detail,0,680) }} ...
                            @else
                                {{ $value->news_detail }}
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
            {{ $list_promotion->appends(Request::all())->links() }}
        </div>
    </div>
</div>