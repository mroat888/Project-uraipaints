@extends('layouts.masterLead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">บันทึกการสั่งงาน</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title mt-40"><span class="pg-title-icon"><i
                            class="ion ion-md-document"></i></span>ตารางบันทึกการสั่งงาน</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal"
                    data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">

                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ตารางบันทึกการสั่งงาน</h5>
                        </div>
                        <div class="col-sm-12 col-md-9">
                             <!-- ------ -->

                             <span class="form-inline pull-right pull-sm-center">
                                <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</button>
                                <form action="{{ url('lead/search_month_add-assignment') }}" method="post" enctype="multipart/form-data">
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
                            <div class="table-responsive-sm">
                                <table id="datable_1" class="table table-sm table-hover">
                                    <thead align="center">
                                        <tr>
                                            <th>#</th>
                                            <th style="text-align:left">เรื่อง</th>
                                            <th>วันที่</th>
                                            <th>พนักงาน</th>
                                            <th>สถานะ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody align="center">
                                        @foreach ($assignments as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td style="text-align:left">
                                                {{$value->assign_title}}
                                                @if (!is_null($value->assign_result_status) || $value->assign_result_status != "")
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                    class="feather feather-paperclip">
                                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                                    </svg>
                                                @endif
                                            </td>
                                            <td>{{$value->assign_work_date}}</td>
                                            <td>{{$value->name}}</td>
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
                                                @if ($value->assign_result_status == 0)
                                                <button onclick="edit_modal({{ $value->id }})"
                                                    class="btn btn-icon btn-warning mr-10" data-toggle="modal"
                                                    data-target="#modalEdit">
                                                    <span class="btn-icon-wrap"><i
                                                            data-feather="edit"></i></span></button>
                                                <a href="{{url('lead/delete_assignment', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                    <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></a>

                                                @else
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-neon" data-toggle="modal"
                                                        data-target="#ModalResult"
                                                        onclick="show_result({{$value->id}})">
                                                        <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
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
                                <input class="form-control" type="date" name="date" min="{{date('Y-m-d')}}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <input type="file" name="assignment_fileupload" id="assignment_fileupload" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">สั่งงานให้
                                    <div class="custom-control custom-checkbox checkbox-info mt-2">
                                        <input type="checkbox" class="custom-control-input"
                                            id="customCheck4" name="CheckAll" value="Y">
                                        <label class="custom-control-label"
                                            for="customCheck4">ทั้งหมด</label>
                                    </div>
                            </label>
                                <select class="select2 select2-multiple form-control" multiple="multiple" data-placeholder="Choose" name="assign_emp_id[]" >
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
                <!-- <form action="{{ url('lead/update_assignment') }}" method="post" enctype="multipart/form-data"> -->
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
                                <input class="form-control" type="date" name="date" id="get_date" min="{{date('Y-m-d')}}"/>
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

    <!-- Modal detail Result -->
    <div class="modal fade" id="ModalResult" tabindex="-1" role="dialog" aria-labelledby="ModalResult"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดการดำเนินงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="get_id">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        //Show
        function show_result(id){
            $.ajax({
                type: "GET",
                url: '{{ url("lead/edit_assignment/") }}/'+id,
                dataType: "JSON",
                async: false,
                success: function(data) {
                    console.log(data);
                    $('#img_show_text').children().remove().end();
                    $('#get_date_text').text(data.dataEdit.assign_work_date);
                    $('#get_title_text').text(data.dataEdit.assign_title);
                    $('#get_detail_text').text(data.dataEdit.assign_detail);

                    let img_name = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataEdit.assign_fileupload;
                    if(data.dataEdit.assign_fileupload != ""){
                        ext = data.dataEdit.assign_fileupload.split('.').pop().toLowerCase();
                        console.log(img_name);
                        if(ext == "pdf"){
                            $('#img_show_text').append('<span><a href="'+img_name+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                        }else{
                            $('#img_show_text').append('<img src = "'+img_name+'" style="max-width:100%;">');
                        }
                    }

                    $.each(data.dataUser, function(key, value){
                        if(value.id == data.dataEdit.assign_emp_id){
                            $('#get_emp_text').text(value.name);
                        }
                    });

                    $('#ModalResult').modal('toggle');
                }
            });
        }
        //Edit
        function edit_modal(id) {
            $.ajax({
                type: "GET",
                url: '{{ url("lead/edit_assignment/") }}/'+id,
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_emp').children().remove().end();
                    $('#img_show').children().remove().end();

                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.assign_work_date);
                    $('#get_title').val(data.dataEdit.assign_title);
                    $('#get_detail').val(data.dataEdit.assign_detail);
                    // $('#get_emp').val(data.dataEdit.assign_emp_id);

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
            url: '{{ url("/lead/create_assignment") }}',
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
            url: '{{ url("/lead/update_assignment") }}',
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

</script>


@endsection

@section('footer')
    @include('layouts.footer')
@endsection('footer')

