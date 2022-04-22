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
                <!-- <button class="btn btn-primary btn-sm"><i data-feather="printer"></i> พิมพ์</button> -->
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
                                            <th rowspan="2" style="text-align:right;">ร้านค้า</th>
                                        </tr>

                                        <tr>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <!-- <th>เขต</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $row = count($users_api);
                                        $key = 0;
                                        $no = 1;
                                        $sum_shops = 0;
                                        for($i = 0; $i< $row; $i++){
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $no++; ?></th>
                                                <td><?php echo $users_api[$key]['name']; ?></td>
                                                <td>-</td>
                                                <td style="text-align:right;"><?php echo number_format($users_api[$key]['count_shop']); ?></td>
                                                <!-- <td>-</td> -->
                                            </tr>
                                    <?php
                                            $sum_shops = $sum_shops+$users_api[$key]['count_shop'];
                                            $key++;
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td style="text-align:right;">ทั้งหมด</td>
                                        <td>{{ $row }}</td>
                                        <td style="text-align:right;">ร้านค้าทั้งหมด</td>
                                        <td style="text-align:right;">{{ number_format($sum_shops) }}</td>
                                        <!-- <td></td> -->
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

