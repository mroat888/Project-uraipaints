@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">สินค้าใหม่</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i
                data-feather="star"></i> บันทึกแจ้งสินค้าใหม่</div>
            <div class="content-right d-flex">
                <button type="button" class="btn btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการแจ้งสินค้าใหม่</div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header" style="margin-bottom: 30px;">
                                <div>
                                </div>
                                <form action="{{url('admin/search-productNew-status-usage')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="d-flex">
                                    <select name="status_usage" class="form-control custom-select">
                                        <option selected disabled>เลือกข้อมูล</option>
                                            <option value="">ทั้งหมด</option>
                                            <option value="1">ใช้งาน</option>
                                            <option value="0">ไม่ใช้งาน</option>
                                    </select>
                                    <button type="submit" class="btn btn-green btn-sm ml-2">ค้นหา</button>
                                </div>
                            </form>
                            </div>
                            <div class="table-responsive col-md-12 table-color">
                                <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>เรื่อง</th>
                                        <th>วันที่อัพเดตล่าสุด</th>
                                        <th>รูปภาพ</th>
                                        <th>สถานะ</th>
                                        <th>URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_new as $key => $value)
                                    @php
                                        $date = Carbon\Carbon::parse($value->updated_at)->addYear(543)->format('d/m/Y');
                                    @endphp
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->product_title}}</td>
                                        <td>{{$date}}</td>
                                        <td>
                                            <a href="{{url('admin/view_product_new_detail', $value->id)}}">
                                                <img src="{{ isset($value->product_image) ? asset('public/upload/ProductNewImage/' . $value->product_image) : '' }}" width="100">
                                            </a>
                                        </td>
                                        <td>
                                            @switch($value->status_usage)
                                                @case(0)
                                                <span class="btn-failed" style="font-size: 12px;">ไม่ใช้งาน</span>
                                                    @break
                                                    @case(1)
                                                    <span class="btn-approve" style="font-size: 12px;">ใช้งานอยู่</span>
                                                        @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if ($value->product_url)
                                                <a href="{{$value->product_url}}" target="_bank" class="btn btn-icon btn-view">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <span class="material-icons">dataset_linked</span>
                                                    </h4>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{url('admin/delete_product_new', $value->id)}}" method="get">
                                                @csrf
                                                <a href="{{ url('admin/update-productNew-status-use', $value->id)}}" class="btn btn-icon btn-teal">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                        class="material-icons">settings_power</span></h4>
                                                </a>
                                                <a href="{{ url('admin/product-new-gallery', $value->id) }}"
                                                    class="btn btn-icon btn-purple">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                            class="material-icons">collections</span></h4>
                                                </a>
                                                <a onclick="edit_modal({{ $value->id }})"
                                                    class="btn btn-icon btn-edit" data-toggle="modal" data-target="#editProductNew">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                        class="material-icons">drive_file_rename_outline</span></h4>
                                                </a>
                                                    @if ($value->status_usage == 0)
                                                    <button type="button" class="btn btn-icon btn-danger delete_product_new">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span
                                                            class="material-icons">delete_outline</span></h4>
                                                    </button>
                                                    @endif
                                            </form>
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
                    <h5 class="modal-title">เพิ่มแจ้งสินค้าใหม่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_product_new" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/create_product_new') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อสินค้า</label>
                                <input class="form-control" placeholder="กรุณาใส่ชื่อเรื่อง" type="text" name="product_title" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่อัพเดตล่าสุด</label>
                                @php
                                    $date2 = Carbon\Carbon::now()->addYear(543);
                                @endphp
                                <input class="form-control" type="text" name="date" value="{{$date2->format('d/m/Y')}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" placeholder="กรุณาใส่รายละเอียด" type="text" name="product_detail" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" placeholder="URL" name="product_url" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ (หน้าปกสินค้า) </label>
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
     <div class="modal fade" id="editProductNew" tabindex="-1" role="dialog" aria-labelledby="editProductNew" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขแจ้งสินค้าใหม่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_update_product_new" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/update_product_new') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อสินค้า</label>
                                <input class="form-control" id="get_title" type="text" name="product_title_edit" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่อัพเดตล่าสุด</label>
                                <input class="form-control" type="text" name="date" value="{{$date2->format('d/m/Y')}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" id="get_detail" type="text" name="product_detail_edit" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" id="get_url" name="product_url_edit" type="text">
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

    <script>
        $("#form_insert_product_new").on("submit", function (e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type:'POST',
                url: '{{ url("admin/create_product_new") }}',
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
                url: "{!! url('admin/edit_product_new/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#img_show').children().remove().end();

                    $('#get_id').val(data.dataEdit.id);
                    $('#get_title').val(data.dataEdit.product_title);
                    $('#get_detail').val(data.dataEdit.product_detail);
                    $('#get_url').val(data.dataEdit.product_url);

                    let img_name = '{{ asset('/public/upload/ProductNewImage') }}/' + data.dataEdit.product_image;
                    if (data.dataEdit.product_image != "") {
                        ext = data.dataEdit.product_image.split('.').pop().toLowerCase();
                        console.log(img_name);
                        if (img_name) {
                            $('#img_show').append('<img src = "' + img_name + '" style="max-width:20%;">');
                        }
                    }

                    $('#editProductNew').modal('toggle');
                }
            });
        }
    </script>

<script>
    $("#form_update_product_new").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("admin/update_product_new") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#editProductNew").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขข้อมูลสำเร็จ',
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
    $(document).ready(function() {
        $('.delete_product_new').click(function(evt) {
            var form = $(this).closest("form");
            evt.preventDefault();

            swal({
                title: `ต้องการลบข้อมูลหรือไม่ ?`,
                text: "ถ้าลบแล้วไม่สามารถกู้คืนข้อมูลได้",
                icon: "warning",
                // buttons: true,
                buttons: [
                    'ยกเลิก',
                    'ตกลง'
                ],
                // infoMode: true
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            })

        });

    });
</script>
@endsection
