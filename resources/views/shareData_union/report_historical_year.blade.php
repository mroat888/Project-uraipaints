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
                                            <td>{{ $yearadmin_api[0]['sales_th'] }}</td>
                                            <td>{{ $sales_th_1 }}</td>
                                            <td>
                                                @php 
                                                    $diff_sale = $sales_1 - $yearadmin_api[0]['sales'];
                                                    $diff_sale_thai = $diff_sale/1000000;

                                                    $prasent_diff = ($diff_sale*100)/$yearadmin_api[0]['sales'];
                                                @endphp
                                                {{ number_format($diff_sale_thai,2) }} ล้าน
                                            </td>
                                            <td>{{ number_format($prasent_diff,2) }} %</td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td style="text-align:left">จำนวนร้านค้า(ร้าน)</td>
                                            <td>{{ number_format($yearadmin_api[0]['customers']) }}</td>
                                            <td>{{ number_format($customers_1) }}</td>
                                            <td>
                                                @php 
                                                    $diff_customers = $customers_1 - $yearadmin_api[0]['customers'];

                                                    $prasent_customers = ($diff_customers*100)/$yearadmin_api[0]['customers'];
                                                @endphp
                                                {{ number_format($diff_customers) }}
                                            </td>
                                            <td>{{ number_format($prasent_customers,2) }} %</td>
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
                                    @php 

                                    @endphp
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
                                            $sum_sale_0 = 0;
                                            $sum_sale_1 = 0;
                                            $sum_sale_diff = 0;
                                            $sum_persent_sale = 0;
                                            $sum_customers_0 = 0; 
                                            $sum_customers_1 = 0; 
                                            $sum_customers_diff = 0; 

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

                                                if(isset($monthadmin_api[$year][$key]['customers'])){
                                                    $customers_0 = $monthadmin_api[$year][$key]['customers'];
                                                    $sum_customers_0 += $customers_0;
                                                }

                                                if(isset($monthadmin_api[$year_old][$key]['customers'])){
                                                    $customers_1 = $monthadmin_api[$year_old][$key]['customers'];
                                                    $sum_customers_1 += $customers_1;
                                                }

                                                $customers_diff = $customers_1 - $customers_0;

                                            @endphp
                                            <tr style="text-align:center">
                                                <td>{{ $i }}</td>
                                                <td>{{ $month_thai[$i] }}</td>
                                                <td>{{ $sales_th_0 }}</td>
                                                <td>{{ $sales_th_1 }}</td>
                                                <td>{{ number_format($sale_diff_thai,2) }} ล้าน</td>
                                                <td>{{ number_format($persent_sale,2) }}</td>
                                                <td>{{ number_format($customers_0) }}</td>
                                                <td>{{ number_format($customers_1) }}</td>
                                                <td>{{ number_format($customers_diff) }}</td>
                                            </tr>
                                            @php 
                                                $qt_break = $i % 3;
                                                $qt_qt = $i/3;
                                            @endphp
                                            @if($qt_break == 0)
                                                @php 
                                                    $sum_sale_0_thai = $sum_sale_0/1000000;
                                                    $sum_sale_1_thai = $sum_sale_1/1000000;
                                                    $sum_sale_diff = $sum_sale_1 - $sum_sale_0;
                                                    $sum_sale_diff_thai = $sum_sale_diff/1000000;
                                                    $sum_persent_sale = ($sum_sale_diff*100)/$sum_sale_0;
                                                    $sum_customers_diff = $sum_customers_1 - $sum_customers_0;
                                                @endphp
                                                <tr class="bg-primary" style="text-align:center; font-weight:bold;">
                                                    <td colspan="2">สรุปไตรมาส {{ $qt_qt }}</td>
                                                    <td>{{ number_format($sum_sale_0_thai,2) }} ล้าน</td>
                                                    <td>{{ number_format($sum_sale_1_thai,2) }} ล้าน</td>
                                                    <td>{{ number_format($sum_sale_diff_thai,2) }} ล้าน</td>
                                                    <td>{{ number_format($sum_persent_sale) }}</td>
                                                    <td>{{ number_format($sum_customers_0) }}</td>
                                                    <td>{{ number_format($sum_customers_1) }}</td>
                                                    <td>{{ number_format($sum_customers_diff) }}</td>
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

    </div>