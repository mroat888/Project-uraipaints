@extends('layouts.masterLead')

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
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ asset('/public/images/banner.jpg') }}">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ asset('/public/images/banner2.jpg') }}">
                                    </div>
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
            <div class="col-md-6">
                {{-- <div class="hk-sec-wrapper"> --}}
                    <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="media pa-20 border border-2 border-light rounded text-white bg-violet-light-1">
                                    <i class="ion ion-md-document font-25 mt-5"></i>
                                    <div class="media-body">
                                        <h6 class="mb-5 ml-20 text-white">คำขออนุมัติ <button type="button"
                                                class="btn btn-xs btn-outline-light btn-rounded float-right"
                                                style="color: white;">เพิ่มใหม่</button>
                                        </h6>
                                        <span class="mb-5 ml-20"> อนุมัติ: 2 &nbsp; ด่วน: 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="media pa-20 border border-2 border-light rounded text-white bg-teal-light-1">
                                    <i class="ion ion-md-clipboard font-25 mt-5 "></i>
                                    <div class="media-body">
                                        <h6 class="mb-5 ml-20 text-white">คำสั่งงาน <button type="button"
                                                class="btn btn-xs btn-outline-light btn-rounded float-right"
                                                style="color: white;">เพิ่มใหม่</button>
                                        </h6>
                                        <span class="mb-5 ml-20"> สำเร็จ: 2 &nbsp; ด่วน: 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mb-30">
                                <div class="media pa-20 border border-2 border-light rounded text-white bg-dark">
                                    <i class="ion ion-md-document font-25 mt-5 "></i>
                                    <div class="media-body">
                                        <h6 class="mb-5 ml-20 text-white">คำขออนุมัติ <button type="button"
                                                class="btn btn-xs btn-outline-light btn-rounded float-right"
                                                style="color: white;">เพิ่มใหม่</button>
                                        </h6>
                                        <span class="mb-5 ml-20"> อนุมัติ: 2 &nbsp; ด่วน: 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mb-30">
                                <div class="media pa-20 border border-2 border-light rounded text-white bg-blue-light-1">
                                    <i class="ion ion-md-document font-25 mt-5 "></i>
                                    <div class="media-body">
                                        <h6 class="mb-5 ml-20 text-white">คำขออนุมัติ <button type="button"
                                                class="btn btn-xs btn-outline-light btn-rounded float-right"
                                                style="color: white;">เพิ่มใหม่</button>
                                        </h6>
                                        <span class="mb-5 ml-20"> อนุมัติ: 2 &nbsp; ด่วน: 1</span>
                                    </div>
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card card-refresh">
                                    <div class="refresh-container">
                                        <div class="la-anim-1"></div>
                                    </div>
                                        <h6 class="card-header" style="font-weight: bold;">
                                            วันสำคัญ
                                        </h6>
                                    <div class="card-body pa-0">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-weight: bold;">วันที่</th>
                                                            <th style="font-weight: bold;">ชื่อร้านค้า</th>
                                                            <th style="font-weight: bold;">ชื่อเรื่อง</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">11/12/2564</th>
                                                            <td>Brincker123</td>
                                                            <td style="color: teal;">วันเกิด</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">10/12/2564</th>
                                                            <td>Hay123</td>
                                                            <td style="color: teal;">Constitution Day</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

            <div class="col-xl-6">
                    <div class="row">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-header card-header-action">
                                    <h6>ยอดขายปัจจุบัน เทียบกับปีก่อน</h6>
                                    <div class="d-flex align-items-center card-action-wrap">
                                        <a href="#" class="inline-block refresh mr-15">
                                            <i class="ion ion-md-arrow-down"></i>
                                        </a>
                                        <a href="#" class="inline-block full-screen">
                                            <i class="ion ion-md-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body pa-0">
                                    <div class="pa-20">
                                        <div id="m_chart_2" style="height: 294px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="col-xl-6">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ยอดขาย ณ ปัจจุบัน</h5>
                        </div>
                        <div class="col-sm-12 col-md-9">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>เดือน</th>
                                            <th>ยอดเป้าหมาย</th>
                                            <th>ยอดที่ทำได้</th>
                                            <th>คิดเป็นเปอร์เซ็นต์ (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>มกราคม</td>
                                            <td>1,000</td>
                                            <td>1,500</td>
                                            <td>90%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </section>
            </div>

        </div>








        <!-- Row -->
        {{-- <div class="row">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-sm">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="card text-white bg-dark">
                                    <div class="card-body d-flex">
                                        <i class="ion ion-md-document font-35 mt-5 mr-10 d-inline-block"></i>
                                        <span class="d-inline-block">
                                            <span class="d-block file-name text-truncate"
                                                style="font-size: 16px;">บันทึกโน้ต <span style="font-size: 18px;">8</span>
                                                <button type="button" class="btn btn-xs btn-outline-light btn-rounded"
                                                    style="color: white;">เพิ่มใหม่ </button></span>
                                            <span class="d-block file-size text-truncate">เลิกใช้ : 3 &nbsp; &nbsp; ปักหมุด
                                                : 1</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="card text-white bg-blue-dark-2">
                                    <div class="card-body d-flex">
                                        <i class="ion ion-md-person font-35 mt-5 mr-10 d-inline-block"></i>
                                        <span class="d-inline-block">
                                            <span class="d-block file-name text-truncate"
                                                style="font-size: 16px;">ลูกค้าใหม่ <span style="font-size: 18px;">2</span>
                                                <button type="button"
                                                    class="btn btn-xs btn-outline-light btn-rounded ml-100"
                                                    style="color: white;">เพิ่มใหม่ </button></span>
                                            <span class="d-block file-size text-truncate">ไม่ผ่าน : 1 &nbsp; &nbsp; ตัดสินใจ
                                                : 2</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Row -->
    </div>
    <!-- /Container -->

@section('footer')
    @include('layouts.footer')
@endsection
<!-- Morris Charts JavaScript -->
<script src="{{asset('/public/template/vendors/raphael/raphael.min.js')}}"></script>
<script src="{{asset('/public/template/vendors/morris.js/morris.min.js')}}"></script>
@endsection
