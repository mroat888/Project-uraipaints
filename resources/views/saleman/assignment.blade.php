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
                                                <div class="box_search d-flex">
                                                    <span class="txt_search">Search:</span>
                                                        <input type="text" name="" id="" class="form-control form-control-sm" placeholder="ค้นหา">
                                                    </div>

                                                <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกวันที่</button>
                                                <span id="selectdate" style="display:none;">

                                                Date : <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" value="<?= date('Y-m-d'); ?>" />

                                                    to <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" value="<?= date('Y-m-d'); ?>" />

                                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button>
                                                </span>

                                            </span>
                                            <!-- ------ -->
                                        </div>
                                        </div>
                                    </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>เรื่อง</th>
                                                <th>วันที่</th>
                                                <th>ลูกค้า</th>
                                                <th>สถานะ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($assignments as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$value->assign_title}}</td>
                                            <td>{{$value->assign_work_date}}</td>
                                            <td>{{$value->assign_emp_id}}</td>
                                            <td>
                                                @if ($value->assign_result_status == 0)
                                                    <span class="badge badge-soft-danger" style="font-size: 12px;">ยังไม่เสร็จ</span>
                                                    @elseif ($value->assign_result_status == 1)
                                                    <span class="badge badge-soft-info" style="font-size: 12px;">สำเร็จ</span>
                                                    @elseif ($value->assign_result_status == 2)
                                                    <span class="badge badge-soft-danger" style="font-size: 12px;">ไม่สำเร็จ</span>
                                                    @elseif ($value->assign_result_status == 3)
                                                    <span class="badge badge-soft-danger" style="font-size: 12px;">รอตัดสินใจ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="assignment_result({{$value->id}})">
                                                <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
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
                    <h5 class="modal-title">สรุปผล Sale plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('assignment_Result') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="assign_id" id="get_assign_id">
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="get_detail" cols="30" rows="5" placeholder="" name="assign_detail"
                                type="text"> </textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select" id="get_result" name="assign_result">
                                    <option selected>-- กรุณาเลือก --</option>
                                    <option value="1">ไม่สนใจ</option>
                                    <option value="2">รอตัดสินใจ</option>
                                    <option value="3">สนใจ/ตกลง</option>
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
                    $('#get_assign_id').val(data.dataResult.id);
                    $('#get_detail').val(data.dataResult.assign_result_detail);
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
