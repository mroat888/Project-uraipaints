@extends('layouts.masterAdmin')

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
            <div class="topichead-bgred"><i data-feather="file-text"></i> บันทึกโน๊ตส่วนตัว</div>
            <div class="content-right d-flex">
                <button type="button" class="btn btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="topic-secondgery">รายการโน๊ตส่วนตัว</div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <!-- ------ -->
                                        <span class="form-inline pull-right pull-sm-center">
                                            <form action="{{ url('admin/search_month_note') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                            <span>
                                                เดือน : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" name="fromMonth"/>

                                                ถึงเดือน : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" name="toMonth"/>

                                            <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm">ค้นหา</button>
                                            </span>
                                        </form>
                                        </span>
                                        <!-- ------ -->
                                    </div>
                                </div>
                                <div class="table-responsive col-md-12 table-color">
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
                                                    <td>{{ $value->note_title }}
                                                        @if ($value->status_pin == 1)
                                                        {{-- <span class="badge badge-danger badge-indicator" style="width: 10px; height: 10px;"></span> --}}
                                                        <span class="material-icons" style="color: rgb(180, 33, 33);">push_pin</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $masterNote = App\NoteTag::get();
                                                            $auth_team_id = explode(',', $value->note_tags);
                                                            $auth_team = array();
                                                            foreach($auth_team_id as $value1){
                                                                $auth_team[] = $value1;
                                                            }

                                                            $number = 1;

                                                            // foreach ($auth_team as $key => $value2) {
                                                                foreach ($masterNote as $key3 => $value3) {
                                                                    for ($i = 0; $i < count($auth_team); $i++){
                                                                    if ($auth_team[$i] == $value3->id) {
                                                        ?>

                                                        @if ($number++ < count($auth_team))
                                                        {{ $value3->name_tag }},
                                                        @else
                                                        {{ $value3->name_tag }}
                                                        @endif
                                                        <?php  }
                                                        }

                                                        }

                                                        ?>
                                                    </td>
                                                    <?php $date = new Carbon\Carbon($value->note_date); ?>
                                                    <td>{{ $date->addYear(543)->format('d/m/Y') }}</td>
                                                    <td>
                                                        <div class="button-list">
                                                            @if ($value->status_pin == 1)
                                                            <a href="{{url('admin/status_pin_update', $value->id)}}" class="btn btn-icon btn-secondary mr-10">
                                                                <h4 class="btn-icon-wrap" style="color: white;"><span
                                                                    class="material-icons">push_pin</span></h4>
                                                            </a>
                                                            @else
                                                            <a href="{{url('admin/status_pin_update', $value->id)}}" class="btn btn-icon btn-view mr-10">
                                                                <h4 class="btn-icon-wrap" style="color: white;"><span
                                                                    class="material-icons">push_pin</span></h4>
                                                            </a>
                                                            @endif
                                                            <button onclick="edit_modal({{ $value->id }})"
                                                                class="btn btn-icon btn-edit mr-10" data-toggle="modal"
                                                                data-target="#editNote"><h4 class="btn-icon-wrap" style="color: white;"><span
                                                                    class="material-icons">drive_file_rename_outline</span></h4>
                                                            </button>
                                                            <a href="{{url('admin/delete_note', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                                <h4 class="btn-icon-wrap" style="color: white;"><span
                                                                    class="material-icons">delete_outline</span></h4>
                                                            </a>
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
                <form action="{{ url('admin/create_note') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">เรื่อง</label>
                                <input class="form-control" name="note_title" placeholder="กรุณาใส่ชื่อเรื่อง" type="text"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="address" cols="30" rows="5" placeholder=""
                                name="note_detail" type="text" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ป้ายกำกับ</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple"
                                    data-placeholder="Choose" name="note_tags[]" required>
                                    <optgroup label="เลือกข้อมูล">
                                        <?php $master = App\NoteTag::orderBy('id', 'desc')->get(); ?>

                                        @foreach ($master as $value)
                                        <option value="{{$value->id}}">{{$value->name_tag}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่แจ้งเตือน</label>
                                <input type="date" class="form-control" placeholder="" name="note_date" min="<?= date('Y-m-d') ?>" required>
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
                <form action="{{ url('admin/update_note') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">เรื่อง</label>
                                <input class="form-control" name="note_title" id="get_title" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="get_detail" cols="30" rows="5" name="note_detail"
                                type="text"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ป้ายกำกับ</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple" name="note_tags[]"  id="get_tags">
                                    {{-- <optgroup id="get_tags">
                                        <option value="1">เพิ่มเติม</option>
                                        <option value="2">เข้าพบลูกค้า</option>
                                        <option value="3">งานใหม่</option>
                                    </optgroup> --}}
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
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
                url: "{!! url('admin/edit_note/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.note_date);
                    $('#get_title').val(data.dataEdit.note_title);
                    $('#get_detail').val(data.dataEdit.note_detail);
                    $('#get_tags').children().remove().end();

                    let rows_tags = data.dataEdit.note_tags.split(",");
                    let count_tags = rows_tags.length;
                    $.each(rows_tags, function(tkey, tvalue){
                        $.each(data.master_note, function(key, value){
                            if(value.id == rows_tags[tkey]){
                                $('#get_tags').append('<option value='+value.id+' selected>'+value.name_tag+'</option>');
                            }else{
                                $('#get_tags').append('<option value='+value.id+'>'+value.name_tag+'</option>');
                            }
                        });
                    });

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
