@extends('layouts.masterLead')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเทียบย้อนหลัง (Quarter)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเทียบย้อนหลัง (Quarter)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายงานเทียบย้อนหลัง (Quarter)</h5>
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
                            <div id="table_list" class="table-responsive col-md-12">
                                <table id="datable_1" class="table table-hover table-bordered" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th rowspan = "3" style="width:200px;"><strong>#</strong></th>
                                            <th colspan="12" style="text-align:center;"><strong>รายงานเทียบย้อนหลัง (Quarter)</strong></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" style="text-align:center;"><strong>ปี {{ $year_search[0]+543 }}</strong></th>
                                            <th colspan="4" style="text-align:center;"><strong>ปี {{ $year_search[1]+543 }}</strong></th>
                                            <th colspan="4" style="text-align:center;"><strong>ปี {{ $year_search[2]+543 }}</strong></th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="bg-primary text-white"><strong>Q1</strong></th>
                                            <th rowspan="2"><strong>Q2</strong></th>
                                            <th rowspan="2" class="bg-primary text-white"><strong>Q3</strong></th>
                                            <th rowspan="2"><strong>Q4</strong></th>

                                            <th rowspan="2" class="bg-primary text-white"><strong>Q1</strong></th>
                                            <th rowspan="2"><strong>Q2</strong></th>
                                            <th rowspan="2" class="bg-primary text-white"><strong>Q3</strong></th>
                                            <th rowspan="2"><strong>Q4</strong></th>

                                            <th rowspan="2" class="bg-primary text-white"><strong>Q1</strong></th>
                                            <th rowspan="2"><strong>Q2</strong></th>
                                            <th rowspan="2" class="bg-primary text-white"><strong>Q3</strong></th>
                                            <th rowspan="2"><strong>Q4</strong></th>
                                        </tr>
                                    </thead>
                                    @php
                                        $description = array('พนักงานขาย','จำนวนร้านค้า','ยอดขายรวม','ยอดคืนรวม','ยอดขายสุทธิ','เปอร์เซ็นต์คืน');
                                    @endphp
                                    <tbody>
                                        @foreach($description as $key => $value)
                                        <tr>
                                            <td style="width:200px;">{{ $value}}</td>

                                            <td class="bg-primary text-white">
                                                @if(isset($quarter_api_year['q1']))
                                                    {{ $quarter_api_year['q1'][$key] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($quarter_api_year['q2']))
                                                    {{ $quarter_api_year['q2'][$key] }}
                                                @endif
                                            </td>
                                            <td class="bg-primary text-white">
                                                @if(isset($quarter_api_year['q3']))
                                                    {{ $quarter_api_year['q3'][$key] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($quarter_api_year['q4']))
                                                    {{ $quarter_api_year['q4'][$key] }}
                                                @endif
                                            </td>

                                            <td class="bg-primary text-white">{{ $quarter_api_year_old1['q1'][$key] }}</td>
                                            <td>{{ $quarter_api_year_old1['q2'][$key] }}</td>
                                            <td class="bg-primary text-white">{{ $quarter_api_year_old1['q3'][$key] }}</td>
                                            <td>{{ $quarter_api_year_old1['q4'][$key] }}</td>

                                            <td class="bg-primary text-white">{{ $quarter_api_year_old2['q1'][$key] }}</td>
                                            <td>{{ $quarter_api_year_old2['q2'][$key] }}</td>
                                            <td class="bg-primary text-white">{{ $quarter_api_year_old2['q3'][$key] }}</td>
                                            <td>{{ $quarter_api_year_old2['q4'][$key] }}</td>
                                            
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

