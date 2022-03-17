@extends('layouts.master')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานสรุปยอดทำเป้า เทียบปี</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานสรุปยอดทำเป้า เทียบปี</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-8">
                            <h5 class="hk-sec-title">ตารางรายงานสรุปยอดทำเป้า เทียบปี</h5>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <!-- ------ -->
                               
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">#</th>
                                            <th style="text-align:center">ปี</th>
                                            <th style="text-align:center">ยอดเป้ารวม</th>
                                            <th style="text-align:center">จำนวนเป้า</th>
                                            <th style="text-align:center">จำนวนลูกค้า</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $no = 0;
                                        $sum_TotalLimit = 0;
                                        $sum_TotalPromotion =0;
                                        $sum_TotalCustomer =0;
                                    @endphp
                                    @if(!empty($compare_api))
                                        @foreach($compare_api['data'] as $key => $value)
                                        @php 
                                            $sum_TotalLimit += $value['TotalLimit'];
                                            $sum_TotalPromotion += $value['TotalPromotion'];
                                            $sum_TotalCustomer += $value['TotalCustomer'];
                                        @endphp
                                        <tr>
                                            <td style="text-align:center">{{ ++$no }}</td>
                                            <td style="text-align:center">{{ $value['year'] }}</td>
                                            <td style="text-align:right">{{ number_format($value['TotalLimit'],2) }}</td>
                                            <td style="text-align:right">{{ number_format($value['TotalPromotion']) }}</td>
                                            <td style="text-align:right">{{ number_format($value['TotalCustomer']) }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight: bold;">
                                            <td colspan="2" style=" text-align:center; font-weight: bold;">ทั้งหมด</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_TotalLimit,2) }}</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_TotalPromotion) }}</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_TotalCustomer) }}</td>
                                        </tr>
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


