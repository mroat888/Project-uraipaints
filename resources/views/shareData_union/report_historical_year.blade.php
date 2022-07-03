<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">สรุปยอดขาย (รายปี)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>สรุปยอดขาย (รายปี)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายงานสรุปยอดขาย (เทียบปีต่อปี)</h5>
                        </div>
                        <div class="col-sm-12 col-md-6" style="text-align:right;">
                            <!-- ------ -->
                                <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-3" style="text-align:center; margin-top:10px;">เทียบระหว่างปี</div>
                                        <div class="form-group col-md-3">
                                            <select name="sel_year_form" id="sel_year_form" class="form-control" required>
                                                <option value="">--ค้นหาปี--</option>
                                                <?php
                                                    list($year,$month,$day) = explode("-", date("Y-m-d"));
                                                    for($i = 0; $i<3; $i++){
                                                ?>
                                                        <option value="{{ $year-$i }}">
                                                            @php 
                                                                $year_thai = ($year-$i)+543
                                                            @endphp
                                                            {{ $year_thai }}
                                                        </option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-1" style="text-align:center; margin-top:10px;"> กับปี </div>
                                        <div class="form-group col-md-3">
                                            <select name="sel_year_to" id="sel_year_to" class="form-control" required>
                                                <option value="">--ค้นหาปี--</option>
                                                <?php
                                                    list($year,$month,$day) = explode("-", date("Y-m-d"));
                                                    for($i = 0; $i<3; $i++){
                                                ?>
                                                        <option value="{{ $year-$i }}">
                                                            @php 
                                                                $year_thai = ($year-$i)+543
                                                            @endphp
                                                            {{ $year_thai }}
                                                        </option>
                                                <?php
                                                    }
                                                ?>
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
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr style="text-align:center">
                                            <th>รายการ</th>
                                            <th>ปี 
                                                @php 
                                                    $year_thai_0 = $yearadmin_api[0]['year']+543;
                                                    if(isset($yearadmin_api[1])){ //-- ตรวจสอบมีข้อมูลมาไหม
                                                        $year_thai_1 = $yearadmin_api[1]['year']+543;
                                                        $sales_1 = $yearadmin_api[1]['sales'];
                                                        $sales_th_1 = $yearadmin_api[1]['sales_th'] ;
                                                        $customers_1 = $yearadmin_api[1]['customers'] ;
                                                    }else{
                                                        $year_thai_1 = $year_thai_0;
                                                        $sales_1 = $yearadmin_api[0]['sales'];
                                                        $sales_th_1 = $yearadmin_api[0]['sales_th'] ;
                                                        $customers_1 = $yearadmin_api[0]['customers'] ;
                                                    }
                                                @endphp
                                                {{ $year_thai_0 }}
                                            </th>
                                            <th>ปี {{ $year_thai_1 }}</th>
                                            <th>ผลต่าง</th>
                                            <th>%เปลี่ยนแปลง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align:center">
                                            <td style="text-align:left">ยอดขาย(บาท)</td>
                                            <td>{{ number_format($yearadmin_api[0]['sales'],2) }}</td>
                                            <td>{{ number_format($sales_1,2) }}</td>
                                                @php 
                                                    $diff_sale = $sales_1 - $yearadmin_api[0]['sales'];
                                                    $diff_sale_thai = $diff_sale/1000000;

                                                    $prasent_diff = ($diff_sale*100)/$yearadmin_api[0]['sales'];

                                                    if($diff_sale < 0){
                                                        $text_color = "text-danger";
                                                    }else{
                                                        $text_color = "text-success";
                                                    }

                                                @endphp
                                            <td class = "{{ $text_color }}">{{ number_format($diff_sale,2) }}</td>
                                            <td class = "{{ $text_color }}">{{ number_format($prasent_diff,2) }} %</td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td style="text-align:left">จำนวนร้านค้า(ร้าน)</td>
                                            <td>{{ number_format($yearadmin_api[0]['customers']) }}</td>
                                            <td>{{ number_format($customers_1) }}</td>
                                                @php 
                                                    $diff_customers = $customers_1 - $yearadmin_api[0]['customers'];
                                                    $prasent_customers = ($diff_customers*100)/$yearadmin_api[0]['customers'];

                                                    if($diff_customers < 0){
                                                        $text_color = "text-danger";
                                                    }else{
                                                        $text_color = "text-success";
                                                    }

                                                @endphp
                                            <td class = "{{ $text_color }}">{{ number_format($diff_customers) }}</td>
                                            <td class = "{{ $text_color }}">{{ number_format($prasent_customers,2) }} %</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                ข้อมูลสิ้นสุด ณ วันที่ 
                                @php 
                                    list($tsyear,$tsmonth,$tswday) = explode("-", $trans_last_date);
                                    $year_thai = $tsyear+543;
                                    $trans_last_date_thai = $tswday."/".$tsmonth."/".$year_thai;
                                @endphp 
                                {{ $trans_last_date_thai }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายงานเปรียบเทียบเดือน</h5>
                        </div>
                        <div class="col-sm-12 col-md-6" style="text-align:right;">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr style="text-align:center">
                                            <th rowspan="2">#</th>   
                                            <th rowspan="2">เดือน</th>
                                            <th colspan="4">ยอดขาย(บาท)</th>
                                            <th colspan="3">จำนวนร้านค้าเปิดบิล</th>
                                        </tr>
                                        <tr style="text-align:center">
                                            <th>ปี {{ $year_thai_0 }}</th>
                                            <th>ปี {{ $year_thai_1 }}</th>
                                            <th>ผลต่าง</th>
                                            <th>% ผลต่าง</th>

                                            <th>ปี {{ $year_thai_0 }}</th>
                                            <th>ปี {{ $year_thai_1 }}</th>
                                            <th>ผลต่าง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $month_thai = ["เดือนไทย","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
                                            $year = $yearadmin_api[0]['year'];
                                            $year_old = $yearadmin_api[1]['year'];
                                        @endphp
                                        <?php 
                                            $sum_sale_0 = 0;
                                            $sum_sale_1 = 0;
                                            $sum_sale_diff = 0;
                                            $sum_persent_sale = 0;
                                            $sum_customers_0 = 0; 
                                            $sum_customers_1 = 0; 
                                            $sum_customers_diff = 0; 

                                            $total_sale_0 = 0;
                                            $total_sale_1 = 0;
                                            $total_sale_diff = 0;
                                            $total_persent_sale = 0;

                                            for($i=1; $i<13; $i++){
                                        ?>
                                            @php 
                                                $key = $i-1;
                                                $sales_th_0  = "-";
                                                $sales_th_1  = "-";
                                                $sales_0 = 0;
                                                $sales_1 = 0;
                                                $customers_0 = 0;
                                                $customers_1 = 0;

                                                if(isset($monthadmin_api[$year][$key]['sales_th'])){
                                                    $sales_th_0 = $monthadmin_api[$year][$key]['sales_th'];
                                                    $sales_0 = $monthadmin_api[$year][$key]['sales'];

                                                    $sum_sale_0 += $sales_0;
                                                }
                                                
                                                if(isset($monthadmin_api[$year_old][$key]['sales_th'])){
                                                    $sales_th_1 = $monthadmin_api[$year_old][$key]['sales_th'];
                                                    $sales_1 = $monthadmin_api[$year_old][$key]['sales'];

                                                    $sum_sale_1 += $sales_1;
                                                }

                                                $sale_diff = $sales_1-$sales_0;
                                                $sale_diff_thai = $sale_diff/1000000;

                                                $persent_sale = ($sale_diff*100)/$sales_0;
                                                if($sale_diff < 0){
                                                    $text_color_sale = "text-danger";
                                                }else{
                                                    $text_color_sale = "text-success";
                                                }

                                                if(isset($monthadmin_api[$year][$key]['customers'])){
                                                    $customers_0 = $monthadmin_api[$year][$key]['customers'];
                                                    $sum_customers_0 += $customers_0;
                                                }

                                                if(isset($monthadmin_api[$year_old][$key]['customers'])){
                                                    $customers_1 = $monthadmin_api[$year_old][$key]['customers'];
                                                    $sum_customers_1 += $customers_1;
                                                }

                                                $customers_diff = $customers_1 - $customers_0;

                                                if($customers_diff < 0){
                                                    $text_color_customer = "text-danger";
                                                }else{
                                                    $text_color_customer = "text-success";
                                                }

                                            @endphp
                                            <tr style="text-align:right">
                                                <td style="text-align:center;">{{ $i }}</td>
                                                <td style="text-align:left;">{{ $month_thai[$i] }}</td>
                                                <td>{{ number_format($sales_0,2) }}</td>
                                                <td>{{ number_format($sales_1,2) }}</td>
                                                <td class="{{ $text_color_sale }}">{{ number_format($sale_diff,2) }}</td>
                                                <td class="{{ $text_color_sale }}">{{ number_format($persent_sale,2) }}</td>
                                                <td style="text-align:center;">{{ number_format($customers_0) }}</td>
                                                <td style="text-align:center;">{{ number_format($customers_1) }}</td>
                                                <td style="text-align:center;" class="{{ $text_color_customer }}">{{ number_format($customers_diff) }}</td>
                                            </tr>
                                            @php 
                                                $qt_break = $i % 3;
                                                $qt_qt = $i/3;

                                                switch($qt_qt){
                                                    case 1 : $bg_row = "bg-info";
                                                        break;
                                                    case 2 : $bg_row = "bg-teal";
                                                        break;
                                                    case 3 : $bg_row = "bg-warning";
                                                        break;
                                                    case 4 : $bg_row = "btn-purple";
                                                        break;
                                                }
                                            @endphp
                                            @if($qt_break == 0)
                                                @php 
                                                    $sum_sale_0_thai = $sum_sale_0/1000000;
                                                    $sum_sale_1_thai = $sum_sale_1/1000000;
                                                    $sum_sale_diff = $sum_sale_1 - $sum_sale_0;
                                                    $sum_sale_diff_thai = $sum_sale_diff/1000000;
                                                    $sum_persent_sale = ($sum_sale_diff*100)/$sum_sale_0;
                                                    $sum_customers_diff = $sum_customers_1 - $sum_customers_0;

                                                    $total_sale_0 += $sum_sale_0;
                                                    $total_sale_1 += $sum_sale_1;

                                                    if($sum_sale_diff < 0){
                                                        $text_color_sum = "text-danger";
                                                    }else{
                                                        $text_color_sum = "text-success";
                                                    }

                                                @endphp
                                                <tr class="{{ $bg_row }}" style="text-align:right; font-weight:bold;">
                                                    <td colspan="2">สรุปไตรมาส {{ $qt_qt }}</td>
                                                    <td>{{ number_format($sum_sale_0,2) }}</td>
                                                    <td>{{ number_format($sum_sale_1,2) }}</td>
                                                    <td class="{{ $text_color_sum }}">{{ number_format($sum_sale_diff,2) }}</td>
                                                    <td class="{{ $text_color_sum }}">{{ number_format($sum_persent_sale) }}</td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;" class="{{ $text_color_customer }}"></td>
                                                </tr>
                                                @php 
                                                    $sum_sale_0 = 0;
                                                    $sum_sale_1 = 0;
                                                    $sum_sale_diff = 0;
                                                    $sum_persent_sale = 0;
                                                    $sum_customers_0 = 0;
                                                    $sum_customers_1 = 0;
                                                    $sum_customers_diff = 0;
                                                @endphp
                                            @endif
                                        <?php
                                            }
                                        ?>
                                            <tfoot style="font-weight: bold; text-align:right">
                                            @php 
                                                $total_sale_diff = $total_sale_1 - $total_sale_0;
                                                $total_persent_sale = ($total_sale_diff*100)/$total_sale_0;

                                                if($total_sale_diff < 0){
                                                    $text_color_sum = "text-danger";
                                                }else{
                                                    $text_color_sum = "text-success";
                                                }
                                            @endphp
                                            <tr>
                                                <td colspan="2">รวมทั้งปี</td>
                                                <td>{{ number_format($total_sale_0,2) }}</td>
                                                <td>{{ number_format($total_sale_1,2) }}</td>
                                                <td class="{{ $text_color_sum }}">{{ number_format($total_sale_diff,2) }}</td>
                                                <td class="{{ $text_color_sum }}">{{ number_format($total_persent_sale,2) }}</td>
                                                <td style="text-align:center;"></td>
                                                <td style="text-align:center;"></td>
                                                <td style="text-align:center;"></td>
                                            </tr>
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                ข้อมูลสิ้นสุด ณ วันที่ 
                                @php 
                                    list($tsyear,$tsmonth,$tswday) = explode("-", $customer_trans_last_date);
                                    $year_thai = $tsyear+543;
                                    $trans_last_date_thai = $tswday."/".$tsmonth."/".$year_thai;
                                @endphp 
                                {{ $trans_last_date_thai }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper mt-0">
                    <!-- Title -->
                    <div class="hk-pg-header mb-0">
                        <div class="topichead-bgred"><i data-feather="file-text"></i> กราฟยอดขายเทียบปี</div>
                    </div>
                    <!-- /Title -->
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <canvas id="myChart" style="height: 294px"></canvas>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <!-- Title -->
                    <div class="hk-pg-header mb-0">
                        <div class="topichead-bgred"><i data-feather="file-text"></i> กราฟยอดขายเทียบไตรมาส</div>
                    </div>
                    <!-- /Title -->
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <canvas id="myChart_2" style="height: 294px"></canvas>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>

    <script src="{{ asset('public/template/graph/Chart.bundle.js') }}"></script>

<?php
    //-- กราฟ ส่วนเดือน ---
    $count = count($grap_data);
    $data_text = array();
    $lable_thai = array();

    for($i=0;$i<2;$i++){
        $data_text[$i] = "";
        $lable = $grap_lable[$i];
        $lable_thai[] = $grap_lable[$i] + 543;

        for($m=0;$m<12;$m++){
            if(isset($grap_data[$lable][$m])){
                $value = $grap_data[$lable][$m];
            }else{
                $value = "0";
            }

            if($m == 11){
                $data_text[$i] .= $value;
            }else{
                $data_text[$i] .= $value.",";
            } 
        }
    }
    //-- จบ กราฟ ส่วนเดือน ---
?>

<script>

    var ctx = document.getElementById("myChart").getContext('2d');

    var datset =[];
    var newDataset =[];
    newDataset[0] = {
        label: 'ยอดขายปี {{ $lable_thai[0] }}',
        borderColor: 'rgba(206,30,40,1)',
        fill: false,
        data: [<?=$data_text[0]?>],
        borderWidth: 2,
        tension: 0
    };
    newDataset[1] = {
        label: 'ยอดขายปี {{ $lable_thai[1] }}',
        borderColor: 'rgba(2, 119, 144,1)',
        fill: false,
        data: [<?=$data_text[1]?>],
        borderWidth: 2,
         tension: 0
    };

    for(let i=0; i<newDataset.length ; i++){
        datset.push(newDataset[i]);
    }

    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["มกราคม", "กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน",
            "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
            datasets: datset
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
    
</script>


<?php
//-- กราฟ ส่วนไตรมาส ---
$count = count($grap_data_quarter);
$data_text_quarter = array();
$lable_thai_quarter = array();

for($i=0;$i<2;$i++){
    $data_text_quarter[$i] = "";
    $lable = $grap_lable[$i];
    $lable_thai[] = $grap_lable[$i] + 543;

    for($qt=0;$qt<4;$qt++){
        if(isset($grap_data_quarter[$lable][$qt])){
            $value = $grap_data_quarter[$lable][$qt];
        }else{
            $value = "0";
        }

        if($qt == 3){
            $data_text_quarter[$i] .= $value;
        }else{
            $data_text_quarter[$i] .= $value.",";
        } 
    }
}
//-- จบ กราฟ ส่วนไตรมาส ---
?>

<script>

    var ctx = document.getElementById("myChart_2").getContext('2d');

    var datset =[];
    var newDataset =[];
    newDataset[0] = {
        label: 'ยอดขายปี {{ $lable_thai[0] }}',
        borderColor: 'rgba(206,30,40,1)',
        fill: false,
        data: [<?=$data_text_quarter[0]?>],
        borderWidth: 2,
        tension: 0
    };
    newDataset[1] = {
        label: 'ยอดขายปี {{ $lable_thai[1] }}',
        borderColor: 'rgba(2, 119, 144,1)',
        fill: false,
        data: [<?=$data_text_quarter[1]?>],
        borderWidth: 2,
         tension: 0
    };

    for(let i=0; i<newDataset.length ; i++){
        datset.push(newDataset[i]);
    }

    const myChart_2 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["ไตรมาส 1", "ไตรมาส 2","ไตรมาส 3","ไตรมาส 4"],
            datasets: datset
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
    
</script>