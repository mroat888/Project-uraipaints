@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">กลุ่มและทีม</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="users"></i> บันทึกรายการกลุ่มและทีม</div>
            <div class="content-right d-flex">
                <button type="button" class="btn btn-green" data-toggle="modal" data-target="#modalInsert"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการกลุ่มและทีม</div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header mb-10">
                                <div>
                                </div>
                            </div>
                            <div class="table-responsive col-md-12 table-color">
                                <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อทีม</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teamSales as $key => $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->team_name }}</td>
                                        <td>
                                            <div class="button-list">
                                                <button class="btn btn-icon btn-edit mr-10 btn_edit" value="{{ $value->id }}">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                        class="material-icons">drive_file_rename_outline</span></h4>
                                                </button>
                                                <a href="{{ url('admin/teamSales_detail', $value->id)}}" class="btn btn-icon btn-view mr-10">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span
                                                        class="material-icons">assignment</span></h4>
                                                </a>
                                                <!-- <button class="btn btn-icon btn-danger mr-10">
                                                    <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></button> -->
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

    <!-- Modal Add -->
    <div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มบันทึกกลุ่มและทีม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ชื่อกลุ่มและทีม</label>
                                <input type="text" name="team_name" id="team_name" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">เขตพื้นที่ขาย</label>
                                <select class="form-control custom-select mt-15" name="team_api" id="team_api">
                                    <option selected disabled>เลือกสาขา</option>
                                    @if(isset($salezones_api) && !is_null($salezones_api))
                                        @foreach ($salezones_api as $key => $value)
                                            <option value="{{ $value['identify'] }}">{{ $value['description'] }}</option>
                                        @endforeach
                                    @endif
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

    <!-- Modal Edit -->
    <div class="modal fade" id="Modaleditteam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขกลุ่มและทีม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="team_id_edit" id="team_id_edit" class="form-control">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ชื่อกลุ่มและทีม</label>
                                <input type="text" name="team_name_edit" id="team_name_edit" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="firstName">เขตพื้นที่ขาย</label>
                                <select class="form-control custom-select mt-15" name="team_api_edit" id="team_api_edit">
                                    <option selected disabled>เลือกสาขา</option>
                                    @if(isset($salezones_api) && !is_null($salezones_api))
                                        @foreach ($salezones_api as $key => $value)
                                            <option value="{{ $value['identify'] }}">{{ $value['description'] }}</option>
                                        @endforeach
                                    @endif
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



    <script>

    $("#form_insert").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/admin/teamsalesCreate") }}',
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

    $(document).on('click','.btn_edit', function(){
        let team_id = $(this).val();
        // console.log(team_id);
        $.ajax({
            type:'GET',
            url: '{{ url("/admin/teamsalesEdit") }}/'+team_id,
            datatype: 'json',
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#team_id_edit").val(team_id);
                    $("#Modaleditteam").modal('show');
                    $("#team_name_edit").val(response.data.team_name);
                    $("#team_api_edit").val(response.data.team_api);
                }
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

    $("#form_edit").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/admin/teamsalesUpdate") }}',
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
