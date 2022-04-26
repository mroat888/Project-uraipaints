@extends('layouts.masterLead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item">หน้าแรก</li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดวันสำคัญ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon">
                            <i data-feather="file-text"></i></span></span>รายละเอียดวันสำคัญ</h4>
            </div>
        </div>
        <!-- /Title -->

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายละเอียดวันสำคัญร้านค้า เดือน <?php echo thaidate('F', date('M')); ?></h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                </div>
                                <div class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ชื่อร้าน</th>
                                                <th>อำเภอ,จังหวัด</th>
                                                <th>เบอร์โทร</th>
                                                <th>วันสำคัญ</th>
                                                <th>ชื่อวัน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!is_null($res_api['data']))
                                                @foreach ($res_api['data'] as $key => $value)
                                                    @php
                                                        $createdAt = Carbon\Carbon::parse($value['focusDate']);
                                                        $date = date('Y-m');

                                                    @endphp

                                                    @if ($createdAt->format('Y-m') == $date)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $value['name'] }}</td>
                                                            <td>{{ $value['adrress2'] }}</td>
                                                            <td>{{ $value['telephone'] }}</td>
                                                            <td>{{ $value['fDateInfo'] }}</td>
                                                            <td>{{ $value['descripDate'] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
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
                <form action="{{ url('create_note') }}" method="post" enctype="multipart/form-data">
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
                            <textarea class="form-control" id="address" cols="30" rows="5" placeholder="" name="note_detail" type="text"
                                required> </textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ป้ายกำกับ</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple"
                                    data-placeholder="Choose" name="note_tags[]" required>
                                    <optgroup label="เลือกข้อมูล">
                                        <?php $master = App\NoteTag::orderBy('id', 'desc')->get(); ?>

                                        @foreach ($master as $value)
                                            <option value="{{ $value->id }}">{{ $value->name_tag }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่แจ้งเตือน</label>
                                <input type="date" class="form-control" placeholder="" name="note_date"
                                    min="<?= date('Y-m-d') ?>" required>
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
                <form action="{{ url('update_note') }}" method="post" enctype="multipart/form-data">
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
                            <textarea class="form-control" id="get_detail" cols="30" rows="5" name="note_detail" type="text"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ป้ายกำกับ</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple" name="note_tags[]"
                                    id="get_tags">

                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่แจ้งเตือน</label>
                                <input type="date" class="form-control" id="get_date" name="note_date"
                                    min="<?= date('Y-m-d') ?>">
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
                url: "{!! url('edit_note/"+id+"') !!}",
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
                    $.each(rows_tags, function(tkey, tvalue) {
                        $.each(data.master_note, function(key, value) {
                            if (value.id == rows_tags[tkey]) {
                                $('#get_tags').append('<option value=' + value.id +
                                    ' selected>' + value.name_tag + '</option>');
                            } else {
                                $('#get_tags').append('<option value=' + value.id + '>' + value
                                    .name_tag + '</option>');
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


        function showselectdate() {
            $("#selectdate").css("display", "block");
            $("#bt_showdate").hide();
        }

        function hidetdate() {
            $("#selectdate").css("display", "none");
            $("#bt_showdate").show();
        }
    </script>
@endsection
