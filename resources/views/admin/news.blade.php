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
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>บันทึกแจ้งข่าวสาร</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
                <a href="{{url('admin/newsBanner')}}" type="button" class="btn btn-violet btn-sm btn-rounded px-3"> + เพิ่มแบนเนอร์ </a>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">ตารางแจ้งข่าวสาร</h5>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header mb-15">
                                <div>
                                </div>
                                <form action="{{url('admin/search-news-status-usage')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="d-flex">
                                    <select name="status_usage" class="form-control custom-select">
                                        <option selected disabled>เลือกข้อมูล</option>
                                            <option value="">ทั้งหมด</option>
                                            <option value="1">ใช้งาน</option>
                                            <option value="0">ไม่ใช้งาน</option>
                                    </select>
                                    <button type="submit" class="btn btn-info btn-sm mr-15 ml-2">ค้นหา</button>
                                </div>
                            </form>
                            </div>
                            <div class="table-responsive col-md-12">
                                <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>เรื่อง</th>
                                        <th>วันที่แจ้งเตือน</th>
                                        <th>รูปภาพ</th>
                                        <th>สถานะ</th>
                                        <th>Link URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_news as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->news_title}}</td>
                                        <td>{{$value->news_date}}</td>
                                        <td><img src="{{ isset($value->news_image) ? asset('public/upload/NewsImage/' . $value->news_image) : '' }}" width="100"></td>
                                        <td>
                                            @switch($value->status_usage)
                                                @case(0)
                                                <span class='badge badge-soft-danger mx-1' style='font-size: 14px;'>ไม่ใช้งาน</span>
                                                    @break
                                                    @case(1)
                                                    <span class='badge badge-soft-success mx-1' style='font-size: 14px;'>ใช้งานอยู่</span>
                                                        @break
                                            @endswitch
                                        </td>
                                        <td><a href="{{$value->url}}" style="color: rgb(11, 8, 141);">{!! Str::limit($value->url,20) !!}</a></td>
                                        <td>
                                            <div class="button-list">
                                                <a href="{{ url('admin/update-news-status-use', $value->id)}}" class="btn btn-icon btn-teal mr-10">
                                                    <span class="btn-icon-wrap"><i data-feather="power"></i></span></a>
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#editNews">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                        @if ($value->status_usage == 0)
                                                        <button id="btn_news_delete" class="btn btn-icon btn-danger mr-10"
                                                             value="{{ $value->id }}">
                                                                <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-trash"></i></h4>
                                                                </button>
                                                        {{-- <a href="{{url('admin/delete_news', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                            <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></a> --}}
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
     <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มบันทึกข่าวสาร</h5>
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
                                <input class="form-control" placeholder="กรุณาใส่ชื่อเรื่อง" type="text" name="news_title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" placeholder="กรุณาใส่รายละเอียด" type="text" name="news_detail" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" placeholder="URL" name="url" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input type="file" name="news_image" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่แจ้งเตือน</label>
                                <input class="form-control" name="news_date" type="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">แชร์ข้อมูล</label>
                                <div class="custom-control custom-checkbox checkbox-info mt-2">
                                    <input type="checkbox" class="custom-control-input"
                                        id="customCheck4" name="status_share" value="1">
                                    <label class="custom-control-label"
                                        for="customCheck4">สามารถแชร์ข้อมูลได้</label>
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
                    <h5 class="modal-title">ฟอร์มแก้ไขข่าวสาร</h5>
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
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" id="get_detail" type="text" name="news_detail_edit" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" id="get_url" name="url_edit" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input type="file" name="news_image_edit" id="get_image" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่แจ้งเตือน</label>
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

        $("#form_insert_news").on("submit", function (e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type:'POST',
                url: '{{ url("admin/create_news") }}',
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
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'บันทึกข้อมูลไม่สำเร็จ',
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
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.news_date);
                    $('#get_title').val(data.dataEdit.news_title);
                    $('#get_detail').val(data.dataEdit.news_detail);
                    // $('#get_image').val(data.dataEdit.news_image);
                    $('#get_url').val(data.dataEdit.url);
                    if (data.dataEdit.status_share == 1) {
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck7' name='status_share_edit' value='1' checked><label class='custom-control-label' for='customCheck7'>สามารถแชร์ข้อมูลได้</label>");
                }else{
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck8' name='status_share_edit' value='1'><label class='custom-control-label' for='customCheck8'>สามารถแชร์ข้อมูลได้</label>");
                }

                    $('#editNews').modal('toggle');
                }
            });
        }
    </script>
@endsection
