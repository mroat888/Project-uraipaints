@extends('layouts.masterHead')

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
                    <h6 class="hk-sec-title mb-30" style="font-weight: bold;">แผนทำงานประจำเดือน <?php echo thaidate('F Y', date("Y-m-d")); ?></h6>
                    <div class="row">
                        <div class="col-md-4">
                            <section class="hk-sec-wrapper">
                                <div class="row">
                                    <div class="col-sm">
                                        <div id="e_chart_1" style="height:140px;"></div>
                                    </div>
                                    <div class="col-sm mt-30" style="color: black;">
                                        <p class="mb-10">แผนทำงาน {{ $count_monthly_plans }}</p>
                                        <p class="mb-10">ทำแล้ว {{ $count_sale_plans_result }}</p>
                                        <p class="mb-10">รอดำเนินการ {{ $count_monthly_plans - $count_sale_plans_result}}</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="hk-sec-wrapper">
                                <div class="row">
                                    <div class="col-sm">
                                        <div id="e_chart_5" style="height:140px;"></div>
                                    </div>
                                    <div class="col-sm mt-30" style="color: black;">
                                        <p class="mb-10">ลูกค้าใหม่ {{ $count_cust_new_amount }}</p>
                                        <p class="mb-10">ทำแล้ว {{ $count_shops_saleplan_result }}</p>
                                        <p class="mb-10">รอดำเนินการ {{ $count_cust_new_amount - $count_shops_saleplan_result }}</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="hk-sec-wrapper">
                                <div class="row">
                                    <div class="col-sm">
                                        <div id="e_chart_3" style="height:140px;"></div>
                                    </div>
                                    <div class="col-sm mt-30" style="color: black;">
                                        <p class="mb-10">เยี่ยมลูกค้า {{ $count_cust_visits_amount }}</p>
                                        <p class="mb-10">ทำแล้ว {{ $count_visit_results_result }}</p>
                                        <p class="mb-10">รอดำเนินการ {{ $count_cust_visits_amount - $count_visit_results_result }}</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="row mt-30">
                        <div class="col-md-2">
                            <div class="card card-sm text-white bg-danger">
                                <div class="card-body">
                                    <span class="d-block font-11 font-weight-500 text-white text-uppercase mb-10"><i data-feather="edit-2"></i>
                                        <!-- <button type="button" class="btn btn-xs btn-outline-danger btn-rounded float-right">New</button> -->
                                    </span> 
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>คำขออนุมัติ {{ $list_approval->count() }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>อนุมัติ</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ปฎิเสธ</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
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

                        <div class="col-md-2">
                            <div class="card card-sm text-white bg-success">
                                <div class="card-body">
                                    <span class="d-block font-11 font-weight-500 text-white text-uppercase mb-10"><i data-feather="user"></i>
                                        <!-- <button type="button" class="btn btn-xs btn-outline-success btn-rounded float-right">New</button> -->
                                    </span> 
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>คำสั่งงาน {{ $assignments->count() }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>ทำแล้ว</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ด่วน</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
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

                        <div class="col-md-2">
                            <div class="card card-sm text-white bg-warning">
                                <div class="card-body" >
                                    <span class="d-block font-11 font-weight-500 text-white text-uppercase mb-10"><i data-feather="file"></i>
                                        <!-- <button type="button" class="btn btn-xs btn-outline-warning btn-rounded float-right">New</button> -->
                                    </span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>บันทึกโน๊ต {{ $notes->count() }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>ไม่ปัก</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ปักหมุด</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
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

                        <div class="col-md-2">
                            <div class="card card-sm text-white bg-info">
                                <div class="card-body" >
                                    <span class="d-block font-11 font-weight-500 text-white text-uppercase mb-10"><i data-feather="user"></i>
                                        <button type="button" class="btn btn-xs btn-outline-info btn-rounded float-right">New</button></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>ลูกค้าใหม่ {{ $customer_shop->count() }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>ใหม่</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>เปลี่ยน</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
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

                        <div class="col-md-4">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-8 font-weight-100 text-dark text-uppercase mb-10"></span>
                                    <div class="mt-15">
                                        <span class="d-block">
                                            <div class="media-img-wrap text-center">
                                                <div class="avatar avatar-sm">
                                                    <!-- <img src="" alt="user"
                                                    class="avatar-text avatar-text-inv-success rounded-circle"> -->
                                                </div>
                                                <div class="avatar avatar-sm">
                                                    <!-- <img src="" alt="user"
                                                    class="avatar-text avatar-text-inv-pink rounded-circle"> -->
                                                </div>
                                                <div class="avatar avatar-sm">
                                                    <!-- <img src="" alt="user"
                                                    class="avatar-text avatar-text-inv-info rounded-circle"> -->
                                                </div>
                                                <div class="avatar avatar-sm">
                                                    <!-- <img src="" alt="user"
                                                    class="avatar-text avatar-text-inv-warning rounded-circle"> -->
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-5">
                                        <div>
                                            <span class="d-block">
                                                <span>ลูกค้าทั้งหมด</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>มีวันสำคัญในเดือน</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>{{ number_format($sum_ActiveTotal) }}</span>
                                            </span>
                                        </div>
                                        <div>
                                            @if($sum_FotalCustomers > 0)
                                                <span>{{ $sum_FotalCustomers }} ร้าน </span>
                                            @else
                                                <span>- ร้าน </span>
                                            @endif
                                            @if($sum_TotalDays > 0)
                                                <span class="ml-40">{{ $sum_TotalDays }} วัน</span>
                                            @else
                                                <span class="ml-40">- วัน</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <h6 class="hk-sec-title mb-10" style="font-weight: bold;">สรุปยอดขาย</h6>
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="myChart" style="height: 294px"></canvas>
                            <!-- <div id="m_chart_4" style="height: 294px"></div> -->
                        </div>
                        <div class="col-md-4">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    @php
                                        if($sum_totalAmtSale > 0 && $sum_totalAmtSale_Previous > 0){
                                            $percentAmtCrn = (($sum_totalAmtSale)*100)/$sum_totalAmtSale_Previous;
                                        }else{
                                            $percentAmtCrn = 0 ;
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
                                            <span>เดือนนี้</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span style="color: red;">{{ number_format($sum_totalAmtSale_Previous) }}</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span style="color: rgb(4, 18, 58);">{{ number_format($sum_totalAmtSale) }}</span>
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
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า (Total)</span>
                                                    </div>
                                                    <div class="col-md-4;" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 14px;">
                                                            {{ number_format($sum_CustTotal) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า (Active)</span>
                                                    </div>
                                                    <div class="col-md-4;" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 14px;">
                                                            {{ number_format($sum_ActiveTotal) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <span style="font-weight: bold; font-size: 14px;">ร้านค้า (Inactive)</span>
                                                    </div>
                                                    <div class="col-md-4;" style="text-align:right;">
                                                        <span style="font-weight: bold; font-size: 14px;">
                                                            {{ number_format($sum_InactiveTotal) }}
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
