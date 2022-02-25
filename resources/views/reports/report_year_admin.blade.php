@extends('layouts.masterAdmin')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานสรุปข้อมูลประจำปี</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานสรุปข้อมูลประจำปี</h4>
            </div>
            <div class="d-flex">
                <button class="btn btn-primary btn-sm"><i data-feather="printer"></i> พิมพ์</button>
            </div>
        </div>
        <!-- /Title -->

        {{-- <div class="body-responsive">
        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Column Chart with Labels</h6>
            <div class="row">
                <div class="col-sm">
                    <div id="e_chart_11" class="echart responsive" style="height:400px;"></div>
                </div>
            </div>
        </section>
        </div> --}}

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ตารางสรุปข้อมูลประจำปี <span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo thaidate('Y', date('Y-m-d')); ?>)</span></h5>
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
                                <table id="datable_1" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2" style="text-align:center;">รายชื่อผู้แทนขาย</th>
                                            <th colspan="6" class="bg-success text-white" style="text-align:center;">จำนวนลูกค้าเยี่ยม(ทั้งหมด)</th>
                                            <th colspan="6" class="bg-info text-white" style="text-align:center;">จำนวนลูกค้าใหม่ (ทั้งหมด)</th>
                                            <th colspan="6" class="bg-warning text-dark" style="text-align:center;">แผนงาน (ทั้งหมด)</th>
                                        </tr>

                                        <tr>
                                            
                                            <th class="bg-success text-white">งาน</th>
                                            <th class="bg-success text-white">ยังไม่ทำ</th>
                                            <th class="bg-success text-white">สำเร็จ</th>
                                            <th class="bg-success text-white">ไม่สำเร็จ</th>
                                            <th class="bg-success text-white">สำเร็จ (%)</th>
                                            <th class="bg-success text-white">ไม่สำเร็จ (%)</th>

                                            <th class="bg-info text-white">งาน</th>
                                            <th class="bg-info text-white">ยังไม่ทำ</th>
                                            <th class="bg-info text-white">สำเร็จ</th>
                                            <th class="bg-info text-white">ไม่สำเร็จ</th>
                                            <th class="bg-info text-white">สำเร็จ (%)</th>
                                            <th class="bg-info text-white">ไม่สำเร็จ (%)</th>

                                            <th class="bg-warning text-dark">งาน</th>
                                            <th class="bg-warning text-dark">ยังไม่ทำ</th>
                                            <th class="bg-warning text-dark">สำเร็จ</th>
                                            <th class="bg-warning text-dark">ไม่สำเร็จ</th>
                                            <th class="bg-warning text-dark">สำเร็จ (%)</th>
                                            <th class="bg-warning text-dark">ไม่สำเร็จ (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0; @endphp
                                        @foreach($report as $key => $value)
                                        <tr>
                                            <th scope="row">{{ ++$no }}</th>
                                            <td>{{ $report[$key]['user_name'] }}</td>
                                            <!-- ลูกค้าเยี่ยม -->
                                            <td class="bg-success"><span class="text-white">{{ $report[$key]['cust_visits_amount'] }}</span></td>
                                            <td class="bg-secondary"><span class="text-white">{{ $report[$key]['cus_visit_in_process'] }}</span></td>
                                            <td><span class="text-success">{{ $report[$key]['cus_visit_success'] }}</span></td>
                                            <td><span class="text-danger">{{ $report[$key]['cus_visit_failed'] }}</span></td>
                                            <td><span class="text-success">{{ $report[$key]['percent_custvisit_success'] }}%</span></td>
                                            <td><span class="text-danger">{{ $report[$key]['percent_custvisit_failed'] }}%</span></td>
                                            <!-- จบ ลูกค้าเยี่ยม -->
                                            <!-- ลูกค้าใหม่ -->
                                            <td class="bg-info"><span class="text-white">{{ $report[$key]['cust_new_amount'] }}</span></td>
                                            <td class="bg-secondary"><span class="text-white">{{ $report[$key]['cust_new_in_process'] }}</span></td>
                                            <td><span class="text-success">{{ $report[$key]['cust_new_success'] }}</span></td>
                                            <td><span class="text-danger">{{ $report[$key]['cust_new_failed'] }}</span></td>
                                            <td><span class="text-success">{{ $report[$key]['percent_custnew_success'] }}%</span></td>
                                            <td><span class="text-danger">{{ $report[$key]['percent_custnew_failed'] }}%</span></td>
                                            <!-- จบลูกค้าใหม่ -->
                                            <!-- แผนงาน Sale plan -->
                                            <td class="bg-warning"><span class="text-dark">{{ $report[$key]['sale_plans_amount'] }}</span></td>
                                            <td class="bg-secondary"><span class="text-white">{{ $report[$key]['sale_plans_in_process'] }}</span></td>
                                            <td><span class="text-success">{{ $report[$key]['sale_plans_success'] }}</span></td>
                                            <td><span class="text-danger">{{ $report[$key]['sale_plans_failed'] }}</span></td>
                                            <td><span class="text-success">{{ $report[$key]['percent_saleplans_success'] }}%</span></td>
                                            <td><span class="text-danger">{{ $report[$key]['percent_saleplans_failed'] }}%</span></td>
                                            <!-- จบ แผนงาน Sale plan -->
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="2" style="text-align:center; ">ทั้งหมด</td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_cust_visits_amount'] }}</span></td>
                                        <td><span class="text-gray">{{ $report_footer[0]['sum_cus_visit_in_process'] }}</span></td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_cus_visit_success'] }}</span></td>
                                        <td><span class="text-danger">{{ $report_footer[0]['sum_cus_visit_failed'] }}</span></td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_percent_custvisit_success'] }}%</span></td>
                                        <td><span class="text-danger">{{ $report_footer[0]['sum_percent_custvisit_failed'] }}%</span></td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_cust_new_amount'] }}</span></td>
                                        <td><span class="text-gray">{{ $report_footer[0]['sum_cus_new_in_process'] }}</span></td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_cus_new_success'] }}</span></td>
                                        <td><span class="text-danger">{{ $report_footer[0]['sum_cus_new_failed'] }}</span></td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_percent_custnew_success'] }}%</span></td>
                                        <td><span class="text-danger">{{ $report_footer[0]['sum_percent_custnew_failed'] }}%</span></td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_sale_plans_amount'] }}</span></td>
                                        <td><span class="text-gray">{{ $report_footer[0]['sum_sale_plans_in_process'] }}</span></td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_sale_plans_success'] }}</span></td>
                                        <td><span class="text-danger">{{ $report_footer[0]['sum_sale_plans_failed'] }}</span></td>
                                        <td><span class="text-success">{{ $report_footer[0]['sum_percent_saleplans_success'] }}%</span></td>
                                        <td><span class="text-danger">{{ $report_footer[0]['sum_percent_saleplans_failed'] }}%</span></td>
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

