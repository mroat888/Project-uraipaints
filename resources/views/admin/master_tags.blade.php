@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">ป้ายกำกับ (บันทึกโน๊ต)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="bookmark"></i> บันทึกป้ายกำกับ (บันทึกโน๊ต)</div>
            <div class="content-right d-flex">
                <button type="button" class="btn btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการป้ายกำกับ (บันทึกโน๊ต)</div>
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
                                        <th>ชื่อป้ายกำกับ</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tags as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->name_tag}}</td>
                                        <td>
                                            <div class="row">
                                                <button onclick="edit_modal({{ $value->id }})"
                                                    class="btn btn-icon btn-edit mr-10" data-toggle="modal" data-target="#editMasterTag">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span  class="material-icons">drive_file_rename_outline</span></h4>
                                                </button>

                                                <form action="{{url('admin/delete_master_tag', $value->id)}}" method="get">
                                                    @csrf
                                                <button type="button" class="btn btn-icon btn-danger delete_master_tag">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span  class="material-icons">delete_outline</span></h4>
                                                </button>
                                                </form>
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
                    <h5 class="modal-title">ฟอร์มบันทึกป้ายกำกับ (บันทึกโน๊ต)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_master_tag" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/create_master_tag') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="present_title">ชื่อป้ายกำกับ</label>
                                <input class="form-control" placeholder="กรุณาใส่ชื่อรายการนำเสนอ" type="text" name="name_tag" required>
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
     <div class="modal fade" id="editMasterTag" tabindex="-1" role="dialog" aria-labelledby="editMasterTag" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขป้ายกำกับ (บันทึกโน๊ต)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_update_master_tag" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/update_product_new') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name_tag_edit">ชื่อป้ายกำกับ</label>
                                <input class="form-control" id="get_name" type="text" name="name_tag_edit">
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
        $("#form_insert_master_tag").on("submit", function (e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type:'POST',
                url: '{{ url("admin/create_master_tag") }}',
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
                url: "{!! url('admin/edit_master_tag/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_name').val(data.dataEdit.name_tag);

                    $('#editMasterTag').modal('toggle');
                }
            });
        }
    </script>

<script>
    $("#form_update_master_tag").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("admin/update_master_tag") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#editMasterTag").modal('hide');
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
        $('.delete_master_tag').click(function(evt) {
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
