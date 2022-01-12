@extends('layouts.masterAdmin')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานสรุปข้อมูลประจำปี</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานสรุปข้อมูลประจำปี</h4>
            </div>
            <div class="d-flex">
                <button class="btn btn-primary btn-sm"><i data-feather="printer"></i> พิมพ์</button>
            </div>
        </div>
        <!-- /Title -->

        {{-- <div class="body-responsive">
        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Column Chart with Labels</h6>
            <div class="row">
                <div class="col-sm">
                    <div id="e_chart_11" class="echart responsive" style="height:400px;"></div>
                </div>
            </div>
        </section>
        </div> --}}

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ตารางสรุปข้อมูลประจำปี <span style="color: rgb(128, 19, 0);">(ประจำปี 2564)</span></h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <!-- ------ -->
                            <span class="form-inline pull-right">
                                <!-- <span class="mr-5">เลือก</span> -->
                                <!-- <input type="month" name="" id="" class="form-control"> -->
                                {{-- <button class="btn btn-primary btn-sm ml-10 mr-15"><i data-feather="printer"></i> พิมพ์</button> --}}
                                </span>

                            </span>
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2" style="text-align:center;">รายชื่อผู้แทนขาย</th>
                                            <th colspan="5" style="text-align:center;">จำนวนลูกค้าที่เข้าพบ (ทั้งหมด)</th>
                                            <th colspan="5" style="text-align:center;">งานที่รับผิดชอบ (ทั้งหมด)</th>
                                        </tr>

                                        <tr>
                                            <th>งาน</th>
                                            <th>สำเร็จ</th>
                                            <th>ไม่สำเร็จ</th>
                                            <th>สำเร็จ (%)</th>
                                            <th>ไม่สำเร็จ (%)</th>
                                            <th>งาน</th>
                                            <th>สำเร็จ</th>
                                            <th>ไม่สำเร็จ</th>
                                            <th>สำเร็จ (%)</th>
                                            <th>ไม่สำเร็จ (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>พงษ์ศักดิ์</td>
                                            <td><span class="text-success">5</span></td>
                                            <td><span class="text-success">2</span></td>
                                            <td><span class="text-danger">3</span></td>
                                            <td><span class="text-success">30%</span></td>
                                            <td><span class="text-danger">50%</span></td>
                                            <td><span class="text-success">5</span></td>
                                            <td><span class="text-success">3</span></td>
                                            <td><span class="text-danger">2</span></td>
                                            <td><span class="text-success">30%</span></td>
                                            <td><span class="text-danger">30%</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>ชัยรุ่งเรือง</td>
                                            <td><span class="text-success">5</span></td>
                                            <td><span class="text-success">2</span></td>
                                            <td><span class="text-danger">3</span></td>
                                            <td><span class="text-success">30%</span></td>
                                            <td><span class="text-danger">50%</span></td>
                                            <td><span class="text-success">5</span></td>
                                            <td><span class="text-success">3</span></td>
                                            <td><span class="text-danger">2</span></td>
                                            <td><span class="text-success">30%</span></td>
                                            <td><span class="text-danger">30%</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>กิตติศักดิ์</td>
                                            <td><span class="text-success">5</span></td>
                                            <td><span class="text-success">2</span></td>
                                            <td><span class="text-danger">3</span></td>
                                            <td><span class="text-success">30%</span></td>
                                            <td><span class="text-danger">50%</span></td>
                                            <td><span class="text-success">5</span></td>
                                            <td><span class="text-success">3</span></td>
                                            <td><span class="text-danger">2</span></td>
                                            <td><span class="text-success">30%</span></td>
                                            <td><span class="text-danger">30%</span></td>
                                        </tr>
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="2" align="center">ทั้งหมด</td>
                                        {{-- <td colspan="11"><span class="text-success">3</span></td> --}}
                                        <td><span class="text-success">36</span></td>
                                        <td><span class="text-success">12</span></td>
                                        <td><span class="text-danger">24</span></td>
                                        <td><span class="text-success">50%</span></td>
                                        <td><span class="text-danger">40%</span></td>
                                        <td><span class="text-success">15</span></td>
                                        <td><span class="text-success">9</span></td>
                                        <td><span class="text-danger">6</span></td>
                                        <td><span class="text-success">50%</span></td>
                                        <td><span class="text-danger">40%</span></td>
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <!-- /Row -->
    </div>

@section('footer')
    @include('layouts.footer')
@endsection

 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>
@endsection

