@php


@endphp
<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">อนุมัติทริปเดินทาง</li>
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
        <div class="topichead-bgred"><i class="ion ion-md-analytics"></i> {{ $text_header }}</div>
        <div class="content-right d-flex"></div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <ul class="nav nav-pills nav-fill bg-light pa-10 mb-40" role="tablist">
                                <li class="nav-item">
                                    <a href="{{ url($url_approve_trip) }}" class="nav-link" style="background: rgb(5, 90, 97); color:rgb(255, 255, 255);">{{ $text_sub_header }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url($url_approve_trip_history) }}" class="nav-link" style="color: rgb(22, 21, 21);">{{ $text_sub_header_history }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายการ ทริปเดินทาง
                                <?php
                                    if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                        echo thaidate('F Y', $date_filter);
                                    }
                                ?>
                            </h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            @php
                                if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                    $date_search = $date_filter;
                                }else{
                                    $date_search = "";
                                }
                            @endphp
                            <!-- ------ -->
                            <span class="form-inline pull-right pull-sm-center">
                                <form action="{{ url($action_search) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <span id="selectdate">
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
                                        @if(Auth::user()->status == 2)
                                        <input type="month" id="selectdateFrom" name="selectdateFrom" value="{{ $date_search }}" class="form-control"
                                        style="margin-left:10px; margin-right:10px;"/>
                                        @endif
                                        <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                                    </span>
                                </form>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="mb-20">
                            <form id="from_trip_approve" enctype="multipart/form-data">
                                @csrf
                                @if(Auth::user()->status == 2)
                                <button type="button" id="btn_saleplan_approve" class="btn btn_purple btn-green btn-sm" name="approve" value="approve">อนุมัติ</button>

                                <button type="button" id="btn_saleplan_approve2" class="btn btn_purple btn-reject btn-sm ml-5" name="failed" value="failed">ให้แก้ไขใหม่</button>
                                @endif
                            </div>
                                <div class="table-responsive-sm table-color">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr style="text-align:center;">
                                            @if(Auth::user()->status == 2)
                                                <th>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck4" onclick="chkAll(this);" name="CheckAll" value="Y">
                                                        <label class="custom-control-label text-white"
                                                            for="customCheck4">ทั้งหมด</label>
                                                    </div>
                                                </th>
                                            @else
                                                <th>#</th>
                                            @endif
                                            <th>ทริปเดือน</th>
                                            <th>วันที่ขออนุมัติ</th>
                                            <th style="text-align:left;">ผู้แทนขาย</th>
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
                                                    list($year, $month, $day) = explode("-", $value->trip_date);
                                                    $year_thai = $year+543;
                                                    $date_thai = $month."/".$year_thai;
                                                }else{
                                                    $date_thai = "-";
                                                }
                                            @endphp
                                        <tr style="text-align:center;">
                                            @if(Auth::user()->status == 2)
                                                <td>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input checkapprove"
                                                            name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$value->id}}">
                                                        <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                    </div>
                                                </td>
                                            @else
                                                <td>{{ ++$key }}</td>
                                            @endif
                                            <td>{{ $date_thai }}</td>
                                            <td>{{ $approve_at }}</td>
                                            @php 
                                                if(isset($value->api_identify)){
                                                    $api_identify = $value->api_identify;
                                                }else{
                                                    $api_identify = "";
                                                }
                                            @endphp
                                            <td style="text-align:left;">{{ $api_identify }} {{ $value->name }}</td>
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

                                                {{-- <!-- <button id="btn_saleplan_restrospective" type="button"
                                                    class="btn btn-icon btn-edit" value="{{ $value->id }}">
                                                    <i data-feather="refresh-ccw"></i>
                                                </button> --> --}}

                                                @if(Auth::user()->status == 2)
                                                <a href="{{ url('lead/approve_trip/edit') }}/{{ $value->id }}"
                                                    class="btn btn-icon btn-edit">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i class="ion ion-md-create"></i>
                                                    </h4>
                                                </a>
                                                @endif

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
                            <div style="float:right;">

                            </div>

                            <!-- ModalSaleplanApprove -->
                            <div class="modal fade" id="ModalSaleplanApprove" tabindex="-1" role="dialog" aria-labelledby="ModalSaleplanApprove" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ยืนยันการอนุมัติแผนงานประจำเดือน ใช่หรือไม่?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="text-align:center;">
                                                <h3>ยืนยันการอนุมัติแผนงานประจำเดือน ใช่หรือไม่?</h3>
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
</div>


<!-- ModalTripRestorespective -->
<div class="modal fade" id="ModalTripRestorespective" tabindex="-1" role="dialog" aria-labelledby="ModalTripRestorespective"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="from_trip_restorespective" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">คุณต้องการส่งข้อมูล ทริปเดินทาง กลับใช่หรือไม่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <h3>คุณต้องการส่งข้อมูล ทริปเดินทาง กลับใช่หรือไม่ ?</h3>
                    <input class="form-control" id="restros_id" name="restros_id" type="hidden" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                </div>
            </div>
        </form>
    </div>
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

    $(document).on('click', '#btn_saleplan_restrospective', function() {
        let restros_id = $(this).val();
        $('#restros_id').val(restros_id);
        $('#ModalTripRestorespective').modal('show');
    });

    $("#from_trip_restorespective").on("submit", function(e) {
        e.preventDefault();
        //var formData = $(this).serialize();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: '{{ url('lead/trip_retrospective') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'เรียบร้อย!',
                    text: "ส่งข้อมูลกลับเรียบร้อยแล้วค่ะ",
                    showConfirmButton: false,
                    timer: 1500,
                });
                $('#ModalTripRestorespective').modal('hide');
                $('#btn_saleplan_restrospective').prop('disabled', true);
                location.reload();
            },
            error: function(response) {
                console.log("error");
                console.log(response);
            }
        });
    });

    $(document).on('click', '#btn_saleplan_approve', function() {
        let approve = $(this).val();
        $('#approve').val(approve);
        $('#ModalSaleplanApprove').modal('show');
    });

    $(document).on('click', '#btn_saleplan_approve2', function() {
        let failed = $(this).val();
        $('#failed').val(failed);
        $('#ModalSaleplanApprove').modal('show');
    });


    $("#from_trip_approve").on("submit", function(e) {
        e.preventDefault();
        //var formData = $(this).serialize();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: '{{ url('lead/approval_trip_confirm_all') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if(response.status == 200){
                Swal.fire({
                    icon: 'success',
                    title: 'เรียบร้อย!',
                    text: "ยืนยันการอนุมัติเรียบร้อยแล้วค่ะ",
                    showConfirmButton: false,
                    timer: 1500,
                });
                $('#ModalSaleplanApprove').modal('hide');
                $('#shop_status_name_lead').text('ยืนยันการอนุมัติเรียบร้อย')
                $('#btn_saleplan_restrospective').prop('disabled', true);
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
    });


</script>
