@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item">โปรโมชั่น</li>
        <li class="breadcrumb-item">บันทึกแจ้งรายการโปรโมชั่น</li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มแบนเนอร์</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i class="ion ion-md-image"></i> เพิ่มแบนเนอร์</div>
            <div class="content-right d-flex">
                <button type="button" class="btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
                <a href="{{ url('admin/pomotion')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">รายการรูปภาพแบนเนอร์</h5>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header mb-10">
                                <div>
                                </div>
                            </div>
                            <div class="table-responsive table-color col-md-12">
                                <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รูปภาพ</th>
                                        <th>รายละเอียด</th>
                                        <th>วันที่เริ่มต้น</th>
                                        <th>วันที่สิ้นสุด</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_banner as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td><img src="{{ isset($value->banner) ? asset('public/upload/NewsBanner/' . $value->banner) : '' }}" width="200"></td>
                                        <td>{{$value->detail}}</td>
                                        <td>{{$value->date}}</td>
                                        <td>{{$value->date_last}}</td>
                                        <td>
                                            <div class="button-list">
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-edit mr-10" data-toggle="modal" data-target="#editBanner">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">
                                                            drive_file_rename_outline</span></h4>
                                                    </button>
                                                    <button id="btn_promotion_delete" class="btn btn-icon btn-danger"
                                                    value="{{ $value->id }}">
                                                       <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">
                                                           delete_outline</span></h4>
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
                    <h5 class="modal-title">ฟอร์มเพิ่มแบนเนอร์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_promotionBanner" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/create_promotionBanner') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="detail">รายละเอียดเกี่ยวกับแบนเนอร์</label>
                        <input class="form-control" type="text" name="detail" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="banner">รูปภาพ</label>
                        <input class="form-control" type="file" name="banner" required>
                    </div>
                    </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="banner">วันที่เริ่มต้น</label>
                                <input class="form-control" type="date" name="date" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="banner">วันที่สิ้นสุด</label>
                                <input class="form-control" type="date" name="date_last" required>
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
     <div class="modal fade" id="editBanner" tabindex="-1" role="dialog" aria-labelledby="editBanner" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขแบนเนอร์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/update_promotionBanner') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="detail">รายละเอียดเกี่ยวกับแบนเนอร์</label>
                        <input class="form-control" type="text" name="detail" id="get_detail" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="banner">รูปภาพ</label>
                        <input class="form-control" type="file" id="get_image" name="banner">
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="banner">วันที่เริ่มต้น</label>
                            <input class="form-control" type="date" name="date" id="get_date" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="banner">วันที่สิ้นสุด</label>
                            <input class="form-control" type="date" name="date_last" id="get_date_last" required>
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
         <form id="from_promotion_delete" enctype="multipart/form-data">
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
                     <input class="form-control" id="promotion_id_delete" name="promotion_id_delete" type="hidden" />
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
        $("#form_insert_promotionBanner").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: '{{ url("admin/create_promotionBanner") }}',
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


        //Edit
        function edit_modal(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('admin/edit_promotionBanner/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.date);
                    $('#get_date_last').val(data.dataEdit.date_last);
                    $('#get_detail').val(data.dataEdit.detail);
                    $('#get_image').val(data.dataEdit.banner);


                    $('#editBanner').modal('toggle');
                }
            });
        }

        $(document).on('click', '#btn_promotion_delete', function() { // ปุ่มลบ
        let promotion_id_delete = $(this).val();
        $('#promotion_id_delete').val(promotion_id_delete);
        $('#ModalNewsDelete').modal('show');
    });

    $("#from_promotion_delete").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/delete_promotionBanner') }}',
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
                    $('#btn_promotion_delete').prop('disabled', true);
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });
    </script>
@endsection
