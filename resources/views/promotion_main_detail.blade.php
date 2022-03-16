<div class="row">
    <div class="col-md-12">
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">รายละเอียดข้อมูลโปรโมชั่น</h5>
            {{-- <p class="mb-40">ข้อมูลโปรโมชั่นประจำวัน</p> --}}
            <div class="row">
                <div class="col-md-6 mt-10">
                    <img class="card-img"
                    src="{{ isset($data->news_image) ? asset('public/upload/PromotionImage/' . $data->news_image) : '' }}" alt="{{ $data->news_title }}" style="max-width:100%;">
                </div>
                <div class="col-md-6 mt-30">
                    <div class="row">
                        <div class="col-md-12"><h5><strong>{{$data->news_title}}</strong> <span class="badge badge-danger badge-pill">{{$data->status_promotion}}</span></h5></div>
                        <div class="col-md-12 mt-2">
                            <span style="font-size:16px;">วันที่เริ่ม : {{$data->news_date}}</span>
                            <span style="font-size:16px;" class="ml-10">วันที่สิ้นสุด : {{$data->news_date_last}}</span>
                        </div>
                        <div class="col-md-12 mt-2"><p>{{ $data->news_detail }}</p></div>
                        <div class="col-md-12 mt-2"><a href="{{ $data->url }}" style="font-size:14px; font-weight: bold; color:rgb(6, 25, 109);">
                            <i class="fa fa-link mr-2"></i>ข้อมูลเพิ่มเติม</a></div>
                            @if ($data->status_share == 1)
                            <div class="col-md-12 mt-5 text-right"><p>แชร์ข้อมูลไปที่</p>
                                <a href="http://www.facebook.com/sharer.php?u={{$data->url}}" target="_blank" class="btn btn-icon btn-icon-circle btn-indigo btn-icon-style-2 mt-2"><span class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                                <a href="https://social-plugins.line.me/lineit/share?url={{$data->url}}" class="btn btn-icon btn-icon-circle btn-success btn-icon-style-2 mt-2" target="_blank">
                                    {{-- <img src="{{ asset('public/images/icon/icon-linePK.svg')}}"> --}}
                                    <span class="btn-icon-wrap"><img src="{{ asset('public/images/icon/icon-lineWH.svg')}}" width="20"></span>

                                </a>
                            </div>
                            @endif

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
