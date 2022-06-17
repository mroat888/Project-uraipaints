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
        <div class="topichead-bgred"><i class="ion ion-md-analytics"></i> ปิด ทริปเดินทาง</div>
        <div class="content-right d-flex"></div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <h5 class="hk-sec-title">รายการ ทริปเดินทาง
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
                                        <select name="selectstatus_trip" class="form-control form-control-sm" aria-label=".form-select-lg example"  style="margin-left:10px; margin-right:10px;">
                                            <option value="" selected>เลือกสถานะ</option>
                                            <option value="2">อนุมัติ, ยืนยัน</option>
                                            <option value="4">Complate</option>
                                        </select>
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
                                        <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                                    </span>
                                </form>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="mb-20">
   
                                <button type="button" class="btn btn_purple btn-green btn-sm btn_approve" value="complate">Complate</button>
                                <button type="button" class="btn btn_purple btn-reject btn-sm ml-5 btn_approve" value="pdf">ดาวโหลด PDF</button>
                                <button type="button" class="btn btn_purple btn-reject btn-sm ml-5 btn_approve" value="excle">ดาวโหลด Excle</button>
                                <button type="button" class="btn btn_purple btn-reject btn-sm ml-5 btn_approve" value="seandmail">ส่งเมล</button>
                                
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
            
                                                <th>วันที่ขออนุมัติ</th>
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
                                                @endphp
                                            <tr style="text-align:center;">
                                                <td>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input checkapprove"
                                                            name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$value->id}}">
                                                        <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $approve_at }}</td>
                                                <td style="text-align:left;">{{ $value->name }}</td>
                                                <td>
                                                    @php 
                                                        switch($value->status){
                                                            case 1 : $user_level = "ผู้แทนขาย";
                                                                break;
                                                            case 2 : $user_level = "ผู้จัดการเขต";
                                                                break;
                                                            case 3 : $user_level = "ผู้จัดการฝ่าย";
                                                                break;
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
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url($url_showdetail) }}/{{ $value->id }}" 
                                                        class="btn btn-icon btn-warning">
                                                        <h4 class="btn-icon-wrap" style="color: white;">
                                                            <i class="ion ion-md-map"></i>
                                                        </h4>
                                                    </a>
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
                                                <input class="form-control" id="approve" name="approve" type="text" />
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
            // var http = new XMLHttpRequest();
            // var url = 'trip_pdf';
            var params = formData;
            console.log(params);

            // $.post({{ url('trip_pdf') }},   // url
			//    { myData: params }, // data to be submit
            // );      
        }
    });


</script>


@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
