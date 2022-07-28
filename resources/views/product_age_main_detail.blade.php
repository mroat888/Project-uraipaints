<style>
    .img_1 {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 150px;
  height: 150px;
    }

  .curveBG {
  background: -moz-linear-gradient(top, rgba(235, 235, 235, 0.3) 10%, #768693 90%);
  background: -webkit-linear-gradient(top, rgba(235, 235, 235, 0.3) 10%, #768693 90%);
  background: linear-gradient(to bottom, rgba(235, 235, 235, 0.3) 10%, #768693 90%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4debebeb', endColorstr='#768693',GradientType=0 );
  padding: 90px 0 140px 0;
  position: relative;
  z-index: 0; }
  .curveBG:before {
    content: '';
    width: 100%;
    height: 100%;
    background-image: url(../images/product/curveBG.jpg);
    background-repeat: no-repeat;
    background-position: bottom center;
    background-size: cover;
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    mix-blend-mode: luminosity;
    opacity: 0.6;
    z-index: -1; }

.gal-txt-section {
  width: 30%;
  position: absolute;
  bottom: 30%; }
  .gal-txt-section h3.BK-BG {
    float: left;
    font-size: 24px;
    letter-spacing: 0.06rem;
    padding: 5px 22px;
    margin: 0 0 25px 0;
    display: block; }
  .gal-txt-section .txt-content {
    margin-bottom: 0; }
    .gal-txt-section .txt-content p {
      color: #253746; }

.partnerGal-slide {
  background-color: white;
  padding: 10px;
  z-index: 99; }
  .partnerGal-slide .owl-theme .owl-nav {
    margin-top: 0; }
    .partnerGal-slide .owl-theme .owl-nav [class*='owl-'] {
      -webkit-transition: all .3s ease;
      transition: all .3s ease; }
      .partnerGal-slide .owl-theme .owl-nav [class*='owl-'].disabled:hover {
        background-color: #D6D6D6; }
  .partnerGal-slide .big-img.owl-theme {
    margin-bottom: 12px; }
    .partnerGal-slide .big-img.owl-theme .owl-prev, .partnerGal-slide .big-img.owl-theme .owl-next {
      width: 40px;
      height: 40px;
      background: rgba(19, 30, 41, 0.6);
      border: 1px solid white;
      border-radius: 50%;
      margin: 0;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      outline: none; }
      .partnerGal-slide .big-img.owl-theme .owl-prev:hover, .partnerGal-slide .big-img.owl-theme .owl-next:hover {
        background-color: #253746; }
    .partnerGal-slide .big-img.owl-theme i {
      font-size: 15px;
      color: white;
      line-height: 38px; }
    .partnerGal-slide .big-img.owl-theme .owl-prev {
      left: 15px; }
    .partnerGal-slide .big-img.owl-theme .owl-next {
      right: 15px; }
  .partnerGal-slide #thumbs .owl-nav {
    display: none; }
  .partnerGal-slide .owl-theme.navigation-thumbs .item {
    background-color: white;
    border: 1px solid white;
    cursor: pointer; }
    .partnerGal-slide .owl-theme.navigation-thumbs .item img {
      opacity: 0.6; }
  .partnerGal-slide .owl-theme.navigation-thumbs .owl-item.synced .item {
    border-color: #032033;
    z-index: 999; }
    .partnerGal-slide .owl-theme.navigation-thumbs .owl-item.synced .item img {
      opacity: 1; }

      .slide-navButton .owl-carousel .owl-nav .owl-prev, .slide-navButton .owl-carousel .owl-nav .owl-next {
    width: 36px;
    height: 36px; }
  .slide-navButton .owl-carousel .owl-nav i {
    font-size: 14px;
    line-height: 36px; }
  .slide-navButton .owl-carousel .owl-dots .owl-dot span {
    width: 9px;
    height: 9px; }
  .slide-navButton.nav-out .owl-carousel .owl-nav .owl-prev, .slide-navButton.nav-out .owl-carousel .owl-nav .owl-next {
    width: 40px;
    height: 45px; }
  .slide-navButton.nav-out .owl-carousel .owl-nav .owl-prev {
    left: -18px; }
  .slide-navButton.nav-out .owl-carousel .owl-nav .owl-next {
    right: -18px; }
  .slide-navButton.nav-out .owl-carousel .owl-nav i {
    font-size: 14px;
    line-height: 43px; }

</style>

         <!-- Title -->
         <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="clipboard"></i> รายละเอียดอายุจัดเก็บสินค้า</div>
            <div class="content-right d-flex">
                @if (Auth::user()->status == 1)
                    <a href="{{url('product_age')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ</a>
                @elseif (Auth::user()->status == 2)
                    <a href="{{url('lead/product_age')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ</a>
                @elseif (Auth::user()->status == 3)
                <a href="{{url('head/product_age')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ</a>
                @elseif (Auth::user()->status == 4)
                <a href="{{url('admin/product_age')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ</a>
                @endif

            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="row">
                <div class="col-md-6">
                    <div class="partnerGal-slide detail_slide" style="border: 1px solid #ddd;">
                        <div id="big" class="owl-carousel owl-theme big-img slider">
                            <a class="item" data-fancybox="gallery" href="{{ asset('public/upload/ProductAge/' . $data_product->image)}}"><img src="{{ asset('public/upload/ProductAge/' . $data_product->image)}}"></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="boxnews-date">
                                <p style="font-size: 16px;"><span style="font-weight: bold;">หมวด : </span>
                                    @if(isset($dataGroups) && !is_null($dataGroups))
                                      @foreach ($dataGroups as $key => $group)
                                        @if ($dataGroups[$key]['id'] == $data_product->category_id)
                                            {{$dataGroups[$key]['group_name']}}
                                        @endif
                                      @endforeach
                                    @endif
                                </p>
                            </div>
                    </div>
                    <div class="boxnews-date col-md-6">
                        <p style="font-size: 16px;"><span style="font-weight: bold;">วันที่อัพเดตล่าสุด : </span>{{Carbon\Carbon::parse($data_product->updated_at)->addYear(543)->format('d/m/Y')}}</p>
                    </div>
                    <div class="boxnews-date col-md-6">
                        <p style="font-size: 16px;"><span style="font-weight: bold;">แบรนด์สินค้า : </span>
                            @if(isset($dataBrands) && !is_null($dataBrands))
                              @foreach ($dataBrands as $key => $group)
                                  @if ($dataBrands[$key]['id'] == $data_product->brand_id)
                                      {{$dataBrands[$key]['brand_name']}}
                                  @endif
                              @endforeach
                            @endif
                        </p>
                    </div>
                    <div class="boxnews-date col-md-12">
                        <p style="font-size: 16px;"><span style="font-weight: bold;">รายละเอียด : </span>{{$data_product->description}}</p>
                    </div>
                    <div class="boxnews-date col-md-12">
                        @if ($data_product->url)
                            <a href="{{$data_product->url}}" target="_bank" class="btn-morenews">ดูรายละเอียดเพิ่มเติม</a>
                            @endif
                    </div>
                    </div>
                    @if ($data_product->status_share == 1)
                            <div class="col-md-12 mt-5 text-right"><p>แชร์ข้อมูลไปที่</p>
                                <a href="http://www.facebook.com/sharer.php?u={{$data_product->url}}" target="_blank" class="btn btn-icon btn-icon-circle btn-indigo btn-icon-style-2 mt-2"><span class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                                <a href="https://social-plugins.line.me/lineit/share?url={{$data_product->url}}" class="btn btn-icon btn-icon-circle btn-success btn-icon-style-2 mt-2" target="_blank">
                                    <span class="btn-icon-wrap"><img src="{{ asset('public/images/icon/icon-lineWH.svg')}}" width="20"></span>

                                </a>
                            </div>
                            @endif

                </div>
                <div class="col-md-12 text-right" style="font-size: 14px;">อัพเดตวันที่ : {{Carbon\Carbon::parse($data_product->updated_at)->addYear(543)->format('d/m/Y')}}</div>
                </div>
            </section>

