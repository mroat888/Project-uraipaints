@extends('layouts.masterAdmin')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item active">ข่าวสาร</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i class="ion ion-md-wifi"></i> แจ้งข่าวสาร</div>
            <div class="content-right d-flex">
                <button type="button" class="btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> +
                    เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Title -->
        {{-- <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="file-text"></i></span></span>แจ้งข่าวสาร</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
                <a href="{{url('admin/newsBanner')}}" type="button" class="btn btn-violet btn-sm btn-rounded px-3"> + เพิ่มแบนเนอร์ </a>
            </div>
        </div> --}}
        <!-- /Title -->

        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">รายการแจ้งข่าวสาร</h5>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="hk-pg-header mb-15">
                            <div>
                            </div>
                            <form action="{{ url('admin/search-news-status-usage') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex">
                                    <select name="status_usage" class="form-control custom-select">
                                        <option selected disabled>เลือกข้อมูล</option>
                                        <option value="1">ใช้งาน</option>
                                        <option value="0">ไม่ใช้งาน</option>
                                    </select>
                                    <button type="submit" class="btn btn-green btn-sm mr-15 ml-2">ค้นหา</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive table-color col-md-12">
                            <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>เรื่อง</th>
                                        <th>เลขที่อ้างอิงเอกสาร</th>
                                        <th>วันที่ออกเอกสาร</th>
                                        <th>ป้ายกำกับ</th>
                                        <th>รูปภาพ</th>
                                        <th>สถานะ</th>
                                        <th>Link URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_news as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->news_title }}</td>
                                            <td>{{ $value->ref_number }}</td>
                                            <td>{{ $value->news_date }}</td>
                                            <td>
                                                <?php
                                                 $masterNews = App\MasterNews::get();
                                                    $tags = explode(',', $value->news_tags);
                                                    $tags2 = array();
                                                    foreach($tags as $value1){
                                                        $tags2[] = $value1;
                                                    }

                                                    $number = 1;

                                                    foreach ($masterNews as $key3 => $value3) {
                                                        for ($i = 0; $i < count($tags2); $i++){
                                                        if ($tags2[$i] == $value3->id) {
                                                ?>
                                                @if ($number++ < count($tags2))
                                                    {{ $value3->name_tag }},
                                                @else
                                                    {{ $value3->name_tag }}
                                                @endif
                                                <?php
                                                            }
                                                        }

                                                    }
                                                        ?>

                                            </td>
                                            <td>
                                                <a href="{{ url('admin/news-view-detail', $value->id) }}">
                                                    <img src="{{ isset($value->news_image) ? asset('public/upload/NewsImage/' . $value->news_image) : '' }}"
                                                        width="100">
                                                </a>
                                            </td>
                                            <td>
                                                @switch($value->status_usage)
                                                    @case(0)
                                                        <span class='badge badge-soft-danger mx-1'
                                                            style='font-size: 14px;'>ไม่ใช้งาน</span>
                                                    @break

                                                    @case(1)
                                                        <span class='badge badge-soft-success mx-1'
                                                            style='font-size: 14px;'>ใช้งานอยู่</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td><a href="{{ $value->url }}"
                                                    style="color: rgb(11, 8, 141);">{!! Str::limit($value->url, 20) !!}</a></td>
                                            <td>
                                                <div class="button-list">
                                                    <a href="{{ url('admin/update-news-status-use', $value->id) }}"
                                                        class="btn btn-icon btn-teal">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span
                                                                class="material-icons">settings_power</span></h4>
                                                    </a>
                                                    <a href="{{ url('admin/news-gallery', $value->id) }}"
                                                        class="btn btn-icon btn-purple">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span
                                                                class="material-icons">collections</span></h4>
                                                    </a>
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-edit" data-toggle="modal"
                                                        data-target="#editNews">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span
                                                                class="material-icons">
                                                                drive_file_rename_outline</span></h4>
                                                    </button>
                                                    @if ($value->status_usage == 0)
                                                        <button id="btn_news_delete" class="btn btn-icon btn-danger"
                                                            value="{{ $value->id }}">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><span
                                                                    class="material-icons">
                                                                    delete_outline</span></h4>
                                                        </button>
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
            </div>
        </section>
    </div>
    <!-- /Container -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มประกาศ (ข่าวสาร)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_news" enctype="multipart/form-data">
                    {{-- <form action="{{ url('admin/create_news') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">เรื่อง</label>
                                <input class="form-control" placeholder="กรุณาใส่ชื่อเรื่อง" type="text" name="news_title"
                                    required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ref_number">เลขที่อ้างอิงเอกสาร</label>
                                <input class="form-control" placeholder="กรุณาใส่เลขที่อ้างอิงเอกสาร" type="text"
                                    name="ref_number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">เลือกป้ายกำกับข่าวสาร</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple"
                                    data-placeholder="Choose" name="news_tags[]" required>
                                    <optgroup label="เลือกข้อมูล">
                                        <?php $master = App\MasterNews::orderBy('id', 'desc')->get(); ?>

                                        @foreach ($master as $value)
                                            <option value="{{ $value->id }}">{{ $value->name_tag }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" placeholder="กรุณาใส่รายละเอียด" type="text" name="news_detail"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" placeholder="URL" name="url" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ (หน้าปกข่าวสาร)</label>
                                <input type="file" name="news_image" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ออกเอกสาร</label>
                                <input class="form-control" name="news_date" type="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">แชร์ข้อมูล</label>
                                <div class="custom-control custom-checkbox checkbox-info mt-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck4"
                                        name="status_share" value="1">
                                    <label class="custom-control-label" for="customCheck4">สามารถแชร์ข้อมูลได้</label>
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
    <div class="modal fade" id="editNews" tabindex="-1" role="dialog" aria-labelledby="editNews" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขประกาศ (ข่าวสาร)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/update_news') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">เรื่อง</label>
                                <input class="form-control" id="get_title" type="text" name="news_title_edit" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ref_number">เลขที่อ้างอิงเอกสาร</label>
                                <input class="form-control" id="get_ref_number" type="text" name="ref_number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">เลือกป้ายกำกับข่าวสาร</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple" name="news_tags[]"
                                    id="get_tags">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" id="get_detail" type="text" name="news_detail_edit"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" id="get_url" name="url_edit" type="text">
                        </div>
                        <div>
                            <div class="form-group">
                                <span id="img_show" class="mt-5"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input type="file" name="news_image_edit" id="get_image" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ออกเอกสาร</label>
                                <input class="form-control" name="news_date_edit" id="get_date" type="date" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">แชร์ข้อมูล</label>
                                <div class="custom-control custom-checkbox checkbox-info mt-2">
                                    <div id="customCheck6"></div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="customCheckPin">สถานะการปักหมุด</label>
                                <div class="custom-control custom-checkbox checkbox-info mt-2">
                                    <div id="customCheckPin"></div>
                                </div>
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

    <!-- Modal Delete Saleplan -->
    <div class="modal fade" id="ModalNewsDelete" tabindex="-1" role="dialog" aria-labelledby="ModalNewsDelete"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_news_delete" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบข้อมูลข่าวสารใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบข้อมูลข่าวสารใช่หรือไม่ ?</h3>
                        <input class="form-control" id="news_id_delete" name="news_id_delete" type="hidden" />
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
        $(document).on('click', '#btn_news_delete', function() { // ปุ่มลบ Slaplan
            let news_id_delete = $(this).val();
            $('#news_id_delete').val(news_id_delete);
            $('#ModalNewsDelete').modal('show');
        });

        $("#from_news_delete").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/delete_news') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: "ลบข้อมูลข่าวสารเรียบร้อยแล้ว",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalNewsDelete').modal('hide');
                    $('#btn_news_delete').prop('disabled', true);
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });

        $("#form_insert_news").on("submit", function(e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/create_news') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        $("#exampleModalLarge01").modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'บันทึกข้อมูลไม่สำเร็จ',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                },
                error: function(response) {
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
                url: "{!! url('admin/edit_news/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#customCheck6').children().remove().end();
                    $('#customCheckPin').children().remove().end();
                    $('#get_tags').children().remove().end();
                    $('#img_show').children().remove().end();

                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.news_date);
                    $('#get_title').val(data.dataEdit.news_title);
                    $('#get_ref_number').val(data.dataEdit.ref_number);
                    $('#get_detail').val(data.dataEdit.news_detail);
                    // $('#get_image').val(data.dataEdit.news_image);
                    $('#get_url').val(data.dataEdit.url);

                    let rows_tags = data.dataEdit.news_tags.split(",");
                    let count_tags = rows_tags.length;
                    $.each(rows_tags, function(tkey, tvalue) {
                        $.each(data.master_news, function(key, value) {
                            if (value.id == rows_tags[tkey]) {
                                $('#get_tags').append('<option value=' + value.id +
                                    ' selected>' + value.name_tag + '</option>');
                            } else {
                                $('#get_tags').append('<option value=' + value.id + '>' + value
                                    .name_tag + '</option>');
                            }
                        });
                    });

                    if (data.dataEdit.status_share == 1) {
                        $('#customCheck6').append(
                            "<input type='checkbox' class='custom-control-input' id='customCheck7' name='status_share_edit' value='1' checked><label class='custom-control-label' for='customCheck7'>สามารถแชร์ข้อมูลได้</label>"
                            );
                    } else {
                        $('#customCheck6').append(
                            "<input type='checkbox' class='custom-control-input' id='customCheck8' name='status_share_edit' value='1'><label class='custom-control-label' for='customCheck8'>สามารถแชร์ข้อมูลได้</label>"
                            );
                    }

                    if (data.dataEdit.status_pin == 1) {
                        $('#customCheckPin').append(
                            "<input type='checkbox' class='custom-control-input' id='customCheck9' name='status_pin' value='1' checked><label class='custom-control-label' for='customCheck9'>ปักหมุด</label>"
                            );
                    } else {
                        $('#customCheckPin').append(
                            "<input type='checkbox' class='custom-control-input' id='customCheck10' name='status_pin' value='1'><label class='custom-control-label' for='customCheck10'>ปักหมุด</label>"
                            );
                    }

                    let img_name = '{{ asset('/public/upload/NewsImage') }}/' + data.dataEdit.news_image;
                    if (data.dataEdit.news_image != "") {
                        ext = data.dataEdit.news_image.split('.').pop().toLowerCase();
                        console.log(img_name);
                        if (img_name) {
                            $('#img_show').append('<img src = "' + img_name + '" style="max-width:20%;">');
                        }
                    }

                    $('#editNews').modal('toggle');
                }
            });
        }
    </script>
@endsection
