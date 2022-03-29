<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเทียบย้อนหลัง (ไตรมาส)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเทียบย้อนหลัง (ไตรมาส)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-7">
                            <h5 class="hk-sec-title">รายงานเทียบย้อนหลัง (ไตรมาส)</h5>
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
                                <table id="datable_1" class="table table-hover table-bordered" style="width:100%;">
                                    <thead>
                                        <tr style="text-align:center">
                                            <th rowspan = "3" style="width:200px;"><strong>#</strong></th>
                                            <th colspan="12" style="text-align:center;"><strong>รายงานเทียบย้อนหลัง (ไตรมาส)</strong></th>
                                        </tr>
                                        <tr style="text-align:center">
                                            <th><strong>มกราคม - มีนาคม</strong></th>
                                            <th><strong>เมษายน - มิถุนายน</strong></th>
                                            <th><strong>กรกฎาคม - กันยายน</strong></th>
                                            <th><strong>ตุลาคม - ธันวาคม</strong></th>
                                            <th><strong>รวมทั้งปี</strong></th>
                                            <th><strong>%ยอดขาย</strong></th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                        @php 
                                            $data= array();
                                            $data_label = array();
                                        @endphp
                                        @foreach($year_search as $key => $year_value)
                                            @php
                                                $data_label[] = $year_value;
                                            @endphp
                                        <tr style="text-align:right">
                                            <td style="text-align:center">{{ $year_value }}</td>
                                            <td>
                                                @if(isset($quarter_api_year[$key]['q1'][4]))
                                                    {{ number_format($quarter_api_year[$key]['q1'][4],2) }}
                                                    @php 
                                                        $data[$key][] = $quarter_api_year[$key]['q1'][4];
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($quarter_api_year[$key]['q2'][4]))
                                                    {{ number_format($quarter_api_year[$key]['q2'][4],2) }}
                                                    @php 
                                                        $data[$key][] = $quarter_api_year[$key]['q2'][4];
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($quarter_api_year[$key]['q3'][4]))
                                                    {{ number_format($quarter_api_year[$key]['q3'][4],2) }}
                                                    @php 
                                                        $data[$key][] = $quarter_api_year[$key]['q3'][4];
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($quarter_api_year[$key]['q4'][4]))
                                                    {{ number_format($quarter_api_year[$key]['q4'][4],2) }}
                                                    @php 
                                                        $data[$key][] = $quarter_api_year[$key]['q4'][4];
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($total_year[$key]['total_year']))
                                                    @if($total_year[$key]['total_year'] != 0)
                                                        {{ number_format($total_year[$key]['total_year'],2) }}
                                                    @else
                                                        0
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="text-align:center;">
                                                @php 
                                                    $sum_all = $sum_netSales_q1+$sum_netSales_q2+$sum_netSales_q3+$sum_netSales_q4;
                                                    if(isset($total_year[$key]['total_year'])){
                                                        if($total_year[$key]['total_year'] != 0){
                                                            $persent_sale = ($total_year[$key]['total_year']*100)/$sum_all;
                                                        }else{
                                                            $persent_sale = 0;
                                                        }
                                                    }
                                                @endphp
                                                {{ number_format($persent_sale,2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight: bold; text-align:right;">
                                            <td style=" text-align:center; font-weight: bold; text-align:center;">ทั้งหมด</td>
                                            <td style="font-weight: bold;">{{ number_format($sum_netSales_q1,2) }}</td>
                                            <td style="font-weight: bold;">{{ number_format($sum_netSales_q2,2) }}</td>
                                            <td style="font-weight: bold;">{{ number_format($sum_netSales_q3,2) }}</td>
                                            <td style="font-weight: bold;">{{ number_format($sum_netSales_q4,2) }}</td>
                                            @php 
                                                $sum_all = $sum_netSales_q1+$sum_netSales_q2+$sum_netSales_q3+$sum_netSales_q4;
                                            @endphp
                                            <td style="font-weight: bold;">{{ number_format($sum_all,2) }}</td>
                                            <td style="font-weight: bold; text-align:center;">{{ number_format(100,2) }}</td>
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
                            
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>

<script src="{{ asset('public/template/graph/Chart.bundle.js') }}"></script>
<?php
    //$data_chat1 = "200,250,380,350";
    //$data_chat2 = "250,180,280,200";
    // $data_chat3 = "180,200,250,220";
    //$data_chat3 = "";
    $count = count($data);
    
    $data_text = array();

    for($i=0;$i<3;$i++){
        $data_text[$i] = "";
        if(isset($data_label[$i])){
            $data_label[$i] = $data_label[$i];
        }else{
            $data_label[$i] = "";
        }
        for($n=0; $n<4; $n++){

            if(isset($data[$i][$n])){
                $value = $data[$i][$n];
            }else{
                $value = 0;
            }
            // dd($value);
            if($n == 3){
                $data_text[$i] .= $value;
            }else{
                $data_text[$i] .= $value.",";
            } 
        } 

    }

    // dd($data, $count, $data_text);

?>

<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var datset =[];
    var newDataset =[];
   
    newDataset[0] = {
        label: '{{ $data_label[0] }}',
        backgroundColor: ['rgba(255, 99, 132, 0)',],
        borderColor: ['rgba(255,99,132,1)',],
        borderWidth: 1,
        data: [{{ $data_text[0] }}],
    };
    newDataset[1] = {
        label: '{{ $data_label[1] }}',
        backgroundColor: ['rgba(255, 99, 132, 0)',],
        borderColor: ['rgba(0,0,255,1)',],
        borderWidth: 1,
        data: [{{ $data_text[1]  }}],
    };
    newDataset[2] = {
        label: '{{ $data_label[2] }}',
        backgroundColor: ['rgba(200, 150, 100, 0)',],
        borderColor: ['rgba(255,128,0,1)',],
        borderWidth: 1,
        data: [{{ $data_text[2]  }}],
    };

    for(let i=0; i<newDataset.length ; i++){
        datset.push(newDataset[i]);
    }
       myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [1,2,3,4],
            datasets: datset
        },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        },
    );

    const actions = [
        {
            name: 'Add Dataset',
            handler(myChart) {
            const data = myChart.data;
            const dsColor = Utils.namedColor(myChart.data.datasets.length);
            const newDataset = {
                label: 'Dataset ' + (data.datasets.length + 1),
                backgroundColor: Utils.transparentize(dsColor, 0.5),
                borderColor: dsColor,
                data: Utils.numbers({count: data.labels.length, min: -100, max: 100}),
            };
            myChart.data.datasets.push(newDataset);
            myChart.update();
            }
        },
    ];

    module.exports = {
        actions: actions,
    };

</script>
