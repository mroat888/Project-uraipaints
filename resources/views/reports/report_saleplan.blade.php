@extends('layouts.master')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงาน Sale plan</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงาน Sale plan</h4>
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
                                $action = 'reportSale/reportSaleplan/search';
                            @endphp
                            <h5 class="hk-sec-title">ตารางสรุป Sale plan <span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo $year+543; ?>)</span></h5>
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
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">เดือน</th>
                                            <th colspan="4" style="text-align:center;">Sale plan</th>
                                            <th colspan="2" style="text-align:center;">คิดเป็นเปอร์เซ็น (%)</th>
                                        </tr>
                                        <tr>
                                            <th>งาน</th>
                                            <th>รอดำเนินการ</th>
                                            <th>สำเร็จ</th>
                                            <th>ไม่สำเร็จ</th>
                                            <th>สำเร็จ</th>
                                            <th>ไม่สำเร็จ</th>
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

                                        for($i = 1; $i <= 12; $i++ ){

                                            if($report[$i]['count_saleplan'] != "-"){
                                                $total_saleplan =  $total_saleplan + $report[$i]['count_saleplan'];
                                            }
                                            if($report[$i]['saleplan_result_in_process'] != "-"){
                                                $total_saleplan_in_process =  $total_saleplan_in_process + $report[$i]['saleplan_result_in_process'];
                                            }
                                            if($report[$i]['saleplan_result_success'] != "-"){
                                                $total_saleplan_success =  $total_saleplan_success + $report[$i]['saleplan_result_success'];
                                            }
                                            if($report[$i]['saleplan_result_failed'] != "-"){
                                                $total_saleplan_failed =  $total_saleplan_failed + $report[$i]['saleplan_result_failed'];
                                            }

                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $month_array[$i-1]; ?></td>
                                                <td><span class="text-success"><?php echo $report[$i]['count_saleplan']; ?></span> </td>
                                                <td><span class="text-secondary"><?php echo $report[$i]['saleplan_result_in_process']; ?></span> </td>
                                                <td><span class="text-success"><?php echo $report[$i]['saleplan_result_success']; ?></span> </td>
                                                <td><span class="text-danger"><?php echo $report[$i]['saleplan_result_failed']; ?></span> </td>
                                                <td><span class="text-success"><?php echo $report[$i]['percent_success']; ?>%</span> </td>
                                                <td><span class="text-danger"><?php echo $report[$i]['percent_failed']; ?>%</span> </td>
                                            </tr>
                                            <?php
                                                }

                                                $sum_saleplan = 0;
                                                $sum_saleplan = $sum_saleplan + $total_saleplan; // จำนวน saleplan ทั้งหมด
                                                if($total_saleplan_success != 0){
                                                    $percent_success = ($total_saleplan_success*100)/$sum_saleplan;
                                                }else{
                                                    $percent_success = 0;
                                                }
                                                if($total_saleplan_failed != 0){
                                                    $percent_failed = ($total_saleplan_failed*100)/$sum_saleplan;
                                                }else{
                                                    $percent_failed = 0;
                                                }
                                            ?>
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="2" align="center">ทั้งหมด</td>
                                        <td class="text-success"><?php echo $total_saleplan; ?></td>
                                        <td class="text-secondary"><?php echo $total_saleplan_in_process; ?></td>
                                        <td class="text-success"><?php echo $total_saleplan_success; ?></td>
                                        <td class="text-danger"><?php echo $total_saleplan_failed; ?></td>
                                        <td class="text-success"><?php echo @round($percent_success); ?>%</td>
                                        <td class="text-danger"><?php echo @round($percent_failed); ?>%</td>
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

