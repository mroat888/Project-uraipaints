@extends('layouts.masterLead')

@section('content')
    @php

    $date = date('m-d-Y');

    $date1 = str_replace('-', '/', $date);

    $yesterday = date('Y-m-d', strtotime($date1 . '-1 days'));

    $date1 = str_replace('-', '/', $date);

    $yesterday2 = date('Y-m-d', strtotime($date1 . '-2 days'));

    @endphp
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">อนุมัติลูกค้าใหม่</li>
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
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="file-text"></i></span></span>อนุมัติลูกค้าใหม่</h4>
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
                            <a href="{{ url('/approval-customer-except') }}" type="button"
                                class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('lead/approval-customer-except-history') }}" type="button"
                                class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-list"></i>
                                </span>
                                <span class="btn-text">ประวัติลูกค้าใหม่</span>
                            </a>
                            <hr>
                            <div id="calendar"></div>
                        </div>
                    </div>

                    <h5 class="hk-sec-title">รายการขออนุมัติลูกค้าใหม่ (นอกแผน)</h5>
                    <div class="row mb-2">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <!-- เงื่อนไขการค้นหา -->
                                @php
                                    $action_search = 'lead/approval-customer-except/search'; //-- action form
                                    if (isset($date_filter)) {
                                        //-- สำหรับ แสดงวันที่ค้นหา
                                        $date_search = $date_filter;
                                    } else {
                                        $date_search = '';
                                    }
                                @endphp
                                <form action="{{ url($action_search) }}" method="post">
                                    @csrf
                                    <div class="hk-pg-header mb-10">
                                        <div class="col-sm-12 col-md-12">
                                            <span class="form-inline pull-right pull-sm-center">
                                                <span id="selectdate">
                                                    @if (count($team_sales) > 1)
                                                        <select name="selectteam_sales" class="form-control form-control-sm"
                                                            aria-label=".form-select-lg example">
                                                            <option value="" selected>เลือกทีม</option>
                                                            @php
                                                                $checkteam_sales = '';
                                                                if (isset($selectteam_sales)) {
                                                                    $checkteam_sales = $selectteam_sales;
                                                                }
                                                            @endphp
                                                            @foreach ($team_sales as $team)
                                                                @if ($checkteam_sales == $team->id)
                                                                    <option value="{{ $team->id }}" selected>
                                                                        {{ $team->team_name }}</option>
                                                                @else
                                                                    <option value="{{ $team->id }}">
                                                                        {{ $team->team_name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                    <select name="selectusers" class="form-control form-control-sm"
                                                        aria-label=".form-select-lg example">
                                                        <option value="" selected>ผู้แทนขาย</option>
                                                        @php
                                                            $checkusers = '';
                                                            if (isset($selectusers)) {
                                                                $checkusers = $selectusers;
                                                            }
                                                        @endphp
                                                        @foreach ($users as $user)
                                                            @if ($checkusers == $user->id)
                                                                <option value="{{ $user->id }}" selected>
                                                                    {{ $user->name }}</option>
                                                            @else
                                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>

                                                    <!-- ปี/เดือน :  -->
                                                    <input type="month" id="selectdateFrom" name="selectdateFrom"
                                                        value="{{ $date_search }}" class="form-control form-control-sm"
                                                        style="margin-left:10px; margin-right:10px;" />
                                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request">ค้นหา</button>
                                                </span>
                                            </span>
                                        </div>
                                    </div>

                                </form>
                                <!-- จบเงื่อนไขการค้นหา -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="mb-20">
                                {{-- <form action="{{ url('lead/approval_customer_confirm_all') }}" method="POST" enctype="multipart/form-data"> --}}
                                <form id="from_saleplan_approve" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" id="btn_saleplan_approve"
                                        class="btn btn_purple btn-violet btn-sm btn-rounded px-3" name="approve"
                                        value="approve">อนุมัติ</button>

                                    <button type="button" id="btn_saleplan_approve2"
                                        class="btn btn_purple btn-danger btn-sm btn-rounded px-3 ml-5" name="failed"
                                        value="failed">ไม่อนุมัติ</button>
                            </div>
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck4"
                                                        onclick="chkAll(this);" name="CheckAll" value="Y">
                                                    <label class="custom-control-label" for="customCheck4">ทั้งหมด</label>
                                                </div>
                                            </th>
                                            <th>#</th>
                                            <th>วันที่เพิ่มลูกค้าใหม่</th>
                                            <th>ผู้แทนขาย</th>
                                            <th>ชื่อร้านค้า</th>
                                            <th>อำเภอ,จังหวัด</th>
                                            <th>ผู้ติดต่อ</th>
                                            <th>การอนุมัติ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $key => $value)
                                        <input type="hidden" value="{{$value->customer_shop_id}}" name="customer_shop_id">  <!-- รหัส customer_shop -->
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input checkapprove"
                                                            name="checkapprove[]" id="customCheck{{ $key + 1 }}"
                                                            value="{{$value->id}}">
                                                        <label class="custom-control-label"
                                                            for="customCheck{{ $key + 1 }}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ Carbon\Carbon::parse($value->created_at)->format('Y-m-d') }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->shop_name }}</td>
                                                <td>{{ $value->AMPHUR_NAME }},{{ $value->PROVINCE_NAME }}</td>
                                                <td>{{ $value->customer_contact_name }}</td>
                                                <td>
                                                    <span class="badge badge-soft-warning"
                                                        style="font-size: 12px;">Pending</span>
                                                </td>
                                                <td>
                                                    <div class="button-list">
                                                        <a href="{{ url('lead/approval_customer_except_detail', $value->id) }}"
                                                            class="btn btn-icon btn-purple btn-link btn_showplan" value="3">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4>
                                                        </a>
                                                        <a href="{{ url('comment_customer_new', [$value->customer_shop_id, $value->id]) }}" class="btn btn-icon btn-info mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;">
                                                                <span class="material-icons">
                                                                    question_answer
                                                                    </span>
                                                            </h4>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- ModalSaleplanApprove -->
                            <div class="modal fade" id="ModalSaleplanApprove" tabindex="-1" role="dialog"
                                aria-labelledby="ModalSaleplanApprove" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">ยืนยันการอนุมัติลูกค้าใหม่ (นอกแผน) ใช่หรือไม่?</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="text-align:center;">
                                            <h3>ยืนยันการอนุมัติลูกค้าใหม่ (นอกแผน) ใช่หรือไม่?</h3>
                                            <input class="form-control" id="approve" name="approve" type="hidden" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">ยกเลิก</button>
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
    <!-- /Container -->

    <script type="text/javascript">
        function showselectdate() {
            $("#selectdate").css("display", "block");
            $("#bt_showdate").hide();
        }

        function hidetdate() {
            $("#selectdate").css("display", "none");
            $("#bt_showdate").show();
        }
    </script>

    <script type="text/javascript">
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


        $("#from_saleplan_approve").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('lead/approval_customer_confirm_all') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
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
                    } else {
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
        $(document).on('click', '.btn_showplan', function() {
            let plan_id = $(this).val();
            //alert(goo);
            $('#Modalsaleplan').modal("show");
        });
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
        document.getElementById('btn_approve').onclick = function() {
            var markedCheckbox = document.getElementsByName('checkapprove');
            var saleplan_id_p = "";

            for (var checkbox of markedCheckbox) {
                if (checkbox.checked) {
                    if (checkbox.value != "") {
                        saleplan_id_p += checkbox.value + ' ,';
                    }
                }
            }
            if (saleplan_id_p != "") {
                $('#Modalapprove').modal('show');
                $('#saleplan_id').val(saleplan_id_p);
            } else {
                alert('กรุณาเลือกรายการด้วยค่ะ');
            }
        }
    </script>
@endsection
