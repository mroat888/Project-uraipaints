@extends('layouts.masterAdmin')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ข้อมูลผู้ใช้งานและกำหนดสิทธิ์</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="file-text"></i></span></span>บันทึกข้อมูลผู้ใช้งานและกำหนดสิทธิ์</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal"
                    data-target="#modalInsert"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">ตารางข้อมูลผู้ใช้งาน</h5>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="hk-pg-header mb-10">
                            <div>
                            </div>
                            <div class="d-flex">
                                <input type="text" name="" id="" class="form-control form-control-sm" placeholder="ค้นหา">
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>อีเมล์</th>
                                    <th>สิทธิ์การใช้งาน</th>
                                    <th>ทีม</th>
                                    <th>การใช้งาน</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>
                                    @php
                                        foreach($master_permission as $value_permiss){
                                            if($value->status ==  $value_permiss->id){
                                                echo "<span class='badge badge-soft-violet' style='font-size: 14px;'>$value_permiss->permission_name</span>";
                                            }
                                        }
                                    @endphp
                                    </td>
                                    <td>
                                    @php
                                        foreach($master_team as $value_team){
                                            if($value->team_id ==  $value_team->id){
                                                echo "<span class='badge badge-soft-success' style='font-size: 14px;'>$value_team->team_name</span>";
                                            }
                                        }
                                    @endphp
                                    </td>
                                    <td>
                                        @if ($value->status_use == 1)
                                        <span class='badge badge-soft-teal' style='font-size: 14px;'>ใช้งานอยู่</span>
                                        @else
                                        <span class='badge badge-soft-danger' style='font-size: 14px;'>ปิดใช้งาน</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="button-list">
                                            <a href="{{ url('admin/update-status-use', $value->id)}}" class="btn btn-icon btn-teal mr-10">
                                                <span class="btn-icon-wrap"><i data-feather="power"></i></span></a>
                                            <button class="btn btn-icon btn-warning mr-10 btn_edit" value="{{ $value->id }}">
                                                <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                @if ($value->status_use == 0)
                                                <button class="btn btn-icon btn-danger mr-10">
                                                    <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></button>
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
    <div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มบันทึกข้อมูลผู้ใช้งาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ชื่อผู้ใช้งาน</label>
                                <input type="text" name="tname" id="tname" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">อีเมล์</label>
                                <input type="email" name="temail" id="temail" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">รหัสผ่าน</label>
                                <input type="password" name="tpassword" id="tpassword" class="form-control" placeholder="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สิทธิ์การใช้งาน</label>
                                <select id="sel_status" name="sel_status" class="form-control custom-select">
                                    <option selected disabled>เลือกข้อมูล</option>
                                    @foreach($master_permission as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->permission_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="username">ชื่อพนักงาน</label>
                                <select name="sel_api_identify" id="sel_api_identify" class="form-control custom-select select2">
                                    <option value="" selected disabled>เลือกข้อมูล</option>
                                    @foreach ($sellers_api as $key => $value)
                                        <option value="{{$sellers_api[$key]['id']}}">{{$sellers_api[$key]['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">ทีม</label>
                                <select id="sel_team" name="sel_team" class="form-control custom-select">
                                    <option selected disabled>เลือกข้อมูล</option>
                                    @foreach($master_team as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->team_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal modaledit -->
    <div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"aria-hidden="true">
        @include('admin.user_permission_edit')
    </div>



<script>

    $(".btn_edit").on("click", function(e){
        e.preventDefault();
        let user_id = $(this).val();

        $.ajax({
            method: 'GET',
            url: '{{ url("/admin/userPermissionEdit") }}/'+user_id,
            datatype: 'json',
            success: function(response){
                console.log(response);
                if(response.status == 200){
                    $('#edit_sel_status').children().remove().end();
                    $('#edit_sel_api_identify').children().remove().end();
                    $('#edit_sel_team').children().remove().end();
                    $("#modaledit").modal('show');
                    $('#edit_tuser_id').val(user_id);
                    $('#edit_tname').val(response.dataUser.name);
                    $('#edit_temail').val(response.dataUser.email);

                    $.each(response.master_permission, function(key, value){
                        if(value.id == response.dataUser.status){
                            $('#edit_sel_status').append('<option value='+value.id+' selected>'+value.permission_name+'</option>');
                        }else{
                            $('#edit_sel_status').append('<option value='+value.id+'>'+value.permission_name+'</option>');
                        }
                    });

                    $.each(response.sellers_api, function(key, value){
                        if(response.sellers_api[key]['id'] == response.dataUser.api_identify){
                            $('#edit_sel_api_identify').append('<option value='+response.sellers_api[key]['id']+' selected>'+response.sellers_api[key]['name']+'</option>');
                        }else{
                            $('#edit_sel_api_identify').append('<option value='+response.sellers_api[key]['id']+'>'+response.sellers_api[key]['name']+'</option>');
                        }
                    });

                    $.each(response.master_teamsale, function(key, value){
                        if(value.id == response.dataUser.team_id){
                            $('#edit_sel_team').append('<option value='+value.id+' selected>'+value.team_name+'</option>');
                        }else{
                            $('#edit_sel_team').append('<option value='+value.id+'>'+value.team_name+'</option>');
                        }
                    });

                }
            }
        });
    });

    $("#form_insert").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/admin/userPermissionCreate") }}',
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
                    $("#modalInsert").modal('hide');
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


