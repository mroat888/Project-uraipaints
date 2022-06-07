@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">ทีม</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="users"></i> บันทึกรายการทีม</div>
            <div class="content-right d-flex">
                <button type="button" class="btn btn-green" data-toggle="modal" data-target="#Modaladdteam"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการทีม</div>
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
                                                    <h4 class="btn-icon-wrap" style="color: white;"><span  class="material-icons">drive_file_rename_outline</span></h4>
                                                </button>
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
    <div class="modal fade" id="Modaladdteam" tabindex="-1" role="dialog" aria-labelledby="Modaladdteam" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มบันทึกทีม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ชื่อทีม</label>
                                <input class="form-control" placeholder="กรุณาใส่ชื่อทีม" type="text" name="team_name" required>
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
    <div class="modal fade" id="Modaleditteam" tabindex="-1" role="dialog" aria-labelledby="Modaleditteam" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขทีม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="team_id_edit" name="team_id_edit">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ชื่อทีม</label>
                                <input type="text" id="team_name_edit" name="team_name_edit" class="form-control" placeholder="กรุณาใส่ชื่อทีม" required>
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
                    $("#Modaladdteam").modal('hide');
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
                    $("#Modaladdteam").modal('hide');
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
