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
                                            <th rowspan="2" style="text-align:center">#</th>
                                            <th rowspan="2" style="text-align:center">ชื่อ</th>
                                            <th colspan="3" style="text-align:center">ยอดเป้ารวม</th>
                                        </tr>
                                        <tr>
                                            @for($i=0; $i<3; $i++)
                                                <th style="text-align:center">{{ $array_year[$i] }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $no = 0;
                                        $sum_netSales_1 = 0;
                                        $sum_netSales_2 = 0;
                                        $sum_netSales_3 = 0;
                                    @endphp
                                    @if(!empty($compare_api))
                                        @foreach($compare_api as $key => $value)
                                            <tr>
                                                <td style="text-align:center">{{ ++$no }}</td>
                                                <td>{{ $compare_api[$key][0]['identify'] }} {{ $compare_api[$key][0]['name'] }}</td>
                                                <td style="text-align:right">
                                                    @if(!empty($compare_api[$key][1]['TotalLimit']))
                                                        {{ number_format($compare_api[$key][0]['TotalLimit'],2) }}
                                                        @php 
                                                            $sum_netSales_1 += $compare_api[$key][0]['TotalLimit'];
                                                        @endphp
                                                    @endif
                                                </td>
                                                <td style="text-align:right">
                                                    @if(!empty($compare_api[$key][1]['TotalLimit']))
                                                        {{ number_format($compare_api[$key][1]['TotalLimit'],2) }}
                                                        @php 
                                                            $sum_netSales_2 += $compare_api[$key][0]['TotalLimit'];
                                                        @endphp
                                                    @endif
                                                </td>
                                                <td style="text-align:right">
                                                    @if(!empty($compare_api[$key][2]['TotalLimit']))
                                                        {{ number_format($compare_api[$key][2]['TotalLimit'],2) }}
                                                        @php 
                                                            $sum_netSales_3 += $compare_api[$key][0]['TotalLimit'];
                                                        @endphp
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight: bold;">
                                            <td colspan="2" style=" text-align:center; font-weight: bold;">ทั้งหมด</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_netSales_1,2) }}</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_netSales_2,2) }}</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_netSales_3,2) }}</td>
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

 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>


