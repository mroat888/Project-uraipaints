@extends('layouts.masterLead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">แก้ไขข้อมูลโปรไฟล์</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="users"></i></span></span>แก้ไขข้อมูลโปรไฟล์</h4>
            </div>
        </div>
        <!-- /Title -->

        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">แก้ไขข้อมูลโปรไฟล์</h5>
            <div class="row">
                <div class="col-sm">
                    <form id="form_edit" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <input type="hidden" name="edit_tuser_id" value="{{ $edit_user->id}}">
                                <div class="col-md-12 form-group">
                                    <label for="firstName">ชื่อผู้ใช้งาน</label>
                                    <input type="text" name="edit_tname" class="form-control" value="{{ $edit_user->name ?? ''}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="firstName">อีเมล์</label>
                                    <input type="email" name="edit_temail" class="form-control" value="{{ $edit_user->email ?? ''}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="firstName">รหัสผ่าน</label>
                                    <input type="password" name="edit_tpassword" class="form-control" placeholder="password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username">สิทธิ์การใช้งาน</label>
                                    <input type="text" name="edit_sel_status" class="form-control" value="{{ $edit_user->permission_name ?? ''}}" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">ชื่อพนักงาน</label>
                                        @foreach ($sellers_api as $value)
                                        @if ($value['id'] == $edit_user->api_identify)
                                            <input type="text" name="edit_sel_api_identify" class="form-control" value="{{ $value['name']}}" readonly>
                                        @endif
                                        @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="username">ทีม</label>
                                    <input type="text" name="edit_sel_team" class="form-control" value="{{ $edit_user->team_name ?? ''}}" readonly>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <!-- /Container -->

    <script>
        $("#form_edit").on("submit", function (e) {
           e.preventDefault();
           var formData = new FormData(this);
           // console.log(formData);
           $.ajax({
               type:'POST',
               url: '{{ url("lead/userProfileUpdate") }}',
               data:formData,
               cache:false,
               contentType: false,
               processData: false,
               success:function(response){
                   console.log(response);
                   if(response.status == 200){
                       Swal.fire({
                           icon: 'success',
                           title: 'Your work has been saved',
                           showConfirmButton: false,
                           timer: 1500
                       })
                       $("#modaledit").modal('hide');
                       location.reload();
                   }else{
                       Swal.fire({
                           icon: 'error',
                           title: 'Your work has been saved',
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

@endsection


