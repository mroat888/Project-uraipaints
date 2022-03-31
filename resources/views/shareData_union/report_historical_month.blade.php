
<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเทียบย้อนหลัง (รายเดือน)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเทียบย้อนหลัง (รายเดือน)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-7">
                            <h5 class="hk-sec-title">รายงานเทียบย้อนหลัง (รายเดือน)</h5>
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <!-- ------ -->
                            <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <select name="sel_year_form" id="sel_year_form" class="form-control" required>
                                                <option value="">--ค้นหาปี--</option>
                                                <?php
                                                    list($year,$month,$day) = explode("-", date("Y-m-d"));
                                                    for($i = 0; $i<3; $i++){
                                                ?>
                                                        <option value="{{ $year-$i }}">{{ $year-$i }}</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-1" style="text-align:center; margin-top:10px;"> ถึง </div>
                                        <div class="form-group col-md-4">
                                            <select name="sel_year_to" id="sel_year_to" class="form-control" required>
                                                <option value="">--ค้นหาปี--</option>
                                                <?php
                                                    list($year,$month,$day) = explode("-", date("Y-m-d"));
                                                    for($i = 0; $i<3; $i++){
                                                ?>
                                                        <option value="{{ $year-$i }}">{{ $year-$i }}</option>
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
                            <div id="table_list" class="table-responsive col-md-12">
                                <table id="" class="table table-hover table-bordered" style="width:100%;">
                                    <thead>
                                    <tr style="text-align:center">
                                        <th rowspan="2"><strong>#</strong></th>
                                        <th rowspan="2"><strong>เดือน</strong></th>
                                        <th colspan = "{{ count($search_year) }}"><strong>ยอดขายสุทธิ</strong></th>
                                        <th colspan = "{{ count($search_year) }}"><strong>ร้านค้า</strong></th>
                                    </tr>
                                    <tr style="text-align:center;">
                                        @foreach($search_year as $key => $value)
                                            <th class="bg-success text-white">{{ $value }}</th>
                                        @endforeach
                                        @foreach($search_year as $key => $value)
                                            <th class="bg-info text-white">{{ $value }}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $month_array = [
                                            'มกราคม', 'กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                                            'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'
                                            ];
                                    ?>
                                    @php 
                                        $no = 0;
                                        $chat_data= array();
                                        $chat_data_label = array();
                                    @endphp
                                    @if(!empty($month_api))
                                        @for($i=0 ;$i<12; $i++)
                                            <tr style="text-align:center;">
                                                <td>{{ ++$no }}</td>
                                                <td><?php echo $month_array[$i]; ?></td>

                                                @foreach($search_year as $key => $value)
                                                    <td style="text-align:right;">
                                                        @if(!empty($month_api[$key][$i]['netSales']))
                                                            {{ number_format($month_api[$key][$i]['netSales'],) }}
                                                            @php 
                                                                $chat_data[$key][$i][] = $month_api[$key][$i]['netSales'];
                                                                $chat_data_label[] = $value;
                                                            @endphp
                                                        @endif
                                                    </td>
                                                @endforeach
                                                @foreach($search_year as $key => $value)
                                                    <td>
                                                        @if(!empty($month_api[$key][$i]['customers']))
                                                            {{ number_format($month_api[$key][$i]['customers']) }}
                                                        @endif
                                                    </td>
                                                @endforeach

                                            </tr>
                                        @endfor
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr style="text-align:center;">
                                            <td colspan="2"><strong>รวม</strong></td>
                                            @foreach($search_year as $key => $value)
                                                <td style="text-align:right;">
                                                    @if(!empty($summary[$key]['sum_netSales']))
                                                        <strong>{{ number_format($summary[$key]['sum_netSales']) }}</strong>
                                                    @endif
                                                </td>
                                            @endforeach
                                            @foreach($search_year as $key => $value)
                                                <td>
                                                    @if(!empty($summary[$key]['sum_customers']))
                                                        <strong>{{ number_format($summary[$key]['sum_customers']) }}</strong>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr style="text-align:center;">
                                            <td colspan="2"><strong>% ยอดรวม</strong></td>
                                            @foreach($search_year as $key => $value)
                                                <td style="text-align:right;">
                                                    @if(!empty($summary_present[$key]))
                                                        <strong>{{ number_format($summary_present[$key],2) }}</strong>
                                                    @endif
                                                </td>
                                            @endforeach
                                            @foreach($search_year as $key => $value)
                                                <td> </td>
                                            @endforeach
                                        </tr>
                                    </tfoot>
                                </table>
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
                        <div class="col-md-6">
                            <canvas id="myChart" style="height: 294px"></canvas>
                        </div>
                        <div class="col-md-6">
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

    $count = count($chat_data);
    $data_text = array();

    for($i=0;$i<3;$i++){
        $data_text[$i] = "";
        if(isset($chat_data_label[$i])){
            $chat_data_label[$i] = $chat_data_label[$i];
        }else{
            $chat_data_label[$i] = "";
        }
        for($m=0;$m<12;$m++){
            if(isset($chat_data[$i][$m])){
                $value = $chat_data[$i][$m][0];
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
?>
 <script>

    var ctx = document.getElementById("myChart").getContext('2d');

    var datset =[];
    var newDataset =[];
    newDataset[0] = {
        label: '{{ $chat_data_label[0] }}',
        backgroundColor: [
            'rgba(255, 99, 132, 0)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)'
        ],
        fill: false,
        borderWidth: 1,
        data: [<?=$data_text[0]?>],
    };
    newDataset[1] = {
        label: '{{ $chat_data_label[1] }}',
        backgroundColor: [
            'rgba(255, 99, 132, 0)'
        ],
        borderColor: [
            'rgba(255, 153, 51, 1)'
        ],
        fill: false,
        borderWidth: 1,
        data: [<?=$data_text[1]?>],
    };
    newDataset[2] = {
        label: '{{ $chat_data_label[2] }}',
        backgroundColor: [
            'rgba(255, 99, 132, 0)'
        ],
        borderColor: [
            'rgba(0, 204, 0, 1)'
        ],
        fill: false,
        borderWidth: 1,
        data: [<?=$data_text[2]?>],
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
                    beginAtZero: true
                }
            }
        }
    });
    
</script>

<?php

    $chat_persent_sale = "";
    $count_year = count($search_year);
    foreach($search_year as $key => $year_value){
        if(!empty($summary_present[$key])){
            if($summary_present[$key] != 0){
                $present = number_format($summary_present[$key],2) ;
            }else{
                $present = number_format(0,2);
            }
        }
        if($key < $count_year-1){
            $chat_persent_sale .= $present.",";
        }else{
            $chat_persent_sale .= $present;
        }
    }

?>


<script>

    var data = {
    labels: [{{ $chat_search_year }}],
        datasets: [{
            data: [ {{ $chat_persent_sale}} ],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 153, 51)',
                'rgb(192, 192, 192)'
            ],
            hoverOffset: 4
        }]
    };

    var config = {
        type: 'pie',
        data: data,
        options: {}
    };

    var myChart = new Chart(
        document.getElementById('myChart_2'),
        config
    );

</script>


