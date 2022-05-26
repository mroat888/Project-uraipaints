@extends('layouts.masterHead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">สั่งงานผู้แทนขาย</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><span class="pg-title-icon"><i class="ion ion-md-create"></i></span> สั่งงานผู้แทนขาย</div>
            <div class="content-right d-flex">
                <button type="button" class="btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">

                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">รายการสั่งงานผู้แทนขาย</h5>
                        </div>
                        <div class="col-sm-12 col-md-9">
                            <!-- ------ -->

                            <span class="form-inline pull-right pull-sm-center">
                                <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</button>
                                <form action="{{ url('head/search_month_add-assignment') }}" method="post" enctype="multipart/form-data">
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

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm table-color">
                                <table id="datable_1" class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>เรื่อง</th>
                                            <th>รูปภาพ</th>
                                            <th>ชื่อผู้แทนขาย</th>
                                            <th>วันที่กำหนดส่ง</th>
                                            <th>สถานะ</th>
                                            <th>การประเมินผล</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assignments as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td style="text-align:left;">{{$value->assign_title}}</td>
                                            <td><img src="{{ isset($value->assign_fileupload) ? asset('public/upload/AssignmentFile/' . $value->assign_fileupload) : '' }}" width="50"></td>
                                            <td>{{$value->name}}</td>
                                            <td>{{Carbon\Carbon::parse($value->assign_work_date)->addYear(543)->format('d/m/Y')}}</td>
                                            <td>
                                                @if ($value->assign_result_status == 0)
                                                    @if ($value->assign_work_date < Carbon\Carbon::today()->format('Y-m-d'))
                                                    <span class="btn-expired" style="font-size: 12px;">Expired</span>
                                                        @else
                                                        <span class="btn-draf" style="font-size: 12px;">รอดำเนินการ</span>
                                                    @endif
                                                @elseif ($value->assign_result_status == 1 || $value->assign_result_status == 2 || $value->assign_result_status == 3)
                                                <span class="btn-approve" style="font-size: 12px;">ดำเนินการแล้ว</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->assign_result_status == 1)
                                                    <span class="btn-approve" style="font-size: 12px;">สำเร็จ</span>
                                                    @elseif ($value->assign_result_status == 2)
                                                    <span class="btn-failed" style="font-size: 12px;">ไม่สำเร็จ</span>
                                                    @else
                                                    <span style="font-size: 12px;">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->assign_result_status == 0 && $value->assign_work_date >= Carbon\Carbon::today()->format('Y-m-d'))
                                                    <button onclick="edit_modal({{ $value->id }})" class="btn btn-icon btn-warning" data-toggle="modal" data-target="#modalEdit">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">drive_file_rename_outline</span></h4>
                                                    </button>
                                                    <a href="{{url('head/delete_assignment', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">delete_outline</span></h4>
                                                    </a>

                                                @else
                                                <div class="button-list">
                                                        <button class="btn btn-icon btn-summarize" data-toggle="modal" data-target="#ModalResult" onclick="show_result({{$value->id}})">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">library_books</span></h4>
                                                    </button>
                                                        </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มบันทึกการสั่งงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <form id="from_createassign" enctype="multipart/form-data">
                {{-- <form action="{{url('/lead/create_assignment')}}" method="POST" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <label for="firstName">เรื่อง</label>
                            <input class="form-control" name="assign_title" placeholder="กรุณาใส่ชื่อเรื่อง" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="" name="assign_detail"
                                    type="text" required> </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่</label>
                                <input class="form-control" type="date" name="date" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <input type="file" name="assignment_fileupload" id="assignment_fileupload" class="form-control">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple" data-placeholder="Choose" name="assign_emp_id[]" required>
                                    <optgroup label="เลือกข้อมูล">
                                        @foreach($users as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                    </optgroup>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขข้อมูลการสั่งงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form action="{{ url('head/update_assignment') }}" method="post" enctype="multipart/form-data"> -->
                <form id="from_updateassign" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="get_id">
                        <div class="form-group">
                            <label for="firstName">เรื่อง</label>
                            <input class="form-control" name="assign_title" id="get_title" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" id="get_detail" name="assign_detail"
                                    type="text" required> </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่</label>
                                <input class="form-control" type="date" name="date" id="get_date"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <input type="file" name="assignment_fileupload_update" id="assignment_fileupload_update" class="form-control">
                                <div id="img_show" class="mt-5"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <select class="form-control custom-select select2" name="assign_emp_id_edit" id="get_emp" required>
                                    <option value="" disabled>กรุณาเลือก</option>
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

    <!-- Modal Detail Result -->
    <div class="modal fade" id="ModalResult" tabindex="-1" role="dialog" aria-labelledby="ModalResult"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="from_updateassign_status_result" enctype="multipart/form-data">
                {{-- <form action="{{url('admin/update_assignment_status_result')}}" method="POST" enctype="multipart/form-data"> --}}
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดการดำเนินงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="hk-sec-wrapper" style="background: rgb(190, 190, 190);">
                        <h6>ผู้จัดการฝ่ายสั่งงาน</h6><br>
                    <input type="hidden" name="id" id="get_id_text_send">
                        <div class="form-group">
                            <label for="firstName">เรื่อง</label>
                            <span id="get_title_text"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด</label>
                                <span id="get_detail_text"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่</label>
                                <span id="get_date_text"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <div id="img_show_text" class="mt-5"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <span id="get_emp_text"></span>
                            </div>
                        </div>
                    </section>

                    <section class="hk-sec-wrapper">
                        <h6><span id="get_emp_send"></span></h6><br>
                        <div class="form-group">
                            <label for="firstName">เรื่อง</label>
                            <span id="get_title_text_send"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด</label>
                                <span id="get_detail_text_send"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่</label>
                                <span id="get_date_text_send"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <div id="img_show_text_send" class="mt-5"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <span id="get_emp_text_send"></span>
                            </div>
                        </div>
                    </section>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="username">สรุปผลลัพธ์</label>
                            <select id="result_send" class="form-control custom-select" name="result_send" required>
                                <option value="">เลือกข้อมูล</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        //Show
        function show_result(id){
            $.ajax({
                type: "GET",
                url: '{{ url("head/edit_assignment/") }}/'+id,
                dataType: "JSON",
                async: false,
                success: function(data) {
                    console.log(data);
                    $('#img_show_text').children().remove().end();
                    $('#get_date_text').text(data.dataEdit.assign_work_date);
                    $('#get_title_text').text(data.dataEdit.assign_title);
                    $('#get_detail_text').text(data.dataEdit.assign_detail);

                    $('#img_show_text_send').children().remove().end();
                    $('#result_send').children().remove().end();
                    $('#get_id_text_send').val(data.dataEdit.id);
                    $('#get_date_text_send').text(data.dataEdit.assign_work_date);
                    $('#get_title_text_send').text(data.dataEdit.assign_title);
                    $('#get_detail_text_send').text(data.dataEdit.assign_result_detail);

                    let img_name = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataEdit.assign_fileupload;
                    if(data.dataEdit.assign_fileupload != ""){
                        ext = data.dataEdit.assign_fileupload.split('.').pop().toLowerCase();
                        console.log(img_name);
                        if(ext == "pdf"){
                            $('#img_show_text').append('<span><a href="'+img_name+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                            $('#img_show_text_send').append('<span><a href="'+img_name+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                        }else{
                            $('#img_show_text').append('<img src = "'+img_name+'" style="max-width:100%;">');
                            $('#img_show_text_send').append('<img src = "'+img_name+'" style="max-width:100%;">');
                        }
                    }

                    $.each(data.dataUser, function(key, value){
                        if(value.id == data.dataEdit.assign_emp_id){
                            $('#get_emp_text').text(value.name);
                            $('#get_emp_text_send').text(value.name);

                            if (value.status == 1) {
                            $('#get_emp_send').text("ผู้แทนขายส่งงาน");
                        }if (value.status == 2) {
                            $('#get_emp_send').text("ผู้จัดการเขตส่งงาน");
                        }if (value.status == 3) {
                            $('#get_emp_send').text("ผู้จัดการฝ่ายส่งงาน");
                        }
                        }
                    });

                if (data.dataEdit.assign_result_status == 1) {
                $('#result_send').append('<option value='+data.dataEdit.assign_result_status+' selected>สำเร็จ</option> <option value="2">ไม่สำเร็จ</option>');
                }
                if (data.dataEdit.assign_result_status == 2){
                    $('#result_send').append('<option value='+data.dataEdit.assign_result_status+' selected>ไม่สำเร็จ</option> <option value="1">สำเร็จ</option>');
                }
                if (data.dataEdit.assign_result_status == 3 || data.dataEdit.assign_result_status == 0){
                    $('#result_send').append('<option value="" selected>เลือกข้อมูล</option> <option value="2">ไม่สำเร็จ</option> <option value="1">สำเร็จ</option>');
                }

                    $('#ModalResult').modal('toggle');
                }
            });
        }
        //Edit
        function edit_modal(id) {
            $.ajax({
                type: "GET",
                url: '{{ url("head/edit_assignment/") }}/'+id,
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_emp').children().remove().end();
                    $('#img_show').children().remove().end();

                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.assign_work_date);
                    $('#get_title').val(data.dataEdit.assign_title);
                    $('#get_detail').val(data.dataEdit.assign_detail);

                    let img_name = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataEdit.assign_fileupload;
                    if(data.dataEdit.assign_fileupload != ""){
                        ext = data.dataEdit.assign_fileupload.split('.').pop().toLowerCase();
                        console.log(img_name);
                        if(ext == "pdf"){
                            $('#img_show').append('<span><a href="'+img_name+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                        }else{
                            $('#img_show').append('<img src = "'+img_name+'" style="max-width:100%;">');
                        }
                    }

                    $.each(data.dataUser, function(key, value){
                        if(value.id == data.dataEdit.assign_emp_id){
                            $('#get_emp').append('<option value='+value.id+' selected>'+value.name+'</option>');
                        }else{
                            $('#get_emp').append('<option value='+value.id+'>'+value.name+'</option>');
                        }
                    });

                    $('#modalEdit').modal('toggle');
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#searchShop').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "lead/searchShop",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        // $('#search_list').html(data);
                    $('#get_id').val(data.id);
                    $('#get_contact_name').val(data.contact_name);
                    $('#get_phone').val(data.shop_phone);
                    $('#get_address').val(data.shop_address);
                    }
                });
                // end of ajax call
            });
        });
    </script>

<script>
    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }


    function showselectdate() {
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate() {
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }
</script>

<script>
    $("#from_createassign").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/head/create_assignment") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#exampleModalLarge01").modal('hide');
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

    $("#from_updateassign").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/head/update_assignment") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#modalEdit").modal('hide');
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

    $("#from_updateassign_status_result").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/head/update_assignment_status_result") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#modalEdit").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                        text: "บันทึกข้อมูลสรุปผลการสั่งงานเรียบร้อยแล้ว",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                        text: "ไม่สามารถบันทึกข้อมูลสรุปผลการสั่งงานได้",
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

</script>


@endsection

@section('footer')
    @include('layouts.footer')
@endsection('footer')

