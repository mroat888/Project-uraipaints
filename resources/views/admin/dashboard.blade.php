@extends('layouts.masterAdmin')

@section('content')


 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">หน้าแรก</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">ปฎิทินกิจกรรม</li> --}}
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="mt-30 mb-30">
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                <h6 class="topic-page hk-sec-title topic-bgblue" style="font-weight: bold;">แผนทำงานประจำเดือน <span><?php echo thaidate('F Y', date("Y-m-d")); ?></span> </h6>
                    <div class="row">
                        <div class="col-md-4">
                            <section class="bg-purple hk-sec-wrapper bg-light">
                                <div class="row">
                                    <!-- <div class="col-sm">
                                        <div id="e_chart_1" style="height:140px;"></div>
                                    </div> -->
                                    <div class="col-12 mb-topic" style="color: #fff;">
                                        <p class="mb-10"><div class="topic-numchart">แผนทำงาน</div> <div class="red-numchart"><div class="wrap_txt-numchart txt-numchart">{{ $count_monthly_plans }}</div></div>  </p>
                                    </div>
                                    <div class="col-12 col-lg-6" style="color: #fff;">
                                        <p class="mb-10">ทำแล้ว  <span class="txt-numchart">{{ $count_sale_plans_result }}</span></p>
                                    </div>
                                    <div class="col-12 col-lg-6 text-right" style="color: #fff;">
                                        <p class="mb-10">รอดำเนินการ  <span class="txt-numchart">{{ $count_monthly_plans - $count_sale_plans_result }}</span></p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="bg-blue hk-sec-wrapper bg-light">
                                <div class="row">
                                    <!-- <div class="col-sm">
                                        <div id="e_chart_5" style="height:140px;"></div>
                                    </div> -->
                                    <div class="col-12 mb-topic" style="color: #fff;">
                                        <p class="mb-10"><div class="topic-numchart2">ลูกค้าใหม่</div> <div class="green-numchart"><span class="wrap_txt-numchart txt-numchart">{{ $count_cust_new_amount }}</span></div></p>
                                    </div>
                                    <div class="col-12 col-lg-6" style="color: #fff;">
                                        <p class="mb-10">ทำแล้ว <span class="txt-numchart">{{ $count_shops_saleplan_result }}</span></p>
                                    </div>
                                    <div class="col-12 col-lg-6 text-right" style="color: #fff;">
                                        <p class="mb-10">รอดำเนินการ <span class="txt-numchart">{{ $count_cust_new_amount - $count_shops_saleplan_result }}</span></p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="bg-orange hk-sec-wrapper bg-light">
                                <div class="row">
                                    <!-- <div class="col-sm">
                                        <div id="e_chart_3" style="height:140px;"></div>
                                    </div> -->
                                    <div class="col-12 mb-topic" style="color: #fff;">
                                        <p class="mb-10"><div class="topic-numchart3">เยี่ยมลูกค้า</div> <div class="orange-numchart"><span class="wrap_txt-numchart txt-numchart">{{ $count_cust_visits_amount }}</span></div></p>
                                    </div>
                                    <div class="col-12 col-lg-6" style="color: #fff;">
                                        <p class="mb-10">ทำแล้ว <span class="txt-numchart">{{ $count_visit_results_result }}</span></p>
                                    </div>
                                    <div class="col-12 col-lg-6 text-right" style="color: #fff;">
                                        <p class="mb-10">รอดำเนินการ <span class="txt-numchart">{{ $count_cust_visits_amount - $count_visit_results_result }}</span></p>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>

            <!-- ----------------------------- -->
            <div class="col-sm-12 col-lg-8">
                <section class="hk-sec-wrapper">
                    <h6 class="topic-page hk-sec-title topic-bgred" style="font-weight: bold;">งานเดือนนี้</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ url('admin/approvalgeneral') }}">
                            <div class="bg-card-blue card-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2">
                                            <button class="icon-btnred btn btn-icon btn-icon-circle btn-light btn-lg mr-25"><span class="btn-icon-wrap"><i
                                            data-feather="edit-2"></i></span></button>
                                        </div>
                                        <div class="col-10">
                                            <div class="card-padleft">
                                                <span class="d-block font-16 font-weight-500 text-uppercase mb-10">

                                                    <div class="bg-red-card">คำขออนุมัติ <span class="circle-numred">{{ $list_approval->count() }}</span></div>
                                                </span>
                                                <div class="summary-txtinline d-flex align-items-end justify-content-between font-16">
                                                    <div>
                                                        <span class="t-summarycard d-block">
                                                            <span>อนุมัติ</span>
                                                        </span>
                                                        <span class="t-summarycard d-block">
                                                            <?php $approve = 0; ?>
                                                            <span>
                                                                @foreach ($list_approval as $value)
                                                                    @if ($value->assign_status == 1)
                                                                        <?php $approve += 1 ?>
                                                                    @endif
                                                                @endforeach
                                                                {{$approve}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="t-summarycard d-block">
                                                            <span>ปฎิเสธ</span>
                                                        </span>
                                                        <?php $reject = 0; ?>
                                                        <span>
                                                            @foreach ($list_approval as $value)
                                                                @if ($value->assign_status == 2)
                                                                    <?php $reject += 1 ?>
                                                                @endif
                                                            @endforeach
                                                            {{$reject}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                </div>
                            </div>
                            </a>
                        </div>


                        <div class="col-md-6">
                            <a href="{{ url('admin/assignment-add') }}">
                            <div class="bg-card-blue card-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2">
                                            <button class="icon-btngreen btn btn-icon btn-icon-circle btn-light btn-lg mr-25"><span class="btn-icon-wrap"><i
                                                data-feather="clipboard"></i></span></button>
                                        </div>
                                        <div class="col-10">
                                            <div class="card-padleft">
                                                <div class="d-block font-16 font-weight-500 text-uppercase mb-10">

                                                    <span class="bg-red-card">คำสั่งงาน <span class="circle-numred">{{ $assignments->count() }}</span></span>
                                                </div>
                                                <div class="summary-txtinline d-flex align-items-end justify-content-between font-16">
                                                    <div>
                                                        <span class="d-block">
                                                            <span>ทำแล้ว</span>
                                                        </span>
                                                        <span class="d-block">
                                                            <?php $success = 0; ?>
                                                            <span>
                                                                @foreach ($assignments as $value)
                                                                    @if ($value->assign_result_status != 0)
                                                                        <?php $success += 1 ?>
                                                                    @endif
                                                                @endforeach
                                                                {{$success}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div>
                                                    <span class="d-block">
                                                            <span>ด่วน</span>
                                                        </span>
                                                        <?php $unfinished = 0; ?>
                                                        <span>
                                                            @foreach ($assignments as $value)
                                                                @if ($value->assign_result_status == 0)
                                                                    <?php $unfinished += 1 ?>

                                                                @endif
                                                            @endforeach
                                                            {{$unfinished}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ url('admin/note') }}">
                            <div class="bg-card-blue card-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2">
                                            <button class="icon-btnyellow btn btn-icon btn-icon-circle btn-light btn-lg mr-25"><span class="btn-icon-wrap"><i
                                            data-feather="file"></i></span></button>
                                        </div>
                                        <div class="col-10">
                                            <div class="card-padleft">
                                                <div class="d-block font-16 font-weight-500 text-uppercase mb-10">

                                                <div class="bg-red-card">บันทึกโน๊ต <span class="circle-numred">{{ $notes->count() }}</span></div></div>
                                            <div class="summary-txtinline d-flex align-items-end justify-content-between font-16">
                                        <div>
                                            <span class="d-block">
                                                <span>ไม่ปัก</span>
                                            </span>
                                            <span class="d-block">
                                                <?php $disuse = 0; ?>
                                                <span>
                                                    @foreach ($notes as $value)
                                                        @if ($value->status_pin == "")
                                                            <?php $disuse += 1 ?>
                                                        @endif
                                                    @endforeach
                                                    {{$disuse}}
                                                </span>
                                            </span>
                                        </div>
                                        <div>
                                        <span class="d-block">
                                                <span>ปักหมุด</span>
                                            </span>
                                            <?php $pin = 0; ?>
                                            <span>
                                                @foreach ($notes as $value)
                                                    @if ($value->status_pin == 1)
                                                        <?php $pin += 1 ?>
                                                    @endif
                                                @endforeach
                                                {{$pin}}
                                            </span>
                                        </div>
                                    </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ url('admin/change_customer_status') }}">
                            <div class="bg-card-blue card-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2">
                                            <button class="icon-btncyan btn btn-icon btn-icon-circle btn-light btn-lg mr-25"><span class="btn-icon-wrap"><i
                                            data-feather="users"></i></span></button>
                                        </div>
                                        <div class="col-10">
                                            <div class="card-padleft">
                                                <div class="d-block font-16 font-weight-500 text-uppercase mb-10">

                                                <span class="bg-red-card">ลูกค้าใหม่ <span class="circle-numred">{{ $customer_shop->count() }}</span></span></div>
                                                <div class="summary-txtinline d-flex align-items-end justify-content-between font-16">
                                            <div>
                                                <span class="d-block">
                                                    <span>ระหว่างดำเนินการ</span>
                                                </span>
                                                <span class="d-block">
                                                    <?php $fail = 0; ?>
                                                    <span>
                                                        @foreach ($customer_shop as $value)
                                                            @if ($value->shop_result_status == 0)
                                                                <?php $fail += 1 ?>
                                                            @endif
                                                        @endforeach
                                                        {{$fail}}
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block">
                                                    <span>เปลี่ยนเป็นลูกค้า</span>
                                                </span>
                                                <?php $wait = 0; ?>
                                                <span>
                                                    @foreach ($customer_shop as $value)
                                                        @if ($value->shop_result_status == 2)
                                                            <?php $wait += 1 ?>
                                                        @endif
                                                    @endforeach
                                                    {{$wait}}
                                                </span>
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-sm-12 col-lg-4">
                <section class="hk-sec-wrapper">
                    <h6 class="topic-page hk-sec-title topic-bggreen" style="font-weight: bold;">ลูกค้า </h6>
                    <div class="row mt-30">
                        <div class="col-md-12">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"></span>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-8">
                                                    <a href="{{url('admin/data_name_store')}}" class="txt-cusall text-dark">ลูกค้าทั้งหมด (ราย)</a>
                                                </div>
                                                <div class="col-4">
                                                    <span class="txt-custotal">
                                                        @if(!empty($res_api))
                                                            {{ number_format($res_api["data"][0]["Responsibility"][0]["ActiveTotal"]) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="bggrey-cus" id="bdate">
                                                <div class="row">
                                                    <div class="col-12 col-xl-8">
                                                        <!-- <a href="{{url('important-day-detail')}}" class="txt-specialday text-dark"> -->
                                                            วันสำคัญในเดือน
                                                        <!-- </a> -->
                                                    </div>
                                                    <div class="col-12 col-xl-4">
                                                        <div>
                                                            @php
                                                                $FocusDates_count = count($res_api["data"][1]["FocusDates"]);
                                                            @endphp
                                                            @if($FocusDates_count > 0)
                                                                <div class="num-specialday">{{ $res_api["data"][1]["FocusDates"][0]["TotalCustomers"] }} ร้าน </div>
                                                                <div class="num-specialday">{{ $res_api["data"][1]["FocusDates"][0]["TotalDays"] }} วัน</div>
                                                            @else
                                                                <div class="num-specialday">0 ร้าน </div>
                                                                <div class="num-specialday">0 วัน</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!--- ---------------------------------------------- -->

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <h6 class="topic-page hk-sec-title topic-bgorange" style="font-weight: bold;">เทียบยอดขายเดือน
                        <?php echo thaidate('F', date("M")); ?> ระหว่างปี
                        @php 
                            if (isset($res_api["data"][2]["SalesCurrent"])){
                                $SalesCurrent_year = $res_api["data"][2]["SalesCurrent"][0]["year"] + 543;
                                $SalesPrevious_year = $res_api["data"][3]["SalesPrevious"][0]["year"] + 543;                   
                            }else{
                                $SalesCurrent_year = "-";
                                $SalesPrevious_year = "-";
                            }
                        @endphp
                        {{ $SalesCurrent_year }} กับปี  
                        {{ $SalesPrevious_year }}
                    </h6>
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <canvas id="myChart" style="height: 294px"></canvas>
                            <span class="mt-8 ml-40 text-danger">
                                @php 
                                    list($year,$month,$day) = explode("-", $res_api["trans_last_date"]);
                                    $year = $year+543;
                                    $trans_last_date = $day."/".$month."/".$year;
                                @endphp
                                ข้อมูล ณ วันที่ {{ $trans_last_date }}
                            </span>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mt-sumsales card card-sm">
                                <div class="card-sumsales card-body" style="color: #fff;">
                                    @php
                                        $SalesPrevious = $res_api["data"][3]["SalesPrevious"];
                                        $totalAmtSale_th_Previous = $SalesPrevious[0]["sales_th"]; // เป้ายอดขายปีที่แล้ว
                                        $totalAmtSale_Previous = $SalesPrevious[0]["sales"]; // เป้ายอดขายปีที่แล้ว

                                        $percentAmtCrn =0;
                                        if(!empty($res_api["data"][2]["SalesCurrent"])){
                                            $SalesCurrent = $res_api["data"][2]["SalesCurrent"];

                                            $totalAmtSale_th = $SalesCurrent[0]["sales_th"]; // ยอดที่ทำได้ปีนี้
                                            $totalAmtSale = $SalesCurrent[0]["sales"]; // ยอดที่ทำได้ปีนี้
                                            $percentAmtCrn = (($totalAmtSale)*100)/$totalAmtSale_Previous;
                                        }else{
                                            $totalAmtSale_th = "0";
                                            $totalAmtSale = 0;
                                            $percentAmtCrn = 0;
                                        }

                                    @endphp

                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"></span>
                                    <h6 class="topic-page hk-sec-title text-center text-white" style="font-weight: bold;">เทียบยอดขายทั้งเดือน
                                        <?php echo thaidate('F', date("M")); ?></h6>
                                            <span class="d-block text-center">
                                                <span id="pie_chart_2" class="easy-pie-chart" data-percent="{{ $percentAmtCrn }}">
                                                    <span class="percent head-font mt-25">{{ $percentAmtCrn }}</span>
                                            </span>
                                            </span>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span><?php echo thaidate('F', date("M")); ?></h6><??>
                                                        @if (isset($res_api["data"][3]["SalesPrevious"]))
                                                            /{{ $SalesPrevious_year }}
                                                        @endif
                                                </span>
                                            </span>
                                        </div>
                                        <div>
                                            <span><?php echo thaidate('F', date("M")); ?></h6>
                                                @if (isset($res_api["data"][2]["SalesCurrent"]))
                                                            /{{ $SalesCurrent_year }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span class="bg-sumsale">{{ $totalAmtSale_th_Previous }}</span>
                                            </span>
                                        </div>
                                        <div>
                                            @if ($totalAmtSale < $totalAmtSale_Previous)
                                            <span class="bg-sumsale text-red">{{ $totalAmtSale_th }}</span>
                                            @else
                                            <span class="bg-sumsale text-green">{{ $totalAmtSale_th }}</span>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase"></span>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3 pdl-0">
                                                <span class="d-block">
                                                    <button class="home-icongreen btn btn-icon btn-info">
                                                        <span class="btn-icon-wrap"><i data-feather="home"></i>
                                                        </span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="col-12">
                                                <div class="row box-txttotalsum">
                                                    <div class="col-6 col-md-7 pdl-0">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า (Active) ทั้งหมด</span>
                                                    </div>
                                                    <div class="col-6 col-md-5 pdr-0" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 16px;">
                                                            @if (!is_null($res_api["data"][0]["Responsibility"]))
                                                                {{ number_format($res_api["data"][0]["Responsibility"][0]["ActiveTotal"]) }} ราย
                                                            @else
                                                                - ราย
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row box-txttotalsum">
                                                    <div class="col-6 col-md-7 pdl-0">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า เปิดบิล ณ เดือนปัจจุบัน</span>
                                                    </div>
                                                    <div class="col-6 col-md-5 pdr-0" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 16px;">
                                                            @if (!is_null($res_api["data"][0]["Responsibility"]))
                                                                {{ number_format($res_api["data"][0]["Responsibility"][0]["BillOrderTotal"]) }} ราย
                                                            @else
                                                                - ราย
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row box-txttotalsum">
                                                    <div class="col-6 col-md-7 pdl-0">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า เปิดบิล คิดเป็น <br> 
                                                        @php 
                                                            if(isset($res_api["trans_last_date"])){
                                                                list($year,$month,$day) = explode("-", $res_api["trans_last_date"]);
                                                                $year = $year+543;
                                                                $trans_last_date = $day."/".$month."/".$year;
                                                            }else{
                                                                $trans_last_date = "-";
                                                            }
                                                        @endphp
                                                        ณ วันที่  {{ $trans_last_date }}
                                                        </span>
                                                    </div>
                                                    <div class="col-6 col-md-5 pdr-0" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 16px;">
                                                            @if (!is_null($res_api["data"][0]["Responsibility"]))
                                                                {{ $res_api["data"][0]["Responsibility"][0]["PercentBillOrder"] }} จากทั้งหมด
                                                            @else
                                                                - % จากทั้งหมด
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row box-txttotalsum">
                                                    <div class="col-6 col-md-7 pdl-0">
                                                        <span style="font-weight: bold; font-size: 14px;" class="num-specialday">ร้านค้า ยังไม่ซื้อ คิดเป็น</span>
                                                    </div>
                                                    <div class="col-6 col-md-5 pdr-0" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 16px;" class="num-specialday">
                                                            @if (!is_null($res_api["data"][0]["Responsibility"]))
                                                                {{ $res_api["data"][0]["Responsibility"][0]["PercentAvailable"] }} จากทั้งหมด
                                                            @else
                                                                - % จากทั้งหมด
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            

        </div>
    </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

@include('union.bdates_modal')

@section('footer')
    @include('layouts.footer')
@endsection


<script src="{{ asset('public/template/graph/Chart.bundle.js') }}"></script>

<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [{{ $day_month }}],
            datasets: [{
                label: 'ยอดขายปี {{ $SalesCurrent_year }}',
                data: [{{ $amtsale_current }}],
                fill: false,
                borderColor: 'rgba(206,30,40,1)',
                borderWidth: 2,
                tension: 0
            },
            {
                label: 'ยอดขายปี {{ $SalesPrevious_year }}',
                data: [{{ $amtsale_previous }}],
                fill: false,
                borderColor: 'rgba(2, 119, 144,1)',
                borderWidth: 2,
                tension: 0
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

@endsection
