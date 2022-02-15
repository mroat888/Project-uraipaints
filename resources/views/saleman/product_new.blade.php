@extends('layouts.master')

@section('content')

    <!-- Row -->

    <!-- /Row -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="mt-30 mb-30">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                                    </li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    {{-- @if ($productNew)
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ isset($productNew->banner) ? asset('public/upload/NewsBanner/' . $productNew->banner) : '' }}">
                                    </div>
                                    @endif --}}

                                    @foreach ($list_banner as $value)
                                    @if ($value->banner != $productNew->news_image)
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ isset($value->banner) ? asset('public/upload/NewsBanner/' . $value->banner) : '' }}">
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('product_new_main')

        <!-- <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">ข้อมูลข่าวสาร</h5>
                    <p class="mb-40">ข้อมูลข่าวสารประจำวัน</p>
                    <div class="row">
                        <div class="col-sm">
                            <div id="owl_demo_4" class="owl-carousel owl-theme">
                                @foreach ($productNew as $value)
                                <div class="item">
                                    <div class="card">
                                        <img class="card-img-top" src="{{ isset($value->product_image) ? asset('public/upload/NewsImage/' . $value->product_image) : '' }}" alt="Card image cap">
                                        <div class="card-body">
                                            <h6>{{$value->product_title}}</h6>
                                            <span>วันที่ : {{$value->product_date}}</span>
                                            <p class="card-text">{{$value->product_detail}}</p>
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
