@extends('layouts.masterAdmin')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเข้าพบลูกค้าเป้าหมาย</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเข้าพบลูกค้าเป้าหมาย</h4>
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
                            <h5 class="hk-sec-title">ตารางรายงานเข้าพบลูกค้าเป้าหมาย<span style="color: rgb(128, 19, 0);">(ประจำปี 2564)</span></h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">เดือน</th>
                                            <th colspan="4" style="text-align:center;">เข้าพบลูกค้าเป้าหมาย</th>
                                            <th colspan="2" style="text-align:center;">คิดเป็นเปอร์เซ็น (%)</th>
                                        </tr>

                                        <tr>
                                            <th>ลูกค้าเป้าหมายตามแผน</th>
                                            <th>สำเร็จ</th>
                                            <th>ไม่สำเร็จ</th>
                                            <th>ลูกค้าใหม่</th>
                                            <th>สำเร็จ</th>
                                            <th>ไม่สำเร็จ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>มกราคม</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>กุมภาพันธ์</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>มีนาคม</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>เมษายน</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>พฤษภาคม</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">6</th>
                                            <td>มิถุนายน</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">7</th>
                                            <td>กรกฎาคม</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">8</th>
                                            <td>สิงหาคม</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">9</th>
                                            <td>กันยายน</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">10</th>
                                            <td>ตุลาคม</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">11</th>
                                            <td>พฤศจิกายน</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">12</th>
                                            <td>ธันวาคม</td>
                                            <td><span class="text-success">3</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-danger">2</span> </td>
                                            <td><span class="text-success">1</span> </td>
                                            <td><span class="text-success">80%</span> </td>
                                            <td><span class="text-danger">20%</span> </td>
                                        </tr>

                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="2" align="center">ทั้งหมด</td>
                                        <td class="text-success">36</td>
                                        <td class="text-success">12</td>
                                        <td class="text-danger">24</td>
                                        <td class="text-success">12</td>
                                        <td class="text-success">60%</td>
                                        <td class="text-danger">48%</td>
                                        {{-- <td class="text-success"></td> --}}
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

