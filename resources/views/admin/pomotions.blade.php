@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">โปรโมชั่น</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">ปฎิทินกิจกรรม</li> --}}
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="gift"></i></span></span>บันทึกรายการโปรโมชั่น</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">ตารางรายการโปรโมชั่น</h5>
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
                                        <th>ชื่อโปรโมชั่น</th>
                                        <th>รูปภาพ</th>
                                        <th>วันที่เริ่ม</th>
                                        <th>วันที่สิ้นสุด</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_promotion as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->news_title}}</td>
                                        <td><img src="{{ isset($value->news_image) ? asset('public/upload/PromotionImage/' . $value->news_image) : '' }}" width="100"></td>
                                        <td>{{$value->news_date}}</td>
                                        <td>{{$value->news_date_last}}</td>
                                        <td>
                                            <div class="button-list">
                                                {{-- <button class="btn btn-icon btn-primary mr-10">
                                                    <span class="btn-icon-wrap"><i data-feather="feather"></i></span></button> --}}
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#editPromotion">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                        <a href="{{url('admin/delete_promotion', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
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
                </div>
            </section>
    </div>
    <!-- /Container -->

     <!-- Modal -->
     <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มบันทึกโปโมชั่น</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_promotion" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/create_promotion') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
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
                                <label for="firstName">แชร์ข้อมูล</label>
                                <div class="custom-control custom-checkbox checkbox-info mt-2">
                                    <input type="checkbox" class="custom-control-input"
                                        id="customCheck4" name="status_share" value="1">
                                    <label class="custom-control-label"
                                        for="customCheck4">สามารถแชร์ข้อมูลได้</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่เริ่มต้น</label>
                                <input class="form-control" name="news_date" type="date" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่สิ้นสุด</label>
                                <input class="form-control" name="news_date_last" type="date" required>
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
     <div class="modal fade" id="editPromotion" tabindex="-1" role="dialog" aria-labelledby="editPromotion" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขข่าวสาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/update_promotion') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">เรื่อง</label>
                                <input class="form-control" id="get_title" type="text" name="news_title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" id="get_detail" type="text" name="news_detail" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" placeholder="URL" id="get_url" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input type="file" name="news_image" id="get_image" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">แชร์ข้อมูล</label>
                                <div class="custom-control custom-checkbox checkbox-info mt-2">
                                    <div id="customCheck6"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่เริ่มต้น</label>
                                <input class="form-control" name="news_date" id="get_date" type="date" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่สิ้นสุด</label>
                                <input class="form-control" name="news_date_last" id="get_date_last" type="date" required>
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

    <script>
        $("#form_insert_promotion").on("submit", function (e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type:'POST',
                url: '{{ url("admin/create_promotion") }}',
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
                url: "{!! url('admin/edit_promotion/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#customCheck6').children().remove().end();
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.news_date);
                    $('#get_date_last').val(data.dataEdit.news_date_last);
                    $('#get_title').val(data.dataEdit.news_title);
                    $('#get_detail').val(data.dataEdit.news_detail);
                    $('#get_url').val(data.dataEdit.url);
                    if (data.dataEdit.status_share == 1) {
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck7' name='status_share' value='1' checked><label class='custom-control-label' for='customCheck7'>สามารถแชร์ข้อมูลได้</label>");
                }else{
                    $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck8' name='status_share' value='1'><label class='custom-control-label' for='customCheck8'>สามารถแชร์ข้อมูลได้</label>");
                }
                    $('#get_image').val(data.dataEdit.news_image);

                    $('#editPromotion').modal('toggle');
                }
            });
        }
    </script>
@endsection
