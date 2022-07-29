@extends('layouts.masterAdmin')

@section('content')

    @php
        $url_approve_trip = "admin/approve_trip";
        $url_showdetail = "admin/approve_trip/detail";
    @endphp

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">ปิดทริปเดินทาง</li>
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
        <div class="topichead-bgred"><i class="ion ion-md-clipboard"></i> ปิดทริปเดินทาง</div>
        <div class="content-right d-flex">
            <button type="button" class="btn btn-reject btn-sm ml-5 btn_seandmail">ส่งอีเมล ทริปเดินทาง</button>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div id="conainer" class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="topic-secondgery">รายการทริปเดินทาง</div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <h5 class="hk-sec-title">
                                <?php
                                    if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                        echo thaidate('F Y', $date_filter);
                                    }
                                ?>
                            </h5>
                        </div>
                        <div class="col-sm-12 col-md-8">
                            @php
                                if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                    $date_search = $date_filter;
                                }else{
                                    $date_search = "";
                                }
                            @endphp
                            <!-- ------ -->
                            <span class="form-inline pull-right pull-sm-center">
                                <form action="{{ url('admin/approve_trip/search') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <span id="selectdate">
                                        <select name="selectstatus_trip" class="form-control" aria-label=".form-select-lg example"  style="margin-left:10px; margin-right:10px;">
                                            <option value="" selected>เลือกสถานะ</option>
                                            <option value="2">อนุมัติ, ยืนยัน</option>
                                            <option value="5">สั่งให้แก้ไข</option>
                                            <option value="4">Complate</option>
                                        </select>
                                        <select name="selectteam_sales" class="form-control" aria-label=".form-select-lg example">
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
                                        <input type="month" id="selectdateFrom" name="selectdateFrom" value="{{ $date_search }}" class="form-control"
                                        style="margin-left:10px; margin-right:10px;"/>
                                        <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                                    </span>
                                </form>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="mb-20 mt-20">

                                <button type="button" class="btn btn_purple btn-green btn-sm btn_approve" value="complate">Complate</button>
                                <!-- <button type="button" class="btn btn_purple btn-reject btn-sm ml-5 btn_approve" value="pdf">ดาวโหลด PDF</button>
                                <button type="button" class="btn btn_purple btn-reject btn-sm ml-5 btn_approve" value="excle">ดาวโหลด Excle</button> -->
                                <!-- <button type="button" class="btn btn_purple btn-reject btn-sm ml-5 btn_approve" value="seandmail">ส่งเมล</button> -->
                                <!-- <a href="{{url('admin/report_email')}}" target = "_blank" class="ml-2">ตัวอย่าง PDF (Email)</a> -->

                            </div>

                            <form id="from_trip_approve" enctype="multipart/form-data">
                                @csrf
                                <div class="table-responsive table-color col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr style="text-align:center;">

                                                <th>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck4" onclick="chkAll(this);" name="CheckAll" value="Y">
                                                        <label class="custom-control-label text-white"
                                                            for="customCheck4">ทั้งหมด</label>
                                                    </div>
                                                </th>
                                                <th>ทริปเดือน</th>
                                                <!-- <th>วันที่ขออนุมัติ</th> -->
                                                <th style="text-align:left;">รายชื่อ</th>
                                                <th>ระดับสิทธิ์</th>
                                                <th>จำนวนวัน</th>
                                                <th>ค่าเบี้ยเลื้ยง</th>
                                                <th>การอนุมัติ</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trip_header as $key => $value)
                                                @php
                                                    list($date_at, $time_at) = explode(" ", $value->request_approve_at);
                                                    list($year_at, $month_at, $day_at) = explode("-", $date_at);
                                                    $year_at_thai = $year_at + 543;
                                                    $approve_at = $day_at."/".$month_at."/".$year_at_thai;

                                                    if(!is_null($value->trip_date)){
                                                        list($year_at, $month_at, $day_at) = explode('-', $value->trip_date);
                                                        $year_at_thai = $year_at+543;
                                                        $trip_date = $month_at."/".$year_at_thai;
                                                    }else{
                                                        $trip_date = "-";
                                                    }
                                                @endphp
                                            <tr style="text-align:center;">
                                                <td>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input checkapprove"
                                                            name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$value->id}}">
                                                        <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $trip_date }}</td>
                                                <!-- <td>{{-- $approve_at --}}</td> -->
                                                <td style="text-align:left;">{{ $value->name }}</td>
                                                <td>
                                                    @php
                                                        $master_permission = DB::table('master_permission')->where('id', $value->status)->first();
                                                        if(!is_null($master_permission)){
                                                            $user_level = $master_permission->permission_name;
                                                        }else{
                                                            $user_level = "-";
                                                        }
                                                    @endphp

                                                    {{ $user_level }}

                                                </td>
                                                <td>{{ $value->trip_day }}</td>
                                                <td>{{ number_format($value->sum_allowance) }}</td>
                                                <td>
                                                    @if ($value->trip_status == 0)
                                                        <span class="badge badge-soft-secondary" style="font-size: 12px;">Darf</span>
                                                    @elseif ($value->trip_status == 1)
                                                        <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                                    @elseif ($value->trip_status == 2)
                                                        <span class="badge badge-soft-success"style="font-size: 12px;">Approval</span>
                                                    @elseif ($value->trip_status == 3)
                                                        <span class="badge badge-soft-danger" style="font-size: 12px;">Reject</span>
                                                    @elseif ($value->trip_status == 4)
                                                        <span class="badge badge-soft-info"style="font-size: 12px;">Close</span>
                                                    @elseif ($value->trip_status == 5)
                                                        <span class="badge badge-soft-purple"style="font-size: 12px;">Request Admin</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($value->trip_status == 5)
                                                        <button class="btn btn-icon btn-edit btn_edittrip"
                                                            value="{{ $value->id }}">
                                                            <h4 class="btn-icon-wrap" style="color: white;">
                                                                <i class="ion ion-md-create"></i>
                                                            </h4>
                                                        </button>
                                                        <a href="{{ url($url_showdetail) }}/{{ $value->id }}"
                                                            class="btn btn-icon btn-warning">
                                                            <h4 class="btn-icon-wrap" style="color: white;">
                                                                <i class="ion ion-md-map"></i>
                                                            </h4>
                                                        </a>
                                                    @else
                                                        <a href="{{ url($url_showdetail) }}/{{ $value->id }}"
                                                                class="btn btn-icon btn-warning">
                                                                <h4 class="btn-icon-wrap" style="color: white;">
                                                                    <i class="ion ion-md-map"></i>
                                                                </h4>
                                                            </a>
                                                        <a href="{{ url('trip_user_pdf') }}/{{ $value->id }}"
                                                            class="btn btn-icon btn-danger" target="_blank">
                                                            <h4 class="btn-icon-wrap" style="color: white;">
                                                                <span class="material-icons">picture_as_pdf</span>
                                                            </h4>
                                                        </a>
                                                        <a href="{{ url('trip_user_excel') }}/{{ $value->id }}"
                                                            class="btn btn-icon btn-excel">
                                                            <h4 class="btn-icon-wrap" style="color: white;">
                                                                <span class="material-icons">table_view</span>
                                                            </h4>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- ModalSaleplanApprove -->
                                <div class="modal fade" id="ModalSaleplanApprove" tabindex="-1" role="dialog" aria-labelledby="ModalSaleplanApprove" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ยืนยันปิดทริปเดินทาง</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="text-align:center;">
                                                <h3>ยืนยัน ปิดทริปเดินทาง ใช่หรือไม่?</h3>
                                                <input class="form-control" id="approve" name="approve" type="hidden" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End ModalSaleplanApprove -->
                            </form>

                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row --> 

        <!-- Modalformemail -->
        <div class="modal fade" id="Modalformemail" tabindex="-1" role="dialog" aria-labelledby="Modalformemail" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <form id="formemail" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ส่งอีเมล ทริปเดินทาง ประจำเดือน</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="selectdateEmail">เดือน/ปี</label>
                                <input type="month" id="selectdateEmail" name="selectdateEmail"
                                value="{{ date('Y-m') }}" class="form-control form-control-lg" required/>
                            </div>
                            <div class="col-md-8 form-group">
                                <div class="mt-40">
                                    <button type="button" class="btn btn_purple btn-reject btn-sm ml-5 btn_pdf" value="pdf">ดาวโหลด PDF</button>
                                    <button type="button" class="btn btn_purple btn-reject btn-sm ml-5 btn_excle" value="excle">ดาวโหลด Excle</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="subject">หัวข้อ</label>
                                <input type="text" id="subject" name="subject" placeholder="ใบเบิกเบี้ยเลี้ยง ประจำเดือน"
                                value="" class="form-control form-control-lg" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="tosend">ถึง</label>
                                <select name="tosend[]" class="select2 select2-multiple form-control tosend" multiple="multiple" id="tosend" data-placeholder="Choose" required>
                                    <optgroup label="เลือกข้อมูล">
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </optgroup> 
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ส่งอีเมล</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- End Modalformemail -->

<!-- Modal Edit -->
<div class="modal fade" id="Modaledit" tabindex="-1" aria-labelledby="Modaledit" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Modaledit">ทริปเดินทาง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form id="form_edit" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" id="trip_header_id" name="trip_header_id" class="form-control">
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="api_identify">รหัสพนักงาน</label>
                    <input type="text" class="form-control" name="api_employee_id_edit" id="api_employee_id_edit" readonly>
                    <input type="hidden" class="form-control" name="api_identify_edit" id="api_identify_edit" readonly>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="namesale">ชื่อพนักงาน</label>
                    <input type="text" class="form-control" name="namesale_edit" id="namesale_edit" readonly>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputPassword4">ทริปของเดือน</label>
                    <input type="month" class="form-control" name="trip_date_edit" id="trip_date_edit" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">จากวันที่</label>
                        <input type="date" class="form-control" name="trip_start_edit" id="trip_start_edit" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">ถึงวันที่</label>
                        <input type="date" class="form-control" name="trip_end_edit" id="trip_end_edit" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">จำนวนวัน</label>
                        <input type="number" class="form-control" name="trip_day_edit" id="trip_day_edit" 
                        onkeyup="calculator_allowance();" onchange="calculator_allowance();" 
                        onclick="calculator_allowance();"required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">อัตราเบี้ยเลี้ยง/วัน</label>
                        <input type="number" class="form-control" name="allowance_edit" id="allowance_edit" 
                        onkeyup="calculator_allowance();" onchange="calculator_allowance();" 
                        onclick="calculator_allowance();" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">รวมค่าเบี้ยเลี้ยง</label>
                        <input type="number" class="form-control" name="sum_allowance_edit" id="sum_allowance_edit" readonly>
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
<!-- End Modal Edit -->

</div>



<script type="text/javascript">

function calculator_allowance(){
    let trip_day = parseInt($('#trip_day_edit').val());
    let allowance = parseInt($('#allowance_edit').val());

    let sum_allowance = trip_day*allowance;

    $('#sum_allowance_edit').val(sum_allowance);
}

$(document).on('click', '.btn_edittrip', function(e){
    e.preventDefault();
    var trip_id = $(this).val();
    $.ajax({
        type:'GET',
        url: '{{ url("trip/edit") }}/' + trip_id,
        cache:false,
        contentType: false,
        processData: false,
        success:function(response){
            console.log(response);
            let trip_date = response.trip_header.trip_date.split("-");
            trip_date = trip_date[0]+"-"+trip_date[1];
            $("#api_identify_edit").val(response.api_identify);
            $("#api_employee_id_edit").val(response.api_employee_id);
            $("#namesale_edit").val(response.namesale);
            $("#trip_header_id").val(response.trip_header.id);
            $("#trip_date_edit").val(trip_date);
            $("#trip_start_edit").val(response.trip_header.trip_start);
            $("#trip_end_edit").val(response.trip_header.trip_end);
            $("#trip_day_edit").val(response.trip_header.trip_day);
            $("#allowance_edit").val(response.trip_header.allowance);
            $("#sum_allowance_edit").val(response.trip_header.sum_allowance);

            $("#Modaledit").modal('show');
        }
    });
});

$("#form_edit").on("submit", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    //console.log(formData);
    $.ajax({
        type:'POST',
        url: '{{ url("admin/trip_header/request/update") }}',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(response){
            console.log(response);
            if(response.status == 200){
                Swal.fire({
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#Modaledit").modal('hide');
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

var month_thai = ['มกราคม','กุมภามพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];

$(document).on('click', '.btn_seandmail', function(){
    $('#Modalformemail').modal('show');
    let sel_date = $('#selectdateEmail').val().split('-');
    let sel_year = parseInt(sel_date[0]);
    let sel_year_thai = sel_year+543
    let month_key =  (parseInt(sel_date[1]) * 1) - 1;

    let subject = 'ใบเบิกค่าเบี้ยเลี้ยง ประจำเดือน '+ month_thai[month_key] + ' ' + sel_year_thai;
    $('#subject').val(subject);
});

$(document).on('change', '#selectdateEmail', function(){
    let sel_date = $(this).val().split('-');
    let sel_year = parseInt(sel_date[0]);
    let sel_year_thai = sel_year+543
    let month_key =  (parseInt(sel_date[1]) * 1) - 1;

    let subject = 'ใบเบิกค่าเบี้ยเลี้ยง ประจำเดือน '+ month_thai[month_key] + ' ' + sel_year_thai;
    $('#subject').val(subject);
});

$("#formemail").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    console.log(formData);

    $('body').waitMe({
                effect : 'bounce',
                text : '',
                // bg : rgba(255,255,255,0.7),
                // color : '#000'
            });

    $.ajax({
        type: 'POST',
        url: '{{ url('trip_mail') }}',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            // console.log(response);
            if(response.status == 200){
                Swal.fire({
                    icon: 'success',
                    title: 'เรียบร้อย!',
                    text: "ส่งอีเมลเรียบร้อยแล้วค่ะ",
                    showConfirmButton: false,
                    timer: 1500,
                });
                $('#Modalformemail').modal('hide');
                // location.reload();
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถส่งอีเมลได้',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#Modalformemail').modal('hide');
            }

            $('body').waitMe("hide");
        }
    });
});

$(document).on('click', '.btn_approve', function() {
    let approve = $(this).val();
    $('#approve').val(approve);
    $('#ModalSaleplanApprove').modal('show');
});

$("#from_trip_approve").on("submit", function(e) {
    e.preventDefault();
    //var formData = $(this).serialize();
    var formData = new FormData(this);
    var approve = $("#approve").val();
    if(approve == "complate"){
        $.ajax({
            type: 'POST',
            url: '{{ url('admin/approval_trip_confirm_all') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                if(response.status == 200){
                    Swal.fire({
                        icon: 'success',
                        title: 'เรียบร้อย!',
                        text: "ปิดทริปเดินทางเรียบร้อยแล้วค่ะ",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalSaleplanApprove').modal('hide');
                    $('#shop_status_name_lead').text('ปิดทริปเดินทางเรียบร้อย')
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่สามารถบันทึกข้อมูลได้',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#ModalSaleplanApprove').modal('hide');
                }
            }
        });

    }else if(approve == "pdf"){

        console.log("PDF---Con");

        $("#from_trip_approve").attr("action", "{{ url('trip_pdf') }}");
        $("#from_trip_approve").attr("method", "post");
        $("#from_trip_approve").attr("target", "_blank");
        $("#from_trip_approve").submit();
        $("#from_trip_approve").removeAttr("action").removeAttr("method").removeAttr("target");

        $('#ModalSaleplanApprove').modal('hide');

    }else if(approve == "excle"){

        console.log("Excle---Con");

        // $("#from_trip_approve").attr("action", "{{ url('trip_excel') }}");
        // $("#from_trip_approve").attr("method", "post");
        // $("#from_trip_approve").attr("target", "_blank");
        // $("#from_trip_approve").submit();
        // $("#from_trip_approve").removeAttr("action").removeAttr("method").removeAttr("target");

        // $('#ModalSaleplanApprove').modal('hide');

    }else if(approve == "seandmail"){

        console.log("seandmail---Con");

        // $("#from_trip_approve").attr("action", "{{ url('trip_excel') }}");
        // $("#from_trip_approve").attr("method", "post");
        // $("#from_trip_approve").attr("target", "_blank");
        // $("#from_trip_approve").submit();
        // $("#from_trip_approve").removeAttr("action").removeAttr("method").removeAttr("target");

        $('#ModalSaleplanApprove').modal('hide');

    }
});


$(document).on('click', '.btn_pdf', function() {
    let sel_trip = $('#selectdateEmail').val();
    console.log(sel_trip);

    $("#formemail").attr("action", "{{ url('trip_report') }}");
    $("#formemail").attr("method", "post");
    $("#formemail").attr("target", "_blank");
    $("#formemail").submit();
    $("#formemail").removeAttr("action").removeAttr("method").removeAttr("target");
});

$(document).on('click', '.btn_excle', function() {
    $("#formemail").attr("action", "{{ url('trip_excel') }}");
    $("#formemail").attr("method", "post");
    $("#formemail").attr("target", "_blank");
    $("#formemail").submit();
    $("#formemail").removeAttr("action").removeAttr("method").removeAttr("target");
});

</script>


@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
