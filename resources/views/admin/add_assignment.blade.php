@extends('layouts.masterAdmin')

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
                            <span class="form-inline pull-right">
                                <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</button>
                                <form action="{{ url('admin/search_month_add-assignment') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <span id="selectdate" style="display:none;">
                                         <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name ="selectdateTo" value="<?= date('Y-m-d'); ?>" required/>

                                        <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button>
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
                                    <thead style="text-align:center;">
                                        <tr>
                                            <th>#</th>
                                            <th>เรื่อง</th>
                                            <th>วันที่</th>
                                            <th>พนักงาน</th>
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
                                                    <a href="{{url('admin/delete_assignment', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                        <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></a>
                                                @else
                                                    <button  onclick="show_result({{ $value->id }})" 
                                                        class="btn btn-icon btn-neon" data-toggle="modal" 
                                                        data-target="#ModalResult" >
                                                        <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
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
                @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <label for="firstName">เรื่อง</label>
                            <input class="form-control" name="assign_title" placeholder="กรุณาใส่ชื่อเรื่อง" type="text" required>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="รายละเอียด" name="assign_detail"
                                    type="text" required> </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่</label>
                                <input class="form-control" type="date" name="date" required/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <input type="file" name="assignment_fileupload" id="assignment_fileupload" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">เลือกชื่อผู้จัดการเขต</label>
                                <!-- <input class="form-control" name="visit_result_status" id="searchTeam" type="text"> -->
                                <select id="sel_manager" class="form-control custom-select select2 " name="assign_manager" required>
                                    <option selected>-- กรุณาเลือก --</option>
                                    @foreach ($managers as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <select id="sel_saleman" class="select2 select2-multiple form-control" multiple="multiple" data-placeholder="Choose" name="assign_emp_id[]" required>

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
                                <textarea class="form-control" cols="30" rows="5" id="get_detail" name="assign_detail_edit"
                                    type="text" required> </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่</label>
                                <input class="form-control" type="date" name="date" id="get_date"/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <input type="file" name="assignment_fileupload_update" id="assignment_fileupload_update" class="form-control">
                                <div id="img_show" class="mt-5"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">เลือกชื่อผู้จัดการเขต</label>
                                <select id="get_manager" class="form-control custom-select select2 " name="get_manager" required>
                                </select>
                            </div>
                        </div>
                        <div class="row">
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

    <!-- Show Edit -->
    <div class="modal fade" id="ModalResult" tabindex="-1" role="dialog" aria-labelledby="ModalResult"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขข้อมูลการสั่งงาน</h5>
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
                                <label for="firstName">ผู้สั่งาน</label>
                                <span id="get_manager_text"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <span id="get_emp_text"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <div id="img_show_text" class="mt-5"></div>
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

    $(document).ready(function() {
        $( "#sel_manager" ).change(function(e) {
            e.preventDefault();
            let umanager = $(this).val();
            console.log(umanager);
            $.ajax({
                method: 'GET',
                url: '{{ url("/admin/fetch_user") }}/'+umanager,
                datatype: 'json',
                success: function(response){
                    if(response.status == 200){
                        console.log(response)
                        $('#sel_saleman').children().remove().end();
                        $.each(response.saleman, function(key, value){
                            $('#sel_saleman').append('<option value='+value.id+'>'+value.name+'</option>')	;
                        });
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $( "#get_manager" ).change(function(e) {
            e.preventDefault();
            let umanager = $(this).val();
            console.log(umanager);
            $.ajax({
                method: 'GET',
                url: '{{ url("/admin/fetch_user") }}/'+umanager,
                datatype: 'json',
                success: function(response){
                    if(response.status == 200){
                        console.log(response)
                        $('#get_emp').children().remove().end();
                        $.each(response.saleman, function(key, value){
                            $('#get_emp').append('<option value='+value.id+'>'+value.name+'</option>')	;
                        });
                    }
                }
            });
        });
    });

    //Show
    function show_result(id) {
        $.ajax({
            type: "GET",
            url: '{{ url("/admin/edit_assignment") }}/'+id,
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
                
                $.each(data.dataManager, function(key, value){
                    if(value.id == data.dataEdit.assign_approve_id){
                        $('#get_manager_text').text(value.name);
                    }
                });

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
            url: '{{ url("/admin/edit_assignment") }}/'+id,
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#get_emp').children().remove().end();
                $('#get_manager').children().remove().end();
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
                        $('#img_show').append('<img src = "'+img_name+'" style="max-width:20%;">');
                    }
                }

                $.each(data.dataManager, function(key, value){
                    if(value.id == data.dataEdit.assign_approve_id){
                        $('#get_manager').append('<option value='+value.id+' selected>'+value.name+'</option>');
                    }else{
                        $('#get_manager').append('<option value='+value.id+'>'+value.name+'</option>');
                    }
                });

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


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
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/admin/create_assignment") }}',
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
            url: '{{ url("/admin/update_assignment") }}',
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

