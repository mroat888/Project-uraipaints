@extends('layouts.masterHead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">บันทึกโน๊ตส่วนตัว</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="file-text"></i></span></span>บันทึกโน๊ตส่วนตัว</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal"
                    data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ตารางข้อมูลโน๊ตส่วนตัว</h5>
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
                                <div class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>เรื่อง</th>
                                                <th>ป้ายกำกับ</th>
                                                <th>วันที่แจ้งเตือน</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->note_title }}</td>
                                                    <td>{{ $value->note_tags }}</td>
                                                    <?php $date = new Carbon\Carbon($value->note_date); ?>
                                                    <td>{{ $date->format('d/m/Y') }}</td>
                                                    <td>
                                                        <div class="button-list">
                                                            <button class="btn btn-icon btn-primary mr-10">
                                                                <span class="btn-icon-wrap"><i
                                                                        data-feather="feather"></i></span></button>
                                                            <button onclick="edit_modal({{ $value->id }})"
                                                                class="btn btn-icon btn-warning mr-10" data-toggle="modal"
                                                                data-target="#editNote">
                                                                <span class="btn-icon-wrap"><i
                                                                        data-feather="edit"></i></span></button>
                                                            <a href="{{url('head/delete_note', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                                <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></a>
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
    </div>
    <!-- /Container -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มบันทึกโน๊ตส่วนตัว</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('head/create_note') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">เรื่อง</label>
                                <input class="form-control" name="note_title" placeholder="กรุณาใส่ชื่อเรื่อง" type="text"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ป้ายกำกับ</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple"
                                    data-placeholder="Choose" name="note_tags">
                                    <optgroup label="เลือกข้อมูล">
                                        <option value="AK">เพิ่มเติม</option>
                                        <option value="HI">เข้าพบลูกค้า</option>
                                        <option value="HI">งานใหม่</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="address" cols="30" rows="5" placeholder=""
                                name="note_detail" type="text"> </textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="firstName">วันที่แจ้งเตือน</label>
                                <input type="date" class="form-control" placeholder="" name="note_date" min="<?= date('Y-m-d') ?>">
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
    <div class="modal fade" id="editNote" tabindex="-1" role="dialog" aria-labelledby="editNote" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขโน๊ตส่วนตัว</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('head/update_note') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">เรื่อง</label>
                                <input class="form-control" name="note_title" id="get_title" type="text" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ป้ายกำกับ</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple" name="note_tags"  id="get_tags">
                                    <optgroup id="get_tags">
                                        <option value="AK">เพิ่มเติม</option>
                                        <option value="HI">เข้าพบลูกค้า</option>
                                        <option value="HB">งานใหม่</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="get_detail" cols="30" rows="5" name="note_detail"
                                type="text"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="firstName">วันที่แจ้งเตือน</label>
                                <input type="date" class="form-control" id="get_date" name="note_date" min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <input type="hidden" name="id" id="get_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}
    <script>
        //Edit
        function edit_modal(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('head/edit_note/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.note_date);
                    $('#get_title').val(data.dataEdit.note_title);
                    $('#get_detail').val(data.dataEdit.note_detail);
                    $('#get_tags').val(data.dataEdit.note_tags);

                    $('#editNote').modal('toggle');
                }
            });
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
