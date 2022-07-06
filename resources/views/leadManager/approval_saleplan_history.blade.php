@extends('layouts.masterLead')

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
            <li class="breadcrumb-item active" aria-current="page">ประวัติอนุมัติ Sale Plan</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        @if (session('error'))
        <div class="alert alert-inv alert-inv-warning alert-wth-icon alert-dismissible fade show" role="alert">
            <span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i>
            </span> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>ประวัติอนุมัติ Sale Plan</h4>
            </div>
            <div class="d-flex">

            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <a href="{{ url('/approvalsaleplan') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                    <span class="icon-label">
                                        <i class="fa fa-file"></i>
                                    </span>
                                    <span class="btn-text">รออนุมัติ</span>
                                </a>

                                <a href="{{ url('lead/approvalsaleplan-history') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                    <span class="icon-label">
                                        <i class="fa fa-list"></i>
                                    </span>
                                    <span class="btn-text">ประวัติ</span>
                                </a>
                                <hr>
                                <div id="calendar"></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            @php 
                                $action_search = "lead/approvalsaleplan-history/search"; //-- action form
                                if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                    $date_search = $date_filter;
                                    list($year_p,$month_p) = explode("-", $date_filter);
                                    $year_p_thai = $year_p+543;
                                }else{
                                    $date_search = "";
                                    $year_p_thai = date("Y")+543;
                                }
                            @endphp
                            <div class="col-sm-12 col-md-6">
                                <h5 class="hk-sec-title">ประวัติอนุมัติ Sale Plan {{ $year_p_thai }}</h5>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                
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
                                            @if(count($team_sales) > 1)
                                                @foreach($team_sales as $team)
                                                    @if($checkteam_sales == $team->id)
                                                        <option value="{{ $team->id }}" selected>{{ $team->team_name }}</option>
                                                    @else
                                                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- ปี/เดือน :  -->
                                        <input type="month" id="selectdateFrom" name="selectdateFrom" 
                                        value="{{ $date_search }}" class="form-control form-control-sm" 
                                        style="margin-left:10px; margin-right:10px;"/>
                                        <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request">ค้นหา</button>
                                    </span>
                                    </form>
                                </span>
                                <!-- <span class="form-inline pull-right">
                                <a style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</a>
                                <form action="{{ url('lead/approvalsaleplan-history/search') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- <input type="text" id="knowledgeSearch" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" /> --}}

                                    <span id="selectdate" style="display:none;">
                                         <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name ="selectdateTo" value="<?= date('Y-m-d'); ?>" />

                                        <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button>
                                    </span>
                                </form>
                                </span> -->
                                <!-- ------ -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="mb-20">
                                </div>
                                    <div class="table-responsive-sm">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="text-align:left;">พนักงานขาย</th>
                                                <th>Sale Plan<br>(นำเสนอสินค้า)</th>
                                                <th>Sale Plan<br>(ลูกค้าใหม่)</th>
                                                <th>รวมงาน</th>
                                                <th>ปิดการขายได้</th>
                                                <th>มูลค่า</th>
                                                <th>ปิดกาาขาย<br>ไม่ได้</th>
                                                <th>จำนวนลูกค้าใหม่</th>
                                                <th>การอนุมัติ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($monthly_plan as $key => $value)
                                                @php
                                                    /*
                                                    $sale_plans = DB::table('sale_plans')
                                                        ->where('monthly_plan_id',$value->id)
                                                        ->get();
                                                    $sale_plan_amount = $sale_plans->count();
                                                    */
                                                    
                                                    $sale_plans = DB::table('sale_plans')
                                                        ->where('monthly_plan_id',$value->id)
                                                        ->get();
                                                        
                                                    $sale_plan_amount = 0;
                                                    foreach($sale_plans as $key_sale_plans => $value_sale_plans){
                                                        $sale_plans_tags_array = explode(',', $value_sale_plans->sale_plans_tags);
                                                        $sale_plan_amount += count($sale_plans_tags_array);
                                                    } 

                                                    $customer_shops_saleplan = DB::table('customer_shops_saleplan')
                                                        ->where('monthly_plan_id', $value->id)
                                                        ->get();
                                                    $cust_new_amount = $customer_shops_saleplan->count();

                                                    $total_plan = $sale_plan_amount + $cust_new_amount;

                                                    list($year,$month) = explode('-', $value->month_date);
                                                    $customer_update_count = DB::table('customer_shops')
                                                        ->join('customer_shops_saleplan', 'customer_shops_saleplan.customer_shop_id', 'customer_shops.id')
                                                        ->where('customer_shops_saleplan.monthly_plan_id', $value->id)
                                                        ->whereYear('customer_shops.shop_status_at', $year)
                                                        ->whereMonth('customer_shops.shop_status_at', $month)
                                                        ->count();
                                                @endphp
                                                    <tr style="text-align:center;">
                                                        <td>{{ $key + 1 }}</td>
                                                        <td style="text-align:left;">{{ $value->name }}</td>
                                                        <td>{{ $sale_plan_amount }}</td>
                                                        <td>{{ $cust_new_amount }}</td>
                                                        <td>{{ $total_plan }}</td>
                                                        <td style="text-aligm:right;">{{ number_format($value->close_sale) }}</td>
                                                        <td style="text-aligm:right;">{{ number_format($value->total_sales) }}</td>
                                                        <td style="text-aligm:right;">{{ number_format($value->close_sales_not) }}</td>
                                                        <td style="text-aligm:right;">{{ number_format($customer_update_count) }}</td>
                                                        <td>
                                                            @if ($value->status_approve == 4)
                                                            <span class="badge badge-soft-info" style="font-size: 12px;">Close</span>
                                                            @elseif ($value->status_approve == 2)
                                                            <span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>
                                                            @elseif ($value->status_approve == 3)
                                                            <span class="badge badge-soft-danger" style="font-size: 12px;">UnApproval</span>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            @if ($value->status_approve == 4)
                                                                <a href="{{ url('/lead/approvalsaleplan-history-detail', $value->id) }}" type="button" class="btn btn-icon btn-success pt-5">
                                                                    <i data-feather="alert-circle"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ url('/approvalsaleplan_detail', $value->id) }}" type="button" class="btn btn-icon btn-primary pt-5">
                                                                    <i data-feather="file-text"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="float:right;">
                                    {{ $monthly_plan->links() }}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- /Row -->
    </div>


    <script type="text/javascript">
        function showselectdate(){
            $("#selectdate").css("display", "block");
            $("#bt_showdate").hide();
        }

        function hidetdate(){
            $("#selectdate").css("display", "none");
            $("#bt_showdate").show();
        }

        function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function() {
                $(".success").fadeOut();
            }, 1000);
        }

    </script>

@endsection

@section('scripts')


@endsection('scripts')
