@extends('layouts.master')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเข้าพบลูกค้าใหม่</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเข้าพบลูกค้าใหม่</h4>
            </div>
            <div class="d-flex">
                <button class="btn btn-primary btn-sm"><i data-feather="printer"></i> พิมพ์</button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ตารางรายงานเข้าพบลูกค้าเป้าหมาย<span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo thaidate('Y', date('Y-m-d')); ?>)</span></h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
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
                                            <th colspan="2" style="text-align:center;">ลูกค้าใหม่</th>
                                            <th colspan="4" style="text-align:center;">ผลดำเนินการ</th>
                                            <th colspan="2" style="text-align:center;">คิดเป็นเปอร์เซ็น (%)</th>
                                        </tr>

                                        <tr>
                                            <th>ตามแผน</th>
                                            <th>นอกแผน</th>
                                            <th>รอตัดสินใจ</th>
                                            <th>ไม่สำเร็จ</th>
                                            <th>สำเร็จ</th>
                                            <th>เปลี่ยนเป็นลูกค้า</th>
                                            <th>สำเร็จ</th>
                                            <th>ไม่สำเร็จ(รวมรอตัดสินใจ)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $month_array = [
                                                'มกราคม', 'กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                                                'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'
                                            ];
                                        ?>
                                        <?php
                                            for($i = 1; $i <= 12; $i++ ){
                                        ?>
                                        <tr>
                                            <td scope="row"><?php echo $i; ?></td>
                                            <td><?php echo $month_array[$i-1]; ?></td>
                                            <td><span class="text-success"><?php echo $report[$i]['count_shop']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['count_shop_noplan']; ?></span> </td>
                                            <td><span class="text-danger"><?php echo $report[$i]['cus_result_in_process']; ?></span> </td>
                                            <td><span class="text-danger"><?php echo $report[$i]['cus_result_failed']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['cus_result_success']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['count_shop_updatestatus']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['percent_success']; ?>%</span> </td>
                                            <td><span class="text-danger"><?php echo $report[$i]['percent_failed']; ?>%</span> </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>      
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="2" style="text-align:center;">ทั้งหมด</td>
                                        <td class="text-success"><?php echo $summary_report['sum_count_shop']; ?></td>
                                        <td class="text-success"><?php echo $summary_report['sum_count_shop_noplan']; ?></td>
                                        <td class="text-danger"><?php echo $summary_report['sum_result_in_process']; ?></td>
                                        <td class="text-success"><?php echo $summary_report['sum_result_failed']; ?></td>
                                        <td class="text-danger"><?php echo $summary_report['sum_result_success']; ?></td>
                                        <td class="text-success"><?php echo $summary_report['sum_shop_updatestatus']; ?></td>
                                        <td class="text-success"><?php echo $summary_report['sum_percent_success']; ?>%</td>
                                        <td class="text-danger"><?php echo $summary_report['sum_percent_failed']; ?>%</td>
                                        {{-- <td class="text-success"></td> --}}
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

