@extends('layouts.masterLead')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานสรุปยอดจำนวนร้านค้า</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานสรุปยอดจำนวนร้านค้า</h4>
            </div>
            <div class="d-flex">
                <button class="btn btn-primary btn-sm"><i data-feather="printer"></i> พิมพ์</button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ตารางสรุปยอดจำนวนร้านค้า</h5>
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
                                            <th colspan="6" style="text-align:center;">รายการร้านค้า</th>
                                        </tr>

                                        <tr>
                                            <th>ชื่อร้าน</th>
                                            <th>ชื่อผู้ติดต่อ</th>
                                            <th>ที่อยู่</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>วันที่</th>
                                            <th>สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Home Paint Outlet</td>
                                            <td>พงษ์ศักดิ์</td>
                                            <td>กรุงเทพ</td>
                                            <td>0985632516</td>
                                            <td>29/10/2021</td>
                                            <td><span class="badge badge-soft-info" style="font-weight: bold; font-size: 14px;">ลูกค้าใหม่</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</td>
                                            <td>สมชาย</td>
                                            <td>กรุงเทพ</td>
                                            <td>0565258569</td>
                                            <td>25/10/2021</td>
                                            <td><span class="badge badge-soft-info" style="font-weight: bold; font-size: 14px;">ลูกค้าใหม่</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>เกรียงยงอิมเพ็กซ์</td>
                                            <td>กิตติศักดิ์</td>
                                            <td>นนทบุรี</td>
                                            <td>0652352658</td>
                                            <td>15/10/2021</td>
                                            <td><span class="badge badge-soft-danger" style="font-weight: bold; font-size: 14px;">ลูกค้าเป้าหมาย</span></td>
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

