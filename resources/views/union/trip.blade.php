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
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">

            <section class="hk-sec-wrapper">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-12">
                        <div class="topic-secondgery">ตารางทริปเดินทาง</div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <span class="form-inline pull-right pull-sm-center">
                            <form action="{{ url($action_search) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <span id="selectdate">
                                    <!-- ปี :  -->
                                    <select name="selectyear" class="form-control" aria-label=".form-select-lg example">
                                            @php
                                                $date_search = "";
                                                if(isset($date_filter)){
                                                    $date_search = $date_filter;
                                                }
                                            @endphp
                                            <?php
                                                $year_now = date('Y');
                                                for($i=0;$i<3;$i++){
                                                    $year_thai = $year_now+543;
                                            ?>
                                                @if($date_search == $year_now)
                                                    <option value="{{ $year_now }}" selected>{{ $year_thai }}</option>
                                                @else
                                                    <option value="{{ $year_now }}">{{ $year_thai }}</option>
                                                @endif
                                            <?php
                                                    $year_now = $year_now-1;
                                                }
                                            ?>
                                        </select>
                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                                </span>
                            </form>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive col-md-12 table-color">
                            <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th>#</th>
                                        <th>ทริปเดือน</th>
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
                                            $trip_revision = DB::table('trip_header_revision_history')
                                                ->where('trip_header_id', $value->id)
                                                ->orderBy('id','desc')
                                                ->first();
                                            if(!is_null($value->trip_date)){
                                                list($year, $month, $day) = explode("-", $value->trip_date);
                                                $year_thai = $year+543;
                                                $date_thai = $month."/".$year_thai;
                                            }else{
                                                $date_thai = "-";
                                            }
                                        @endphp
                                    <tr style="text-align:center;">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $date_thai }}</td>
                                        <td>
                                            @if(!is_null($trip_revision))
                                                @if($trip_revision->trip_day_history != $value->trip_day)
                                                    <span style="text-decoration: line-through;" class="text-red">{{ $trip_revision->trip_day_history }}</span>
                                                @endif
                                            @endif
                                            {{ $value->trip_day }}
                                        </td>
                                        <td>
                                            @if(!is_null($trip_revision))
                                                @if($trip_revision->sum_allowance_history != $value->sum_allowance)
                                                    <span style="text-decoration: line-through;" class="text-red">{{ number_format($trip_revision->sum_allowance_history) }}</span>
                                                @endif
                                            @endif
                                            {{ number_format($value->sum_allowance) }}
                                        </td>
                                        <td>
                                            @if ($value->trip_status == 0)
                                                <span class="badge badge-soft-secondary" style="font-size: 12px;">Darf</span>
                                            @elseif ($value->trip_status == 1)
                                                <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                            @elseif ($value->trip_status == 2)
                                                <span class="badge badge-soft-success"style="font-size: 12px;">Approval</span>
                                            @elseif ($value->trip_status == 3)
                                                <span class="badge badge-soft-danger" style="font-size: 12px;">Re-write</span>
                                            @elseif ($value->trip_status == 4)
                                                <span class="badge badge-soft-info"style="font-size: 12px;">Close</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center;">
                                            @php
                                                $btn_disable = "";
                                                $a_disable = "";
                                                if($value->trip_status != 0 && $value->trip_status != 3){
                                                    $btn_disable = "disabled";
                                                    $a_disable = "pointer-events: none";
                                                }
                                            @endphp
                                            <form action="{{ url($url_request, $value->id) }}" method="GET">

                                            @if($value->trip_status == 0 || $value->trip_status == 3) <!-- สถานะ draf และ re-write -->
                                                @php 
                                                    if(Auth::user()->status == 1){
                                                        $user_lavel = 1;
                                                    }else{
                                                        $user_lavel = 2;
                                                    }
                                                @endphp
                                                <button class="btn btn-icon btn-info btn_request" {{ $btn_disable }} rel="{{ $user_lavel }}">
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
                                                
                                            @else
                                                <a href="{{ url($url_trip_detail) }}/{{ $value->id }}"
                                                    class="btn btn-icon btn-warning">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i class="ion ion-md-map"></i>
                                                    </h4>
                                                </a>
                                                <!-- Report -->
                                                <!-- <a href="{{ url('trip_user_pdf') }}/{{ $value->id }}"
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
                                                </a> -->
                                                <!-- Report -->
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
                        <input type="text" class="form-control" name="api_employee_id" id="api_employee_id" readonly>
                        <input type="hidden" class="form-control" name="api_identify" id="api_identify">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="namesale">ชื่อพนักงาน</label>
                        <input type="text" class="form-control" name="namesale" id="namesale" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">ทริปของเดือน</label>
                        @php 
                            if(!is_null($trips_last)){
                                if(!is_null($trips_last->trip_date)){
                                    $tripdate = strtotime($trips_last->trip_date);
                                    $trip_last = date('Y-m-d', strtotime(' + 1 month', $tripdate));
                                    list($year, $month, $day) = explode('-', $trip_last );
                                    $trip_last = $year."-".$month;
                                }else{
                                    $trip_last = null;
                                }
                            }else{
                                $trip_last = null ;
                            }                         
                        @endphp
                        <input type="month" class="form-control" name="trip_date" id="trip_date" 
                        min="{{ $trip_last }}" value="{{ $trip_last }}" required>
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
                    <input type="text" class="form-control" name="api_employee_id_edit" id="api_employee_id_edit" readonly>
                    <input type="hidden" class="form-control" name="api_identify_edit" id="api_identify_edit" readonly>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="namesale">ชื่อพนักงาน</label>
                    <input type="text" class="form-control" name="namesale_edit" id="namesale_edit" readonly>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputPassword4">ทริปของเดือน</label>
                    <input type="month" class="form-control" name="trip_date_edit" id="trip_date_edit" required>
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
                        <input type="number" class="form-control" name="allowance_edit" id="allowance_edit" 
                        onkeyup="calculator_allowance();" onchange="calculator_allowance();" 
                        onclick="calculator_allowance();" required>
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

function calculator_allowance()
{
    let trip_day = parseInt($('#trip_day_edit').val());
    let allowance = parseInt($('#allowance_edit').val());

    let sum_allowance = trip_day*allowance;

    $('#sum_allowance_edit').val(sum_allowance);
}

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
            $("#api_employee_id").val(response.api_employee_id);
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
            let trip_date = response.trip_header.trip_date.split("-");
            trip_date = trip_date[0]+"-"+trip_date[1];
            $("#api_identify_edit").val(response.api_identify);
            $("#api_employee_id_edit").val(response.api_employee_id);
            $("#namesale_edit").val(response.namesale);
            $("#trip_header_id").val(response.trip_header.id);
            $("#trip_date_edit").val(trip_date);
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
    e.preventDefault();
    var form = $(this).closest("form");
    let user_lavel = $(this).attr('rel');
    let title = "";
    let btn_cancel = "";
    let btn_confirm = "";
    if(user_lavel == 1){
        title = "ขออนุมัติทริปเดินทางใช่หรือไม่ ?";
        btn_cancel = "ยกเลิก";
        btn_confirm = "ขออนุมัติ";
    }else{
        title = "ยืนยันส่งทริปเดินทางใช่หรือไม่ ?";
        btn_cancel = "ยกเลิก";
        btn_confirm = "ยืนยัน";
    }
    swal({
        title: title,
        icon: "warning",
        buttons: [
            btn_cancel,
            btn_confirm
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
