@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายการสั่งงาน</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
     <div class="container-fluid px-xxl-65 px-xl-20">
         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-clipboard"></i></span>รายการสั่งงาน</h4>
            </div>
            <div class="d-flex">
                {{-- <button type="button" class="btn btn-primary btn-sm btn-rounded px-3" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button> --}}
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">

                        <!-- <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <h5 class="hk-sec-title">ตารางรายการสั่งงาน</h5>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10">
                                        <div>
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <!-- ------ -->

                                            <span class="form-inline pull-right pull-sm-center">
                                                <!-- <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</button> -->
                                                <form action="{{ url('search_month_assignment') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                <span id="selectdate" >

                                                    เดือน : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" name="fromMonth"/>

                                                    ถึง : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name="toMonth"/>

                                                <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm">ค้นหา</button>

                                                {{-- <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button> --}}
                                                </span>
                                            </form>
                                            </span>
                                            <!-- ------ -->
                                        </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table id="datable_1" class="table table-hover">
                                        <thead style="text-align:center;">
                                            <tr>
                                                <th>#</th>
                                                <th style="width:10%">ไฟล์แนบ</th>
                                                <th style="text-align:left">เรื่อง</th>
                                                <th>วันกำหนดส่ง</th>
                                                <th>สถานะ</th>
                                                <th>ประเมินผล</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:center;">
                                            @foreach ($assignments as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>
                                                @if ($value->assign_fileupload)
                                                    <img class="card-img"
                                                    src="{{ isset($value->assign_fileupload) ? asset('public/upload/AssignmentFile/' . $value->assign_fileupload) : '' }}"
                                                    alt="{{ $value->assign_title }}"
                                                    style="max-width:80%;">
                                                <!-- <span class="badge badge-soft-secondary" style="font-size: 12px;">ไม่มี</span> -->
                                                @endif
                                            </td>
                                            <td style="text-align:left">{{$value->assign_title}}</td>
                                            <td>{{$value->assign_work_date}}</td>
                                            <td>
                                                @if ($value->assign_result_status == 0)
                                                    <span class="badge badge-soft-secondary" style="font-size: 12px;">รอดำเนินการ</span>
                                                @elseif ($value->assign_result_status == 3)
                                                    <span class="badge badge-soft-warning" style="font-size: 12px;">ดำเนินการแล้ว</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->assign_result_status == 1)
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">สำเร็จ</span>
                                                    @elseif ($value->assign_result_status == 2)
                                                    <span class="badge badge-soft-danger" style="font-size: 12px;">ไม่สำเร็จ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                    @php
                                                        if(($value->assign_result_status != 0) || ($value->assign_work_date < date('Y-m-d'))){
                                                            $btn_disabled = "disabled";
                                                            $btn_result_hidden = "hidden='hidden'";
                                                            $btn_result_show_hidden = "";
                                                        }else{
                                                            $btn_disabled = "";
                                                            $btn_result_hidden = "";
                                                            $btn_result_show_hidden = "hidden='hidden'";
                                                        }
                                                    @endphp
                                                    <button class="btn btn-icon btn-teal mr-10" data-toggle="modal" 
                                                        data-target="#ModalResult" 
                                                        onclick="assignment_result({{$value->id}})" {{ $btn_result_hidden }}>
                                                        <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i class="ion ion-md-book"></i></h4>
                                                    </button>
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-neon" data-toggle="modal"
                                                        data-target="#ModalResult_show"
                                                        onclick="assignment_show_result({{$value->id}})" {{ $btn_result_show_hidden }}>
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i
                                                            class="ion ion-md-list"></i></h4></button>
                                                        </div>
                                                </div>
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


@include('union.assignment_modal_submitwork')
@include('union.assignment_modal_showresult')


<script>
    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }

    function showselectdate(){
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }

</script>

@endsection
