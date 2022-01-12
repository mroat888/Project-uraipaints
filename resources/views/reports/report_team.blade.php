@extends('layouts.masterLead')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานยอดลูกทีมที่รับผิดชอบ</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานยอดลูกทีมที่รับผิดชอบ</h4>
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
                            <h5 class="hk-sec-title">ตารางยอดลูกทีมที่รับผิดชอบ</h5>
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
                                            <th colspan="2" style="text-align:center;">รายชื่อ</th>
                                            <th colspan="2" style="text-align:center;">จำนวน</th>
                                        </tr>

                                        <tr>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>ร้านค้า</th>
                                            <th>เขต</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>พงษ์ศักดิ์</td>
                                            <td>0985632516</td>
                                            <td>5</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>ชัยรุ่งเรือง</td>
                                            <td>0214552223</td>
                                            <td>3</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>กิตติศักดิ์</td>
                                            <td>0245278965</td>
                                            <td>2</td>
                                            <td>1</td>
                                        </tr>
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="2" align="center">ทั้งหมด</td>
                                        <td colspan="5">3</td>
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

