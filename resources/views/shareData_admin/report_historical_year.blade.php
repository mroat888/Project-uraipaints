@extends('layouts.masterAdmin')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเทียบย้อนหลัง (ทั้งปี)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเทียบย้อนหลัง (ทั้งปี)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ตารางรายงานเทียบย้อนหลัง (ทั้งปี)</h5>
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
                                            <th colspan="6" style="text-align:center;">รายงานเทียบย้อนหลัง (ทั้งปี)</th>
                                        </tr>

                                        <tr>
                                            <th>ปี</th>
                                            <th>จำนวนร้านค้า</th>
                                            <th>ยอดขายรวม</th>
                                            <th>ยอดคืนรวม</th>
                                            <th>ยอดขายสุทธิ</th>
                                            <th>เปอร์เซ็นต์คืน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($yearleader_api_now['code'] == 200)
                                        @foreach($yearleader_api_now['data'] as $key => $value)
                                        <tr>
                                            <td>{{ $value['year']+543 }}</td>
                                            <td>{{ number_format($value['customers']) }}</td>
                                            <td>{{ number_format($value['sales']) }}</td>
                                            <td>{{ number_format($value['credits']) }}</td>
                                            <td>{{ number_format($value['netSales']) }}</td>
                                            <td>{{ number_format($value['%Credit'],2) }}%</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    @if($yearleader_api_old1['code'] == 200)
                                        @foreach($yearleader_api_old1['data'] as $key => $value)
                                        <tr>
                                            <td>{{ $value['year']+543 }}</td>
                                            <td>{{ number_format($value['customers']) }}</td>
                                            <td>{{ number_format($value['sales']) }}</td>
                                            <td>{{ number_format($value['credits']) }}</td>
                                            <td>{{ number_format($value['netSales']) }}</td>
                                            <td>{{ number_format($value['%Credit'],2) }}%</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    @if($yearleader_api_old2['code'] == 200)
                                        @foreach($yearleader_api_old2['data'] as $key => $value)
                                        <tr>
                                            <td>{{ $value['year']+543 }}</td>
                                            <td>{{ number_format($value['customers']) }}</td>
                                            <td>{{ number_format($value['sales']) }}</td>
                                            <td>{{ number_format($value['credits']) }}</td>
                                            <td>{{ number_format($value['netSales']) }}</td>
                                            <td>{{ number_format($value['%Credit'],2) }}%</td>
                                        </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                    <!-- <tfoot style="font-weight: bold;">
                                        <td colspan="2" align="center">ทั้งหมด</td>
                                        <td>3</td>
                                        <td>3</td>
                                        <td>3</td>
                                        <td>60,000</td>
                                    </tfoot> -->
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

