@extends('layouts.master')

@section('content')

 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">หน้าแรก</li>
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
                                    <!-- <div class="col-12 col-xl">
                                        <div id="e_chart_1" style="height:140px;"></div>
                                    </div> -->
                                    <div class="col-12 mb-topic" style="color: #fff;">
                                        <p class="mb-10"><div class="topic-numchart">แผนทำงาน</div> <div class="red-numchart"><div class="wrap_txt-numchart txt-numchart">{{ $count_sale_plans_amount }}</div></div>  </p>
                                    </div>
                                    <div class="col-6" style="color: #fff;">
                                        <p class="mb-10">อนุมัติ  <span class="txt-numchart">{{ $count_sale_plans_result }}</span></p>
                                    </div>
                                    <div class="col-6 text-right" style="color: #fff;">
                                        <p class="mb-10">รอดำเนินการ  <span class="txt-numchart">{{ $count_sale_plans_amount - $count_sale_plans_result }}</span></p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="bg-blue hk-sec-wrapper bg-light">
                                <div class="row">
                                    <!-- <div class="col-12 col-xl">
                                        <div id="e_chart_5" style="height:140px;"></div>
                                    </div> -->
                                    <div class="col-12 mb-topic" style="color: #fff;">
                                        <p class="mb-10"><div class="topic-numchart2">ลูกค้าใหม่</div> <div class="green-numchart"><span class="wrap_txt-numchart txt-numchart">{{ $count_shops_saleplan_amount }}</span></div></p>
                                    </div>
                                    <div class="col-6" style="color: #fff;">
                                        <p class="mb-10">อนุมัติ <span class="txt-numchart">{{ $count_shops_saleplan_result }}</span></p>
                                    </div>
                                    <div class="col-6 text-right" style="color: #fff;">
                                        <p class="mb-10">รอดำเนินการ <span class="txt-numchart">{{ $count_shops_saleplan_amount - $count_shops_saleplan_result }}</span></p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="bg-orange hk-sec-wrapper bg-light">
                                <div class="row">
                                    <!-- <div class="col-12 col-xl">
                                        <div id="e_chart_3" style="height:140px;"></div>
                                    </div> -->
                                    <div class="col-12 mb-topic" style="color: #fff;">
                                        <p class="mb-10"><div class="topic-numchart3">เยี่ยมลูกค้า</div> <div class="orange-numchart"><span class="wrap_txt-numchart txt-numchart">{{ $count_isit_amount }}</span></div></p>
                                    </div>
                                    <div class="col-6" style="color: #fff;">
                                        <p class="mb-10">อนุมัติ <span class="txt-numchart">{{ $count_isit_results_result }}</span></p>
                                    </div>
                                    <div class="col-6 text-right" style="color: #fff;">
                                        <p class="mb-10">รอดำเนินการ <span class="txt-numchart">{{ $count_isit_amount - $count_isit_results_result }}</span></p>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-sm-12 col-lg-8">
                <section class="hk-sec-wrapper">
                    {{-- <h6 class="hk-sec-title mb-10" style="font-weight: bold;">สรุปยอดขาย</h6> --}}
                    <h6 class="topic-page hk-sec-title topic-bgred" style="font-weight: bold;">งานวันนี้</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ url('approval') }}">
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

                                                    <div class="bg-red-card">ขออนุมัติ <span class="circle-numred">{{$list_approval->count()}}</span></div>
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
                                                            <span>ด่วน</span>
                                                        </span>
                                                        <?php $assign_is_hot = 0; ?>
                                                        <span>
                                                            @foreach ($list_approval as $value)
                                                                @if ($value->assign_status == 1 && $value->assign_is_hot == 1)
                                                                    <?php $assign_is_hot += 1 ?>

                                                                @endif
                                                            @endforeach
                                                            {{$assign_is_hot}}
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
                            <a href="{{ url('assignment') }}">
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
                                                            <span>รอดำเนินการ</span>
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
                            <a href="{{ url('note') }}">
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
                            <a href="{{ url('lead') }}">
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
                                                <div class="col-7">
                                                    <a href="{{url('customer')}}" class="txt-cusall text-dark">ลูกค้าทั้งหมด (ราย)</a>
                                                </div>
                                                <div class="col-5">
                                                    <span class="txt-custotal">{{ number_format($res_api["data"][0]["Customers"][0]["ActiveTotal"]) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="bggrey-cus">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <a href="{{url('important-day-detail')}}" class="txt-specialday text-dark">วันสำคัญในเดือน</a>
                                                    </div>
                                                    <div class="col-4">
                                                        <div>
                                                            @php
                                                                $FocusDates_count = count($res_api["data"][1]["FocusDates"]);
                                                            @endphp
                                                            @if($FocusDates_count > 0)
                                                                <div class="num-specialday">{{ $res_api["data"][1]["FocusDates"][0]["TotalCustomers"] }} ร้าน </div>
                                                                <div class="num-specialday">{{ $res_api["data"][1]["FocusDates"][0]["TotalDays"] }} วัน</div>
                                                            @else
                                                                <span>- ร้าน </span>
                                                                <span class="ml-40">- วัน</span>
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <!-- <h6 class="topic-page hk-sec-title mb-10" style="font-weight: bold;">สรุปยอดขาย</h6> -->
                    <h6 class="topic-page hk-sec-title topic-bgorange" style="font-weight: bold;">สรุปยอดขาย</h6>
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="myChart" style="height: 294px"></canvas>
                            {{-- <div id="myChart" style="height: 294px"></div> --}}
                            {{-- <div id="e_chart_6" class="echart" style="height:294px;"></div> --}}
                        </div>
                        <div class="col-md-4">
                            <div class="card card-sm">
                                <div class="card-sumsales card-body" style="color: #fff;">
                                    @php
                                        $SalesPrevious = $res_api["data"][3]["SalesPrevious"];
                                        $totalAmtSale_th_Previous = $SalesPrevious[0]["totalAmtSale_th"]; // เป้ายอดขายปีที่แล้ว
                                        $totalAmtSale_Previous = $SalesPrevious[0]["totalAmtSale"]; // เป้ายอดขายปีที่แล้ว

                                        $percentAmtCrn =0;
                                        if(!empty($res_api["data"][2]["SalesCurrent"])){
                                            $SalesCurrent = $res_api["data"][2]["SalesCurrent"];

                                            $totalAmtSale_th = $SalesCurrent[0]["totalAmtSale_th"]; // ยอดที่ทำได้ปีนี้
                                            $totalAmtSale = $SalesCurrent[0]["totalAmtSale"]; // ยอดที่ทำได้ปีนี้
                                            $percentAmtCrn = (($totalAmtSale)*100)/$totalAmtSale_Previous;
                                        }else{
                                            $totalAmtSale_th = "0";
                                            $totalAmtSale = 0;
                                            $percentAmtCrn = 0;
                                        }

                                    @endphp

                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"></span>
                                            <span class="d-block text-center">
                                                <span id="pie_chart_2" class="easy-pie-chart" data-percent="{{ $percentAmtCrn }}">
                                                    <span class="percent head-font mt-25">{{ $percentAmtCrn }}</span>
                                            </span>
                                            </span>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>เป้ายอดขาย</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ยอดที่ทำได้</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span class="bg-sumsale">{{ $totalAmtSale_th_Previous }}</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="bg-sumsale">{{ $totalAmtSale_th }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase"></span>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="d-block">
                                                    <button class="btn btn-icon btn-info">
                                                        <span class="btn-icon-wrap"><i data-feather="home"></i>
                                                        </span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="col-12">
                                                <div class="row box-txttotalsum">
                                                    <div class="col-md-8">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า (Total)</span>
                                                    </div>
                                                    <div class="col-md-4" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 18px;">
                                                            {{ number_format($res_api["data"][0]["Customers"][0]["CustTotal"]) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row box-txttotalsum">
                                                    <div class="col-md-8">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า (Active)</span>
                                                    </div>
                                                    <div class="col-md-4" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 18px;">
                                                            {{ number_format($res_api["data"][0]["Customers"][0]["ActiveTotal"]) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row box-txttotalsum">
                                                    <div class="col-md-8">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า (Inactive)</span>
                                                    </div>
                                                    <div class="col-md-4" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 18px;">
                                                            {{ number_format($res_api["data"][0]["Customers"][0]["InactiveTotal"]) }}
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
                label: 'ยอดขายปีปัจจุบัน',
                data: [{{ $amtsale_current }}],
                backgroundColor: [
                    // 'rgba(255, 99, 132, 0.3)',
                    'rgba(255, 99, 132, 0)',
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
            },
            {
                label: 'ยอดขายปีที่แล้ว',
                data: [{{ $amtsale_previous }}],
                backgroundColor: [
                    // 'rgba(255, 99, 132, 0.2)',
                    // 'rgba(127, 121, 228, 0.4)',
                    'rgba(127, 121, 228, 0)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    // 'rgba(255,99,132,1)',
                    'rgba(127, 121, 228,1)',
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

@endsection
