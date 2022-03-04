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
                                            <th><strong>Q1</strong></th>
                                            <th><strong>Q2</strong></th>
                                            <th><strong>Q3</strong></th>
                                            <th><strong>Q4</strong></th>
                                            <th><strong>Total</strong></th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                        @foreach($year_search as $key => $year_value)
                                        <tr>
                                            <td>{{ $year_value }}</td>
                                            <td>
                                                @if(isset($quarter_api_year[$key]['q1'][4]))
                                                    {{ number_format($quarter_api_year[$key]['q1'][4],2) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($quarter_api_year[$key]['q2'][4]))
                                                    {{ number_format($quarter_api_year[$key]['q2'][4],2) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($quarter_api_year[$key]['q3'][4]))
                                                    {{ number_format($quarter_api_year[$key]['q3'][4],2) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($quarter_api_year[$key]['q4'][4]))
                                                    {{ number_format($quarter_api_year[$key]['q4'][4],2) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($total_year[$key]['total_year']))
                                                    {{ number_format($total_year[$key]['total_year'],2) }}
                                                @endif
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

