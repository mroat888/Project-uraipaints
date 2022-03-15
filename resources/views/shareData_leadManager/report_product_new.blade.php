@extends('layouts.masterLead')

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
                                            <th colspan="2" style="text-align:center;">รายการสินค้า</th>
                                            <th colspan="3" style="text-align:center;">รายการยอดขายสินค้าใหม่</th>
                                            <th colspan="2" style="text-align:center;">คิดเป็นเปอร์เซ็น (%)</th>
                                        </tr>

                                        <tr>
                                            <th>ชื่อสินค้าใหม่</th>
                                            <th>ระยะเวลา</th>
                                            <th>เป้าทั้งหมด</th>
                                            <th>เป้าที่ทำได้</th>
                                            <th>ผลต่าง</th>
                                            <!-- <th>จำนวนร้านค้า</th> -->
                                            <th>เป้าที่ทำได้</th>
                                            <th>ผลต่าง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $rows1 = count($sellers_api);
                                        
                                        for($i=0 ; $i< $rows1; $i++){
                                            if(isset($sellers_api[$i])){
                                    ?>
                                                <tr class="bg-info text-white">
                                                    <td colspan="8"><strong>{{ $sellers_api[$i][0]['saleman_name'] }}</strong></td>
                                                </tr>
                                    <?php
                                                $rows2 = count($sellers_api[$i]);
                                                $no=0;
                                                for($in=0 ; $in< $rows2; $in++){
                                    ?>
                                                    <tr>
                                                        <th scope="row">{{ ++$no }}</th>
                                                        <td>{{ $sellers_api[$i][$in]['description'] }}</td>
                                                        <td>{{ $sellers_api[$i][$in]['fromdate'] }} - {{ $sellers_api[$i][$in]['todate'] }}</td>
                                                        <td>{{ number_format($sellers_api[$i][$in]['Target'],2) }}</td>
                                                        <td>{{ number_format($sellers_api[$i][$in]['Sales'],2) }}</td>
                                                        <td>{{ number_format($sellers_api[$i][$in]['Diff'],2) }}</td>
                                                        <!-- <td>-</td> -->
                                                        <td>{{ number_format($sellers_api[$i][$in]['persent_sale'],2) }}%</td>
                                                        <td>{{ number_format($sellers_api[$i][$in]['persent_diff'],2) }}%</td>
                                                    </tr>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="3" align="center">ทั้งหมด</td>
                                        <td class="text-success">{{ number_format($summary_sellers_api['sum_target'],2) }}</td>
                                        <td class="text-success">{{ number_format($summary_sellers_api['sum_sales'],2) }}</td>
                                        <td class="text-danger">{{ number_format($summary_sellers_api['sum_diff'],2) }}</td>
                                        <!-- <td class="text-secondary">-</td> -->
                                        <td class="text-success">{{ number_format($summary_sellers_api['sum_persent_sale'],2) }}%</td>
                                        <td class="text-danger">{{ number_format($summary_sellers_api['sum_persent_diff'],2) }}%</td>
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

