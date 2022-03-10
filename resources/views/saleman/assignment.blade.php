@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">งานที่ได้รับมอบหมาย</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
     <div class="container-fluid px-xxl-65 px-xl-20">
         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-clipboard"></i></span>ตารางงานที่ได้รับมอบหมาย</h4>
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

                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <h5 class="hk-sec-title">ตารางงานที่ได้รับมอบหมาย</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10">
                                        <div>
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <!-- ------ -->

                                            <span class="form-inline pull-right pull-sm-center">
                                                <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</button>
                                                <form action="{{ url('search_month_assignment') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                <span id="selectdate" style="display:none;">

                                                    เดือน : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" name="fromMonth"/>

                                                    ถึงเดือน : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name="toMonth"/>

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
                                                <th>เรื่อง</th>
                                                <th>วันที่</th>
                                                {{-- <th>ลูกค้า</th> --}}
                                                <th>สถานะ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:center;">
                                            @foreach ($assignments as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$value->assign_title}}</td>
                                            <td>{{$value->assign_work_date}}</td>
                                            {{-- <td>{{$value->name}}</td> --}}
                                            <td>
                                                @if ($value->assign_result_status == 0)
                                                    <span class="badge badge-soft-secondary" style="font-size: 12px;">รอดำเนินการ</span>
                                                    @elseif ($value->assign_result_status == 1)
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">สำเร็จ</span>
                                                    @elseif ($value->assign_result_status == 2)
                                                    <span class="badge badge-soft-danger" style="font-size: 12px;">ไม่สำเร็จ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                    @php 
                                                        if($value->assign_work_date < date('Y-m-d')){
                                                            $btn_disabled = "disabled";
                                                        }else{
                                                            $btn_disabled = "";
                                                        }
                                                    @endphp
                                                    <button class="btn btn-icon btn-teal mr-10" data-toggle="modal" data-target="#ModalResult" onclick="assignment_result({{$value->id}})" {{ $btn_disabled }}>
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                class="ion ion-md-book"></i></h4>
                                                    </button>
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

     <!-- Modal Result -->
<div class="modal fade" id="ModalResult" tabindex="-1" role="dialog" aria-labelledby="ModalResult" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผลงานที่ได้รับมอบหมาย</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card">
                        <div class="card-body">
                            <h5 id="header_title" class="card-title"></h5>
                            <div class="my-3"><span>ผู้สั่งงาน : </span><span id="get_assign_approve_id"></span></div>
                            <div class="my-3"><span>วันที่ปฎิบัติ : </span><span id="get_assign_work_date"></span></div>

                            <div class="my-3">
                                <p>รายละเอียด : </p>
                                <p  id="get_detail" class="card-text"></p>
                            </div>
                            <div class="my-3" id="img_show"></div>
                        </div>
                    </div>

                    <form action="{{ url('assignment_Result') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="assign_id" id="get_assign_id">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select" id="get_result" name="assign_result" required>
                                    <option selected value="">-- กรุณาเลือก --</option>
                                    <option value="1">สำเร็จ</option>
                                    <option value="2">ไม่สำเร็จ</option>
                                </select>
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

    <script>
        //Edit
        function assignment_result(id) {
            // $("#get_assign_id").val(id);
            $.ajax({
                type: "GET",
                url: "{!! url('assignment_result_get/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    console.log(data);
                    $('#img_show').children().remove().end();

                    $('#get_assign_id').val(data.dataResult.id);
                    $('#get_detail').text(data.dataResult.assign_detail);
                    $('#header_title').text(data.dataResult.assign_title);
                    $('#get_assign_work_date').text(data.dataResult.assign_work_date);
                    $('#get_assign_approve_id').text(data.emp_approve.name);

                    let img_name = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataResult.assign_fileupload;
                    if(data.dataResult.assign_fileupload != ""){
                        ext = data.dataResult.assign_fileupload.split('.').pop().toLowerCase();
                        console.log(img_name);
                        if(ext == "pdf"){
                            $('#img_show').append('<span><a href="'+img_name+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                        }else{
                            $('#img_show').append('<img src = "'+img_name+'" style="max-width:100%;">');
                        }
                    }

                    if (data.dataResult.assign_result_status != 0) {
                        $('#get_result').val(data.dataResult.assign_result_status);
                    }

                    $('#ModalResult').modal('toggle');
                }
            });
        }
    </script>

    <script>
        var x = document.getElementById("demo");

        function getLocation(id) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
            $("#id").val(id);
        }

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
            $("#lat").val(position.coords.latitude);
            $("#lon").val(position.coords.longitude);
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    reak;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }
    </script>


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
