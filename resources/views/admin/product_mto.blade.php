@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">รายการสั่งผลิต (MTO)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="archive"></i> สินค้าสั่งผลิต (MTO)</div>
            <div class="content-right d-flex">
                <button type="button" class="btn btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการสินค้าสั่งผลิต (MTO)</div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header" style="margin-bottom: 30px;">
                                <div>
                                </div>
                                <span class="form-inline pull-right">
                                    <form action="{{url('admin/search-product_mto')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <select name="category" class="form-control" aria-label=".form-select-lg example">
                                            <option value="" selected>หมวดสินค้า</option>
                                            @foreach ($groups as $key => $value)
                                                <option value="{{$groups[$key]['id']}}">{{$groups[$key]['group_name']}}</option>
                                            @endforeach
                                        </select>

                                        <select name="brand" class="form-control" aria-label=".form-select-lg example">
                                            <option value="" selected>ชื่อแบรนด์สินค้า</option>
                                            @foreach ($brands as $key => $value)
                                                <option value="{{$brands[$key]['id']}}">{{$brands[$key]['brand_name']}}</option>
                                            @endforeach
                                        </select>

                                        <select name="status_usage" class="form-control">
                                            <option selected disabled>เลือกข้อมูล</option>
                                                <option value="">ทั้งหมด</option>
                                                <option value="1">ใช้งาน</option>
                                                <option value="0">ไม่ใช้งาน</option>
                                        </select>
                                        <button type="submit" class="btn btn-green btn-sm ml-2">ค้นหา</button>
                                </form>
                                </span>

                            </div>
                            <div class="table-responsive col-md-12 table-color">
                                <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>คำอธิบายอายุจัดเก็บสินค้า</th>
                                        <th>วันที่อัพเดตล่าสุด</th>
                                        <th>รูปภาพ</th>
                                        <th>สถานะ</th>
                                        <th>URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_mto as $key => $value)
                                    @php
                                        $date = Carbon\Carbon::parse($value->updated_at)->addYear(543)->format('d/m/Y');
                                    @endphp
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{!! Str::limit($value->description,40) !!}</td>
                                        <td>{{$date}}</td>
                                        <td>
                                            <a href="{{url('admin/view_product_mto_detail', $value->id)}}">
                                                <img src="{{ isset($value->image) ? asset('public/upload/ProductMTO/' . $value->image) : '' }}" width="100">
                                            </a>
                                        </td>
                                        <td>
                                            @switch($value->status)
                                                @case(0)
                                                <span class="btn-failed" style="font-size: 12px;">ไม่ใช้งาน</span>
                                                    @break
                                                    @case(1)
                                                    <span class="btn-approve" style="font-size: 12px;">ใช้งานอยู่</span>
                                                        @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if ($value->url)
                                                <a href="{{$value->url}}" target="_bank" class="btn btn-icon btn-view">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <span class="material-icons">dataset_linked</span>
                                                    </h4>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                                <a href="{{ url('admin/update-productMto-status-use', $value->id)}}" class="btn btn-icon btn-teal">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                        class="material-icons">settings_power</span></h4>
                                                </a>
                                                <a onclick="edit_modal({{ $value->id }})"
                                                    class="btn btn-icon btn-edit" data-toggle="modal" data-target="#editProductMto">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                        class="material-icons">drive_file_rename_outline</span></h4>
                                                </a>
                                                    @if ($value->status == 0)
                                                    <button type="button" class="btn btn-icon btn-danger" id="btn_mto_delete" value="{{ $value->id }}">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span
                                                            class="material-icons">delete_outline</span></h4>
                                                    </button>
                                                    @endif
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
                    <h5 class="modal-title">เพิ่มสินค้าสั่งผลิต (MTO)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_product_mto" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/create_product_catalog') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">หมวด</label>
                                <select name="category_id" class="form-control custom-select select2" required>
                                    <option value="" selected disabled>กรุณาเลือกหมวด</option>
                                    @foreach ($groups as $key => $value)
                                        <option value="{{$groups[$key]['id']}}">{{$groups[$key]['group_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่อัพเดตล่าสุด</label>
                                @php
                                    $date2 = Carbon\Carbon::now()->addYear(543);
                                @endphp
                                <input class="form-control" type="text" name="date" value="{{$date2->format('d/m/Y')}}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">แบรนด์สินค้า</label>
                                <select name="brand_id" class="form-control custom-select select2" required>
                                    <option value="" selected disabled>กรุณาเลือกแบรนด์สินค้า</option>
                                    @foreach ($brands as $key => $value)
                                        <option value="{{$brands[$key]['id']}}">{{$brands[$key]['brand_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">คำอธิบาย (Description)</label>
                            <textarea class="form-control" cols="30" rows="5" placeholder="คำอธิบาย (Description)" type="text" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" placeholder="URL" name="url" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ (หน้าปก) </label>
                                <input type="file" name="image" class="form-control">
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
     <div class="modal fade" id="editProductMto" tabindex="-1" role="dialog" aria-labelledby="editProductMto" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขสินค้าสั่งผลิต (MTO)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_update_product_mto" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/update_product_age') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">หมวด</label>
                                <select name="category_id" id="category_id" class="form-control custom-select select2">
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่อัพเดตล่าสุด</label>
                                <input class="form-control" type="text" name="date" value="" id="get_date" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">แบรนด์สินค้า</label>
                                <select name="brand_id" id="brand_id" class="form-control custom-select select2">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" id="get_description" type="text" name="description_edit"></textarea>
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
                                <input type="file" name="image_edit" id="get_image" class="form-control">
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

    <!-- Modal Delete -->
    <div class="modal fade" id="ModalAgeDelete" tabindex="-1" role="dialog" aria-labelledby="ModalAgeDelete"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="from_age_delete" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบข้อมูลสินค้าสั่งผลิต (MTO) ใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบข้อมูลสินค้าสั่งผลิต (MTO) ใช่หรือไม่ ?</h3>
                        <input class="form-control" id="mto_id_delete" name="mto_id_delete" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .img_1 {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px;
        }
    </style>

    <script>
        $("#form_insert_product_mto").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: '{{ url("admin/create_product_mto") }}',
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
                            text: "บันทึกข้อมูลสินค้าสั่งผลิต (MTO) เรียบร้อยแล้ว",
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
                url: "{!! url('admin/edit_product_mto/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#img_show').children().remove().end();

                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.updated_at);
                    $('#get_description').val(data.dataEdit.description);
                    $('#get_url').val(data.dataEdit.url);

                    $.each(data.editGroups, function(key, value){
                        if(data.editGroups[key]['id'] == data.dataEdit.category_id){
                            $('#category_id').append('<option value='+data.editGroups[key]['id']+' selected>'+data.editGroups[key]['group_name']+'</option>');
                        }else{
                            $('#category_id').append('<option value='+data.editGroups[key]['id']+'>'+data.editGroups[key]['group_name']+'</option>');
                        }
                    });

                    $.each(data.editBrands, function(key, value){
                        if(data.editBrands[key]['id'] == data.dataEdit.brand_id){
                            $('#brand_id').append('<option value='+data.editBrands[key]['id']+' selected>'+data.editBrands[key]['brand_name']+'</option>');
                        }else{
                            $('#brand_id').append('<option value='+data.editBrands[key]['id']+'>'+data.editBrands[key]['brand_name']+'</option>');
                        }
                    });

                    let img_name = '{{ asset('/public/upload/ProductMTO') }}/' + data.dataEdit.image;
                    if (data.dataEdit.image != "") {
                        ext = data.dataEdit.image.split('.').pop().toLowerCase();
                        console.log(img_name);
                        if (img_name) {
                            $('#img_show').append('<img src = "' + img_name + '" style="max-width:20%;">');
                        }
                    }

                    $('#editProductMto').modal('toggle');
                }
            });
        }
    </script>

<script>
    $("#form_update_product_mto").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: '{{ url("admin/update_product_mto") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#editProductMto").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: "แก้ไขข้อมูลสินค้าสั่งผลิต (MTO) เรียบร้อยแล้ว",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'แก้ไขข้อมูลไม่สำเร็จ',
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
    $(document).on('click', '#btn_mto_delete', function() { // ปุ่มลบ Slaplan
            let mto_id_delete = $(this).val();
            $('#mto_id_delete').val(mto_id_delete);
            $('#ModalAgeDelete').modal('show');
        });

        $("#from_age_delete").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/delete_mto') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบข้อมูลสำเร็จ!',
                        text: "ลบข้อมูลสินค้าสั่งผลิต (MTO) เรียบร้อยแล้ว",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalAgeDelete').modal('hide');
                    $('#btn_mto_delete').prop('disabled', true);
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
