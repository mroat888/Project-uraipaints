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
                                <form action="{{ url('admin/data_report_product-new/search') }}" method="post" enctype="multipart/form-data">
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
                                </form>
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="card">
                                <div class="card-header">
                                    รายละเอียด
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $campaignpromotes_name_api['data'][0]['description']}}</h5>
                                    <p class="card-text">รหัส : {{ $campaignpromotes_name_api['data'][0]['campaign_id']}}</p>
                                    <p class="card-text">
                                        ตั้งแต่ : {{ $campaignpromotes_name_api['data'][0]['fromdate']}}
                                        ถึง : {{ $campaignpromotes_name_api['data'][0]['todate']}}
                                    </p>
                                    <p class="card-text">หมายเหตุ : {{ $campaignpromotes_name_api['data'][0]['remark']}}</p>
                                    <p class="card-text">เป้าทั้งหมด : {{ $campaignpromotes_name_api['data'][0]['Target']}}</p>
                                    <p class="card-text">เป้าที่ทำได้ : {{ $campaignpromotes_name_api['data'][0]['Sales']}}</p>
                                    <p class="card-text">ผลต่าง : {{ $campaignpromotes_name_api['data'][0]['Diff']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div id="table_list" class="table-responsive col-md-12">
                                <table id="datable_1" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th colspan="5" style="text-align:center;">รายการยอดขายสินค้าใหม่</th>
                                            <th colspan="2" style="text-align:center;">คิดเป็นเปอร์เซ็น (%)</th>
                                        </tr>

                                        <tr>
                                            <th>ผู้แทนขาย</th>
                                            <th>เป้าทั้งหมด</th>
                                            <th>เป้าที่ทำได้</th>
                                            <th>ผลต่าง</th>
                                            <th>จำนวนร้านค้า</th>
                                            <th>เป้าที่ทำได้</th>
                                            <th>ผลต่าง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 0;
                                        @endphp
                                        @foreach($campaign_detail_api as $value)
                                        <tr>
                                            <th scope="row">{{ ++$no }}</th>
                                            <td>
                                                {{ $value['identify'] }}
                                                {{ $value['name'] }}
                                            </td>
                                            <td>{{ number_format($value['Target'],2) }}</td>
                                            <td>{{ number_format($value['Sales'],2) }}</td>
                                            <td>{{ number_format($value['Diff'],2) }}</td>
                                            <td>-</td>
                                            <td>{{ number_format($value['persent_sale'],2) }}%</td>
                                            <td>{{ number_format($value['persent_diff'],2) }}%</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="2" align="center">ทั้งหมด</td>
                                        <td class="text-success">{{ number_format($summary_campaign_detail_api['sum_target'],2) }}</td>
                                        <td class="text-success">{{ number_format($summary_campaign_detail_api['sum_sales'],2) }}</td>
                                        <td class="text-danger">{{ number_format($summary_campaign_detail_api['sum_diff'],2) }}</td>
                                        <td class="text-secondary">-</td>
                                        <td class="text-success">{{ number_format($summary_campaign_detail_api['sum_persent_sale'],2) }}%</td>
                                        <td class="text-danger">{{ number_format($summary_campaign_detail_api['sum_persent_diff'],2) }}%</td>
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

