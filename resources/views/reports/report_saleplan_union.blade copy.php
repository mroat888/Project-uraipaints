<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานสรุปแผนประจำเดือน</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานสรุปแผนประจำเดือน</h4>
            </div>
        </div>
        <!-- /Title -->


        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-7">
                            
                            <!-- <h5 class="hk-sec-title">ตารางสรุป Sale plan <span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo thaidate('Y', $year); ?>)</span></h5> -->
                            <h5 class="hk-sec-title">ตารางสรุป แผนประจำเดือน <span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo $year+543; ?>)</span></h5>
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

                                        for($i = 1; $i <= 12; $i++ ){
                                    ?>
                                        <tr class="showdetail" rel="{{ $i }}">
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td><?php echo $month_array[$i-1]; ?></td>
                                            <td><span class="text-success"><?php echo $report[$i]['count_saleplan']; ?></span> </td>
                                            <td><span class="text-secondary"><?php echo $report[$i]['saleplan_result_in_process']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['saleplan_result_success']; ?></span> </td>
                                            <td><span class="text-danger"><?php echo $report[$i]['saleplan_result_failed']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['percent_success']; ?>%</span> </td>
                                            <td><span class="text-danger"><?php echo $report[$i]['percent_failed']; ?>%</span> </td>
                                        </tr>

                                        @if(isset($report_detail[$i]))
                                            @foreach($report_detail[$i] as $value)
                                            <tr class="detail" rel="{{ $i }}">
                                                <td></td>
                                                <td>{{ $value['saleman'] }}</td>
                                                <td>{{ $value['count_saleplan'] }}</td>
                                                <td>{{ $value['saleplan_result_in_process'] }}</td>
                                                <td>{{ $value['saleplan_result_success'] }}</td>
                                                <td>{{ $value['saleplan_result_failed']}}</td>
                                                <td>{{ $value['percent_success']}}%</td>
                                                <td>{{ $value['percent_failed']}}%</td>  
                                            </tr>
                                            @endforeach
                                        @endif

                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot style="font-weight: bold;">
                                        <td colspan="2" align="center">ทั้งหมด</td>
                                        <td class="text-success"><?php echo $summary_report['sum_count_saleplan']; ?></td>
                                        <td class="text-secondary"><?php echo $summary_report['sum_result_in_process']; ?></td>
                                        <td class="text-success"><?php echo $summary_report['sum_result_success']; ?></td>
                                        <td class="text-danger"><?php echo $summary_report['sum_result_failed']; ?></td>
                                        <td class="text-success"><?php echo $summary_report['sum_percent_success']; ?>%</td>
                                        <td class="text-danger"><?php echo $summary_report['sum_percent_failed']; ?>%</td>
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

<style>
    .detail{
        background-color:#DCD0FF;
        display:none;
    }

    .detail:hover{
        background-color:#FFF;
    }
</style>
<script>
    $(document).on('click', '.showdetail', function(){
        let rel = $(this).attr("rel");
        $('.detail[rel=' + rel + ']').toggle();
    });
</script>

 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>

