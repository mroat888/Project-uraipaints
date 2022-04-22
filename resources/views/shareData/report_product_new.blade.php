@extends('layouts.master')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานยอดขายสินค้าใหม่</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานยอดขายสินค้าใหม่</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ตารางรายงานยอดขายสินค้าใหม่</h5>
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
                                            <th colspan="2" style="text-align:center;">รายละเอียดเป้าสินค้าใหม่</th>
                                            <th colspan="5" style="text-align:center;">ทำได้</th>
                                            <!-- <th colspan="3" style="text-align:center;">รายการยอดขายสินค้าใหม่</th>
                                            <th colspan="2" style="text-align:center;">คิดเป็นเปอร์เซ็น (%)</th> -->
                                        </tr>

                                        <tr style="text-align:center">
                                            <th>ชื่อเป้า</th>
                                            <th>ระยะเวลา</th>
                                            <th>เป้าทั้งหมด</th>
                                            <th>เป้าที่ทำได้</th>
                                            <th>คิดเป็น%</th>
                                            <th>คงเหลือ</th>
                                            <th>คิดเป็น%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $rows = count($sellers_api);
                                        $no=0;
                                        for($i=0 ; $i< $rows; $i++){
                                            list($fyear,$fmonth,$fday) = explode("-",$sellers_api[$i]['fromdate']);
                                            $fromdate = $fday."/".$fmonth."/".$fyear;

                                            list($tyear,$tmonth,$tday) = explode("-",$sellers_api[$i]['todate']);
                                            $todate = $tday."/".$tmonth."/".$tyear;
                                    ?>

                                        <tr style="text-align:center">
                                            <th scope="row">{{ ++$no }}</th>
                                            <td style="text-align:left;">{{ $sellers_api[$i]['description'] }}</td>
                                            <td>{{ $fromdate }} - {{ $todate }}</td>
                                            <td>{{ number_format($sellers_api[$i]['Target'],0) }}</td>
                                            <td>{{ number_format($sellers_api[$i]['Sales'],0) }}</td>
                                            <td>{{ number_format($sellers_api[$i]['persent_sale'],0) }}%</td>
                                            <td>{{ number_format($sellers_api[$i]['Diff'],0) }}</td>
                                            <td>{{ number_format($sellers_api[$i]['persent_diff'],0) }}%</td>
                                        </tr>
                                        
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot style="font-weight: bold; text-align:center">
                                        <td colspan="3" align="center">ทั้งหมด</td>
                                        <td class="text-success">{{ number_format($summary_sellers_api['sum_target'],0) }}</td>
                                        <td class="text-success">{{ number_format($summary_sellers_api['sum_sales'],0) }}</td>
                                        <td class="text-success">{{ number_format($summary_sellers_api['sum_persent_sale'],0) }}%</td>
                                        <td class="text-danger">{{ number_format($summary_sellers_api['sum_diff'],0) }}</td>
                                        <td class="text-danger">{{ number_format($summary_sellers_api['sum_persent_diff'],0) }}%</td>
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

