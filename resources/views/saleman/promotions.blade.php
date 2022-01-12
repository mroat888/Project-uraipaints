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
                                    @if ($list_promotion_a)
                                    <?php $date = new Carbon\Carbon($list_promotion_a->news_date); ?>
                                    @if ($date->format('Y-m') == Carbon\Carbon::today()->format('Y-m'))
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ isset($list_promotion_a->news_image) ? asset('public/upload/PromotionImage/' . $list_promotion_a->news_image) : '' }}">
                                    </div>
                                    @endif
                                    @endif
                                    @foreach ($list_promotion as $value)
                                    @if ($value->news_image != $list_promotion_a->news_image)
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ isset($value->news_image) ? asset('public/upload/PromotionImage/' . $value->news_image) : '' }}">
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

        <div class="row">
            <div class="col-md-8">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div><h6 class="hk-sec-title mb-10">โปรโมชั่นประจำเดือน มกราคม/2565</h6></div>
                    </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header mb-10 mt-10">
                                <div>
                                </div>
                                <div class="box_search d-flex">
                                <span class="txt_search">Search:</span>
                                    <input type="text" name="" id="" class="form-control form-control-sm" placeholder="ค้นหา">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รูปภาพ</th>
                                            <th>ชื่อโปรโมชั่น</th>
                                            <th>วันที่</th>
                                            <th>สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $key = 1; ?>
                                        @foreach ($list_promotion as $value)
                                        <?php $date = new Carbon\Carbon($value->news_date); ?>
                                        @if ($date->format('Y-m') == Carbon\Carbon::today()->format('Y-m'))
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td><img src="{{ isset($value->news_image) ? asset('public/upload/PromotionImage/' . $value->news_image) : '' }}" width="100"></td>
                                        <td>{{$value->news_title}}</td>
                                        <td>{{$value->news_date}}</td>
                                        <td><span class="badge badge-soft-danger mt-15 mr-10" style="font-size: 12px;">{{$value->status_promotion}}</span></td>
                                    </tr>
                                    @endif
                                    <?php $key++; ?>
                                    @endforeach
                                        {{-- <tr>
                                            <td>3</td>
                                            <td>
                                                <div class="media-img-wrap">
                                                    <div class="avatar avatar-sm">
                                                        <img src="{{ asset('/public/template/dist/img/avatar1.jpg') }}" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="topic_purple">แนะนำสินค้า</span></td>
                                            <td>11/10/2021</td>
                                            <td><span class="badge badge-soft-primary mt-15 mr-10" style="font-size: 12px;">เฉพาะวันนี้</span></td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </section>
            </div>

            <div class="col-md-4">
            <div class="card card-profile-feed">
                <div class="card-header card-header-action">
                    <h6><span>โปรโมชั่นมาแรงเดือน มกราคม/2565 <span class="badge badge-soft-warning ml-5">
                        <?php $sum = 0; ?>
                        @foreach ($p_hot as $value)
                    <?php $date = new Carbon\Carbon($value->news_date); ?>
                    @if ($date->format('Y-m') >= Carbon\Carbon::today()->format('Y-m'))
                        <?php  $sum++; ?>
                        @endif
                        @endforeach
                    {{$sum}}
                </span></span></h6>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($list_promotion as $key => $value)
                    <?php $date = new Carbon\Carbon($value->news_date); ?>
                    @if ($date->format('Y-m') == Carbon\Carbon::today()->format('Y-m'))
                    @if ($value->status_promotion == "hot")
                    <li class="list-group-item border-0">
                        <div class="media align-items-center">
                            <div class="d-flex media-img-wrap mr-15">
                                <div class="avatar avatar-sm">
                                    <span class="avatar-text avatar-text-inv-pink rounded-circle"><span class="initial-wrap"><img src="{{ isset($value->news_image) ? asset('public/upload/PromotionImage/' . $value->news_image) : '' }}" alt=""></span>
                                    </span>
                                </div>
                            </div>
                            <div class="media-body">
                                <span class="d-block text-dark text-capitalize text-truncate mw-150p">{{$value->news_title}}</span>
                                <span class="d-block font-13 text-truncate mw-150p">จำกัด 100 ร้านค้า</span>
                            </div>
                        </div>
                    </li>
                    @endif
                    @endif
                    @endforeach
                </ul>
            </div>
            </div>

        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
