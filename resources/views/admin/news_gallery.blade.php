@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item">ข่าวสาร</li>
        <li class="breadcrumb-item">แจ้งข่าวสาร</li>
        <li class="breadcrumb-item active">แกลลอรี่ข่าวสาร</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
         <!-- Title -->
         <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="image"></i> แกลลอรี่ข่าวสาร</div>
            <div class="content-right d-flex">
                <button type="button" class="btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
                <a href="{{url('admin/news')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ</a>
            </div>
        </div>
        <!-- /Title -->

        <!-- Title -->
        {{-- <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="image"></i></span></span>แกลลอรี่ข่าวสาร</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
                <a href="{{url('admin/news')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3"> ย้อนกลับ</a>
            </div>
        </div> --}}
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการแกลลอรี่</div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="table-responsive table-color col-md-12">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รูปภาพ</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gallerys as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td><img src="{{ isset($value->image) ? asset('public/upload/NewsGallery/' . $value->image) : '' }}" width="100"></td>
                                        <td>
                                            <div class="button-list">
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-edit" data-toggle="modal" data-target="#editNews">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">
                                                            drive_file_rename_outline</span></h4>
                                                        </button>
                                                        <button id="btn_news_delete" class="btn btn-icon btn-danger"
                                                             value="{{ $value->id }}">
                                                             <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">
                                                                delete_outline
                                                                </span></h4>
                                                                </button>
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
                    <h5 class="modal-title">เพิ่มประกาศ (ข่าวสาร)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_news_gallery" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/create_news_gallery') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                    <input type="hidden" name="news_id" value="{{$newsID->id}}">
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input type="file" name="news_gallery[]" multiple class="form-control">
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
                <form action="{{ url('admin/update_news_gallery') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="get_id">
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                            <span id="img_show" class="mt-5"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input type="file" name="news_gallery" id="get_image" class="form-control">
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
                        <input class="form-control" id="gallery_id_delete" name="gallery_id_delete" type="hidden" />
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
        let gallery_id_delete = $(this).val();
        $('#gallery_id_delete').val(gallery_id_delete);
        $('#ModalNewsDelete').modal('show');
    });

    $("#from_news_delete").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/delete_news_gallery') }}',
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

        $("#form_insert_news_gallery").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: '{{ url("admin/create_news_gallery") }}',
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
                url: "{!! url('admin/edit_news_gallery/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#img_show').children().remove().end();
                    $('#get_id').val(data.dataEdit.id);

                let img_name = '{{ asset("/public/upload/NewsGallery") }}/' + data.dataEdit.image;
                if(data.dataEdit.image != ""){
                    ext = data.dataEdit.image.split('.').pop().toLowerCase();
                    console.log(img_name);
                    if(img_name){
                        $('#img_show').append('<img src = "'+img_name+'" style="max-width:20%;">');
                    }
                }

                    $('#editNews').modal('toggle');
                }
            });
        }
    </script>
@endsection
