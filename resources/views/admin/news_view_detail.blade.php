
@extends('layouts.masterAdmin')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item">แจ้งข่าวสาร</li>
            <li class="breadcrumb-item active">รายละเอียดข่าวสาร</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

<style>
    /* .img_1 {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  /* width: 150px; */
  /* height: 150px;  */

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

<!-- Container -->
<div class="container-fluid px-xxl-65 px-xl-20">
    <!-- Title -->
    <div class="hk-pg-header mb-10">
        <div class="topichead-bgred"><i data-feather="file-text"></i> รายละเอียดข่าวสาร</div>
        <div class="content-right d-flex">
            <a href="{{ url('admin/news')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
        <section class="hk-sec-wrapper">
            {{-- <h5 class="hk-sec-title">รายละเอียดข้อมูลข่าวสาร</h5> --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="partnerGal-slide detail_slide" style="border: 1px solid #ddd;">
                        <div id="big" class="owl-carousel owl-theme big-img slider">
                            <a class="item" data-fancybox="gallery" href="{{ asset('public/upload/NewsImage/' . $data->news_image)}}"><img src="{{ isset($data->news_image) ? asset('public/upload/NewsImage/' . $data->news_image) : '' }}"></a>
                            @foreach ($gallerys as $value)
                            <a class="item" data-fancybox="gallery" href="{{ asset('public/upload/NewsGallery/' . $value->image)}}"><img src="{{ isset($value->image) ? asset('public/upload/NewsGallery/' . $value->image) : '' }}"></a>
                            @endforeach
                        </div>
                        <div id="thumbs" class="owl-carousel owl-theme thumbs-img navigation-thumbs">
                            <div class="item" href="{{ asset('public/upload/NewsImage/' . $data->news_image)}}"><img src="{{ isset($data->news_image) ? asset('public/upload/NewsImage/' . $data->news_image) : '' }}"></div>
                            @foreach ($gallerys as $value)
                            <div class="item"><img src="{{ isset($value->image) ? asset('public/upload/NewsGallery/' . $value->image) : '' }}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 mt-10">
                    <img class="card-img"
                    src="{{ isset($data->news_image) ? asset('public/upload/NewsImage/' . $data->news_image) : '' }}" alt="{{ $data->news_title }}" style="max-width:100%;">
                </div> --}}
                <div class="col-md-6 mt-30">
                    <div class="row">
                        <div class="col-md-12"><h5><strong>{{$data->news_title}}</strong></h5></div>
                        <div class="col-md-12 mt-2">
                            <span style="font-size:16px;">วันที่เริ่ม : {{$data->news_date}}</span>
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
                <div class="col-md-12 text-right" style="font-size: 18px;"><div class="boxnews-date">อัพเดตวันที่ : {{$data->updated_at->format('d/m/Y')}}</div></div>
            </div>
        </section>
    </div>
</div>

</div>
<!-- /Container -->

@section('footer')
@include('layouts.footer')
@endsection

@endsection



