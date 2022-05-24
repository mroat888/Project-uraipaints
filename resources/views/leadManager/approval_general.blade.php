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
            <li class="breadcrumb-item active" aria-current="page">อนุมัติคำขออนุมัติ</li>
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
                    data-feather="file-text"></i></span></span>อนุมัติคำขออนุมัติ</h4>
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
                            <a href="{{ url('/approvalgeneral') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('approvalgeneral/history') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
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
                            <div class="col-md-3">
                                <h5 class="hk-sec-title">รายการคำขออนุมัติ</h5>
                            </div>
                            <div class="col-md-9">
                                <!-- ------ -->
                                <span class="form-inline pull-right">
                                   <a style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกวันที่</a>
                                   <form action="{{ url('lead/approvalGeneral/search') }}" method="POST" enctype="multipart/form-data">
                                       @csrf
                                       {{-- <input type="hidden" name="id" value="{{$id_create}}" /> --}}

                                       <span id="selectdate" style="display:none;">
                                            <input type="date" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" name ="selectdateTo" value="" />

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
                                <form id="from_general_approve" enctype="multipart/form-data">
                                    @csrf
                                <button type="button" id="btn_saleplan_approve" class="btn btn_purple btn-approval" name="approve" value="approve">อนุมัติ</button>

                                <button type="button" id="btn_saleplan_approve2" class="btn btn_purple btn-reject ml-5" name="failed" value="failed">ไม่อนุมัติ</button>
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
                                            <th>ผู้แทนขาย</th>
                                            <th>เรื่องขออนุมัติ</th>
                                            <th>ชื่อร้าน</th>
                                            <th>วันที่ขออนุมัติ</th>
                                            <th>การอนุมัติ</th>
                                            <th>ความคิดเห็น</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($request_approval as $key => $value)
                                        <?php
                                        // $chk =  App\Assignment::join('users', 'assignments.created_by', '=', 'users.id')
                                        // ->whereNotNull('assignments.assign_request_date')
                                        // ->where('assignments.created_by', $value->created_by)->select('users.name', 'assignments.*')->first();
                                        ?>
                                        <tr>
                                            <td>
                                                {{-- <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input checkapprove"
                                                        name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$chk->created_by}}">
                                                    <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                </div> --}}
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input checkapprove"
                                                        name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$value->id}}">
                                                    <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                </div>
                                                {{$value->id}}
                                            </td>
                                            <td>{{$key + 1}}</td>
                                            {{-- <td>{{Carbon\Carbon::parse($chk->assign_request_date)->format('Y-m-d')}}</td> --}}
                                            <td>{{$value->name}}</td>
                                            <td>
                                                @if ($value->assign_is_hot == 1)
                                                <span class="material-icons" style="color: orangered;"> offline_bolt </span>
                                                @endif
                                                {{$value->assign_title}}</td>
                                            <td>{{$value->assign_shop}}</td>
                                            <td>{{Carbon\Carbon::parse($value->assign_request_date)->format('Y-m-d')}}</td>
                                            <td>
                                                <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                            </td>
                                            <td align="center">
                                                <span class="badge badge-soft-primary" style="font-size: 12px;">มี</span>
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                <a href="{{ url('comment_approval', [$value->id, $value->created_by]) }}" class="btn btn-icon btn-purple mr-10">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i data-feather="message-square"></i>
                                                    </h4>
                                                </a>
                                                <a href="{{url('lead/approval_general_detail', $value->created_by)}}" class="btn btn-icon btn-primary btn-link btn_showplan pt-5" value="3">
                                                    <i data-feather="file-text"></i>
                                                </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{-- @foreach ($request_approval as $key => $value)
                                        <?php
                                        // $chk =  App\Assignment::join('users', 'assignments.created_by', '=', 'users.id')
                                        // ->whereNotNull('assignments.assign_request_date')
                                        // ->where('assignments.created_by', $value->created_by)->select('users.name', 'assignments.*')->first();
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input checkapprove"
                                                        name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$chk->created_by}}">
                                                    <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                </div>
                                            </td>
                                            <td>{{$key + 1}}</td>
                                            <td>{{Carbon\Carbon::parse($chk->assign_request_date)->format('Y-m-d')}}</td>
                                            <td>{{$chk->name}}</td>
                                            <td>
                                                <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                            </td>
                                            <td>
                                                <a href="{{url('lead/approval_general_detail', $chk->created_by)}}" class="btn btn-icon btn-primary btn-link btn_showplan pt-5" value="3">
                                                    <i data-feather="file-text"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
         <!-- ModalSaleplanApprove -->
         <div class="modal fade" id="ModalSaleplanApprove" tabindex="-1" role="dialog" aria-labelledby="ModalSaleplanApprove"
         aria-hidden="true">
         <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title">ยืนยันการอนุมัติคำขออนุมัติ ใช่หรือไม่?</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body" style="text-align:center;">
                         <h3>ยืนยันการอนุมัติคำขออนุมัติ ใช่หรือไม่?</h3>
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


        $("#from_general_approve").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('lead/approval_confirm_all') }}',
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
                    $('#shop_status_name_lead').text('ยืนยันการอนุมัติเรียบร้อย');
                    // $('#btn_saleplan_restrospective').prop('disabled', true);
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
    $(document).on('click', '.btn_showplan', function(){
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
