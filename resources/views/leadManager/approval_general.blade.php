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
            <div class="topichead-bgred"><i data-feather="file-text"></i> อนุมัติคำขออนุมัติ</div>
            <div class="content-right d-flex">
            </div>
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
                                    <a href="{{ url('/approvalgeneral') }}" class="nav-link" style="background: rgb(5, 90, 97); color:rgb(255, 255, 255);">รายการรออนุมัติ</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('approvalgeneral/history') }}" class="nav-link" style="color: rgb(22, 21, 21);">ประวัติการอนุมัติ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12" style="margin-bottom: 30px;">
                        <h5 class="hk-sec-title">รายการคำขออนุมัติ</h5>
                    </div>
                    <div class="row mb-2">
                            <div class="col-md-12">
                            <span class="form-inline pull-right">
                                <!-- เงื่อนไขการค้นหา -->
                                @php

                                    if(isset($checkteam_sales)){
                                        $checkteam_sales = $checkteam_sales;
                                    }else{
                                        $checkteam_sales = "";
                                    }
                                    if(isset($checkusers)){
                                        $checkusers = $checkusers;
                                    }else{
                                        $checkusers = "";
                                    }
                                    if(isset($checkdateFrom)){
                                        $checkdateFrom = $checkdateFrom;
                                    }else{
                                        $checkdateFrom = "";
                                    }

                                    if(isset($checkdateTo)){
                                        $checkdateTo = $checkdateTo;
                                    }else{
                                        $checkdateTo = "";
                                    }

                                @endphp

                                <form action="{{ url('lead/approvalGeneral/search') }}" method="post">
                                @csrf
                                <span id="selectdate" >
                                    @if(count($team_sales) > 1)
                                    <select name="selectteam_sales" class="form-control">
                                        <option value="" selected>เลือกทีม</option>
                                            @foreach($team_sales as $team)
                                                @if($checkteam_sales == $team->id)
                                                    <option value="{{ $team->id }}" selected>{{ $team->team_name }}</option>
                                                @else
                                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                                @endif
                                            @endforeach
                                    </select>
                                    @endif
                                    <select name="selectusers" class="form-control">
                                        <option value="" selected>ผู้แทนขาย</option>
                                        @foreach($users as $user)
                                            @if($checkusers == $user->id)
                                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                            @else
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="date" class="form-control" style="margin-left:10px; margin-right:10px;"
                                    id="selectdateFrom" name="selectdateFrom" value="{{ $checkdateFrom }}" />

                                    ถึง <input type="date" class="form-control" style="margin-left:10px; margin-right:10px;"
                                    id="selectdateTo" name="selectdateTo" value="{{ $checkdateTo }}" />

                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-green" id="submit_request">ค้นหา</button>
                                </span>

                                </form>
                                <!-- จบเงื่อนไขการค้นหา -->

                            </span>
                            <!-- ------ -->
                           </div>
                        </div>
                        <form id="from_general_approve" enctype="multipart/form-data">
                            {{-- <form action="{{url('lead/approval_confirm_all')}}" method="post" enctype="multipart/form-data"> --}}
                            @csrf
                    <div class="row">
                    <form id="from_general_approve" enctype="multipart/form-data">
                            @csrf
                        <div class="col-sm">
                            <div class="mb-20">
                                <button type="button" id="btn_saleplan_approve" class="btn btn_purple btn-approval" name="approve" value="approve">อนุมัติ</button>

                                <button type="button" id="btn_saleplan_approve2" class="btn btn_purple btn-reject ml-5 btn_click" name="failed" value="failed">ไม่อนุมัติ</button>
                            </div>
                            <div class="table-responsive-sm table-color">
                                <table id="datable_1" class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customCheck4" onclick="chkAll(this);" name="CheckAll" value="Y">
                                                    <label class="custom-control-label" for="customCheck4" style="color: white;">ทั้งหมด</label>
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
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input checkapprove"
                                                        name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$value->id}}">
                                                    <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                </div>
                                            </td>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>
                                                @if($value->assign_is_hot == "1")
                                                <span class="material-icons" style="color: orangered;">
                                                    local_fire_department
                                                    </span>
                                                @endif
                                                {{$value->assign_title}}</td>
                                            {{-- <td>{{$value->assign_shop}}</td> --}}
                                            <td>{{ $value->api_customers_title }} {{ $value->api_customers_name }}</td>
                                            <td>{{Carbon\Carbon::parse($value->assign_request_date)->addYear(543)->format('d/m/Y')}}</td>
                                            <td>
                                                <span class="btn-pending" style="font-size: 12px;">Pending</span>
                                            </td>
                                            <td>
                                                <span class="btn-approve" style="font-size: 12px;">มี</span>
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                <button onclick="edit_modal({{ $value->id }})" type="button" class="btn btn-icon btn-purple mr-10"
                                                    data-original-title="ดูรายละเอียดและคอมเม้นต์" data-toggle="tooltip" data-toggle="modal" data-target="editApproval">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">comment</span></h4>
                                                </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                        </div>
                    </div>
                </section>
            </div>
        </div>

    {{-- </form> --}}
        <!-- /Row -->
    </div>
    <!-- /Container -->

    <div class="modal fade" id="editApproval" tabindex="-1" role="dialog" aria-labelledby="editApproval" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดข้อมูลการขออนุมัติ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_comment" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ขออนุมัติสำหรับ</label>
                                    <select class="form-control custom-select" name="approved_for" id="get_for" disabled="true">
                                        <option selected disabled>เลือก</option>
                                        <?php $masters = App\ObjectiveAssign::get(); ?>
                                    @foreach ($masters as $value)
                                    <option value="{{$value->id}}">{{$value->masassign_title}}</option>
                                    @endforeach
                                    </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ขออนุมัติ</label>
                                <input class="form-control" type="text" name="assign_request_date" id="get_request_date" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">หัวข้อ / เรื่อง</label>
                                <input class="form-control" name="assign_title" id="get_title" type="text" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ต้องการ</label>
                                <input class="form-control" type="text" name="assign_work_date" id="get_work_date" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" id="get_detail" name="assign_detail"
                                    type="text" readonly></textarea>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="firstName">เรื่องด่วน</label>
                                    <div class="custom-control custom-checkbox">
                                        <div id="customCheck6"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="firstName">การอนุมัติ</label>
                                    <select id="approval_send" class="form-control custom-select" name="approval_send" required>
                                        <option value="">เลือกข้อมูล</option>
                                        <option value="1">อนุมัติ</option>
                                        <option value="4">แก้ไขใหม่</option>
                                        <option value="2">ไม่อนุมัติ</option>
                                    </select>
                                </div>
                        </div>

                        <input type="hidden" name="id" id="get_id">
                        <div>
                            <h5>ความคิดเห็น</h5>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" id="comment" name="comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" type="text" required></textarea>
                        </div>

                        <div class="form-group">
                            <div id="div_comment"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

function edit_modal(id) {
        $.ajax({
            type: "GET",
            url: "{!! url('lead/view_approval/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                console.log(data);
                $('#customCheck6').children().remove().end();
                $('#div_comment').children().remove().end();
                $('#comment').val('');

                $('#get_id').val(data.dataEdit.id);
                $('#get_title').val(data.dataEdit.assign_title);
                $('#get_detail').val(data.dataEdit.assign_detail);
                $('#get_for').val(data.dataEdit.approved_for);
                $('#get_xx').val(data.dataEdit.assign_is_hot);

                let get_request_date = data.dataEdit.assign_request_date.split(" ");
                let get_request_date2 = get_request_date[0].split("-");
                let year_th_request = parseInt(get_request_date2[0])+543;
                let date_request = get_request_date2[2]+"/"+get_request_date2[1]+"/"+year_th_request;
                $('#get_request_date').val(date_request);

                let get_work_date = data.dataEdit.assign_work_date.split("-");
                let year_th_work = parseInt(get_work_date[0])+543;
                let date_work = get_work_date[2]+"/"+get_work_date[1]+"/"+year_th_work;
                $('#get_work_date').val(date_work);

                if(data.dataEdit_comment_edit){
                    $('#comment').val(data.dataEdit_comment_edit.assign_comment_detail);
                }

                if (data.dataEdit.assign_is_hot == 1) {
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck7' name='assign_is_hot' value='1' checked readonly><label class='custom-control-label' for='customCheck7' readonly>ขออนุมัติด่วน</label>");
                }else{
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck8' name='assign_is_hot' value='1' readonly><label class='custom-control-label' for='customCheck8' readonly>ขออนุมัติด่วน</label>");
                }

                if(data.dataEdit_comment){
                    $.each(data['dataEdit_comment'], function(key, value){
                        $('#div_comment').append('<div>Comment by: '+value.user_comment+' Date: '+value.created_at+'</div>');
                        $('#div_comment').append('<div class="alert alert-primary py-20" role="alert">'+value.assign_comment_detail+'</div>');
                    });
                }

                $('#editApproval').modal('toggle');

            }
        });
    }

    $(".btn_click").on("click", function(){
        var btn_val = $(this).val();
        var formData = new FormData();
        formData.append( 'approve', $(this).val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
                // location.reload();
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
    })


        $("#from_general_approve").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            var btn_click = $(this).val();
            console.log(btn_click);
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

    //-- Create Comment
    $("#form_comment").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("lead/create_comment_request_approval") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                //console.log(response);
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
    //-- End Create Comment
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
