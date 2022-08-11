<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานรับคืนสินค้า</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container-fluid px-xxl-65 px-xl-20">
    <!-- Title -->
    <div class="hk-pg-header mb-10">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานรับคืนสินค้า</h4>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row mb-35">
                    <div class="col-sm-12 col-md-6">
                        <h5 class="hk-sec-title">สรุปยอดทั้งปี</h5>
                    </div>
                    <div class="col-sm-12 col-md-6" style="text-align:right;">
                        <!-- ------ -->
                        <span class="form-inline pull-right">
                                <!-- เงื่อนไขการค้นหา -->
                            <form action="{{ url($action_search) }}" method="post">
                                @csrf
                                <span id="selectdate" >
                                    <select name="sel_year_form" id="sel_year_form" class="form-control" required>
                                        <option value="">--เลือกปี--</option>
                                        <?php
                                            list($year,$month,$day) = explode("-", date("Y-m-d"));
                                            for($i = 0; $i<3; $i++){
                                        ?>
                                                @php 
                                                    $year_thai = ($year-$i)+543
                                                @endphp
                                                @if($year_search == $year-$i)
                                                    <option value="{{ $year-$i }}" selected>{{ $year_thai }}</option>
                                                @else
                                                    <option value="{{ $year-$i }}">{{ $year_thai }}</option>
                                                @endif
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm" id="submit_request">ค้นหา</button>
                                </span>
                            </form>
                        </span>
                            <!-- จบเงื่อนไขการค้นหา -->
                    </div>
                </div>
  
                <div class="row">
                    <div class="col-sm">
                        <div class="table-responsive-sm table-color">
                            <table id="datable_1" class="table table-sm table-hover">
                                <thead>
                                    <tr style="text-align:center">
                                        <th>ปี</th>
                                        <th>ยอดขาย</th>
                                        <th>ยอดรับคืน</th>
                                        <th>คิดเป็น%</th>
                                    </tr>
                                </thead>
                                @if(isset($yearadmin_api))
                                <tbody>
                                    <tr style="text-align:center">
                                        <td>{{ $yearadmin_api[0]['year']+543 }}</td>
                                        <td>{{ number_format($yearadmin_api[0]['sales'],2) }}</td>
                                        <td class="text-red">{{ number_format($yearadmin_api[0]['credits'],2) }}</td>
                                        <td>{{ number_format($yearadmin_api[0]['%Credit'],2) }}</td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </div>
                        <div class="mt-3" style="text-align:left;">
                            ข้อมูลสิ้นสุด ณ วันที่
                            @php 
                                if(isset($trans_last_date)){
                                    list($lat_year, $lat_month, $lat_day) = explode("-", $trans_last_date);
                                    $lat_year_thai = $lat_year + 543;
                                    $trans_last_date = $lat_day."/".$lat_month."/".$lat_year_thai;
                                }else{
                                    $trans_last_date = "-";
                                }
                            @endphp 
                            {{ $trans_last_date }}
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
                            <h5 class="hk-sec-title">สรุปยอดรายเดือน</h5>
                        </div>
                        <div class="col-sm-12 col-md-6" style="text-align:right;">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm table-color">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr style="text-align:center">
                                            <th>#</th>
                                            <th>เดือน</th>
                                            <th>ยอดขาย</th>
                                            <th>ยอดรับคืน</th>
                                            <th>คิดเป็น%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $month_thai = ["เดือนไทย","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
                                        @endphp
                                        <?php 
                                            for($i=1; $i<13; $i++){
                                        ?>
                                            @php 
                                                $key = $i-1;
                                                $sales = 0;
                                                $credits = 0;
                                                $persent_credit = 0;

                                                if(isset($monthadmin_api[$key]['sales'])){
                                                    $sales = $monthadmin_api[$key]['sales'];
                                                }
                                                if(isset($monthadmin_api[$key]['credits'])){
                                                    $credits = $monthadmin_api[$key]['credits'];
                                                }
                                                if(isset($monthadmin_api[$key]['%Credit'])){
                                                    $persent_credit = $monthadmin_api[$key]['%Credit'];
                                                }

                                                if($credits != 0){
                                                    $text_red = "text-red";
                                                }else{
                                                    $text_red = "";
                                                }
                                            @endphp
                                            <tr style="text-align:center">
                                                <td>{{ $i }}</td>
                                                <td>{{ $month_thai[$i] }}</td>
                                                <td>{{ number_format($sales,2) }}</td>
                                                <td class="{{ $text_red }}">{{ number_format($credits,2) }}</td>
                                                <td>{{ number_format($persent_credit,2) }}</td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                ข้อมูลสิ้นสุด ณ วันที่ 
                                @php 
                                    $customer_trans_last_date = "-";
                                    if(isset($customer_trans_last_date)){
                                        list($lat_year, $lat_month, $lat_day) = explode("-", $customer_trans_last_date);
                                        $lat_year_thai = $lat_year + 543;
                                        $customer_trans_last_date = $lat_day."/".$lat_month."/".$lat_year_thai;
                                    }
                                @endphp 
                                {{ $customer_trans_last_date }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    
</div>
