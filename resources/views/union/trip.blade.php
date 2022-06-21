<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent" style="margin-top: -15px;">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active">แผนงานประจำเดือน</li>
        <li class="breadcrumb-item active" aria-current="page">ทริปเดินทาง</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container-fluid px-xxl-65 px-xl-20">
    <!-- Title -->
    <div class="hk-pg-header mb-10">
        <div class="topichead-bgred"><i data-feather="clipboard"></i> รายการทริปเดินทาง</div>
        <div class="content-right d-flex">
            <button type="button" class="btn btn-green" data-toggle="modal" id="createmodal"> + เพิ่มใหม่ </button>
        </div>
    </div>
    <!-- /Title -->
    <!-- Title -->
    {{-- <div class="hk-pg-header mb-10">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-people"></i></span>รายการทริปเดินทาง</h4>
        </div>
        <div class="d-flex">
            <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" id="createmodal"> + เพิ่มใหม่ </button>
        </div>
    </div> --}}
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">

            <section class="hk-sec-wrapper">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-12">
                        <div class="topic-secondgery">ตารางทริปเดินทาง</div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive col-md-12 table-color">
                            <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th>#</th>
                                        <th>วันที่</th>
                                        <th>จำนวนวัน</th>
                                        <th>ค่าเบี้ยเลื้ยง</th>
                                        <th>การอนุมัติ</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($trips) > 0)
                                    @foreach($trips as $key => $value)
                                        @php
                                            list($date, $time) = explode(" ", $value->created_at);
                                            list($year, $month, $day) = explode("-", $date);
                                            $year_thai = $year+543;
                                            $date_thai = $day."/".$month."/".$year_thai;
                                        @endphp
                                    <tr style="text-align:center;">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $date_thai }}</td>
                                        <td>{{ $value->trip_day }}</td>
                                        <td>{{ number_format($value->sum_allowance) }}</td>
                                        <td>
                                            @if ($value->trip_status == 0)
                                                <span class="badge badge-soft-secondary" style="font-size: 12px;">Darf</span>
                                            @elseif ($value->trip_status == 1)
                                                <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                            @elseif ($value->trip_status == 2)
                                                <span class="badge badge-soft-success"style="font-size: 12px;">Approval</span>
                                            @elseif ($value->trip_status == 3)
                                                <span class="badge badge-soft-danger" style="font-size: 12px;">Reject</span>
                                            @elseif ($value->trip_status == 4)
                                                <span class="badge badge-soft-info"style="font-size: 12px;">Close</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center;">
                                            @php
                                                $btn_disable = "";
                                                $a_disable = "";
                                                if($value->trip_status != 0){
                                                    $btn_disable = "disabled";
                                                    $a_disable = "pointer-events: none";
                                                }
                                            @endphp
                                            <form action="{{ url($url_request, $value->id) }}" method="GET">

                                            @if($value->trip_status > 1) <!-- ตั้งแต่อนุมัติ -->
                                                <!-- Report -->
                                                <a href="{{ url('trip_user_pdf') }}/{{ $value->id }}"
                                                    class="btn btn-icon btn-danger" target="_blank">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <span class="material-icons">picture_as_pdf</span>
                                                    </h4>
                                                </a>
                                                <a href="{{ url('trip_user_excel') }}/{{ $value->id }}"
                                                    class="btn btn-icon btn-excel">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <span class="material-icons">table_view</span>
                                                    </h4>
                                                </a>
                                                <!-- Report -->
                                            @else
                                                <button class="btn btn-icon btn-info btn_request" {{ $btn_disable }}>
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i class="ion ion-md-send"></i>
                                                    </h4>
                                                </button>

                                                <button class="btn btn-icon btn-edit btn_edittrip"
                                                    value="{{ $value->id }}" {{ $btn_disable }}>
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i class="ion ion-md-create"></i>
                                                    </h4>
                                                </button>

                                                <a href="{{ url($url_trip_detail) }}/{{ $value->id }}"
                                                    class="btn btn-icon btn-warning" style="{{ $a_disable }}">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i class="ion ion-md-map"></i>
                                                    </h4>
                                                </a>

                                                <button class="btn btn-icon btn-red mr-10 btn_deletetrip"
                                                    value="{{ $value->id }}" {{ $btn_disable }}>
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i class="ion ion-md-trash"></i>
                                                    </h4>
                                                </button>
                                            @endif

                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- /Container -->

<!-- Modal Insert -->
<div class="modal fade" id="Modalcreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ทริปเดินทาง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="form_insert" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="api_identify">รหัสพนักงาน</label>
                        <input type="text" class="form-control" name="api_identify" id="api_identify" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="namesale">ชื่อพนักงาน</label>
                        <input type="text" class="form-control" name="namesale" id="namesale" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">วันที่สร้าง</label>
                        <input type="text" class="form-control" name="created_at" id="created_at" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">จากวันที่</label>
                        <input type="date" class="form-control" name="trip_start" id="trip_start" placeholder="จากวันที่" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">ถึงวันที่</label>
                        <input type="date" class="form-control" name="trip_end" id="inputPassword4" placeholder="ถึงวันที่" disabled>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">จำนวนวัน</label>
                        <input type="number" class="form-control" name="trip_day" id="trip_day" placeholder="จำนวนวัน" disabled>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">อัตราเบี้ยเลี้ยง/วัน *</label>
                        <input type="number" class="form-control" name="allowance" id="allowance" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">รวมค่าเบี้ยเลี้ยง</label>
                        <input type="number" class="form-control" name="sum_allowance" id="sum_allowance" placeholder="รวมค่าเบี้ยเลี้ยง" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-primary">บันทึก</button>
            </div>

        </form>

    </div>
  </div>
</div>
<!-- End Modal Insert -->

<!-- Modal Edit -->
<div class="modal fade" id="Modaledit" tabindex="-1" aria-labelledby="Modaledit" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Modaledit">ทริปเดินทาง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form id="form_edit" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" id="trip_header_id" name="trip_header_id" class="form-control">
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="api_identify">รหัสพนักงาน</label>
                    <input type="text" class="form-control" name="api_identify_edit" id="api_identify_edit" readonly>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="namesale">ชื่อพนักงาน</label>
                    <input type="text" class="form-control" name="namesale_edit" id="namesale_edit" readonly>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputPassword4">วันที่สร้าง</label>
                    <input type="text" class="form-control" name="created_at_edit" id="created_at_edit"  readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">จากวันที่</label>
                        <input type="date" class="form-control" name="trip_start_edit" id="trip_start_edit" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">ถึงวันที่</label>
                        <input type="date" class="form-control" name="trip_end_edit" id="trip_end_edit" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">จำนวนวัน</label>
                        <input type="number" class="form-control" name="trip_day_edit" id="trip_day_edit" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">อัตราเบี้ยเลี้ยง/วัน</label>
                        <input type="number" class="form-control" name="allowance_edit" id="allowance_edit" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">รวมค่าเบี้ยเลี้ยง</label>
                        <input type="number" class="form-control" name="sum_allowance_edit" id="sum_allowance_edit" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-primary">บันทึก</button>
            </div>

        </form>

    </div>
  </div>
</div>
<!-- End Modal Edit -->

<!-- Modal Delete -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="ModalDelete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="from_delete" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">คุณต้องการลบข้อมูล ทริปเดินทาง ใช่หรือไม่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <h3>คุณต้องการลบข้อมูล<br>ทริปเดินทาง ใช่หรือไม่ ?</h3>
                    <input type="hidden" id="trip_header_id_delete" name="trip_header_id_delete" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Modal Delete -->

<script>

    $(document).on('click', '#createmodal', function(e){
        e.preventDefault();
        $.ajax({
            type:'GET',
            url: '{{ url("trip/create") }}',
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                $("#api_identify").val(response.api_identify);
                $("#namesale").val(response.namesale);
                $("#Modalcreate").modal('show');
            }
        });
    });

    $(document).on('click', '.btn_edittrip', function(e){
        e.preventDefault();
        var trip_id = $(this).val();
        $.ajax({
            type:'GET',
            url: '{{ url("trip/edit") }}/' + trip_id,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                let date_create = response.trip_header.created_at.split(" ");
                $("#api_identify_edit").val(response.api_identify);
                $("#namesale_edit").val(response.namesale);
                $("#trip_header_id").val(response.trip_header.id);
                $("#created_at_edit").val(date_create[0]);
                $("#trip_start_edit").val(response.trip_header.trip_start);
                $("#trip_end_edit").val(response.trip_header.trip_end);
                $("#trip_day_edit").val(response.trip_header.trip_day);
                $("#allowance_edit").val(response.trip_header.allowance);
                $("#sum_allowance_edit").val(response.trip_header.sum_allowance);

                $("#Modaledit").modal('show');
            }
        });
    });

    $(document).on('click', '.btn_deletetrip', function(e){
        e.preventDefault();
        let trip_id_delete = $(this).val();
        $('#trip_header_id_delete').val(trip_id_delete);
        $('#ModalDelete').modal('show');
    });

    $(document).on('click', '.btn_request', function(e){
        var form = $(this).closest("form");
        e.preventDefault();

        swal({
            title: `ขออนุมัติทริปเดินทางใช่หรือไม่ ?`,
            icon: "warning",
            buttons: [
                'ยกเลิก',
                'ขออนุมัติ'
            ],
            infoMode: true
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        })
    });

    $("#form_insert").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("trip/insert") }}',
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
                    });
                    $("#Modalcreate").modal('hide');
                    window.location.href= '{{ url($url_trip_detail) }}/'+response.trip_id;
                    // location.reload();
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

    $("#form_edit").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("trip/update") }}',
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
                    });
                    $("#Modaledit").modal('hide');
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

    $("#from_delete").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("trip/delete") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been delete',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#ModalDelete').modal('hide');
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Your work has been delete',
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
