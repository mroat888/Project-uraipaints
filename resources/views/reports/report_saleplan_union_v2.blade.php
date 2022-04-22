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
                        <div class="col-sm-12 col-md-9">
                            @php 
                                $month_array = [
                                        "01" => 'มกราคม', "02" => 'กุมภาพันธ์', "03" => 'มีนาคม', "04" => 'เมษายน', "05" => 'พฤษภาคม', "06" => 'มิถุนายน',
                                        "07" => 'กรกฎาคม', "08" => 'สิงหาคม', "09" => 'กันยายน', "10" => 'ตุลาคม', "11" => 'พฤศจิกายน', "12" => 'ธันวาคม'
                                    ];
                            @endphp
                            
                            <!-- <h5 class="hk-sec-title">ตารางสรุป Sale plan <span style="color: rgb(128, 19, 0);">(ประจำปี <?php echo thaidate('Y', $year); ?>)</span></h5> -->
                            <h5 class="hk-sec-title">ตารางสรุป แผนประจำเดือน <span style="color: rgb(128, 19, 0);">( {{ $month_array[$search_month] }} <?php echo $year+543; ?>)</span></h5>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <!-- ------ -->
                            
                            <form action="{{ url($action) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-9">
                                            <select name="sel_month" id="sel_month" class="form-control" required>
                                                <option value="">--เลือกเดือน--</option>
                                                @foreach($month_array as $key =>  $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
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
                                        <tr style="text-align:center">
                                            <th rowspan="2"><strong>#</strong></th>
                                            <th rowspan="2"><strong>รายชื่อผู้แทนขาย</strong></th>
                                            <th colspan="5" class="bg-danger text-white" style="text-align:center;"><strong>แผน</strong></th>
                                            <th colspan="2" class="bg-success text-white" style="text-align:center;"><strong>แผนงาน</strong></th>
                                            <th colspan="2" class="bg-info text-white" style="text-align:center;"><strong>ลูกค้าใหม่</strong></th>
                                            <th colspan="2" class="bg-warning text-dark" style="text-align:center;"><strong>เยี่ยมลูกค้า</strong></th>
                                        </tr>
                                        <tr style="text-align:center">
                                            <th class="bg-danger text-white"><strong>สถานะ</strong></th>
                                            <th class="bg-danger text-white"><strong>รวม</strong></th>
                                            <th class="bg-danger text-white"><strong>เสร็จแล้ว</strong></th>
                                            <th class="bg-danger text-white"><strong>คงเหลือ</strong></th>
                                            <th class="bg-danger text-white"><strong>%สำเร็จ</strong></th>

                                            <th class="bg-success text-white"><strong>แผน</strong></th>
                                            <th class="bg-success text-white"><strong>เสร็จแล้ว</strong></th>

                                            <th class="bg-info text-white"><strong>แผน</strong></th>
                                            <th class="bg-info text-white"><strong>เสร็จแล้ว</strong></th>

                                            <th class="bg-warning text-dark"><strong>แผน</strong></th>
                                            <th class="bg-warning text-dark"><strong>เสร็จแล้ว</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php 
                                        $no = 0;
                                        // dd($users_saleman);
                                    @endphp
                                    @foreach($users_saleman as $key_saleman => $value_saleman)
                                        <tr style="text-align:center">
                                            <td>{{ ++$no }}</td>
                                            <td style="text-align:left">{{ $value_saleman->name }}</td>

                                            <td>
                                                @if($monthly_plans_status[$key_saleman] == "2")
                                                    <span class="badge badge-soft-success">Approved</span>
                                                @elseif($monthly_plans_status[$key_saleman] == "1")
                                                    <span class="badge badge-soft-warning">Pending</span>
                                                @elseif($monthly_plans_status[$key_saleman] == "0")
                                                    <span class = "badge badge-soft-white">Draft</span>
                                                @else
                                                    <span class = "badge badge-soft-danger">Null</span>
                                                @endif
                                            </td>
                                            <td class="bg-danger text-white">{{ $monthly_plans_total[$key_saleman] }}</td>
                                            <td>{{ $monthly_plans_success[$key_saleman] }}</td>
                                            <td>{{ $monthly_plans_balance[$key_saleman] }}</td>
                                            <td>{{ number_format($monthly_plans_present[$key_saleman]) }}%</td>

                                            <td class="bg-success text-white">{{ $count_saleplan[$key_saleman] }}</td>
                                            <td>{{ $count_sale_success[$key_saleman] }}</td>

                                            <td class="bg-info text-white">{{ $count_customer_new[$key_saleman] }}</td>
                                            <td>{{ $count_customer_new_success[$key_saleman] }}</td>

                                            <td class="bg-warning text-dark">{{ $count_customer_visits[$key_saleman] }}</td>
                                            <td>{{ $count_customer_visits_success[$key_saleman] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot style="text-align:center;">
                                        <tr>
                                            <td colspan="3"><strong>รวมทั้งหมด</strong></td>
                                            <td class="bg-danger text-white"><strong>{{ $summary['sum_monthly_plans_total'] }}</strong></td>
                                            <td><strong>{{ $summary['sum_monthly_plans_success'] }}</strong></td>
                                            <td><strong>{{ $summary['sum_monthly_plans_balance'] }}</strong></td>
                                            <td><strong>{{ number_format($summary['sum_monthly_plans_present']) }}%</strong></td>
                                            <td class="bg-success text-white"><strong>{{ $summary['sum_count_saleplan'] }}</strong></td>
                                            <td><strong>{{ $summary['sum_count_sale_success'] }}</strong></td>
                                            <td class="bg-info text-white"><strong>{{ $summary['sum_count_customer_new'] }}</strong></td>
                                            <td><strong>{{ $summary['sum_count_customer_new_success'] }}</strong></td>
                                            <td class="bg-warning text-dark"><strong>{{ $summary['sum_count_customer_visits'] }}</strong></td>
                                            <td><strong>{{ $summary['sum_count_customer_visits_success'] }}</strong></td>
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

