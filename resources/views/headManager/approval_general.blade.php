@extends('layouts.masterHead')

@section('content')

@php
    $title_header = "ให้ความเห็นการขออนุมัติ";
    $title_header_table = "รายการขออนุมัติ";

    $url_approvalgeneral = "head/approvalgeneral";
    $url_approvalgeneral_history = "head/approvalgeneral/history";
    $action_search = "head/approvalgeneral/search"; //-- action form
@endphp


<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $title_header }}</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container-fluid px-xxl-65 px-xl-20">

    <!-- Title -->
    <div class="hk-pg-header mb-10">
        <div class="topichead-bgred"><i data-feather="file-text"></i> {{ $title_header }}</div>
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
                                <a href="{{ url($url_approvalgeneral) }}" class="nav-link" style="background: rgb(5, 90, 97); color:rgb(255, 255, 255);">รายการรออนุมัติ</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($url_approvalgeneral_history) }}" class="nav-link" style="color: rgb(22, 21, 21);">ประวัติการอนุมัติ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12" style="margin-bottom: 30px;">
                    <h5 class="hk-sec-title">{{ $title_header_table }}</h5>
                </div>
                <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-12">
                            <!-- ------ -->
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

                                <form action="{{ url($action_search) }}" method="post">
                                @csrf
                                <span id="selectdate" >
                                    @if(count($team_sales) > 1)
                                    <select name="selectteam_sales" class="form-control" aria-label=".form-select-lg example">
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
                                    <select name="selectusers" class="form-control" aria-label=".form-select-lg example">
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

                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                                </span>

                                </form>
                                <!-- จบเงื่อนไขการค้นหา -->

                            </span>
                            <!-- ------ -->
                        </div>
                    </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-responsive-sm table-color">
                            <table id="datable_1" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ผู้แทนขาย</th>
                                        <th>เรื่องด่วน</th>
                                        <th>เรื่องขออนุมัติ</th>
                                        <th>ชื่อร้าน</th>
                                        <th>วันที่ขออนุมัติ</th>
                                        <th>การอนุมัติ</th>
                                        <th>ความคิดเห็น</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments_history as $key => $assignments)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $assignments->name }}</td>
                                        <td>
                                            @if($assignments->assign_is_hot == "1")
                                                <span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>
                                            @endif
                                        </td>
                                        <td>{{ $assignments->assign_title }}</td>
                                        <td>{{ $assignments->api_customers_title }} {{ $assignments->api_customers_name }}</td>
                                        <td>
                                            {{Carbon\Carbon::parse($assignments->assign_request_date)->addYear(543)->format('d/m/Y')}}
                                        </td>
                                        <td>
                                            @php
                                                $status = "";
                                                switch($assignments->assign_status){
                                                    case "0" : $status = '<span class="badge badge-soft-warning" style="font-size: 12px;">Padding</span>';
                                                        break;
                                                    case "4" : $status = '<span class="badge badge-soft-danger" style="font-size: 12px;">Re-write</span>';
                                                        break;
                                                }
                                            @endphp
                                            <?php echo $status; ?>
                                        </td>
                                        <td>
                                            @if ($assignments->assign_id)
                                                <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button onclick="edit_modal({{ $assignments->id }})" type="button" class="btn btn-icon btn-violet mr-10"
                                                data-original-title="ดูรายละเอียดและคอมเม้นต์" data-toggle="tooltip" data-toggle="modal" data-target="editApproval">
                                                <i data-feather="message-square"></i>
                                            </button>
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
    <!-- /Row -->
</div>
<!-- /Container -->


<!-- Modal Edit -->
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
                            <input class="form-control" placeholder="กรุณาใส่หัวข้อ / เรื่อง" name="assign_title" id="get_title" type="text" readonly>
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
                    </div>

                    <input type="hidden" name="id" id="get_id">
                    <div>
                        <h5>ความคิดเห็น</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" id="comment" name="comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" type="text"></textarea>
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

<script>
    //Edit
    function edit_modal(id) {
        $.ajax({
            type: "GET",
            url: "{!! url('head/view_approval/"+id+"') !!}",
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
                        let get_created_at = data.dataEdit.created_at.split(" ");
                        let get_created_at2 = get_created_at[0].split("-");
                        let year_th_create = parseInt(get_created_at2[0])+543;
                        let date_create = get_created_at2[2]+"/"+get_created_at2[1]+"/"+year_th_create;

                        $('#div_comment').append('<div>Comment by: '+value.user_comment+' Date: '+date_create+'</div>');
                        $('#div_comment').append('<div class="alert alert-primary py-20" role="alert">'+value.assign_comment_detail+'</div>');
                    });
                }

                let get_work_date = data.dataEdit.assign_work_date.split("-");
                let year_th_work = parseInt(get_work_date[0])+543;
                let date_work = get_work_date[2]+"/"+get_work_date[1]+"/"+year_th_work;
                $('#get_work_date').val(date_work);

                let get_request_date = data.dataEdit.assign_request_date.split(" ");
                let get_request_date2 = get_request_date[0].split("-");
                let year_th_request = parseInt(get_request_date2[0])+543;
                let date_request = get_request_date2[2]+"/"+get_request_date2[1]+"/"+year_th_request;
                $('#get_request_date').val(date_request);


                $('#editApproval').modal('toggle');

            }
        });
    }
    //Edit


    //-- Create Comment
    $("#form_comment").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("head/create_comment_request_approval") }}',
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

@endsection('content')
