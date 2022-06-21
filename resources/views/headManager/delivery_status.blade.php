@extends('layouts.masterHead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">สถานะจัดส่ง</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="topichead-bgred"><i class="ion ion-md-basket"></i> สถานะจัดส่ง</div>
                    <div class="row">
                        <div class="col-sm" style="margin-top: 20px;">
                            <form action="{{ url('head/search_delivery_status') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" name="date" class="form-control mt-15">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control custom-select mt-15" name="status">
                                        <option selected disabled>เลือกสถานะจัดส่ง</option>
                                        <option value="เตรียมจัดส่ง">เตรียมจัดส่ง</option>
                                        <option value="จัดส่งเรียบร้อย">จัดส่งเรียบร้อย</option>
                                        <option value="รับสินค้าเรียบร้อย">รับสินค้าเรียบร้อย</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control custom-select mt-15" name="province">
                                        <option selected disabled>เลือกจังหวัด</option>
                                        @foreach ($province_api as $key => $value)
                                            <option value="{{$province_api[$key]['identify']}}">{{$province_api[$key]['name_thai']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6" style="margin-top: 15px;">
                                    <select class="form-control custom-select select2" name="customer">
                                        <option selected disabled>เลือกร้านค้า</option>
                                        @foreach ($customer_api as $key => $value)
                                            <option value="{{$customer_api[$key]['identify']}}">{{$customer_api[$key]['title']}} {{$customer_api[$key]['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 text-right" style="margin-top: 20px;">
                                    <button type="submit" class="btn btn-green">ค้นหา</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        @include('delivery_status_main')

    </div>
    <!-- /Container -->

@endsection
