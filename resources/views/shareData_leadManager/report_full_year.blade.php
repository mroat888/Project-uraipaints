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
                            @php 
                                $action_search = "leadManage/data_report_full-year/search";
                            @endphp
                            <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
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
                                    @if($yearseller_api['code'] == 200)
                                        @foreach($yearseller_api['data'] as $key => $value)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $value['year'] }}</td>
                                            <td>{{ number_format($value['customers']) }}</td>
                                            <td>{{ number_format($value['sales'],2) }}</td>
                                            <td>{{ number_format($value['credits'],2) }}</td>
                                            <td>{{ number_format($value['netSales'],2) }}</td>
                                            <td>{{ number_format($value['%Credit'],2) }}%</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-9">
                            <h5 class="hk-sec-title">ตารางรายงานสินค้า TOP10</h5>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <!-- ------ -->
                            <button type="button" id="btn_group" onclick="swith_div('#div_table_group');" class="btn btn-primary btn-sm">Group</button>
                            <button type="button" id="btn_subgroup" onclick="swith_div('#div_table_subgroup');" class="btn btn-warning btn-sm">SubGroup</button>
                            <button type="button" id="btn_productlist" onclick="swith_div('#div_table_ProductList');" class="btn btn-success btn-sm">ProductList</button>
                            <!-- ------ -->
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                            <div id="div_table_group">
                                    <table class="table table-sm table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="9" style="text-align:center;" class="bg-primary text-white">สินค้า TOP Group</th>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>ปี</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>จำนวนร้านค้า</th>
                                                <th>ผู้แทนขาย</th>
                                                <th>ยอดขายรวม</th>
                                                <th>ยอดคืนรวม</th>
                                                <th>ยอดขายสุทธิ</th>
                                                <th>เปอร์เซ็นต์คืน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($grouptop_api['code'] == 200)
                                            @foreach($grouptop_api['data'] as $key => $value)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $value['year'] }}</td>
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ number_format($value['customers']) }}</td>
                                                <td>{{ number_format($value['Sellers']) }}</td>
                                                <td>{{ number_format($value['sales'],2) }}</td>
                                                <td>{{ number_format($value['credits'],2) }}</td>
                                                <td>{{ number_format($value['netSales'],2) }}</td>
                                                <td>{{ number_format($value['%Credit'],2) }}%</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div id="div_table_subgroup" style="display:none">
                                    <table class="table table-sm table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="9" style="text-align:center;" class="bg-warning text-white">สินค้า TOP Sub Group</th>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>ปี</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>จำนวนร้านค้า</th>
                                                <th>ผู้แทนขาย</th>
                                                <th>ยอดขายรวม</th>
                                                <th>ยอดคืนรวม</th>
                                                <th>ยอดขายสุทธิ</th>
                                                <th>เปอร์เซ็นต์คืน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($subgrouptop_api['code'] == 200)
                                            @foreach($subgrouptop_api['data'] as $key => $value)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $value['year'] }}</td>
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ number_format($value['customers']) }}</td>
                                                <td>{{ number_format($value['Sellers']) }}</td>
                                                <td>{{ number_format($value['sales'],2) }}</td>
                                                <td>{{ number_format($value['credits'],2) }}</td>
                                                <td>{{ number_format($value['netSales'],2) }}</td>
                                                <td>{{ number_format($value['%Credit'],2) }}%</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div id="div_table_ProductList" style="display:none">
                                    <table class="table table-sm table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="9" style="text-align:center;" class="bg-success text-white">สินค้า TOP ProductList</th>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>ปี</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>จำนวนร้านค้า</th>
                                                <th>ผู้แทนขาย</th>
                                                <th>ยอดขายรวม</th>
                                                <th>ยอดคืนรวม</th>
                                                <th>ยอดขายสุทธิ</th>
                                                <th>เปอร์เซ็นต์คืน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($pdlisttop_api['code'] == 200)
                                            @foreach($pdlisttop_api['data'] as $key => $value)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $value['year'] }}</td>
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ number_format($value['customers']) }}</td>
                                                <td>{{ number_format($value['Sellers']) }}</td>
                                                <td>{{ number_format($value['sales'],2) }}</td>
                                                <td>{{ number_format($value['credits'],2) }}</td>
                                                <td>{{ number_format($value['netSales'],2) }}</td>
                                                <td>{{ number_format($value['%Credit'],2) }}%</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

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

<script>
    function swith_div(rel){
        $("#div_table_group").hide();
        $("#div_table_subgroup").hide();
        $("#div_table_ProductList").hide();
        console.log(rel);
        $(rel).fadeIn();
    }
</script>
 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>
@endsection

