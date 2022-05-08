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
            <li class="breadcrumb-item">การขออนุมัติ</li>
            <li class="breadcrumb-item active" aria-current="page">ประวัติลูกค้าใหม่</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>ประวัติลูกค้าใหม่</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{ url('approval-customer-except') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('lead/approval-customer-except-history') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-list"></i>
                                </span>
                                <span class="btn-text">ประวัติลูกค้าใหม่</span>
                            </a>
                            <hr>
                            <div id="calendar"></div>
                        </div>
                    </div>

  
                    <h5 class="hk-sec-title">รายชื่อลูกค้าใหม่</h5>
                    <div class="row mb-2">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <!-- เงื่อนไขการค้นหา -->
                                @php 
                                    $action_search = "lead/approval-customer-except-history/search"; //-- action form
                                    if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                        $date_search = $date_filter;
                                    }else{
                                        $date_search = "";
                                    }
                                @endphp
                                <form action="{{ url($action_search) }}" method="post">
                                @csrf
                                <div class="hk-pg-header mb-10">
                                    <div class="col-sm-12 col-md-12">
                                        <span class="form-inline pull-right pull-sm-center">
                                            <span id="selectdate">
                                                @if(count($team_sales) > 1)
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
                                                @endif
                                                <select name="selectusers" class="form-control form-control-sm" aria-label=".form-select-lg example">
                                                    <option value="" selected>ผู้แทนขาย</option>
                                                    @php 
                                                        $checkusers = "";
                                                        if(isset($selectusers)){
                                                            $checkusers = $selectusers;
                                                        }
                                                    @endphp
                                                    @foreach($users as $user)
                                                        @if($checkusers == $user->id)
                                                            <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                                        @else
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                
                                                <!-- ปี/เดือน :  -->
                                                <input type="month" id="selectdateFrom" name="selectdateFrom" 
                                                value="{{ $date_search }}" class="form-control form-control-sm" 
                                                style="margin-left:10px; margin-right:10px;"/>
                                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request">ค้นหา</button>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                @php 
                                    $check_Radio_1 = "";
                                    $check_Radio_2 = "";
                                    $check_Radio_3 = "";
                                    $check_Radio_4 = "";
                                    $check_Radio_5 = "";
                                    if(isset($slugradio_filter)){
                                        switch($slugradio_filter){
                                            case "สำเร็จ" : $check_Radio_2 = "checked";
                                                break;
                                            case "สนใจ" : $check_Radio_3 = "checked";
                                                break;
                                            case "ไม่สนใจ" : $check_Radio_4 = "checked";
                                                break;
                                            case "รอตัดสินใจ" : $check_Radio_5 = "checked";
                                                break;
                                            default : $check_Radio_1 = "checked";
                                        }
                                    }else{
                                        $check_Radio_1 = "checked";
                                    }
                                @endphp
                                <div class="hk-pg-header mb-10">
                                    <div class="form-check form-check-inline">
                                    <label>
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio1" value="ทั้งหมด" {{ $check_Radio_1 }}>
                                        <!-- <label class="form-check-label" for="inlineRadio1">ทั้งหมด</label> -->
                                        <section class="bg-orange hk-sec-wrapper mt-3">
                                            <div class="row">
                                                <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                    <input type="hidden" name="count_customer_all" value="{{ $count_customer_all }}" >
                                                    <p class="mb-10"><div class="topic-numchart">ทั้งหมด</div> <div class="red-numchart"><div class="wrap_txt-numchart txt-numchart">{{ $count_customer_all }}</div></div>  </p>
                                                </div>
                                            </div>
                                        </section>
                                    </label>
                                    </div>

                                    <div class="form-check form-check-inline ">
                                    <label>
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio2" value="สำเร็จ" {{ $check_Radio_2 }}>
                                        <!-- <label class="form-check-label" for="inlineRadio2">สำเร็จ</label> -->
                                        <section class="bg-blue hk-sec-wrapper">
                                            <div class="row">
                                                <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                    <input type="hidden" name="count_customer_success" value="{{ $count_customer_success }}" >
                                                    <p class="mb-10"><div class="topic-numchart">สำเร็จ</div> <div class="red-numchart"><div class="wrap_txt-numchart txt-numchart">{{ $count_customer_success }}</div></div>  </p>
                                                </div>
                                            </div>
                                        </section>
                                    </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <label>
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio3" value="สนใจ" {{ $check_Radio_3 }}>
                                        <!-- <label class="form-check-label" for="inlineRadio3">สนใจ</label> -->
                                        <section class="bg-purple hk-sec-wrapper">
                                            <div class="row">
                                                <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                    <input type="hidden" name="count_customer_result_1" value="{{ $count_customer_result_1 }}" >
                                                    <p class="mb-10"><div class="topic-numchart">สนใจ</div> <div class="red-numchart"><div class="wrap_txt-numchart txt-numchart">{{ $count_customer_result_1 }}</div></div>  </p>
                                                </div>
                                            </div>
                                        </section>
                                    </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <label>
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio4" value="ไม่สนใจ" {{ $check_Radio_4 }}>
                                        <!-- <label class="form-check-label" for="inlineRadio4">ไม่สนใจ</label> -->
                                        <section class="bg-purple hk-sec-wrapper">
                                            <div class="row">
                                                <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                    <input type="hidden" name="count_customer_result_3" value="{{ $count_customer_result_3 }}" >
                                                    <p class="mb-10"><div class="topic-numchart">ไม่สนใจ</div> <div class="red-numchart"><div class="wrap_txt-numchart txt-numchart">{{ $count_customer_result_3 }}</div></div>  </p>
                                                </div>
                                            </div>
                                        </section>
                                    </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                    <label>
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio5" value="รอตัดสินใจ" {{ $check_Radio_5 }}>
                                        <!-- <label class="form-check-label" for="inlineRadio5">รอตัดสินใจ</label> -->
                                        <section class="bg-purple hk-sec-wrapper mt-3">
                                            <div class="row">
                                                <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                    <input type="hidden" name="count_customer_result_2" value="{{ $count_customer_result_2 }}" >
                                                    <p class="mb-10"><div class="topic-numchart">รอตัดสินใจ</div> <div class="red-numchart"><div class="wrap_txt-numchart txt-numchart">{{ $count_customer_result_2 }}</div></div>  </p>
                                                </div>
                                            </div>
                                        </section>
                                    </label>
                                    </div>
                                </div>
                                </form>
                                <!-- จบเงื่อนไขการค้นหา -->
                                
                                <!-- ส่วนตารางการแสดงรายการ -->
                                @php 
                                    $btn_edit_hide = "display:none;";
                                    $url_customer_detail = "lead/approval_customer_except_history_detail";
                                @endphp

                                <div class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="font-weight: bold;">#</th>
                                                <th style="font-weight: bold;">วันที่เพิ่มลูกค้าใหม่</th>
                                                <th style="font-weight: bold;">วันที่อนุมัติ</th>
                                                <th style="font-weight: bold;">ผู้แทนขาย</th>
                                                <th style="font-weight: bold;">ชื่อร้าน</th>
                                                <th style="font-weight: bold;">อำเภอ,จังหวัด</th>
                                                <th style="font-weight: bold;">การอนุมัติ</th>
                                                <th style="font-weight: bold;">สถานะ</th>
                                                <th style="font-weight: bold;" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_shops as $key => $shop)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    @php 
                                                        list($shop_date, $shop_time) = explode(' ',$shop->shop_created_at);
                                                    @endphp
                                                    {{ $shop_date }}</td>
                                                <td>
                                                    @php 
                                                        if(isset($shop->approve_at)){
                                                            list($approve_date, $approve_time) = explode(' ', $shop->approve_at);
                                                        }else{
                                                            $approve_date = "-";
                                                        }
                                                    @endphp
                                                    {{ $approve_date }}
                                                </td>
                                                <td>{{ $shop->saleman_name }}</td>
                                                <td>{{ $shop->shop_name }}</td>
                                                <td>{{ $shop->AMPHUR_NAME }}, {{ $shop->PROVINCE_NAME }}</td>

                                                <td>
                                                    @if($shop->saleplan_shop_aprove_status == 2)
                                                        <span class="badge badge-soft-violet" style="font-size: 12px;">อนุมัติ</span>
                                                    @elseif($shop->saleplan_shop_aprove_status == 3)
                                                        <span class="badge badge-soft-danger" style="font-size: 12px;">ไม่อนุมัติ</span>
                                                    @else
                                                        {{ $shop->saleplan_shop_aprove_status }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($shop->saleplan_shop_aprove_status == 3)
                                                        <span class="badge badge-soft-purple" style="font-size: 12px;">ไม่ผ่านอนุมัติ</span>
                                                    @else
                                                        @if(!is_null($shop->cust_result_status))
                                                            @if($shop->cust_result_status == 2) <!-- สนใจ	 -->
                                                                <span class="badge badge-soft-orange" style="font-size: 12px;">สนใจ</span>
                                                            @elseif($shop->cust_result_status == 1) <!-- รอตัดสินใจ -->
                                                                <span class="badge badge-soft-primary" style="font-size: 12px;">รอตัดสินใจ</span>
                                                            @elseif($shop->cust_result_status == 0) <!-- ไม่สนใจ  -->
                                                                <span class="badge badge-soft-danger" style="font-size: 12px;">ไม่สนใจ</span>
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="button-list">
                                                    @if($shop->shop_status != 1)
                                                        <button class="btn btn-icon btn-warning mr-10 btn_editshop" style="{{ $btn_edit_hide }}" value="{{ $shop->id }}">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-create"></i></h4></button>
                                                    @endif
                                                        <a href="{{ url($url_customer_detail, $shop->id) }}" class="btn btn-icon btn-success mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- จบ ส่วนตารางการแสดงรายการ -->

                            </div>
                        </div>
                    </div>

                    
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

<style>
    [type=radio] {
        position: absolute;
        opacity: 0;
    }

    [type=radio]+section {
        cursor: pointer;
        margin-right: 0.5rem;
    }

    /* [type=radio]:checked + section {
        outline: 5px solid orange;
    } */
</style>

<script type="text/javascript">
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
    $(document).on('click', '.btn_showplan', function(){
        let plan_id = $(this).val();
        //alert(goo);
        $('#Modalsaleplan').modal("show");
    });

    $(document).on('click', '.checkRadio', function(){
        $("#submit_request").trigger("click");
    });
</script>

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')