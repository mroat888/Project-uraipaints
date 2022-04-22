<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเข้าพบลูกค้า</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเข้าพบลูกค้า</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-7">
                            <!-- <h5 class="hk-sec-title">ตารางรายงานเข้าพบลูกค้า<span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo thaidate('Y', date('Y-m-d')); ?>)</span></h5> -->
                            <h5 class="hk-sec-title">ตารางรายงานเข้าเยี่ยมลูกค้า<span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo $year+543; ?>)</span></h5>
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
                                            <th colspan="2" style="text-align:center;">เข้าพบลูกค้า</th>
                                            <th colspan="3" style="text-align:center;">ผลดำเนินการ</th>
                                            <th colspan="2" style="text-align:center;">คิดเป็นเปอร์เซ็น (%)</th>
                                        </tr>

                                        <tr>
                                            <th>ลูกค้าตามแผน</th>
                                            <th>ลูกค้าเพิ่มเติม</th>
                                            <th>ระหว่างดำเนินการ</th>
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
                                            <td scope="row"><?php echo $i; ?></td>
                                            <td><?php echo $month_array[$i-1]; ?></td>
                                            <td><span class="text-success"><?php echo $report[$i]['cus_is_plan']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['cus_isnot_plan']; ?></span> </td>
                                            <td><span class="text-danger"><?php echo $report[$i]['cus_visit_in_process']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['cus_visit_success']; ?></span> </td>
                                            <td><span class="text-danger"><?php echo $report[$i]['cus_visit_failed']; ?></span> </td>
                                            <td><span class="text-success"><?php echo $report[$i]['percent_success']; ?>%</span> </td>
                                            <td><span class="text-danger"><?php echo $report[$i]['percent_failed']; ?>%</span> </td>
                                        </tr>
                                        @if(isset($report_detail[$i]))
                                            @foreach($report_detail[$i] as $value)
                                            <tr class="detail" rel="{{ $i }}">
                                                <td></td>
                                                <td>{{ $value['saleman'] }}</td>
                                                <td>{{ $value['cus_is_plan'] }}</td>
                                                <td>{{ $value['cus_isnot_plan'] }}</td>
                                                <td>{{ $value['cus_visit_in_process'] }}</td>
                                                <td>{{ $value['cus_visit_success']}}</td>
                                                <td>{{ $value['cus_visit_failed']}}</td>
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
                                        <td colspan="2" style="text-align:center;">ทั้งหมด</td>
                                        <td class="text-success"><?php echo $summary_report['sum_cus_is_plan']; ?></td>
                                        <td class="text-success"><?php echo $summary_report['sum_cus_isnot_plan']; ?></td>
                                        <td class="text-danger"><?php echo $summary_report['sum_cus_visit_in_process']; ?></td>
                                        <td class="text-success"><?php echo $summary_report['sum_cus_visit_success']; ?></td>
                                        <td class="text-danger"><?php echo $summary_report['sum_cus_visit_failed']; ?></td>
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


