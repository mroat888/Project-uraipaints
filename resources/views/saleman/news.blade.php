@extends('layouts.master')

@section('content')

   <!-- Breadcrumb -->
   <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">ข่าวสาร</li>
    </ol>
</nav>
<!-- /Breadcrumb -->


    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
         <!-- Title -->
         <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon">
                    <i class="ion ion-md-wifi"></i></span>ข่าวสาร</h4>
            </div>
            <div class="d-flex">

            </div>
        </div>
        <!-- /Title -->

        {{-- <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i class="ion ion-md-wifi"></i> ข้อมูลข่าวสาร</div>
            <div class="content-right d-flex"></div>
        </div> --}}

        @include('news_main')

        <!-- <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">ข้อมูลข่าวสาร</h5>
                    <p class="mb-40">ข้อมูลข่าวสารประจำวัน</p>
                    <div class="row">
                        <div class="col-sm">
                            <div id="owl_demo_4" class="owl-carousel owl-theme">
                                @foreach ($list_news as $value)
                                <div class="item">
                                    <div class="card">
                                        <img class="card-img-top" src="{{ isset($value->news_image) ? asset('public/upload/NewsImage/' . $value->news_image) : '' }}" alt="Card image cap">
                                        <div class="card-body">
                                            <h6>{{$value->news_title}}</h6>
                                            <span>วันที่ : {{$value->news_date}}</span>
                                            <p class="card-text">{{$value->news_detail}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div> -->

    </div>
    <!-- /Container -->

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
