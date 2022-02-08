@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">คุณสมบัติสินค้า</li>
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
                    data-feather="grid"></i></span></span>บันทึกคุณสมบัติสินค้า</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">ตารางคุณสมบัติสินค้า</h5>
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
                                    <tr align="center">
                                        <th>#</th>
                                        <th>เรื่อง</th>
                                        <th>URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($propertys as $key => $value)
                                    <tr align="center">
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->property_title}}</td>
                                        <td>{{$value->property_url}}</td>
                                        <td style="width: 10px;">
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#editProductProperty">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                        </td>
                                        <td align="left">
                                            <form action="{{url('admin/delete_product_property', $value->id)}}" method="get">
                                                @csrf
                                            <button type="button" class="btn btn-icon btn-danger delete_product_property">
                                                <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></button>
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
                    <h5 class="modal-title">ฟอร์มบันทึกคุณสมบัติสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_product_property" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/create_product_property') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อสินค้า</label>
                                <input class="form-control" placeholder="กรุณาใส่ชื่อเรื่อง" type="text" name="property_title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" placeholder="กรุณาใส่รายละเอียด" type="text" name="property_detail" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" placeholder="URL" name="property_url" type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
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
     <div class="modal fade" id="editProductProperty" tabindex="-1" role="dialog" aria-labelledby="editProductProperty" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขคุณสมบัติสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_update_product_property" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/update_product_property') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อสินค้า</label>
                                <input class="form-control" id="get_title" type="text" name="property_title_edit" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" id="get_detail" type="text" name="property_detail_edit" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" id="get_url" name="property_url_edit" type="text">
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
        $("#form_insert_product_property").on("submit", function (e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type:'POST',
                url: '{{ url("admin/create_product_property") }}',
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
                url: "{!! url('admin/edit_product_property/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_title').val(data.dataEdit.property_title);
                    $('#get_detail').val(data.dataEdit.property_detail);
                    // $('#get_image').val(data.dataEdit.property_image);
                    $('#get_url').val(data.dataEdit.property_url);

                    $('#editProductProperty').modal('toggle');
                }
            });
        }
    </script>

<script>
    $("#form_update_product_property").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("admin/update_product_property") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#editProductProperty").modal('hide');
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
        $('.delete_product_property').click(function(evt) {
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
