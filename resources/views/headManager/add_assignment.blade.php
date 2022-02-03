@extends('layouts.masterHead')

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

                                <button style="margin-left:5px; margin-right:5px;" id="bt_showdate"
                                    class="btn btn-light btn-sm" onclick="showselectdate()">เลือกวันที่</button>
                                <span id="selectdate" style="display:none;">
                                    date : <input type="date" class="form-control form-control-sm"
                                        style="margin-left:10px; margin-right:10px;" id="selectdateFrom"
                                        value="<?= date('Y-m-d') ?>" />

                                    to <input type="date" class="form-control form-control-sm"
                                        style="margin-left:10px; margin-right:10px;" id="selectdateTo"
                                        value="<?= date('Y-m-d') ?>" />

                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm"
                                        id="submit_request" onclick="hidetdate()">ค้นหา</button>
                                </span>

                            </span>
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover">
                                    <thead align="center">
                                        <tr>
                                            <th>#</th>
                                            <th>เรื่อง</th>
                                            <th>วันที่</th>
                                            <th>พนักงาน</th>
                                            <th>สถานะ</th>

                                        </tr>
                                    </thead>
                                    <tbody align="center">
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
                <form action="{{ url('lead/create_assignment') }}" method="post" enctype="multipart/form-data">
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
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ไฟล์เอกสาร</label>
                                <input type="file" name="image" id="" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <select class="form-control custom-select select2" name="assign_emp_id" required>
                                    <option value="" selected disabled>กรุณาเลือก</option>
                                    @foreach($users as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
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
                <form action="{{ url('lead/update_assignment') }}" method="post" enctype="multipart/form-data">
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
                                <input type="file" name="image" id="" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สั่งงานให้</label>
                                <select class="form-control custom-select" name="assign_emp_id" id="get_emp" required>
                                    <option selected>กรุณาเลือก</option>
                                    <option value="1">ศิริลักษณ์</option>
                                    <option value="2">อิศรา</option>
                                    <option value="3">ดวงดาว</option>
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

    {{-- <script>
        //Edit
        function assignment_result(id) {
            // $("#get_assign_id").val(id);
            $.ajax({
                type: "GET",
                url: "{!! url('lead/assignment_result_get/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_assign_id').val(data.dataResult.id);
                    $('#get_result_detail').val(data.dataResult.assign_result_detail);
                    if (data.dataResult.assign_result_status != 0) {
                        if (data.dataResult.assign_result_status == 1) {
                            $('#get_result').val("สนใจ/ตกลง");
                        } if (data.dataResult.assign_result_status == 2) {
                            $('#get_result').val("ไม่สนใจ");
                         } if (data.dataResult.assign_result_status == 3) {
                            $('#get_result').val("รอตัดสินใจ");
                        }
                    }

                    $('#ModalResult').modal('toggle');
                }
            });
        }
    </script> --}}

    <script>
        //Edit
        function edit_modal(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('lead/edit_assignment/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.assign_work_date);
                    $('#get_title').val(data.dataEdit.assign_title);
                    $('#get_detail').val(data.dataEdit.assign_detail);
                    $('#get_emp').val(data.dataEdit.assign_emp_id);

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



@section('footer')
    @include('layouts.footer')
@endsection
@endsection
