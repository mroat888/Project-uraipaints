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
            <li class="breadcrumb-item active" aria-current="page">อนุมัติ Sale Plan</li>
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
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>อนุมัติแผนประจำเดือน<?php echo thaidate('F Y', date('Y-m', strtotime("+1 month"))); ?></h4>
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
                                <a href="{{ url('/approvalsaleplan') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                    <span class="icon-label">
                                        <i class="fa fa-file"></i>
                                    </span>
                                    <span class="btn-text">รออนุมัติ</span>
                                </a>

                                <a href="{{ url('lead/approvalsaleplan-history') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
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
                            <div class="col-sm-12 col-md-6">
                                <h5 class="hk-sec-title">ตารางอนุมัติแผนประจำเดือน<?php echo thaidate('F Y', date('Y-m', strtotime("+1 month"))); ?></h5>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <!-- ------ -->
                                <span class="form-inline pull-right">
                                <a style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</a>
                                <form action="{{ url('approvalsaleplan/search') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- <input type="text" id="knowledgeSearch" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" /> --}}

                                    <span id="selectdate" style="display:none;">
                                         <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name ="selectdateTo" value="<?= date('Y-m-d'); ?>" />

                                        <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button>
                                    </span>
                                </form>
                                </span>
                                <!-- ------ -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="mb-20">
                                {{-- <form action="{{ url('lead/approval_saleplan_confirm_all') }}" method="POST" enctype="multipart/form-data"> --}}
                                <form id="from_saleplan_approve" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" id="btn_saleplan_approve" class="btn btn_purple btn-violet btn-sm btn-rounded px-3" name="approve" value="approve">อนุมัติ</button>

                                    <button type="button" id="btn_saleplan_approve2" class="btn btn_purple btn-danger btn-sm btn-rounded px-3 ml-5" name="failed" value="failed">ไม่อนุมัติ</button>
                                </div>
                                    <div class="table-responsive-sm">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck4" onclick="chkAll(this);" name="CheckAll" value="Y">
                                                        <label class="custom-control-label"
                                                            for="customCheck4">ทั้งหมด</label>
                                                    </div>
                                                </th>
                                                <th>#</th>
                                                {{-- <th>วันที่</th> --}}
                                                <th>พนักงานขาย</th>
                                                <th>แผนงาน</th>
                                                <th>ลูกค้าใหม่</th>
                                                <th>เยียมลูกค้า</th>
                                                <th>การอนุมัติ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monthly_plan as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox checkbox-info">
                                                                <input type="checkbox" class="custom-control-input checkapprove"
                                                                    name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$value->id}}">
                                                                <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{$key + 1}}</td>
                                                        {{-- <td>{{$value->month_date}}</td> --}}
                                                        <td>{{$value->name}}</td>
                                                        <td>{{$value->sale_plan_amount}}</td>
                                                        <td>{{$value->cust_new_amount}}</td>
                                                        <td>{{$value->cust_visits_amount}}</td>
                                                        <td><span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span></td>
                                                        <td>
                                                            <a href="{{ url('/approvalsaleplan_detail', $value->id) }}" type="button" class="btn btn-icon btn-primary pt-5">
                                                                <i data-feather="file-text"></i>
                                                            </a>
                                                            <?php
                                                            $status_saleplan = App\SalePlan::where('monthly_plan_id', $value->id)
                                                            ->whereIn('sale_plans_status', [2,3])->count();

                                                            $status_customer = App\Customer::where('monthly_plan_id', $value->id)
                                                            ->whereIn('shop_aprove_status', [2,3])->count();

                                                            ?>

                                                            @if ($status_customer == 0 && $status_saleplan == 0)
                                                            <button id="btn_saleplan_restrospective" type="button" class="btn btn-icon btn-warning ml-2" value="{{ $value->id }}">
                                                                <i data-feather="refresh-ccw"></i>
                                                            </button>
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

                                <!-- ModalSaleplanApprove -->
                                <div class="modal fade" id="ModalSaleplanApprove" tabindex="-1" role="dialog" aria-labelledby="ModalSaleplanApprove"
                                aria-hidden="true">
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


    <!-- ModalSaleplanRestorespective -->
    <div class="modal fade" id="ModalSaleplanRestorespective" tabindex="-1" role="dialog" aria-labelledby="ModalSaleplanRestorespective"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_saleplan_restorespective" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการส่งข้อมูล Sale Plan กลับใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการส่งข้อมูล Sale Plan กลับใช่หรือไม่ ?</h3>
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
            $('#ModalSaleplanRestorespective').modal('show');
        });

        $("#from_saleplan_restorespective").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('lead/retrospective') }}',
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
                    $('#ModalSaleplanRestorespective').modal('hide');
                    $('#shop_status_name_lead').text('ส่งข้อมูล Sale Plan กลับเรียบร้อย')
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


        $("#from_saleplan_approve").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('lead/approval_saleplan_confirm_all') }}',
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

@endsection

@section('scripts')


@endsection('scripts')
