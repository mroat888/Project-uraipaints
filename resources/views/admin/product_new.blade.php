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
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="star"></i></span></span>บันทึกแจ้งสินค้าใหม่</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">รายการแจ้งสินค้าใหม่</h5>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header mb-10">
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
                                        <th>วันที่อัพเดตล่าสุด</th>
                                        <th>รูปภาพ</th>
                                        <th>สถานะ</th>
                                        <th>URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_new as $key => $value)
                                    <?php $createdAt = Carbon\Carbon::parse($value->created_at); ?>
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->product_title}}</td>
                                        <td>{{$createdAt->format('Y-m-d')}}</td>
                                        <td><img src="{{ isset($value->product_image) ? asset('public/upload/ProductNewImage/' . $value->product_image) : '' }}" width="100"></td>
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
                                        <td><a href="{{$value->product_url	}}" style="color: rgb(11, 8, 141);">{!! Str::limit($value->product_url,20) !!}</a></td>
                                        {{-- <td>
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-warning" data-toggle="modal" data-target="#editProductNew">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                        </td> --}}
                                        <td>
                                            <form action="{{url('admin/delete_product_new', $value->id)}}" method="get">
                                                @csrf
                                                <a href="{{ url('admin/update-productNew-status-use', $value->id)}}" class="btn btn-icon btn-teal">
                                                    <span class="btn-icon-wrap"><i data-feather="power"></i></span></a>
                                                <div onclick="edit_modal({{ $value->id }})"
                                                    class="btn btn-icon btn-warning" data-toggle="modal" data-target="#editProductNew">
                                                    <span class="btn-icon-wrap"><i data-feather="edit"></i></span></div>
                                                    @if ($value->status_usage == 0)
                                                    <button type="button" class="btn btn-icon btn-danger delete_product_new">
                                                        <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></button>
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
                                <input class="form-control" type="text" name="date" value="{{ date('Y-m-d') }}" readonly>
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
                                <label for="firstName">รูปภาพ (หน้าปก)</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ (อัลบั้ม)</label>
                                <input type="file" name="alabum[]" class="form-control">
                            </div>
                        </div> --}}
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
                    <h5 class="modal-title">ฟอร์มแก้ไขสินค้าใหม่</h5>
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
                        </div>
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" cols="30" rows="5" id="get_detail" type="text" name="product_detail_edit" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" id="get_url" name="product_url_edit" type="text">
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
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_title').val(data.dataEdit.product_title);
                    $('#get_detail').val(data.dataEdit.product_detail);
                    // $('#get_image').val(data.dataEdit.product_image);
                    $('#get_url').val(data.dataEdit.product_url);
                    // $('#get_image').val(data.dataEdit.product_image);

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
