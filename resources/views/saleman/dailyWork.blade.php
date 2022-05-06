@extends('layouts.master')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item active">งานประจำวัน</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
            <div class="row">
                <div class="col-sm-12 col-lg-8">
                    <section class="hk-sec-wrapper">
                        {{-- <h6 class="hk-sec-title mb-10" style="font-weight: bold;">สรุปยอดขาย</h6> --}}
                        <h6 class="topic-page hk-sec-title topic-bgblue" style="font-weight: bold;">งานประจำวัน </h6>
                        <div class="row mt-30">
                        <div class="col-12 col-md-6">
                            <a href="{{ url('approval') }}">
                            <div class="card card-sm text-white bg-purple">
                                <div class="row card-body">
                                    <div class="col-3">
                                        <span class="d-block font-16 font-weight-500 text-uppercase mb-10">
                                            <button class="btn btn-icon btn-icon-circle btn-light btn-lg mr-25 icon-red"><span class="btn-icon-wrap"><i
                                                data-feather="edit-2"></i></span></button>
                                        </span>
                                    </div>
                                    <div class="col-9">
                                        <div class="font_lg">ขออนุมัติ <span class="txt-numchart"> {{$list_approval->count()}}</span></div>
                                        <div class="box-dailywork box-inlineflex d-flex align-items-end justify-content-between mt-10 font-16">
                                            <div>
                                                <span class="d-block">
                                                    <span>อนุมัติ</span>
                                                    <span class="txt-numchart">
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
                                                </span>
                                            </div>
                                            <div>
                                                <span>ด่วน</span>
                                                <?php $assign_is_hot = 0; ?>
                                                <span class="txt-numchart">
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
                            </a>
                        </div>


                        <div class="col-12 col-md-6">
                            <a href="{{ url('assignment') }}">
                            <div class="card card-sm text-white bg-blue">
                                <div class="row card-body">
                                    <div class="col-3">
                                        <span class="d-block font-16 font-weight-500 text-uppercase mb-10">
                                                <button class="btn btn-icon btn-icon-circle btn-light btn-lg mr-25 icon-green"><span class="btn-icon-wrap"><i
                                                    data-feather="clipboard"></i></span></button>

                                        </span>
                                    </div>
                                    <div class="col-9">
                                        <div class="font_lg">คำสั่งงาน <span class="txt-numchart"> {{ $assignments->count() }}</span></div>
                                        <div class="box-dailywork d-flex align-items-end justify-content-between mt-10 font-16">
                                            <div>
                                                <span class="d-block">
                                                    <span>ทำแล้ว</span>
                                                    <span class="txt-numchart">
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
                                                </span>
                                            </div>
                                            <div>
                                                <span>รอดำเนินการ</span>
                                                <?php $unfinished = 0; ?>
                                                <span class="txt-numchart">
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
                            </a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{ url('note') }}">
                            <div class="card card-sm text-white bg-orange">
                                <div class="row card-body">
                                    <div class="col-3">
                                        <span class="d-block font-16 font-weight-500 text-uppercase mb-10">
                                            <button class="btn btn-icon btn-icon-circle btn-light btn-lg mr-25 icon-blue"><span class="btn-icon-wrap"><i
                                                data-feather="file"></i></span></button>

                                        </span>
                                    </div>
                                    <div class="col-9">
                                        <div class="font_lg">บันทึกโน๊ต <span class="txt-numchart"> {{ $notes->count() }}</span></div>
                                        <div class="box-dailywork d-flex align-items-end justify-content-between mt-10">
                                            <div>
                                                <span class="d-block">
                                                    <span>ไม่ปัก</span>
                                                    <span class="txt-numchart">
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
                                                </span>
                                            </div>
                                            <div>
                                                <span>ปักหมุด</span>
                                                <?php $pin = 0; ?>
                                                <span class="txt-numchart">
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
                            </a>
                        </div>

                        <div class="col-12 col-md-6">
                            <a href="{{ url('lead') }}">
                            <div class="card card-sm text-white bg-orange2">
                                <div class="row card-body">
                                    <div class="col-3">
                                        <span class="d-block font-16 font-weight-500 text-uppercase mb-10">
                                        <button class="btn btn-icon btn-icon-circle btn-light btn-lg mr-25 icon-orange"><span class="btn-icon-wrap"><i
                                            data-feather="users"></i></span></button>
                                        </span>
                                    </div>
                                    <div class="col-9">
                                        <div class="font_lg">ลูกค้าใหม่ <span class="txt-numchart"> {{ $customer_shop->count() }}</span></div>
                                        <div class="box-dailywork d-flex align-items-end justify-content-between mt-10">
                                            <div>
                                                <span class="d-block">
                                                    <span>ระหว่างดำเนินการ</span>
                                                    <span class="txt-numchart">
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
                                                </span>
                                            </div>
                                            <div>
                                                <span>เปลี่ยนเป็นลูกค้า</span>
                                                <?php $wait = 0; ?>
                                                <span class="txt-numchart">
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
                            </a>
                        </div>
                    </div>
                    </section>
                </div>
                    </section>
                {{-- </div> --}}

                <div class="col-12 col-lg-4">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="topic-page hk-sec-title topic-bggreen" style="font-weight: bold;">ลูกค้า </h6>
                                <div class="card card-sm">
                                    <div class="card-body" style="color: black;">
                                        <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"></span>
                                        <div>
                                            <div class="row">
                                                <div class="col-8">
                                                    <a href="{{url('customer')}}" class="txt-cusall text-dark">ลูกค้าทั้งหมด</a>
                                                </div>
                                                <div class="col-4">
                                                    <span class="txt-custotal">{{ $total_shop }}</span>
                                                </div>
                                            </div>
                                            <div class="bggrey-cus">
                                                <div class="row">
                                                    <div class="col-12 col-xl-8">
                                                        <a href="{{url('important-day-detail')}}" class="txt-specialday text-dark">มีวันสำคัญในเดือน</a>
                                                    </div>
                                                    <div class="col-12 col-xl-4">
                                                        <div class="num-specialday"><span>{{ $ShopInMonthDays }} ร้าน</span></div>
                                                        <div class="num-specialday"><span>{{ $InMonthDays }} วัน</span></div>
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
            {{-- </div> --}}
            </div>


        <div class="mt-30 mb-30">
            <div class="row">
                <div class="col-md-12">
                    <section class="hk-sec-wrapper">
                        <div class="hk-pg-header mb-10">
                            <div class="topichead-bgred">Sale Plan (นำเสนอสินค้า) ประจำเดือน <?php echo thaidate('F Y', date("Y-m-d")); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10 mt-10">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-color col-md-12">
                                        <table  id="datable_1" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>วัตถุประสงค์</th>
                                                    <th>ลูกค้า</th>
                                                    <th>จำนวนรายการนำเสนอ</th>
                                                    <th>อำเภอ,จังหวัด</th>
                                                    <th>ความเห็น ผจก.</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

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

                                                        $pieces = explode(",", $value->sale_plans_tags);
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $key + 1}}</td>
                                                        <td><span class="topic_purple">{!! Str::limit($value->masobj_title, 30) !!}</span></td>
                                                        <td>
                                                            @if($shop_name != "")
                                                                {!! Str::limit($shop_name,20) !!}
                                                            @endif
                                                        </td>
                                                        <td align="center">{{ count($pieces) }}</td>
                                                        <td>
                                                            @if($shop_address != "")
                                                                {{ $shop_address }}
                                                            @endif
                                                        </td>
                                                        <td style="text-align:center;">
                                                            @if ($value->saleplan_id)
                                                            <button onclick="approval_comment({{ $value->id }})"
                                                                class="btn btn-icon btn-violet" data-toggle="modal"
                                                                data-target="#ApprovalComment">
                                                                <span class="btn-icon-wrap"><i data-feather="message-square"></i></span>
                                                            </button>
                                                            @endif
                                                        </td>
                                                        <td style="text-align:center">
                                                            <div class="button-list">
                                                                {{-- @php
                                                                $text_notify = "";
                                                                if ($value->status_result == 1){

                                                                    $sale_plan_results = DB::table('sale_plan_results')->where('sale_plan_id', $value->id)->first();
                                                                    $master_setting = DB::table('master_setting')->where('name','OverCheckOut')->first();

                                                                    $setting_day = "+".$master_setting->stipulate." days";
                                                                    $checkin_date = str_replace('-', '/', $sale_plan_results->sale_plan_checkin_date);
                                                                    $OverCheckOut = date('Y-m-d',strtotime($checkin_date . $setting_day));

                                                                    $lastday = date('Y-m-t');
                                                                    if($lastday < $OverCheckOut){
                                                                        $OverCheckOut = $lastday;
                                                                    }

                                                                    $text_notify = "checkout ไม่เกิน ".$OverCheckOut ;
                                                                    if($OverCheckOut >= date('Y-m-d')){
                                                                        $btn_primary_disabled = "disabled";
                                                                        $btn_pumpkin_disabled = "";
                                                                        $btn_neon_disabled = "disabled";
                                                                    }else{
                                                                        $btn_primary_disabled = "disabled";
                                                                        $btn_pumpkin_disabled = "disabled";
                                                                        $btn_neon_disabled = "disabled";
                                                                    }

                                                                }elseif ($value->status_result == 2){
                                                                    $btn_primary_disabled = "disabled";
                                                                    $btn_pumpkin_disabled = "disabled";
                                                                    $btn_neon_disabled = "";

                                                                }elseif ($value->status_result == 3){
                                                                    $btn_primary_disabled = "disabled";
                                                                    $btn_pumpkin_disabled = "disabled";
                                                                    $btn_neon_disabled = "";
                                                                }else{
                                                                    $btn_primary_disabled = "";
                                                                    $btn_pumpkin_disabled = "disabled";
                                                                    $btn_neon_disabled = "disabled";
                                                                }
                                                                @endphp --}}

                                                                {{-- <button class="btn btn-icon btn-primary"
                                                                    data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})" {{ $btn_primary_disabled }}>
                                                                    <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                <button class="btn btn-icon btn-pumpkin"
                                                                    data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})" {{ $btn_pumpkin_disabled }}>
                                                                    <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button> --}}
                                                                    {{-- <button class="btn btn-icon text-white" style="background-color: rgb(73, 39, 113)">
                                                                        <span class="btn-icon-wrap"><i data-feather="file"></i></span></button> --}}

                                                                <button class="btn btn-icon text-white" style="background-color: rgb(2, 119, 144)" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})">
                                                                    <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>

                                                            </div>
                                                            {{-- <span class="text-danger" style="font-size:11px;">{{ $text_notify }}</span> --}}
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
                        <div class="hk-pg-header mb-10">
                            <div class="topichead-bggreen">
                                Sale Plan (เปิดลูกค้าใหม่) ประจำเดือน <?php echo thaidate('F Y', date("Y-m-d")); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10 mt-10">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-color col-md-12">
                                        <table id="datable_1_2" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ชื่อร้าน</th>
                                                    <th>อำเภอ,จังหวัด</th>
                                                    <th>วัตถุประสงค์</th>
                                                    <th style="text-align:center;">ความเห็น ผจก.</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer_new as $key => $value)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->shop_name}}
                                                    @if ($value->is_monthly_plan == "N")
                                                    <span class="badge badge-soft-indigo"
                                                    style="font-weight: bold; font-size: 12px;">นอกแผน</span>
                                                    @endif
                                                    </td>
                                                    <td>{{ $value->AMPHUR_NAME }}, {{ $value->PROVINCE_NAME }}</td>
                                                    <td>{{ $value->cust_name }}</td>
                                                    <td style="text-align:center;">
                                                        @php
                                                            $count_new = DB::table('customer_shop_comments')
                                                            ->where('customer_shops_saleplan_id', $value->id)
                                                            ->count();
                                                        @endphp
                                                        @if ($count_new > 0)
                                                        <button onclick="custnew_comment({{ $value->id }})"
                                                            class="btn btn-icon btn-violet" data-toggle="modal"
                                                            data-target="#CustNewComment">
                                                            <span class="btn-icon-wrap"><i data-feather="message-square"></i></span>
                                                        </button>
                                                        @endif
                                                    </td>
                                                    <td style="text-align:right;">
                                                        <div class="button-list">
                                                            {{-- @php
                                                                $text_notify = "";
                                                                if ($value->cust_result_checkin_date != "" && $value->cust_result_checkout_date == ""){

                                                                    $shops_saleplan_result = DB::table('customer_shops_saleplan_result')
                                                                    ->where('customer_shops_saleplan_id', $value->id)
                                                                    ->first();
                                                                    $master_setting = DB::table('master_setting')->where('name','OverCheckOut')->first();
                                                                    $setting_day = "+".$master_setting->stipulate." days";
                                                                    $checkin_date = str_replace('-', '/', $shops_saleplan_result->cust_result_checkin_date);
                                                                    $OverCheckOut = date('Y-m-d',strtotime($checkin_date . $setting_day));

                                                                    $lastday = date('Y-m-t');
                                                                    if($lastday < $OverCheckOut){
                                                                        $OverCheckOut = $lastday;
                                                                    }

                                                                    $text_notify = "checkout ไม่เกิน ".$OverCheckOut;

                                                                    if($OverCheckOut >= date('Y-m-d')){
                                                                        $btn_primary_cusnew = "disabled";
                                                                        $btn_pumpkin_cusnew = "";
                                                                        $btn_neon_cusnew = "disabled";
                                                                    }else{
                                                                        $btn_primary_cusnew = "disabled";
                                                                        $btn_pumpkin_cusnew = "disabled";
                                                                        $btn_neon_cusnew = "disabled";
                                                                    }

                                                                }elseif($value->cust_result_checkin_date != "" && $value->cust_result_checkout_date != ""){
                                                                    $btn_primary_cusnew = "disabled";
                                                                    $btn_pumpkin_cusnew = "disabled";
                                                                    $btn_neon_cusnew = "";
                                                                }else{
                                                                    $btn_primary_cusnew = "";
                                                                    $btn_pumpkin_cusnew = "disabled";
                                                                    $btn_neon_cusnew = "disabled";
                                                                }
                                                            @endphp --}}
                                                            <button class="btn btn-icon text-white" style="background-color: rgb(25, 64, 124)"
                                                                data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})">
                                                                <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                            <button class="btn btn-icon text-white" style="background-color: rgb(234, 105, 18)"
                                                            data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})">
                                                            <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                            <button class="btn btn-icon text-white" style="background-color: rgb(2, 119, 144)" data-toggle="modal" data-target="#ModalCustResult" onclick="customer_new_result({{ $value->id }})">
                                                            <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                        </div>
                                                        {{-- <span class="text-danger mr-3" style="font-size:11px;">{{ $text_notify }}</span> --}}
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
                        <div class="hk-pg-header mb-10">
                            <div class="topichead-blue">
                                เยี่ยมลูกค้า
                             </div>
                             <div class="d-flex content-right">
                                <button type="button" class="btn-green"
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
                                    <div class="table-responsive table-color col-md-12">
                                        <table id="datable_1_3" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ชื่อร้าน</th>
                                                    <th>อำเภอ,จังหวัด</th>
                                                    <th>วันสำคัญ</th>
                                                    <th>สถานะ</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                @foreach ($customer_visit_api as $key => $value)

                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{!! Str::limit($customer_visit_api[$key]['shop_name'], 20) !!}</td>
                                                        <td>{{ $customer_visit_api[$key]['shop_address'] }}</td>
                                                        <td>{{ $customer_visit_api[$key]['focusdate'] }}</td>
                                                        <td>
                                                            @if ($customer_visit_api[$key]['visit_status'] == 0)
                                                                <span class="badge badge-soft-secondary mt-15 mr-10"
                                                                    style="font-weight: bold; font-size: 12px;">รอดำเนินการ</span>
                                                            @elseif ($customer_visit_api[$key]['visit_status'] == 1)
                                                                <span class="badge badge-soft-success mt-15 mr-10"
                                                                    style="font-weight: bold; font-size: 12px;">สำเร็จ</span>
                                                            @elseif ($customer_visit_api[$key]['visit_status'] == 2)
                                                                <span class="badge badge-soft-danger mt-15 mr-10"
                                                                    style="font-weight: bold; font-size: 12px;">ไม่สำเร็จ</span>
                                                            @endif
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <div class="button-list">
                                                                {{-- @php
                                                                    $text_notify = "";
                                                                    if($customer_visit_api[$key]['visit_checkin_date'] != "" && $customer_visit_api[$key]['visit_checkout_date'] == ""){

                                                                        $customer_visit_results = DB::table('customer_visit_results')
                                                                        ->where('customer_visit_id', $customer_visit_api[$key]['id'])
                                                                        ->first();
                                                                        $master_setting = DB::table('master_setting')->where('name','OverCheckOut')->first();
                                                                        $setting_day = "+".$master_setting->stipulate." days";
                                                                        $checkin_date = str_replace('-', '/', $customer_visit_results->cust_visit_checkin_date);
                                                                        $OverCheckOut = date('Y-m-d',strtotime($checkin_date . $setting_day));

                                                                        $lastday = date('Y-m-t');
                                                                        if($lastday < $OverCheckOut){
                                                                            $OverCheckOut = $lastday;
                                                                        }

                                                                        $text_notify = "checkout ไม่เกิน ".$OverCheckOut;

                                                                        if($OverCheckOut >= date('Y-m-d')){
                                                                            $btn_primary_cusvisit_disabled = "disabled";
                                                                            $btn_pumpkin_cusvisit_disabled = "";
                                                                            $btn_neon_cusvisit_disabled = "disabled";
                                                                        }else{
                                                                            $btn_primary_cusvisit_disabled = "disabled";
                                                                            $btn_pumpkin_cusvisit_disabled = "disabled";
                                                                            $btn_neon_cusvisit_disabled = "disabled";
                                                                        }

                                                                    }elseif($customer_visit_api[$key]['visit_checkin_date'] != "" && $customer_visit_api[$key]['visit_checkout_date'] != ""){
                                                                        $btn_primary_cusvisit_disabled = "disabled";
                                                                        $btn_pumpkin_cusvisit_disabled = "disabled";
                                                                        $btn_neon_cusvisit_disabled = "";
                                                                    }else{
                                                                        $btn_primary_cusvisit_disabled = "";
                                                                        $btn_pumpkin_cusvisit_disabled = "disabled";
                                                                        $btn_neon_cusvisit_disabled = "disabled";
                                                                    }
                                                                @endphp --}}
                                                                <button class="btn btn-icon text-white" style="background-color: rgb(25, 64, 124)"
                                                                    data-toggle="modal" data-target="#ModalcheckinVisit" onclick="getLocation({{ $customer_visit_api[$key]['id'] }})">
                                                                    <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                <button class="btn btn-icon text-white" style="background-color: rgb(234, 105, 18)"
                                                                    data-toggle="modal" data-target="#ModalcheckinVisit" onclick="getLocation({{ $customer_visit_api[$key]['id'] }})">
                                                                    <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                <button class="btn btn-icon text-white" style="background-color: rgb(2, 119, 144)" data-toggle="modal" data-target="#ModalVisitResult" onclick="customer_visit_result({{ $customer_visit_api[$key]['id'] }})">
                                                                    <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                            </div>
                                                            {{-- <span class="text-danger mr-3" style="font-size:11px;">{{ $text_notify }}</span> --}}
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


            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

    <!-- Modal VisitCustomer -->
    <div class="modal fade" id="addCustomerVisit" tabindex="-1" role="dialog" aria-labelledby="addCustomerVisit"
        aria-hidden="true">
        @include('saleman.visitCustomers_add_dailyWork')
    </div>

    <!-- Modal Check-in/Out Saleplan -->
    <div class="modal fade" id="Modalcheckin" tabindex="-1" role="dialog" aria-labelledby="Modalcheckin"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="from_saleplan">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">SalePlan Check-in 2 Check-out</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-20 text-center">
                            {{-- <button type="button" class="btn btn-primary" onclick="getLocation()">GetLocation</button> --}}
                            <input type="hidden" id="lat" name="lat">
                            <input type="hidden" id="lon" name="lon">
                            <p id="demo"></p>
                        </div>
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Check-in/Out Curtomer -->
    <div class="modal fade" id="ModalcheckinCust" tabindex="-1" role="dialog" aria-labelledby="ModalcheckinCust"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="from_customer_new">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Check-in 2 Check-out</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-20 text-center">
                            <input type="hidden" id="cust_lat" name="lat">
                            <input type="hidden" id="cust_lon" name="lon">
                            <p id="cust_demo"></p>
                        </div>
                        <input type="hidden" name="id" id="cust_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Check-in/Out Curtomer Visit -->
    <div class="modal fade" id="ModalcheckinVisit" tabindex="-1" role="dialog" aria-labelledby="ModalcheckinVisit"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="from_customer_visit">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Check-in 2 Check-out</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-20 text-center">
                            <input type="hidden" id="visit_lat" name="lat">
                            <input type="hidden" id="visit_lon" name="lon">
                            <p id="visit_demo"></p>
                        </div>
                        <input type="hidden" name="id" id="custvisit_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Result -->
<div class="modal fade" id="ModalResult" tabindex="-1" role="dialog" aria-labelledby="ModalResult" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผล Sale plan (นำเสนอสินค้า)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="from_saleplan_result">
                        @csrf
                        <input type="hidden" name="saleplan_id" id="get_saleplan_id">
                            <div class="my-3"><span>ลูกค้า : </span><span id="get_shop"></span></div>
                            <div class="my-3"><span>อำเภอ, จังหวัด : </span><span id="get_shop_address"></span></div>
                            <div class="my-3"><span>วัตถุประสงค์ : </span><span id="get_objective"></span></div>
                            <div class="my-3"><span>รายการนำเสนอ : </span><span id="get_name"></span></div>
                        <div class="form-group">
                            <label for="username">สรุปรายละเอียด</label>
                            <textarea class="form-control" id="get_detail" cols="30" rows="5" placeholder="" name="saleplan_detail"
                                type="text"> </textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select" id="get_result" name="saleplan_result">
                                    <option selected>-- กรุณาเลือก --</option>
                                    <option value="0">ไม่สนใจ</option>
                                    <option value="1">สนใจ/ตกลง</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Modal Customer Result -->
<div class="modal fade" id="ModalCustResult" tabindex="-1" role="dialog" aria-labelledby="ModalCustResult" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผล Sale Plan (เปิดลูกค้าใหม่)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="from_customer_new_result">
                        @csrf
                        <input type="hidden" name="cust_id" id="get_cust_new_id">
                        <input type="hidden" name="saleplan_id" id="get_cust_saleplan_id">
                        <input type="hidden" name="cust_result_id" id="get_cust_result_id">
                            <div class="my-3"><span>ชื่อร้าน : </span><span id="get_cust_name"></span></div>
                            <div class="my-3"><span>ชื่อผู้ติดต่อ : </span><span id="get_cust_contact_name"></span></div>
                            <div class="my-3"><span>อำเภอ, จังหวัด : </span><span id="get_cust_address"></span></div>
                            <div class="my-3"><span>วัตถุประสงค์ : </span><span id="get_cust_objective"></span></div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="get_cust_detail" cols="30" rows="5" placeholder="" name="shop_result_detail"
                                type="text" require> </textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select" id="get_cust_result" name="shop_result_status">
                                    <option selected>-- กรุณาเลือก --</option>
                                    <option value="0">ไม่สนใจ</option>
                                    <option value="2">สนใจ/ตกลง</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Modal Customer Vist Result -->
    <div class="modal fade" id="ModalVisitResult" tabindex="-1" role="dialog" aria-labelledby="ModalVisitResult" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผลเยี่ยมลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <form action="{{ url('customer_visit_Result') }}" method="post" enctype="multipart/form-data"> -->
                    <form id="from_customer_visit_result">
                        @csrf
                        <input type="hidden" name="visit_id" id="get_visit_id">
                        <div class="my-3"><span>ชื่อร้าน : </span><span id="get_visit_name"></span></div>
                        <div class="my-3"><span>ชื่อผู้ติดต่อ : </span><span id="get_visit_contact_name"></span></div>
                        <div class="my-3"><span>อำเภอ, จังหวัด : </span><span id="get_visit_address"></span></div>
                        <div class="my-3"><span>วัตถุประสงค์ : </span><span id="get_visit_objective"></span></div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="get_visit_detail" cols="30" rows="5" placeholder="" name="visit_result_detail"
                                type="text"> </textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select" id="get_visit_result" name="visit_result_status">
                                    {{-- <option selected>-- กรุณาเลือก --</option> --}}
                                    <option value="1">สำเร็จ</option>
                                    <option value="2">ไม่สำเร็จ</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
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

        function approval_comment(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('saleplan_view_comment/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#div_comment').children().remove().end();
                    console.log(data);

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



        var x = document.getElementById("demo");
        var v = document.getElementById("visit_demo");
        var cust = document.getElementById("cust_demo");

        function getLocation(id) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
                v.innerHTML = "Geolocation is not supported by this browser.";
                cust.innerHTML = "Geolocation is not supported by this browser.";
            }
            $("#id").val(id);

            $("#cust_id").val(id);
            $("#custvisit_id").val(id);
            console.log(id);
        }

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
            v.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
            cust.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;

            $("#lat").val(position.coords.latitude);
            $("#lon").val(position.coords.longitude);
            $("#visit_lat").val(position.coords.latitude);
            $("#visit_lon").val(position.coords.longitude);
            $("#cust_lat").val(position.coords.latitude);
            $("#cust_lon").val(position.coords.longitude);
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

<script>
    //Edit
    function saleplan_result(id) {
        $("#get_saleplan_id").val(id);
        $('#get_title').text("");
        $('#get_objective').text("");
        $('#get_shop_address').text("");
        $('#get_shop').text("");
        $('#get_name').text("");
        // $('#get_result').val("");

        $.ajax({
            type: "GET",
            url: "{!! url('saleplan_result_get/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {

                $('#get_saleplan_id').val(data.dataResult.saleplan_id);
                $('#get_title').text(data.dataResult.sale_plans_title);
                $('#get_objective').text(data.dataResult.masobj_title);
                $('#get_shop_address').text(data.customer_api);
                $('#get_shop').text(data.customer_name);
                $('#get_detail').val(data.dataResult.sale_plan_detail);
                $('#get_result').val(data.dataResult.sale_plan_status);

                let rows_tags = data.dataResult.sale_plans_tags.split(",");
                    let count_tags = rows_tags.length;
                        $.each(rows_tags, function(tkey, tvalue){
                            $.each(data.pdglists_api, function(key, value){
                                if(data.pdglists_api[key]['identify'] == rows_tags[tkey]){
                                    $('#get_name').text(data.pdglists_api[key]['name']);
                                }else{
                                    $('#get_name').text();
                                }
                            });
                        });

                $('#ModalResult').modal('toggle');
            }
        });
    }
</script>

<script>
    //Edit
    function customer_new_result(id) {
        // $('#get_cust_new_id').val(id);
        $('#get_cust_name').text('');
        // $('#get_cust_result').val('');
        $.ajax({
            type: "GET",
            url: "{!! url('customer_new_result_get/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                // console.log(data.dataResult);

                $('#get_cust_new_id').val(data.dataResult.shop_id);
                $('#get_cust_name').text(data.dataResult.shop_name);
                $('#get_cust_contact_name').text(data.dataResult.customer_contact_name);
                $('#get_cust_address').text(data.cust_new_address);
                $('#get_cust_objective').text(data.dataResult.cust_name);
                $('#get_cust_result_id').val(data.dataResult.resultID);
                $('#get_cust_detail').val(data.dataResult.cust_result_detail);
                $('#get_cust_result').val(data.dataResult.cust_result_status);
                $('#get_cust_saleplan_id').val(data.dataResult.id);

                // if (data.dataResult.shop_name == '') {
                //     $('#get_cust_name').text(data.cust_new_name);
                // }else{
                //     $('#get_cust_name').text(data.dataResult.shop_name);
                // }

                $('#ModalCustResult').modal('toggle');
            }
        });
    }
</script>

<script>
    //Edit
    function customer_visit_result(id) {
        // $("#get_cust_new_id").val(id);
        // console.log(id);
        $.ajax({
            type: "GET",
            url: "{!! url('customer_visit_result_get/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#get_visit_id').val(data.dataResult.id);
                $('#get_visit_name').text(data.visit_name);
                $('#get_visit_contact_name').text(data.dataResult.customer_contact_name);
                $('#get_visit_address').text(data.visit_address);
                $('#get_visit_objective').text(data.dataResult.visit_name);
                $('#get_visit_detail').val(data.dataResult.cust_visit_detail);
                $('#get_visit_result').val(data.dataResult.cust_visit_status);

                $('#ModalVisitResult').modal('toggle');
            }
        });
    }
</script>

<script>
    $("#from_saleplan").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/saleplan_checkin") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#Modalcheckin").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Your work has been saved',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

    $("#from_customer_new").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/customer_new_checkin") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#ModalcheckinCust").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Your work has been saved',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

    $("#from_customer_visit").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/customer_visit_checkin") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#ModalcheckinVisit").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Your work has been saved',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

    $("#from_saleplan_result").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/saleplan_Result") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#ModalResult").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Your work has been saved',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

    $("#from_customer_new_result").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/customer_new_Result") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#ModalCustResult").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Your work has been saved',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

    $("#from_customer_visit_result").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/customer_visit_Result") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#ModalVisitResult").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Your work has been saved',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

</script>

@endsection

@section('footer')
    @include('layouts.footer')
@endsection('footer')
