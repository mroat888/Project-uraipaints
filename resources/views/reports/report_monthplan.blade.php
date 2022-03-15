@extends('layouts.master')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงาน ผลดำเนินการ</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงาน ผลดำเนินการ</h4>
            </div>
            {{-- <div class="d-flex">
                <button class="btn btn-primary btn-sm"><i data-feather="printer"></i> พิมพ์</button>
            </div> --}}
        </div>
        <!-- /Title -->


        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-7">
                            <!-- <h5 class="hk-sec-title">ตารางสรุป Sale plan <span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo thaidate('Y', date('Y')); ?>)</span></h5> -->
                            @php 
                                if(isset($sel_year)){
                                    $year = $sel_year;
                                }else{
                                    $year = date('Y');
                                }
                                $action = '/reportSale/reportMonthlyPlans/search';
                            @endphp
                            <h5 class="hk-sec-title">ตารางสรุป ผลดำเนินการ <span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo $year+543; ?>)</span></h5>
                        </div>
                        <div class="col-sm-12 col-md-5">
                                <!-- ------ -->
                            <form action="{{ url($action) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-9">
                                            <select name="sel_year" id="sel_year" class="form-control" required>
                                                <option value="">--ค้นหาปี--</option>
                                                <?php
                                                    list($year,$month,$day) = explode("-", date("Y-m-d"));
                                                    for($i = 0; $i<4; $i++){
                                                ?>
                                                        <option value="{{ $year-$i }}">{{ $year-$i }}</option>
                                                <?php
                                                    }
                                                ?>
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
                             <div id="table_list" class="table-responsive col-md-12">
                                <table id="datable_1" class="table table-hover">
                                <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2" style="text-align:center;">เดือน</th>
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
                                        <?php
                                            $month_array = [
                                            'มกราคม', 'กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                                            'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'
                                        ];

                                        $total_saleplan = 0;
                                        $total_saleplan_in_process = 0;
                                        $total_saleplan_success = 0;
                                        $total_saleplan_failed = 0;
                                        $no = 0;
                                       // for($i = 0; $i <= 12; $i++ ){
                                        ?>
                                        @php $no = 0; @endphp
                                        @foreach($report as $key => $value)
                                        <tr>
                                            <th scope="row">{{ ++$no }}</th>
                                            <td>{{ $month_array[$key] }}</td>
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

                                        <?php
                                        //}
                                        ?>

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

