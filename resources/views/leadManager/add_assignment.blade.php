@extends('layouts.masterLead')

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
                        <div class="row">
                            <div class="col-sm">
                                <ul class="nav nav-pills nav-fill bg-light pa-10 mb-40" role="tablist">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link" style="background: rgb(5, 90, 97); color:rgb(255, 255, 255);">สั่งงานผู้แทนขาย</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('lead/get_assignment')}}" class="nav-link" style="color: rgb(22, 21, 21);">งานที่ได้รับมอบหมาย</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12" style="margin-bottom: 30px;">
                            <h5 class="hk-sec-title">รายการสั่งงานผู้แทนขาย</h5>
                        </div>
                    <div class="row" style="margin-bottom: 30px;">
                        <div class="col-sm-12 col-md-12">
                             <!-- ------ -->
                             <span class="form-inline pull-right pull-sm-center">
                                <form action="{{ url('lead/search_month_add-assignment') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <span id="selectdate">
                                {{-- @if (count($team_sales) > 1)
                                    <select name="selectteam_sales" class="form-control mr-2"
                                       >
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
                                @endif --}}
                                {{-- <select name="selectusers" class="form-control">
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
                                </select> --}}

                                    @if(count($team_sales) >= 1)
                                    <select name="selectteam_sales" class="form-control">
                                        <option value="" selected>เลือกทีม</option>
                                            @foreach($team_sales as $team)
                                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                            @endforeach
                                    </select>
                                    @endif

                                    <select name="selectusers" class="form-control">
                                        <option value="" selected>ผู้แทนขาย</option>
                                        @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="month" value="" class="form-control" style="margin-left:10px; margin-right:10px;" id="" name="selectdateTo"/>
                                <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-green">ค้นหา</button>

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
                                            <th>ผู้แทนขาย</th>
                                            <th>วันที่กำหนดส่ง</th>
                                            <th>สถานะ</th>
                                            <th>ประเมินผล</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assignments as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$value->assign_title}}</td>
                                            <td>
                                                @php
                                                    $assign_file = App\Assignment_gallery::where('assignment_id', $value->id)->where('status', 0)->first();
                                                @endphp
                                                <a href="{{url('lead/assignment_view_image', $value->id)}}">
                                                    <img src="{{ isset($assign_file->image) ? asset('public/upload/AssignmentFile/' . $assign_file->image) : '' }}" width="50">
                                                </a>
                                            </td>
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
                                                <div class="button-list">
                                                @if ($value->assign_result_status == 0)
                                                <button onclick="edit_modal({{ $value->id }})" class="btn btn-icon btn-edit mr-10" data-toggle="modal" data-target="#modalEdit">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">drive_file_rename_outline</span></h4>
                                                </button>
                                                <a href="{{url('lead/assignment_file', $value->id)}}" class="btn btn-icon btn-purple" value="{{ $value->id }}">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                        class="material-icons">collections</span></h4>
                                                </a>
                                                <button id="btn_assign_delete" class="btn btn-icon btn-danger" value="{{ $value->id }}">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">delete_outline</span></h4>
                                                </button>

                                                @else
                                                <button class="btn btn-icon btn-summarize" data-toggle="modal" data-target="#ModalResult" onclick="show_result({{$value->id}})">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">library_books</span></h4>
                                                </button>
                                                <a href="{{url('lead/assignment_file', $value->id)}}" class="btn btn-icon btn-purple" value="{{ $value->id }}">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                        class="material-icons">collections</span></h4>
                                                </a>
                                                @endif
                                            </div>
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
                    <h5 class="modal-title">เพิ่มบันทึกการสั่งงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <form id="from_createassign" enctype="multipart/form-data">
                {{-- <form action="{{url('/lead/create_assignment')}}" method="POST" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="firstName">เรื่อง</label>
                            <input class="form-control" name="assign_title" placeholder="กรุณาใส่ชื่อเรื่อง" type="text">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="firstName">วันที่กำหนดส่ง</label>
                            <input class="form-control" type="date" name="date" min="{{date('Y-m-d')}}" />
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
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="" name="assign_detail"
                                    type="text" required> </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <input type="file" name="assignment_fileupload[]" class="form-control" multiple>
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
                    <h5 class="modal-title">แก้ไขบันทึกการสั่งงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form action="{{ url('lead/update_assignment') }}" method="post" enctype="multipart/form-data"> -->
                <form id="from_updateassign" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="get_id">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">เรื่อง</label>
                            <input class="form-control" name="assign_title" id="get_title" type="text">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="firstName">วันที่</label>
                            <input class="form-control" type="date" name="date" id="get_date" min="{{date('Y-m-d')}}"/>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" id="get_detail" name="assign_detail"
                                    type="text" required> </textarea>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <input type="file" name="assignment_fileupload_update" id="assignment_fileupload_update" class="form-control">
                                <div id="img_show" class="mt-5"></div>
                            </div> --}}
                            <div class="col-md-12 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <select class="form-control custom-select select2" name="assign_emp_id_edit" id="get_emp" required>
                                    <option value="" disabled>กรุณาเลือก</option>
                                </select>
                            </div>
                        {{-- </div> --}}
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
                    <input type="hidden" name="id" id="get_id_text_send">
                        <div class="form-group">
                            <label for="firstName">เรื่อง : </label>
                            <span id="get_title_text"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด : </label>
                                <span id="get_detail_text"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ปฎิบัติ : </label>
                                <span id="get_date_text"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สั่งงานให้ : </label>
                                <span id="get_emp_text"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ไฟล์เอกสาร : </label>
                                <div id="img_show_text" class="mt-5"></div>
                            </div>
                        </div>
                    </section>

                    <section class="hk-sec-wrapper">
                        <h6><span id="get_emp_send"></span></h6><br>
                        <div class="form-group">
                            <label for="firstName">เรื่อง : </label>
                            <span id="get_title_text_send"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด : </label>
                                <span id="get_detail_text_send"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ปฎิบัติ : </label>
                                <span id="get_date_text_send"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <span id="get_emp_text_send"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <div id="img_show_text_send" class="mt-5"></div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Saleplan -->
    <div class="modal fade" id="ModalAssignDelete" tabindex="-1" role="dialog" aria-labelledby="ModalAssignDelete"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_assign_delete" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบข้อมูลการสั่งงานใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบข้อมูลการสั่งงานใช่หรือไม่ ?</h3>
                        <input class="form-control" id="assign_id_delete" name="assign_id_delete" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).on('click', '#btn_assign_delete', function() { // ปุ่มลบ Slaplan
            let assign_id_delete = $(this).val();
            $('#assign_id_delete').val(assign_id_delete);
            $('#ModalAssignDelete').modal('show');
        });

        $("#from_assign_delete").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('lead/delete_assignment') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: "ลบข้อมูลสั่งงานเรียบร้อยแล้ว",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalAssignDelete').modal('hide');
                    $('#btn_assign_delete').prop('disabled', true);
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });

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
                    // $('#get_date_text').text(data.dataEdit.assign_work_date);
                    $('#get_title_text').text(data.dataEdit.assign_title);
                    $('#get_detail_text').text(data.dataEdit.assign_detail);

                    $('#img_show_text_send').children().remove().end();
                    $('#result_send').children().remove().end();
                    $('#get_id_text_send').val(data.dataEdit.id);
                    // $('#get_date_text_send').text(data.dataEdit.assign_work_date);
                    $('#get_title_text_send').text(data.dataEdit.assign_title);
                    $('#get_detail_text_send').text(data.dataEdit.assign_result_detail);

                    let work_date = data.dataEdit.assign_work_date.split("-");
                    let year_th = parseInt(work_date[0])+543;
                    let date_work = work_date[2]+"/"+work_date[1]+"/"+year_th;

                    $('#get_date_text').text(date_work);
                    $('#get_date_text_send').text(date_work);

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

                    $.each(data.dataGallery, function(key, value){
                    let img_name = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataGallery[key]['image'];
                    if(data.dataGallery[key]['image'] != ""){
                        ext = data.dataGallery[key]['image'].split('.').pop().toLowerCase();
                        console.log(img_name);
                        if(ext == "pdf"){
                            $('#img_show_text').append('<span><a href="'+img_name+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                        }else{
                            $('#img_show_text').append('<a href="'+img_name+'" target="_blank"><img src = "'+img_name+'" style="max-width:30%;"></a>');
                        }
                    }
                });

                    let img_name_send = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataEdit.assign_result_fileupload;
                    if(data.dataEdit.assign_result_fileupload != ""){
                        ext = data.dataEdit.assign_result_fileupload.split('.').pop().toLowerCase();
                        console.log(img_name_send);
                        if(ext == "pdf"){
                            $('#img_show_text_send').append('<span><a href="'+img_name_send+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                        }else{
                            $('#img_show_text_send').append('<img src = "'+img_name_send+'" style="max-width:30%;">');
                        }
                    }

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

                    if(data.dataEdit.assign_fileupload){
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


    $("#from_updateassign_status_result").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/lead/update_assignment_status_result") }}',
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

