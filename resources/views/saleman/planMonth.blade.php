@extends('layouts.master')

@section('content')
    @php
        $monthly_plan_id = $monthly_plan_next->id;
    @endphp
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item active">แผนประจำเดือน</li>
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
                        <div class="hk-pg-header mb-10">
                            <div>
                                <h6 class="hk-sec-title mb-10" style="font-weight: bold;">แผนสรุปรายเดือน ปี <?php echo thaidate('Y', date('Y')); ?></h6>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <!-- ------ -->

                                <span class="form-inline pull-right pull-sm-center">
                                    <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</button>
                                    <form action="{{ url('search_month_planMonth') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <span id="selectdate" style="display:none;">

                                            เดือน : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" name="fromMonth"/>

                                            ถึงเดือน : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name="toMonth"/>

                                            <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm">ค้นหา</button>
                                        </span>
                                    </form>
                                </span>
                                <!-- ------ -->
                            </div>
                        </div>
                        {{-- <h5 class="hk-sec-title">แผนสรุปรายเดือน ปี 2565</h5> --}}
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>เดือน</th>
                                                    <th>แผนทำงาน</th>
                                                    <th>ลูกค้าใหม่</th>
                                                    <th>รวมงาน</th>
                                                    {{-- <th>ดำเนินการแล้ว</th> --}}
                                                    <!-- <th>คงเหลือ</th>
                                                    <th>สำเร็จ %</th> -->
                                                    <th>เยี่ยมลูกค้า</th>
                                                    <th>สถานะ</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($monthly_plan as $key => $value)
                                                    @php
                                                        $sale_plan_amount = DB::table('sale_plans')
                                                            ->where('monthly_plan_id', $value->id)
                                                            ->whereIn('sale_plans_status', [0,1,2])
                                                            ->count();

                                                        $cust_new_amount = DB::table('customer_shops_saleplan')
                                                            ->where('monthly_plan_id', $value->id)
                                                            ->whereIn('shop_aprove_status', [0,1,2])
                                                            ->count();

                                                        $total_plan = $sale_plan_amount + $cust_new_amount;

                                                        $cust_visits_amount = DB::table('customer_visits')
                                                            ->where('monthly_plan_id', $value->id)
                                                            ->count();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ thaidate('F Y', $value->month_date) }}</td>
                                                        <td>{{ $sale_plan_amount }}</td>
                                                        <td>{{ $cust_new_amount }}</td>
                                                        <td>{{ $total_plan }}</td>
                                                        <td>{{ $cust_visits_amount }}</td>
                                                        <td>

                                                            @if ($value->status_approve == 0)
                                                                <span class="badge badge-soft-secondary"
                                                                    style="font-size: 12px;">
                                                                    Draf
                                                                </span>

                                                            @elseif ($value->status_approve == 1)
                                                                <span class="badge badge-soft-warning"
                                                                    style="font-size: 12px;">
                                                                    Pending
                                                                </span>
                                                            @else
                                                                <span class="badge badge-soft-success"
                                                                    style="font-size: 12px;">
                                                                    Approve
                                                                </span>
                                                            @endif


                                                        </td>
                                                        <td style="text-align:center">
                                                            <div class="button-list">

                                                                <form action="{{ url('approve_monthly_plan', $value->id) }}" method="GET">
                                                                    @if ($value->status_approve == 1 || $value->status_approve == 2)
                                                                    <button type="button" class="btn btn-icon btn-secondary requestApproval" disabled>
                                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                                        @else

                                                                        @if($value->id != $monthly_plan_next->id)
                                                                            @php
                                                                                list($myear,$mmonth,$mday) = explode("-",$value->month_date);
                                                                                $master_setting = DB::table('master_setting')->where('name','OverSaleplan')->first();
                                                                                $count_setting = strlen($master_setting->stipulate);
                                                                                if($count_setting < 2){
                                                                                    $setting_day = "0".$master_setting->stipulate;
                                                                                }else{
                                                                                    $setting_day = $master_setting->stipulate;
                                                                                }
                                                                                $OverSaleplan = $myear."-".$mmonth."-".$setting_day;
                                                                                // dd($OverSaleplan, date('Y-m-d'));
                                                                            @endphp
                                                                            @if($OverSaleplan >= date('Y-m-d'))
                                                                                <button type="button" class="btn btn-icon btn-teal requestApproval">
                                                                                    <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                                            @else
                                                                                <button type="button" class="btn btn-icon btn-teal requestApproval" disabled>
                                                                                    <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                                            @endif
                                                                    @else
                                                                            @if($sale_plan_amount > 0)
                                                                                @php
                                                                                    list($myear,$mmonth,$mday) = explode("-",$value->month_date);
                                                                                    $master_setting = DB::table('master_setting')->where('name','OverSaleplan')->first();
                                                                                    $count_setting = strlen($master_setting->stipulate);
                                                                                    if($count_setting < 2){
                                                                                        $setting_day = "0".$master_setting->stipulate;
                                                                                    }else{
                                                                                        $setting_day = $master_setting->stipulate;
                                                                                    }
                                                                                    $OverSaleplan = $myear."-".$mmonth."-".$setting_day;
                                                                                    // dd($OverSaleplan, date('Y-m-d'));
                                                                                @endphp
                                                                                @if($OverSaleplan >= date('Y-m-d'))
                                                                                    <button type="button" class="btn btn-icon btn-teal requestApproval">
                                                                                    <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                                                @else
                                                                                    <button type="button" class="btn btn-icon btn-teal requestApproval" disabled>
                                                                                    <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                                                @endif
                                                                            @else
                                                                            <button type="button" class="btn btn-icon btn-teal requestApproval" disabled>
                                                                                <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                                            @endif

                                                                        @endif

                                                                    @endif
                                                                </form>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-md-12">
                    <section class="hk-sec-wrapper">
                        <h5 class="hk-sec-title">แผนงานประจำเดือน <?php echo thaidate('F Y', $monthly_plan_next->month_date); ?></h5>
                        <div class="row mt-30">
                            <div class="col-md-4">
                                <div class="card card-sm text-white bg-violet">
                                    <div class="card-body">
                                        <span class="d-block font-11 font-weight-500 text-uppercase"></span>
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div>
                                                <span class="d-block">
                                                    <button class="btn btn-icon btn-light btn-lg">
                                                        <span class="btn-icon-wrap"><i data-feather="briefcase"></i></span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="mb-10 text-white">
                                                <span style="font-weight: bold; font-size: 18px;">แผนทำงาน</span>
                                            </div>
                                            <div class="mb-10">
                                                <span style="font-weight: bold; font-size: 18px;">
                                                    @php
                                                        $sale_plan_amount_next = DB::table('sale_plans')
                                                            ->where('monthly_plan_id', $monthly_plan_next->id)
                                                            ->whereIn('sale_plans_status', [0,1,2])
                                                            ->count();
                                                    @endphp
                                                    {{ $sale_plan_amount_next }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card card-sm text-white bg-teal">
                                    <div class="card-body">
                                        <span class="d-block font-11 font-weight-500 text-uppercase"></span>
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div>
                                                <span class="d-block">
                                                    <button class="btn btn-icon btn-light btn-lg">
                                                        <span class="btn-icon-wrap"><i data-feather="user-plus"></i>
                                                        </span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="mb-10">
                                                <span style="font-weight: bold; font-size: 18px;">พบลูกค้าใหม่</span>
                                            </div>
                                            <div class="mb-10">
                                                <span style="font-weight: bold; font-size: 18px;">
                                                    @php
                                                        $cust_new_amount_next = DB::table('customer_shops_saleplan')
                                                            ->where('monthly_plan_id', $monthly_plan_next->id)
                                                            ->whereIn('shop_aprove_status', [0,1,2])
                                                            ->count();
                                                    @endphp
                                                    {{ $cust_new_amount_next }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card card-sm text-white bg-warning">
                                    <div class="card-body">
                                        <span class="d-block font-11 font-weight-500 text-uppercase"></span>
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div>
                                                <span class="d-block">
                                                    <button class="btn btn-icon btn-light btn-lg">
                                                        <span class="btn-icon-wrap"><i data-feather="log-in"></i>
                                                        </span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="mb-10">
                                                <span style="font-weight: bold; font-size: 18px;">เยี่ยมลูกค้า</span>
                                            </div>
                                            <div class="mb-10">
                                                <span style="font-weight: bold; font-size: 18px;">
                                                    @php
                                                        $cust_visits_amount_next = DB::table('customer_visits')
                                                            ->where('monthly_plan_id', $monthly_plan_next->id)
                                                            ->count();
                                                    @endphp
                                                    {{ $cust_visits_amount_next }}
                                                </span>
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
                        <div class="hk-pg-header mb-10">
                            <div>
                                <h6 class="hk-sec-title mb-10" style="font-weight: bold;">แผนงานประจำเดือน <?php echo thaidate('F Y', $monthly_plan_next->month_date); ?></h6>
                            </div>
                            <div class="d-flex">
                                @if($monthly_plan_next->status_approve == 1 || $monthly_plan_next->status_approve == 2)
                                    <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10"
                                        data-toggle="modal" data-target="#saleplanAdd" disabled> + เพิ่มใหม่ </button>
                                @else
                                    <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10"
                                        data-toggle="modal" data-target="#saleplanAdd"> + เพิ่มใหม่ </button>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10 mt-10">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table id="datable_1" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>เรื่อง</th>
                                                    <th>ลูกค้า</th>
                                                    <th>อำเภอ,จังหวัด</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!is_null($list_saleplan))
                                                @foreach ($list_saleplan as $key => $value)
                                                    @php
                                                        $shop_name = "";
                                                        $shop_address = "";
                                                        foreach($customer_api as $key_api => $value_api){
                                                            if($customer_api[$key_api]['id'] == $value->customer_shop_id){
                                                                $shop_name = $customer_api[$key_api]['shop_name'];
                                                                $shop_address = $customer_api[$key_api]['shop_address'];
                                                            }
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{!! Str::limit($value->sale_plans_title, 20) !!}</td>
                                                        <td>
                                                            @if($shop_name != "")
                                                                {!! Str::limit($shop_name,20) !!}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($shop_address != "")
                                                                {{ $shop_address }}
                                                            @endif
                                                        </td>
                                                            @php
                                                                switch($value->sale_plans_status){
                                                                    case 0 :    $text_status = "Draf";
                                                                                $badge_color = "badge-soft-secondary";
                                                                                $btn_disabled = "";
                                                                        break;
                                                                    case 1 :    $text_status = "Pending";
                                                                                $badge_color = "badge-soft-warning";
                                                                                $btn_disabled = "disabled";
                                                                        break;
                                                                    case 2 :    $text_status = "Approve";
                                                                                $badge_color = "badge-soft-success";
                                                                                $btn_disabled = "disabled";
                                                                        break;
                                                                    default :   $text_status = "-";
                                                                                $badge_color = "";
                                                                                $btn_disabled = "disabled";
                                                                        break;
                                                                }
                                                            @endphp
                                                        <td style="text-align:right">
                                                            <div class="button-list">
                                                                @if ($value->saleplan_id)
                                                                <button onclick="approval_comment({{ $value->id }})"
                                                                    class="btn btn-icon btn-violet" data-toggle="modal"
                                                                    data-target="#ApprovalComment">
                                                                    <span class="btn-icon-wrap"><i data-feather="message-square"></i></span>
                                                                </button>
                                                                @endif
                                                                <button class="btn btn-icon btn-warning btn_editsalepaln"
                                                                    value="{{ $value->id }}" {{ $btn_disabled }}>
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-create"></i></h4>
                                                                </button>
                                                                <button id="btn_saleplan_delete"
                                                                    class="btn btn-icon btn-danger mr-10"
                                                                    value="{{ $value->id }}" {{ $btn_disabled }}>
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-trash"></i></h4>
                                                                </button>


                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>

                <div class="col-md-12">
                    <section class="hk-sec-wrapper">
                        <div class="hk-pg-header mb-10">
                            <div>
                                <h6 class="hk-sec-title mb-10" style="font-weight: bold;">พบลูกค้าใหม่</h6>
                            </div>
                            <div class="d-flex">
                                @if($monthly_plan_next->status_approve == 1 || $monthly_plan_next->status_approve == 2)
                                    <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10"
                                    data-toggle="modal" data-target="#addCustomer" disabled> + เพิ่มใหม่ </button>
                                @else
                                    <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10"
                                    data-toggle="modal" data-target="#addCustomer"> + เพิ่มใหม่ </button>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10 mt-10">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table id="datable_1_2" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ชื่อร้าน</th>
                                                    <th>อำเภอ,จังหวัด</th>
                                                    <th>วัตถุประสงค์</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!is_null($customer_new))
                                                @foreach ($customer_new as $key => $value)

                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $value->shop_name }}</td>
                                                        <td>{{ $value->AMPHUR_NAME }}, {{ $value->PROVINCE_NAME }}</td>
                                                        <td>{{$value->cust_name}}</td>
                                                        <td style="text-align:right;">
                                                            <div class="button-list">
                                                                @php

                                                                    $count_new = DB::table('customer_shop_comments')
                                                                    ->where('customer_shops_saleplan_id', $value->id)
                                                                    ->count();

                                                                        switch($value->shop_aprove_status){
                                                                            case 0 :  $btn_disabled = "";
                                                                                break;
                                                                            case 1 :  $btn_disabled = "disabled";
                                                                                break;
                                                                            case 2 :  $btn_disabled = "disabled";
                                                                                break;
                                                                            default :  $btn_disabled = "disabled";
                                                                                break;
                                                                        }

                                                                @endphp

                                                                @if ($count_new > 0)
                                                                <button onclick="custnew_comment({{ $value->id }})"
                                                                    class="btn btn-icon btn-violet" data-toggle="modal"
                                                                    data-target="#CustNewComment">
                                                                    <span class="btn-icon-wrap"><i data-feather="message-square"></i></span>
                                                                </button>
                                                                @endif
                                                                <button class="btn btn-icon btn-warning mr-10 btn_editshop"
                                                                    value="{{ $value->id }}" {{ $btn_disabled }}>
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-create"></i></h4>
                                                                </button>
                                                                <button class="btn btn-icon btn-danger mr-10 btn_cust_new_delete"
                                                                    value="{{ $value->id }}" {{ $btn_disabled }}>
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-trash"></i></h4>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        // }
                                                    ?>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>

                <div class="col-md-12">
                    <section class="hk-sec-wrapper">
                        <div class="hk-pg-header mb-10">
                            <div>
                                <h6 class="hk-sec-title mb-10" style="font-weight: bold;">เยี่ยมลูกค้า</h6>
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10"
                                    data-toggle="modal" data-target="#addCustomerVisit"> + เพิ่มใหม่ </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10 mt-10">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table id="datable_1_3" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ชื่อร้าน</th>
                                                    <th>อำเภอ,จังหวัด</th>
                                                    <th>วันสำคัญ</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php $no = 1; ?>

                                                @foreach ($customer_visit_api as $key => $value)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $customer_visit_api[$key]['shop_name'] }}</td>
                                                    <td>{{ $customer_visit_api[$key]['shop_address'] }}</td>
                                                    <td>{{ $customer_visit_api[$key]['focusdate'] }}</td>
                                                    @php
                                                     $month = DB::table('monthly_plans')
                                                                    ->where('id', $customer_visit_api[$key]['monthly_plan_id'])
                                                                    ->select('status_approve')->first();

                                                            switch($month->status_approve){
                                                            case 0 :  $btn_disabled = "";
                                                                break;
                                                            case 1 :  $btn_disabled = "disabled";
                                                                break;
                                                            case 2 :  $btn_disabled = "disabled";
                                                                break;
                                                            default :  $btn_disabled = "disabled";
                                                                break;
                                                            }

                                                    @endphp
                                                    <td>
                                                        <button class="btn btn-icon btn-danger mr-10 btn_cust_new_delete2"
                                                                    value="{{ $customer_visit_api[$key]['id'] }}" {{ $btn_disabled }}>
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-trash"></i></h4>
                                                                </button>
                                                        {{-- <div class="button-list">
                                                            <a href="{{url('delete_visit', $customer_visit_api[$key]['id'])}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                                <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-trash"></i></h4></a>
                                                        </div> --}}
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
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

    <!-- Modal -->
    <div class="modal fade" id="saleplanAdd" tabindex="-1" role="dialog" aria-labelledby="saleplanAdd"
        aria-hidden="true">
        @include('saleplan.salePlanForm')
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="saleplanEdit" tabindex="-1" role="dialog" aria-labelledby="saleplanEdit"
        aria-hidden="true">
        @include('saleplan.salePlanForm_edit')
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomer"
        aria-hidden="true">
        @include('customer.lead_insert')
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomer"
        aria-hidden="true">
        @include('customer.lead_edit_saleplan')
    </div>

    <!-- Modal VisitCustomer -->
    <div class="modal fade" id="addCustomerVisit" tabindex="-1" role="dialog" aria-labelledby="addCustomerVisit"
        aria-hidden="true">
        @include('saleman.visitCustomers_add')
    </div>

    <!-- Modal Delete Customer Approve -->
    <div class="modal fade" id="ModalapproveDelete" tabindex="-1" role="dialog" aria-labelledby="Modalapprove"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_cus_delete" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบข้อมูลลูกค้าใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบข้อมูลลูกค้า ใช่หรือไม่ ?</h3>
                        <input class="form-control" id="shop_id_delete" name="shop_id_delete" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete Customer Visit Approve -->
    <div class="modal fade" id="ModalapproveDelete2" tabindex="-1" role="dialog" aria-labelledby="ModalapproveDelete2"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_cus_delete2" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบข้อมูลเยี่ยมลูกค้าใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบข้อมูลเยี่ยมลูกค้า ใช่หรือไม่ ?</h3>
                        <input class="form-control" id="cust_visit_id_delete" name="cust_visit_id_delete" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete Saleplan -->
    <div class="modal fade" id="ModalSaleplanDelete" tabindex="-1" role="dialog" aria-labelledby="ModalSaleplanDelete"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_saleplan_delete" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบข้อมูล Sale Plan ใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบข้อมูล Sale Plan ใช่หรือไม่ ?</h3>
                        <input class="form-control" id="saleplan_id_delete" name="saleplan_id_delete" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Comment -->
    <div class="modal fade" id="ApprovalComment" tabindex="-1" role="dialog" aria-labelledby="ApprovalComment" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ความคิดเห็น</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div id="div_comment">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
            </div>
        </div>
    </div>

    <!-- Modal Comment -->
    <div class="modal fade" id="CustNewComment" tabindex="-1" role="dialog" aria-labelledby="CustNewComment" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ความคิดเห็น</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div id="div_cust_new_comment">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
            </div>
        </div>
    </div>

    <script>
        //Edit
        function approval_comment(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('saleplan_view_comment/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#div_comment').children().remove().end();
                    console.log(data);
                    // $('#get_comment_id').val(data.comment.id);
                    // $('#get_comment').val(data.comment.saleplan_comment_detail);

                    // $.each(data.comment, function(key, value){
                    //     $('#div_comment').append('<div class="alert alert-primary py-20" role="alert">'+value.saleplan_comment_detail+'</div>');
                    // });
                    $.each(data, function(key, value){
                        $('#div_comment').append('<div>Comment by: '+data[key].user_comment+' Date: '+data[key].created_at+'</div>');
                        $('#div_comment').append('<div class="alert alert-primary py-20" role="alert">'+data[key].saleplan_comment_detail+'</div>');
                    });

                    $('#ApprovalComment').modal('toggle');
                }
            });
        }

        function custnew_comment(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('customernew_view_comment/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#div_cust_new_comment').children().remove().end();
                    console.log(data);
                    $.each(data, function(key, value){
                        $('#div_cust_new_comment').append('<div>Comment by: '+data[key].user_comment+' Date: '+data[key].created_at+'</div>');
                        $('#div_cust_new_comment').append('<div class="alert alert-primary py-20" role="alert">'+data[key].customer_comment_detail+'</div>');
                    });

                    $('#CustNewComment').modal('toggle');
                }
            });
        }

    </script>


    <script>
        var x = document.getElementById("demo");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    reak;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
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


    <script type="text/javascript">
        function chkAll(checkbox) {

            var cboxes = document.getElementsByName('checkapprove');
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

<script>
    // -- SalePlan
    $(document).on('click', '.btn_editsalepaln', function(e){
        e.preventDefault();
        let salepaln_id = $(this).val();
        let api_token = '<?=$api_token?>';
        console.log(salepaln_id);
        $.ajax({
            method: 'POST',
            url: '{{ url("/saleplanEdit_fetch") }}',
            data:{
                "_token": "{{ csrf_token() }}",
                'id': salepaln_id,
                'api_token': api_token
            },
            success: function(response){
                console.log(response);
                if(response.status == 200){
                    $("#saleplanEdit").modal('show');
                    $('#get_id2').val(salepaln_id);
                    $('#saleplan_id_edit').val(response.salepaln.customer_shop_id);
                    $('#get_title').val(response.salepaln.sale_plans_title);
                    $('#get_objective').val(response.salepaln.sale_plans_objective);
                    $('#get_tags').children().remove().end();
                    $('#saleplan_phone_edit').val(response.shop_phone);
                    $('#saleplan_address_edit').val(response.shop_address);

                    $.each(response.customer_api, function(key, value){
                        if(response.customer_api[key]['id'] == response.salepaln.customer_shop_id){
                            $('#sel_searchShopEdit').append('<option value='+response.customer_api[key]['id']+' selected>'+response.customer_api[key]['shop_name']+'</option>');
                        }else{
                            $('#sel_searchShopEdit').append('<option value='+response.customer_api[key]['id']+'>'+response.customer_api[key]['shop_name']+'</option>');
                        }
                    });

                    let rows_tags = response.salepaln.sale_plans_tags.split(",");
                    let count_tags = rows_tags.length;
                        $.each(rows_tags, function(tkey, tvalue){
                            $.each(response.pdglists_api, function(key, value){
                                if(response.pdglists_api[key]['identify'] == rows_tags[tkey]){
                                    $('#get_tags').append('<option value='+response.pdglists_api[key]['identify']+' selected>'+
                                    response.pdglists_api[key]['name']+'</option>');
                                }else{
                                    $('#get_tags').append('<option value='+response.pdglists_api[key]['identify']+'>'+
                                    response.pdglists_api[key]['name']+'</option>');
                                }
                            });
                        });     
                    //     $.each(response.master_present, function(key, value){
                    //         if(value.id == rows_tags[tkey]){
                    //             $('#get_tags').append('<option value='+value.id+' selected>'+value.present_title+'</option>');
                    //         }else{
                    //             $('#get_tags').append('<option value='+value.id+'>'+value.present_title+'</option>');
                    //         }
                    //     });
                    // });
                }
            }
        });
    });

    $(document).on('click', '#btn_saleplan_delete', function() { // ปุ่มลบ Slaplan
        let saleplan_id_delete = $(this).val();
        $('#saleplan_id_delete').val(saleplan_id_delete);
        $('#ModalSaleplanDelete').modal('show');
    });

    $("#from_saleplan_delete").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('delete_saleplan') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: "ลบข้อมูลลูกค้าเรียบร้อยแล้วค่ะ",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalSaleplanDelete').modal('hide');
                    $('#shop_status_name_lead').text('ลบข้อมูล Sale Plan เรียบร้อย')
                    $('#btn_saleplan_delete').prop('disabled', true);
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });

    // $(document).on('click', '#btn_update', function() {
    //     let shop_id = $(this).val();
    //     $('#shop_id').val(shop_id);
    //     $('#Modalapprove').modal('show');
    // });

</script>


<script>
    //-- ส่วนลูกค้าใหม่
    $(document).on('click', '.btn_cust_new_delete', function() { // ปุ่มลบลูกค้าใหม่
        let shop_id_delete = $(this).val();
        $('#shop_id_delete').val(shop_id_delete);
        $('#ModalapproveDelete').modal('show');
    });

    //-- ส่วนเยี่ยมลูกค้า
    $(document).on('click', '.btn_cust_new_delete2', function() { // ปุ่มลบเยี่ยมลูกค้า
        let cust_visit_id_delete = $(this).val();
        $('#cust_visit_id_delete').val(cust_visit_id_delete);
        $('#ModalapproveDelete2').modal('show');
    });

    $(document).on('click','.btn_editshop', function(e){ // แก้ไขลูกค้าใหม่
        e.preventDefault();
        let shop_id = $(this).val();

        $.ajax({
            method: 'GET',
            // url: '{{ url("/edit_customerLead") }}/'+shop_id,
            url: '{{ url("/edit_shopsaleplan") }}/'+shop_id,
            datatype: 'json',
            success: function(response){
                console.log(response);
                $('#edit_shop_objective').children().remove().end();
                if(response.status == 200){
                    $("#editCustomer").modal('show');
                    $("#edit_shops_saleplan_id").val(shop_id);
                    $("#edit_shop_name").val(response.dataEdit.shop_name);

                    $.each(response.master_customer_new, function(key, value){
                        if(value.id == response.dataEdit.customer_shop_objective){
                            $('#edit_shop_objective').append('<option value='+value.id+' selected>'+value.cust_name+'</option>')	;
                        }else{
                            $('#edit_shop_objective').append('<option value='+value.id+'>'+value.cust_name+'</option>')	;
                        }
                    });

                    if(response.customer_contacts != null){
                        $("#edit_cus_contacts_id").val(response.customer_contacts.id);
                        $("#edit_contact_name").val(response.customer_contacts.customer_contact_name);
                        $("#edit_customer_contact_phone").val(response.customer_contacts.customer_contact_phone);
                    }

                    $("#edit_shop_address").val(response.dataEdit.shop_address);

                    $.each(response.shop_province, function(key, value){
                        if(value.PROVINCE_ID == response.dataEdit.shop_province_id){
                            $('#edit_province').append('<option value='+value.PROVINCE_ID+' selected>'+value.PROVINCE_NAME+'</option>')	;
                        }else{
                            $('#edit_province').append('<option value='+value.PROVINCE_ID+'>'+value.PROVINCE_NAME+'</option>')	;
                        }
                    });

                    $.each(response.shop_amphur, function(key, value){
                        if(value.AMPHUR_ID == response.dataEdit.shop_amphur_id){
                            $('#edit_amphur').append('<option value='+value.AMPHUR_ID+' selected>'+value.AMPHUR_NAME+'</option>')	;
                        }else{
                            $('#edit_amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                        }
                    });

                    $.each(response.shop_district, function(key, value){
                        if(value.DISTRICT_ID == response.dataEdit.shop_district_id){
                            $('#edit_district').append('<option value='+value.DISTRICT_ID+' selected>'+value.DISTRICT_NAME+'</option>')	;
                        }else{
                            $('#edit_district').append('<option value='+value.DISTRICT_ID+'>'+value.DISTRICT_NAME+'</option>')	;
                        }
                    });

                    $("#edit_shop_zipcode").val(response.dataEdit.shop_zipcode);

                }
            }
        });

    });

    $("#from_cus_delete").on("submit", function(e) {
        e.preventDefault();
        //var formData = $(this).serialize();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: '{{ url('/customer_shops_saleplan_delete') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: "ลบข้อมูลลูกค้าเรียบร้อยแล้วค่ะ",
                    showConfirmButton: false,
                    timer: 1500,
                });
                $('#ModalapproveDelete').modal('hide');
                $('#shop_status_name_lead').text('ลบข้อมูลลูกค้าเรียบร้อย')
                $('#btn_update').prop('disabled', true);
                $('#btn_delete').prop('disabled', true);

                location.reload();
            },
            error: function(response) {
                console.log("error");
                console.log(response);
            }
        });
    });
</script>

<script>
$("#from_cus_delete2").on("submit", function(e) {
    e.preventDefault();
    //var formData = $(this).serialize();
    var formData = new FormData(this);
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: '{{ url('/delete_visit') }}',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: "ลบข้อมูลเยี่ยมลูกค้าเรียบร้อยแล้วค่ะ",
                showConfirmButton: false,
                timer: 1500,
            });
            $('#ModalapproveDelete2').modal('hide');
            $('#status_visit').text('ลบข้อมูลเยี่ยมลูกค้าเรียบร้อย')
            $('#btn_update').prop('disabled', true);
            $('#btn_delete').prop('disabled', true);

            location.reload();
        },
        error: function(response) {
            console.log("error");
            console.log(response);
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        $('.requestApproval').click(function(evt) {
            var form = $(this).closest("form");
            evt.preventDefault();

            swal({
                title: `ต้องการขออนุมัติแผนงานหรือไม่ ?`,
                // text: "ถ้าลบแล้วไม่สามารถกู้คืนข้อมูลได้",
                icon: "warning",
                // buttons: true,
                buttons: [
                    'ยกเลิก',
                    'ขออนุมัติ'
                ],
                infoMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            })

        });


        $('#is_monthly_plan').val('Y'); // กำหนดสถานะ Y = อยู่ในแผน , N = ไม่อยู่ในแผน (เพิ่มระหว่างเดือน)

        $("#customer_shops").on("change", function (e) {
            e.preventDefault();
            let shop_id = $(this).val();
            if(shop_id != ""){
                $('#customer_shops_id').val(shop_id);
                $('#shop_name').attr('readonly', true);
                $('#contact_name').attr('readonly', true);
                $('#shop_phone').attr('readonly', true);
                $('#shop_address').attr('readonly', true);
                $('#province').attr('disabled', 'disabled');
                $('#amphur').attr('disabled', 'disabled');
                $('#district').attr('disabled', 'disabled');
                $('#postcode').attr('readonly', true);
            }else{
                $('#customer_shops_id').val('');
                $('#shop_name').val('');
                $('#contact_name').val('');
                $('#shop_phone').val('');
                $('#shop_address').val('');
                // $('#province').val('');
                // $('#district').val('');
                // $('#postcode').val('');
                // document.getElementById("shop_name").value = "";

                $('#shop_name').attr('readonly', false);
                $('#contact_name').attr('readonly', false);
                $('#shop_phone').attr('readonly', false);
                $('#shop_address').attr('readonly', false);
                $('#province').removeAttr("disabled");
                $('#amphur').removeAttr("disabled");
                $('#district').removeAttr("disabled");
                $('#postcode').attr('readonly', false);
            }
            $.ajax({
                method: 'GET',
                url: '{{ url("/edit_customerLead") }}/'+shop_id,
                datatype: 'json',
                success: function(response){
                    console.log(response);
                    if(response.status == 200){
                        $("#customer_shops_id").val(shop_id);
                        $("#shop_name").val(response.dataEdit.shop_name);
                        if(response.customer_contacts != null){
                            $("#contact_name").val(response.customer_contacts.customer_contact_name);
                            $("#shop_phone").val(response.customer_contacts.customer_contact_phone);
                        }
                        $("#shop_address").val(response.dataEdit.shop_address);

                        $.each(response.shop_province, function(key, value){
                            if(value.PROVINCE_ID == response.dataEdit.shop_province_id){
                                $('#province').append('<option value='+value.PROVINCE_ID+' selected>'+value.PROVINCE_NAME+'</option>')	;
                            }else{
                                $('#province').append('<option value='+value.PROVINCE_ID+'>'+value.PROVINCE_NAME+'</option>')	;
                            }
                        });

                        $.each(response.shop_amphur, function(key, value){
                            if(value.AMPHUR_ID == response.dataEdit.shop_amphur_id){
                                $('#amphur').append('<option value='+value.AMPHUR_ID+' selected>'+value.AMPHUR_NAME+'</option>')	;
                            }else{
                                $('#amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                            }
                        });

                        $.each(response.shop_district, function(key, value){
                            if(value.DISTRICT_ID == response.dataEdit.shop_district_id){
                                $('#district').append('<option value='+value.DISTRICT_ID+' selected>'+value.DISTRICT_NAME+'</option>')	;
                            }else{
                                $('#district').append('<option value='+value.DISTRICT_ID+'>'+value.DISTRICT_NAME+'</option>')	;
                            }
                        });

                        $("#postcode").val(response.dataEdit.shop_zipcode);
                    }
                }
            });

        });

    });
</script>


@endsection

@section('footer')
    @include('layouts.footer')
@endsection('footer')

