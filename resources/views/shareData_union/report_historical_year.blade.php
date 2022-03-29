<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเทียบย้อนหลัง (ทั้งปี)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเทียบย้อนหลัง (ทั้งปี)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-8">
                            <h5 class="hk-sec-title">ตารางรายงานเทียบย้อนหลัง (ทั้งปี)</h5>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <!-- ------ -->
                                <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <select name="sel_year_form" id="sel_year_form" class="form-control" required>
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
                                        <div class="form-group col-md-1" style="text-align:center; margin-top:10px;"> ถึง </div>
                                        <div class="form-group col-md-4">
                                            <select name="sel_year_to" id="sel_year_to" class="form-control" required>
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
                                            <th rowspan="2">ปี</th>
                                            <th colspan="3" style="text-align:center;">จำนวน</th>
                                            <th rowspan="2">มูลค่าการขาย</th>
                                            <th colspan="2" style="text-align:center;">รับคืน</th>
                                            <th rowspan="2">มูลค่าขายสุทธิ</th>
                                            <th rowspan="2">%ยอดขาย</th>
                                        </tr>

                                        <tr style="text-align:center">
                                            <th>ลูกค้า</th>
                                            <th>ผู้แทนขาย</th>
                                            <th>เดือน</th>
                                            <th>มูลค่า</th>
                                            <th>%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $sum_present_sale = 0;
                                    @endphp
                                    @if(!is_null($yearadmin_api))
                                        @foreach($yearadmin_api as $key => $value)
                                        <tr style="text-align:center">
                                            <td>{{ $value['year'] }}</td>
                                            <td>{{ number_format($value['customers']) }}</td>
                                            <td>{{ number_format($value['Sellers']) }}</td>
                                            <td>{{ number_format($value['months']) }}</td>
                                            <td style="text-align:right">{{ number_format($value['sales']) }}</td>
                                            <td style="text-align:right">{{ number_format($value['credits']) }}</td>
                                            <td>{{ number_format($value['%Credit'],2) }}%</td>
                                            <td style="text-align:right">{{ number_format($value['netSales']) }}</td>
                                            <td>{{ number_format($value['%Sale'],2) }}%</td>
                                        </tr>
                                            @php
                                                $sum_present_sale += $value['%Sale'];
                                            @endphp
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot style="font-weight: bold; text-align:center">
                                        <td style="text-align:center">รวม</td>
                                        <td colspan="3" style="text-align:center"></td>
                                        <td style="text-align:right">{{ number_format($summary_yearadmin_api['sum_sales']) }}</td>
                                        <td style="text-align:right">{{ number_format($summary_yearadmin_api['sum_credits']) }}</td>
                                        <td>{{ number_format($summary_yearadmin_api['sum_persent_credits'],2) }}%</td>
                                        <td style="text-align:right">{{ number_format($summary_yearadmin_api['sum_netSales']) }}</td>
                                        <td>{{ $sum_present_sale }}%</td>
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
                            <canvas id="myChart_2" style="height: 294px"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="myChart_3" style="height: 294px"></canvas>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <canvas id="myChart" style="height: 294px"></canvas>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->

    </div>



<script src="{{ asset('public/template/graph/Chart.bundle.js') }}"></script>



<script>
  var data = {
  labels: [{{ $chat_year }}],
  datasets: [{
    label: 'ยอดขาย',
    data: [{{ $chat_persent_sale }}],
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)'
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
    document.getElementById('myChart_3'),
    config
  );

</script>


<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [{{ $chat_year }}],
            datasets: [{
                label: 'จำนวนลูกค้าปัจจุบัน',
                data: [{{ $chat_customer }}],
                backgroundColor: [
                    // 'rgba(255, 99, 132, 0.3)',
                    'rgba(255, 99, 132, 0.3)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
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
</script>

<script>
    var ctx = document.getElementById("myChart_2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [{{ $chat_year }}],
            datasets: [{
                label: 'ยอดขาย',
                data: [{{ $chat_netsales }}],
                backgroundColor: [
                    // 'rgba(255, 99, 132, 0.3)',
                    'rgba(255, 99, 132, 0.3)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
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
</script>



 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>


