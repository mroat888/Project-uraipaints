@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">บันทึกขออนุมัติ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="clipboard"></i> บันทึกขออนุมัติ</div>
            <div class="content-right d-flex">
                <button type="button" class="btn btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="topic-secondgery">รายการขออนุมัติ</div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <!-- ------ -->
                                        <span class="form-inline pull-right pull-sm-center">
                                            <form id="form_search" enctype="multipart/form-data">

                                                <span id="selectdate">

                                                    จาก : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" name="fromMonth"/>

                                                    ถึง : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name="toMonth"/>

                                                <button type="submit"style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm">ค้นหา</button>

                                                </span>
                                            </form>
                                        </span>
                                        <!-- ------ -->
                                    </div>
                                </div>


                                <div id="table_product">
                                    <div class="table-responsive-sm table-color">
                                        <table id="datable_1" class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>เรื่องด่วน</th>
                                                    <th>เรื่อง</th>
                                                    <th>ชื่อร้าน</th>
                                                    <th>วันที่ต้องการ</th>
                                                    <th>การอนุมัติ</th>
                                                    <th>สถานะ</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list_approval as $key => $value)
                                                    @php
                                                        list($aswork_year, $aswork_month, $aswork_day) = explode("-", $value->assign_work_date);
                                                        $aswork_year_thai = $aswork_year + 543;
                                                        $assign_work_date = $aswork_day."/".$aswork_month."/".$aswork_year_thai;
                                                    @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>
                                                        @if($value->assign_is_hot == 1)
                                                            <span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $value->assign_title }}</td>
                                                    <td>
                                                        @if(isset($customer_api))
                                                            @foreach ($customer_api as $key => $cus_api_value)
                                                               @if($cus_api_value['id'] == $value->assign_shop)
                                                                {{ $cus_api_value['shop_name'] }}
                                                               @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $assign_work_date }}</td>
                                                    <td>
                                                        @php
                                                            switch($value->assign_status){
                                                                case 0 :    $badge_status = "badge-soft-warning";
                                                                            $status = "Pending";
                                                                    break;
                                                                case 1 :    $badge_status = "badge-soft-success";
                                                                            $status = "Approval";
                                                                    break;
                                                                case 2 :    $badge_status = "badge-soft-secondary";
                                                                            $status = "Reject";
                                                                    break;
                                                                case 4 :    $badge_status = "badge-soft-info";
                                                                            $status = "Re-write";
                                                                    break;
                                                                default:    $status = "";
                                                                            $badge_status = "";
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $badge_status }}" style="font-size: 12px;">{{ $status }}</span>
                                                        @if($value->assign_id)
                                                            <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($value->assign_status == 0 || $value->assign_status == 4)
                                                            <span class="badge badge-soft-warning" style="font-size: 12px;">ขออนุมัติ</span>
                                                        @elseif($value->assign_status == 1 || $value->assign_status == 2)
                                                            <span class="badge badge-soft-success" style="font-size: 12px;">สำเร็จ</span>
                                                         @endif
                                                    </td>
                                                    <td>
                                                        <button onclick="approval_comment({{ $value->id }})"
                                                        class="btn btn-icon btn-purple mr-10" data-toggle="modal" data-target="#ApprovalComment">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></button>

                                                        @if ($value->assign_status == 4) <!-- สถานะให้แก้ไข -->
                                                            <button onclick="edit_modal({{ $value->id }})" class="btn btn-icon btn-warning mr-10" data-toggle="modal"
                                                                data-target="#editApproval">
                                                                <span class="btn-icon-wrap"><i class="ion ion-md-create" style="font-size: 18px;"></i></span>
                                                            </button>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                            <tbody>
                                        </table>
                                    </div>
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
                                    <option selected disabled value="">กรุณาเลือก</option>
                                    <?php $masters = App\ObjectiveAssign::get(); ?>
                                    @foreach ($masters as $value)
                                    <option value="{{$value->id}}">{{$value->masassign_title}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="firstName">วันที่ขออนุมัติ</label>
                            <input class="form-control" name="" type="text" value="{{ Carbon\Carbon::now()->addYear(543)->format('d/m/Y')}}" readonly>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">หัวข้อ / เรื่อง</label>
                                <input class="form-control" placeholder="กรุณาใส่หัวข้อ / เรื่อง" name="assign_title" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ต้องการ</label>
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
                            <div class="form-group col-md-12">
                                <label for="firstName">ค้นหาชื่อร้าน</label>
                                <select name="sel_searchShop2" id="sel_searchShop2" class="form-control custom-select select2">
                                    <option value="" selected disabled>กรุณาเลือกชื่อร้านค้า</option>
                                    @if(isset($customer_api))
                                        @foreach ($customer_api as $key => $value)
                                            <option value="{{$customer_api[$key]['id']}}">{{$customer_api[$key]['shop_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
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
                    <h5 class="modal-title">แก้ไขข้อมูลการขออนุมัติ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form action="{{ url('update_approval') }}" method="post" enctype="multipart/form-data"> --}}
                <form id="form_update_request_approval" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ขออนุมัติสำหรับ</label>
                                <select class="form-control custom-select" name="approved_for" id="get_for">
                                    <option selected disabled>เลือก</option>
                                    <?php $masters = App\ObjectiveAssign::get(); ?>
                                    @foreach ($masters as $value)
                                    <option value="{{$value->id}}">{{$value->masassign_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ขออนุมัติ</label>
                                <input class="form-control" name="" type="text" id="get_request_date" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">หัวข้อ / เรื่อง</label>
                                <input class="form-control" placeholder="กรุณาใส่หัวข้อ / เรื่อง" name="assign_title" id="get_title" type="text">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ต้องการ</label>
                                <input class="form-control" type="date" name="assign_work_date" id="get_work_date" min="<?= date('Y-m-d') ?>" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" id="get_detail" name="assign_detail"
                                    type="text"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ค้นหาชื่อร้าน</label>
                                <select name="sel_searchShopEdit" id="sel_searchShopEdit" class="form-control custom-select select2">
                                    <option value="" selected disabled>เลือกข้อมูล</option>
                                </select>
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
                    </div>
                    <input type="hidden" name="get_id" id="get_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Modal ApprovalComment -->
<div class="modal fade" id="ApprovalComment" tabindex="-1" role="dialog" >
    @include('union.general_history_display')
</div>


{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}

<script>
    $("#form_insert_request_approval").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        console.log(formData);
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

    $("#form_update_request_approval").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("update_approval") }}',
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
                $("#editApproval").modal('hide');
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
                console.log(data.customer_api);
                $('#customCheck6').children().remove().end();
                $('#get_id').val(data.dataEdit.id);
                $('#get_work_date').val(data.dataEdit.assign_work_date);
                $('#get_title').val(data.dataEdit.assign_title);
                $('#get_detail').val(data.dataEdit.assign_detail);
                $('#get_for').val(data.dataEdit.approved_for);
                $('#get_xx').val(data.dataEdit.assign_is_hot);

                let get_request_date = data.dataEdit.assign_request_date.split(" ");
                let get_request_date2 = get_request_date[0].split("-");
                let year_th = parseInt(get_request_date2[0])+543;
                let date_request = get_request_date2[2]+"/"+get_request_date2[1]+"/"+year_th;
                $('#get_request_date').val(date_request);

                if (data.dataEdit.assign_is_hot == 1) {
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck7' name='assign_is_hot' value='1' checked><label class='custom-control-label' for='customCheck7'>ขออนุมัติด่วน</label>");
                }else{
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck8' name='assign_is_hot' value='0'><label class='custom-control-label' for='customCheck8'>ขออนุมัติด่วน</label>");
                }

                $.each(data.customer_api, function(key, value){
                    if(data.customer_api[key]['id'] == data.dataEdit.assign_shop){
                        $('#sel_searchShopEdit').append('<option value='+data.customer_api[key]['id']+' selected>'+data.customer_api[key]['shop_name']+'</option>');
                    }else{
                        $('#sel_searchShopEdit').append('<option value='+data.customer_api[key]['id']+'>'+data.customer_api[key]['shop_name']+'</option>');
                    }
                });
                // $('#customCheck2').val(data.dataEdit.assign_is_hot);

                $('#editApproval').modal('toggle');
            }
        });
    }

</script>

<script>

    //approval_comment
    function approval_comment(id) {
        console.log(id);
        $('#div_assign_approve').children().remove().end();
        $.ajax({
            type: "GET",
            url: "{!! url('view_comment/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                console.log(data);
                $('#div_comment').children().remove().end();
                $('#div_assign_status').children().remove().end();
                $("#assign_parent").hide();


                switch(data['dataassign'].assign_status) {
                    case 0 : div_assign_status = '<span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>';
                        break;
                    case 1 : div_assign_status = '<span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>';
                        break;
                    case 2 : div_assign_status = '<span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>';
                        break;
                    default: $div_assign_status = '<span class="badge badge-soft-warning" style="font-size: 12px;">ไม่มี</span>'
                }
                let get_assign_request_date = data['dataassign'].assign_request_date.split(" ");
                let get_request_date2 = get_assign_request_date[0].split("-");
                let year_th = parseInt(get_request_date2[0])+543;
                let date_request = get_request_date2[2]+"/"+get_request_date2[1]+"/"+year_th;

                let assign_work_date = data['dataassign'].assign_work_date.split(" ");
                let assign_work_date2 = assign_work_date[0].split("-");
                let work_year_th = parseInt(assign_work_date2[0])+543;
                let date_work = assign_work_date2[2]+"/"+assign_work_date2[1]+"/"+work_year_th;

                $('#assign_detail_comment').text(data['dataassign'].assign_detail);
                $('#header_title_comment').text('เรื่อง : '+data['dataassign'].assign_title);
                $('#header_approved_for_comment').text(data['dataassign'].masassign_title);
                $('#get_assign_request_name').text(data['dataassign'].assignments_request_name);
                $('#get_assign_request_date').text(date_request);
                $('#get_assign_work_date_comment').text(date_work);

                $('#div_assign_status').append('<span>การอนุมัติ : </span>'+div_assign_status);

                $('#div_assign_approve').append('<span>ผู้อนุมัติ : '+data['dataassign'].assignments_approve_name+
                ' วันที่ : '+data['dataassign'].assignments_approve_date+'</span>');

                $.each(data['comment'], function(key, value){

                // let get_assign_request_date = data['dataassign'].assign_request_date.split(" ");
                let created_comment = value.created_at.split("-");
                let year_th_comment = parseInt(get_request_date2[0])+543;
                let date_comment = created_comment[2]+"/"+created_comment[1]+"/"+year_th_comment;

                    $('#div_comment').append('<div>ผู้ให้ความเห็น : '+value.user_comment+' วันที่: '+date_comment+'</div>');
                    $('#div_comment').append('<div class="alert alert-primary py-20" role="alert">'+value.assign_comment_detail+'</div>');
                });

                if(data['dataassign_parent']){
                    let count_parent = Object.keys(data['dataassign_parent']).length;
                    // console.log(count_parent);
                    if(count_parent > 0){
                        let assign_request_date = data['dataassign_parent'].assign_request_date.split(" ");

                        $("#assign_parent").attr("style", { display: "block" });
                        $("#title_parent").text(data['dataassign_parent'].assign_title);
                        $("#approved_for_parent").text(data['dataassign_parent'].masassign_title);
                        $("#assign_request_date").text(assign_request_date[0]);
                        $("#assign_work_date_parent").text(data['dataassign_parent'].assign_work_date);
                        $("#assign_detail_parent").text(data['dataassign_parent'].assign_detail);
                    }
                }

                $('#ApprovalComment').modal('toggle');
            }
        });
    }

    $("#form_search").on("submit", function (e) {
        e.preventDefault();
        // var formData = new FormData(this);
        var fromMonth = $('#selectdateFrom').val();
        var toMonth = $('#selectdateTo').val();

        if(fromMonth === ""){
            fromMonth = "00";
        }

        if(toMonth === ""){
            toMonth = "00";
        }

        var content = "<div class='table-responsive col-md-12'>";
                content += "<table id='datable_request' class='table table-hover'>";
                    content += "<thead>";
                        content += "<tr>";
                            content += "<th>#</th>";
                            content += "<th>เรื่องด่วน</th>";
                            content += "<th>เรื่อง</th>";
                            content += "<th>ชื่อร้าน</th>";
                            content += "<th>วันที่ต้องการ</th>";
                            content += "<th>การอนุมัติ</th>";
                            content += "<th>สถานะ</th>";
                            content += "<th>Action</th>";
                        content += "</tr>";
                    content += "</thead>";
                    content += "<tbody>";
                    content += "<tbody>";
                    content += "<tbody>";
                content += "</table>";
            content += "</div>";

        $("#table_product").html(content);

        $('#datable_request').DataTable({
            processing: false,
            serverSide: false,
            ajax: {
                method:"get",
                url: '{{ url("/search_month_requestApprove") }}/'+fromMonth+"/"+toMonth,
                dataType: 'json',
                },
                columns: [
                    {data: 'key', name: 'key'},
                    {data: 'assign_is_hot', name: 'assign_is_hot'},
                    {data: 'assign_title', name: 'assign_title'},
                    {data: 'assign_shop_name', name: 'assign_shop_name'},
                    {data: 'assign_work_date', name: 'assign_work_date'},
                    {data: 'assign_status', name: 'assign_status'},
                    {data: 'assign_status_approve', name: 'assign_status_approve'},
                    {data: 'action', name: 'action'},
                ]
        });

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
