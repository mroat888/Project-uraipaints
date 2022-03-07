@extends('layouts.masterLead')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานสรุปยอดทั้งปี</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานสรุปยอดทั้งปี</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-8">
                            <h5 class="hk-sec-title">ตารางรายงานสรุปยอดทั้งปี</h5>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <!-- ------ -->
                            <form action="{{ url('leadManage/data_report_full-year/search') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <select name="sel_year" id="sel_year" class="form-control" required>
                                            <option value="">--ค้นหาปี--</option>
                                            @php
                                                list($year,$month,$day) = explode('-', date('Y-m-d'));
                                            @endphp

                                            @for($i = 0; $i<4; $i++)
                                                <option value="{{ $year-$i}}">{{ $year-$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-teal btn-sm px-3 ml-2">ค้นหา</button>
                                    </div>
                                </div>
                            </form>
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
                                            <th colspan="6" style="text-align:center;">รายงานสรุปยอด</th>
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
                                    @if($yearleader_api['code'] == 200)
                                        @foreach($yearleader_api['data'] as $key => $value)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $value['year']+543 }}</td>
                                            <td>{{ $value['customers'] }}</td>
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

