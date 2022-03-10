@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">การขออนุมัติ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="clipboard"></i></span></span>บันทึกข้อมูลการขออนุมัติ</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ตารางข้อมูลการขออนุมัติ</h5>
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
                                            <form action="{{ url('search_month_requestApprove') }}" method="post" enctype="multipart/form-data">
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
                                <div class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>เรื่อง</th>
                                                <th>วันที่</th>
                                                <th>การอนุมัติ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_approval as $key => $value)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$value->assign_title}}</td>
                                                <td>{{$value->assign_work_date}}</td>
                                                <td>
                                                    @if ($value->assign_status == 0)
                                                    <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                                    @elseif ($value->assign_status == 1)
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>
                                                    @else
                                                    <span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>
                                                    @endif

                                                    {{-- เรื่องด่วน --}}
                                                    @if ($value->assign_is_hot == 1)
                                                    <span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>
                                                    @endif

                                                    @if ($value->assign_id)
                                                            <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>
                                                    @endif
                                                </td>
                                                    <td>
                                                        <div class="button-list">
                                                        @if ($value->assign_status == 0)

                                                            <button onclick="edit_modal({{ $value->id }})"
                                                                class="btn btn-icon btn-warning mr-10" data-toggle="modal"
                                                                data-target="#editApproval">
                                                                <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>

                                                                <button id="btn_request_delete" class="btn btn-icon btn-danger mr-10"
                                                                    value="{{ $value->id }}">
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-trash"></i></h4>
                                                                </button>

                                                        @elseif ($value->assign_status == 1)
                                                            @if ($value->assign_id)

                                                            <button onclick="approval_comment({{ $value->id }})"
                                                                class="btn btn-icon btn-violet mr-10" data-toggle="modal"
                                                                data-target="#ApprovalComment">
                                                                <span class="btn-icon-wrap"><i
                                                                        data-feather="message-square"></i></span></button>

                                                                        <button onclick="edit_modal({{ $value->id }})"
                                                                            class="btn btn-icon btn-info mr-10" data-toggle="modal"
                                                                            data-target="#editApproval">
                                                                            <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                            @endif
                                                            <button onclick="approval_detail({{ $value->id }})"
                                                                class="btn btn-icon btn-primary mr-10" data-toggle="modal"
                                                                data-target="#Approvaldetail">
                                                                <span class="btn-icon-wrap">
                                                                    <i data-feather="file-text"></i></span>
                                                                </button>
                                        
                                                        @elseif ($value->assign_status == 2)
    
                                                            @if ($value->assign_id)
                                                            <button onclick="approval_comment({{ $value->id }})"
                                                                class="btn btn-icon btn-violet mr-10" data-toggle="modal"
                                                                data-target="#ApprovalComment">
                                                                <span class="btn-icon-wrap"><i
                                                                        data-feather="message-square"></i></span></button>

                                                                        <button onclick="edit_modal({{ $value->id }})"
                                                                            class="btn btn-icon btn-info mr-10" data-toggle="modal"
                                                                            data-target="#editApproval">
                                                                            <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                            @endif

                                                        @endif
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
    <!-- /Container -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มข้อมูลการขออนุมัติ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form action="{{ url('create_approval') }}" method="post" enctype="multipart/form-data"> --}}
                    <form id="form_insert_request_approval" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">ขออนุมัติสำหรับ</label>
                                <select class="form-control custom-select" name="approved_for" required>
                                    <option selected disabled>กรุณาเลือก</option>
                                    <?php $masters = App\ObjectiveAssign::get(); ?>
                                    @foreach ($masters as $value)
                                    <option value="{{$value->id}}">{{$value->masassign_title}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">หัวข้อ / เรื่อง</label>
                                <input class="form-control" placeholder="กรุณาใส่หัวข้อ / เรื่อง" name="assign_title" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ / Date</label>
                                <input class="form-control" type="date" name="assign_work_date" min="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" placeholder="กรุณาใส่รายละเอียด" name="assign_detail"
                                    type="text" required></textarea>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="firstName">เรื่องด่วน</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="assign_is_hot" value="1">
                                        <label class="custom-control-label" for="customCheck1">ขออนุมัติด่วน</label>
                                    </div>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="editApproval" tabindex="-1" role="dialog" aria-labelledby="editApproval" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดข้อมูลการขออนุมัติ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('update_approval') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ขออนุมัติสำหรับ</label>
                                    <select class="form-control custom-select" name="approved_for" id="get_for" disabled>
                                        <option selected disabled>เลือก</option>
                                        <?php $masters = App\ObjectiveAssign::get(); ?>
                                    @foreach ($masters as $value)
                                    <option value="{{$value->id}}">{{$value->masassign_title}}</option>
                                    @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">หัวข้อ / เรื่อง</label>
                                <input class="form-control" placeholder="กรุณาใส่หัวข้อ / เรื่อง" name="assign_title" id="get_title" type="text" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ / Date</label>
                                <input class="form-control" type="date" name="assign_work_date" id="get_work_date" min="<?= date('Y-m-d') ?>" readonly>
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
                                    {{-- <input type="text" name="" id="get_xx"> --}}
                                    <div class="custom-control custom-checkbox">
                                        <div id="customCheck6"></div>
                                        {{-- <input type="checkbox" class="custom-control-input" id="customCheck6" name="assign_is_hot" value="1">
                                        <label class="custom-control-label" for="customCheck6">ขออนุมัติด่วน</label> --}}
                                    </div>
                                </div>
                        </div>

                        <input type="hidden" name="id" id="get_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        {{-- <button type="submit" class="btn btn-primary">บันทึก</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Approval Detail-->
    <div class="modal fade" id="ApprovalDetail" tabindex="-1" role="dialog" aria-labelledby="ApprovalDetail" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียด</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">

                        <div class="card">
                            <div class="card-body">
                                <h5 id="header_title" class="card-title"></h5>
                                <div class="my-3"><span>หัวข้อ/เรื่อง : </span><span id="get_assign_title"></span></div>
                                <div class="my-3"><span>วันที่ปฎิบัติ : </span><span id="get_assign_work_date"></span></div>

                                <div class="my-3">
                                    <p>รายละเอียด : </p>
                                    <p  id="assign_detail" class="card-text"></p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
            </div>
        </div>
    </div>


    <!-- Modal ApprovalComment -->
    <div class="modal fade" id="ApprovalComment" tabindex="-1" role="dialog" aria-labelledby="ApprovalComment" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ความคิดเห็น</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">

                        <div class="card">
                            <div class="card-body">
                                <h5 id="header_title" class="card-title"></h5>
                                {{-- <div class="my-3"><span>ผู้คอมเม้นท์ : </span><span id="get_assign_approve_id"></span></div> --}}
                                <div class="my-3"><span>วันที่ปฎิบัติ : </span><span id="get_assign_work_date"></span></div>

                                <div class="my-3">
                                    <p>รายละเอียด : </p>
                                    <p  id="assign_detail" class="card-text"></p>
                                </div>
                                {{-- <div class="my-3" id="img_show"></div> --}}
                            </div>
                        </div>

                        <div class="form-group">

                            <div id="div_comment">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Saleplan -->
    <div class="modal fade" id="ModalSaleplanDelete" tabindex="-1" role="dialog" aria-labelledby="ModalSaleplanDelete"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_request_delete" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบข้อมูลขออนุมัติ ใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบข้อมูลขออนุมัติ ใช่หรือไม่ ?</h3>
                        <input class="form-control" id="request_id_delete" name="request_id_delete" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}
    <script>

    $(document).on('click', '#btn_request_delete', function() { // ปุ่มลบ Slaplan
        let request_id_delete = $(this).val();
        $('#request_id_delete').val(request_id_delete);
        $('#ModalSaleplanDelete').modal('show');
    });

    $("#from_request_delete").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('delete_approval') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: "ลบข้อมูลลูกค้าเรียบร้อยแล้วค่ะ",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalSaleplanDelete').modal('hide');
                    $('#shop_status_name_lead').text('ลบข้อมูล Sale Plan เรียบร้อย')
                    $('#btn_request_delete').prop('disabled', true);
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });


        $("#form_insert_request_approval").on("submit", function (e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type:'POST',
                url: '{{ url("create_approval") }}',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(response){
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $("#addCustomer").modal('hide');
                    location.reload();
                },
                error: function(response){
                    console.log("error");
                    console.log(response);
                }
            });
        });
    </script>

<script>
    //Edit
    function edit_modal(id) {
        $.ajax({
            type: "GET",
            url: "{!! url('edit_approval/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#customCheck6').children().remove().end();
                $('#get_id').val(data.dataEdit.id);
                $('#get_work_date').val(data.dataEdit.assign_work_date);
                $('#get_title').val(data.dataEdit.assign_title);
                $('#get_detail').val(data.dataEdit.assign_detail);
                $('#get_for').val(data.dataEdit.approved_for);
                $('#get_xx').val(data.dataEdit.assign_is_hot);

                if (data.dataEdit.assign_is_hot == 1) {
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck7' name='assign_is_hot' value='1' checked disabled><label class='custom-control-label' for='customCheck7'>ขออนุมัติด่วน</label>");
                }else{
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck8' name='assign_is_hot' value='1' disabled><label class='custom-control-label' for='customCheck8'>ขออนุมัติด่วน</label>");
                }
                // $('#customCheck2').val(data.dataEdit.assign_is_hot);

                $('#editApproval').modal('toggle');
            }
        });
    }

    function approval_detail(id){
        $.ajax({
            type: "GET",
            url: "{!! url('edit_approval/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
               // console.log(data);
                $('#get_assign_work_date').text(data.dataEdit.assign_work_date);
                $('#get_assign_title').text(data.dataEdit.assign_title);
                $('#assign_detail').text(data.dataEdit.assign_detail);

                $('#ApprovalDetail').modal('toggle');
            }
        });
    }

</script>

<script>
    
    //Edit
    function approval_comment(id) {
        $.ajax({
            type: "GET",
            url: "{!! url('view_comment/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#div_comment').children().remove().end();
                console.log(data);

                $.each(data, function(key, value){
                    $('#assign_detail').text(data[key].assign_detail);
                    $('#header_title').text(data[key].assign_title);
                    $('#get_assign_work_date').text(data[key].assign_work_date);
                    $('#get_assign_approve_id').text(data[key].user_comment);
                    $('#div_comment').append('<div>Comment by: '+data[key].user_comment+' Date: '+data[key].created_at+'</div>');
                    $('#div_comment').append('<div class="alert alert-primary py-20" role="alert">'+data[key].assign_comment_detail+'</div>');
                });

                $('#ApprovalComment').modal('toggle');
            }
        });
    }
</script>

    <script>
    $(document).on('click', '.btn_showplan', function(){
        let plan_id = $(this).val();
        //alert(goo);
        $('#Modalsaleplan').modal("show");
    });
</script>

@section('footer')
    @include('layouts.footer')
@endsection

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
