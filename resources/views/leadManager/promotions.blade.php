@extends('layouts.masterLead')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item active">โปรโมชั่น</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        {{-- <div class="mt-30 mb-30">
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
                                    @if ($list_news_a)
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ isset($list_news_a->banner) ? asset('public/upload/NewsBanner/' . $list_news_a->banner) : '' }}">
                                    </div>
                                    @endif

                                    @foreach ($list_banner as $value)
                                    @if ($value->banner != $list_news_a->news_image)
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
        </div> --}}

        @include('promotion_main')

    </div>
    <!-- /Container -->

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
