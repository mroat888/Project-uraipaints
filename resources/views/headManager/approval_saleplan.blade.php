@extends('layouts.masterHead')

@section('content')

@php

    $date = date('m-d-Y');

    $date1 = str_replace('-', '/', $date);

    $yesterday = date('Y-m-d',strtotime($date1 . "-1 days"));



    $date1 = str_replace('-', '/', $date);

    $yesterday2 = date('Y-m-d',strtotime($date1 . "-2 days"));

@endphp
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ให้ความเห็นแผนประจำเดือน</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="message-square"></i> ให้ความเห็นแผนประจำเดือน</div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        @php
                                    $action_search = "head/approvalsaleplan/search"; //-- action form
                                    if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                        $date_search = $date_filter;
                                    }else{
                                        $date_search = "";
                                    }
                                @endphp

                                <div class="topic-secondgery">รายการแผนประจำเดือน
                                    <?php
                                        if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                            echo thaidate('F Y', $date_search);
                                        }
                                    ?>
                                </div>
                        <div class="row" style="margin-bottom: 30px;">
                            <div class="col-sm-12 col-md-12">
                                <!-- ------ -->

                                <span class="form-inline pull-right pull-sm-center">
                                    <form action="{{ url($action_search) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <span id="selectdate">
                                        <select name="selectteam_sales" class="form-control form-control-sm" aria-label=".form-select-lg example">
                                            <option value="" selected>เลือกทีม</option>
                                            @php
                                                $checkteam_sales = "";
                                                if(isset($selectteam_sales)){
                                                    $checkteam_sales = $selectteam_sales;
                                                }
                                            @endphp
                                            @foreach($team_sales as $team)
                                                @if($checkteam_sales == $team->id)
                                                    <option value="{{ $team->id }}" selected>{{ $team->team_name }}</option>
                                                @else
                                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <!-- ปี/เดือน :  -->
                                        <input type="month" id="selectdateFrom" name="selectdateFrom"
                                        value="{{ $date_search }}" class="form-control form-control-sm"
                                        style="margin-left:10px; margin-right:10px;"/>
                                        <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                                    </span>
                                    </form>
                                </span>
                                <!-- ------ -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="table-responsive-sm table-color">
                                    <table id="datable_1" class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ผู้แทนขาย</th>
                                                <th>Sale Plan (นำเสนอสินค้า)</th>
                                                <th>Sale Plan (ลูกค้าใหม่)</th>
                                                <th>รวมงาน</th>
                                                <th>ปิดการขายได้</th>
                                                <th>มูลค่า</th>
                                                <th>ปิดการขายไม่ได้</th>
                                                <th>จำนวนลูกค้าใหม่</th>
                                                <th>สถานะ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monthly_plan as $key => $value)
                                                @php
                                                    $sale_plans_count = DB::table('sale_plans')
                                                        ->where('monthly_plan_id', $value->id)
                                                        ->whereIn('sale_plans_status',[1,2])
                                                        ->count();
                                                    $cust_new_amount = DB::table('customer_shops_saleplan')
                                                        ->where('monthly_plan_id', $value->id)
                                                        ->whereIn('shop_aprove_status', [1,2])
                                                        ->count();
                                                    $total_saleplan = $sale_plans_count + $cust_new_amount;

                                                    list($year,$month) = explode('-', $value->month_date);
                                                    $customer_update_count = DB::table('customer_shops')
                                                        ->join('customer_shops_saleplan', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
                                                        ->where('customer_shops_saleplan.monthly_plan_id', $value->id)
                                                        ->whereYear('customer_shops.shop_status_at', $year)
                                                        ->whereMonth('customer_shops.shop_status_at', $month)
                                                        ->count();
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ number_format($sale_plans_count) }}</td>
                                                    <td>{{ number_format($cust_new_amount) }}</td>
                                                    <td>{{ number_format($total_saleplan) }}</td>
                                                    <td>{{ number_format($value->close_sale) }}</td>
                                                    <td>{{ number_format($value->total_sales) }}</td>
                                                    <td>{{ number_format($value->close_sales_not) }}</td>
                                                    <td>{{ number_format($customer_update_count) }}</td>
                                                    <td>
                                                        @if ($value->status_approve == 1)
                                                            <span class="badge badge-soft-warning"
                                                                style="font-size: 12px;">
                                                                Pending
                                                            </span>
                                                        @elseif ($value->status_approve == 2)
                                                            <span class="badge badge-soft-success"
                                                                style="font-size: 12px;">
                                                                Approve
                                                            </span>
                                                        @elseif ($value->status_approve == 4)
                                                            <span class="badge badge-soft-info"
                                                                style="font-size: 12px;">
                                                                Close
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($value->status_approve == 4)
                                                        <a href="{{ url('head/approvalsaleplan_detail_close', $value->id) }}" type="button" class="btn btn-icon btn-danger pt-5">
                                                            <i data-feather="file-text"></i>
                                                        </a>
                                                        @endif

                                                        <a href="{{ url('head/approvalsaleplan_detail', $value->id) }}" type="button" class="btn btn-icon btn-view pt-5">
                                                            <i data-feather="file-text"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <!-- /Row -->
    </div>

    <script type="text/javascript">
        function chkAll(checkbox) {

            var cboxes = document.getElementsByName('checkapprove[]');
            var len = cboxes.length;

            if (checkbox.checked == true) {
                for (var i = 0; i < len; i++) {
                    cboxes[i].checked = true;
                }
            } else {
                for (var i = 0; i < len; i++) {
                    cboxes[i].checked = false;
                }
            }
        }
    </script>

@endsection

@section('scripts')


<script>
    function showselectdate(){
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }
</script>

<script>
    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }
</script>

<script>
    function showselectdate() {
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate() {
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }
</script>

@endsection('scripts')
