@extends('layouts.masterAdmin')

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
                        <div class="col-sm-12 col-md-8">
                            <h5 class="hk-sec-title">ตารางรายงานยอดขายสินค้าใหม่</h5>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <!-- ------ -->
                                <!-- <form action="{{ url('admin/data_report_product-new/search') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-10">
                                            <select name="sel_campaign" id="sel_campaign" class="form-control select2" required>
                                                <option value="">--ค้นหาสินค้าใหม่--</option>
                                                @foreach($campaignpromotes_api['data'] as $value)
                                                    <option value="{{ $value['campaign_id'] }}">{{ $value['description'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-teal btn-sm px-3 ml-2">ค้นหา</button>
                                        </div>
                                    </div>
                                </form> -->
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div id="table_list" class="table-responsive col-md-12">
                                <table id="datable_1" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รหัส</th>
                                            <th>ชื่อสินค้าใหม่</th>
                                            <th>วันที่เริ่ม</th>
                                            <th>วันที่สิ้นสุด</th>
                                            <th>จำนวนสินค้า</th>
                                            <th>ผู้แทนขาย</th>
                                            <th>เป้าขาย</th>
                                            <th>เป้าที่ทำได้</th>
                                            <th>ผลต่าง</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no =0;
                                        @endphp
                                        @foreach($campaignpromotes_api['data'] as $value)
                                        <tr>
                                            <th scope="row">{{ ++$no }}</th>
                                            <td>{{ $value['campaign_id'] }}</td>
                                            <td>{{ $value['description'] }}</td>
                                            <td>{{ $value['fromdate'] }}</td>
                                            <td>{{ $value['todate'] }}</td>
                                            <td>{{ $value['Product'] }}</td>
                                            <td>{{ $value['Seller'] }}</td>
                                            <td>{{ number_format($value['Target'],2) }}</td>
                                            <td>{{ number_format($value['Sales'],2) }}</td>
                                            <td>{{ number_format($value['Diff'],2) }}$</td>
                                            <td>
                                            @php
                                                $pathurl = url('admin/data_report_product-new/show').'/'.$value['campaign_id'];
                                            @endphp
                                            <a href="{{ $pathurl }}" class="btn btn-icon btn-success mr-10">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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

