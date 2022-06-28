<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
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
        <div class="topichead-bgred"><i data-feather="file-text"></i> รายการทริปเดินทาง</div>
        <div class="content-right d-flex">
            <a href="{{ url($url_back) }}" type="button" class="btn btn-secondary btn-rounded"> ย้อนกลับ </a>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">ตารางทริปเดินทาง</div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="api_identify">รหัสพนักงาน : {{ $users->api_identify }} </label>
                    </div>
                    <div class="col-md-4">
                        <label for="namesale">ชื่อพนักงาน : {{ $users->name }}</label>
                    </div>
                    <div class="col-md-4">
                        <label for="inputPassword4">วันที่สร้าง :
                            @php
                                list($date_create, $time_create) = explode(" ", $trip_header->created_at);
                                list($year_create, $monht_create, $day_create) = explode("-", $date_create);
                                $year_create_thai = $year_create+543;
                                $created_at_thai = $day_create."/".$monht_create."/".$year_create_thai;
                            @endphp
                            {{ $created_at_thai }}
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="api_identify">จากวันที่ :
                            @php
                                if(!is_null($trip_header->trip_start)){
                                    list($year_start, $month_start, $day_start) = explode("-", $trip_header->trip_start);
                                    $year_start_thai = $year_start+543;
                                    $trip_start_thai = $day_start."/".$month_start."/".$year_start_thai;
                                }else{
                                    $trip_start_thai = "-";
                                }
                                if(!is_null($trip_header->trip_end)){
                                    list($year_end, $month_end, $day_end) = explode("-", $trip_header->trip_end);
                                    $year_end_thai = $year_end+543;
                                    $trip_end_thai = $day_end."/".$month_end."/".$year_end_thai;
                                }else{
                                    $trip_end_thai = "-";
                                }
                            @endphp
                            {{ $trip_start_thai }} ถึง
                            {{ $trip_end_thai }}
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label for="namesale">จำนวนวัน : {{ $trip_header->trip_day }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="inputPassword4">อัตราเบี้ยเลี้ยง/วัน : {{ number_format($trip_header->allowance) }}</label>
                    </div>
                    <div class="col-md-4">
                        <label for="inputPassword4">รวมค่าเบี้ยเลี้ยง : {{ number_format($trip_header->sum_allowance) }}</label>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Row -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">

            <section class="hk-sec-wrapper">
                <div class="hk-pg-header mb-10">
                    <div class="topichead-bggreen">
                        รายการทริปเดินทาง
                    </div>
                    @if($trip_header->trip_status == '0')
                        <div class="content-right d-flex">
                            <button type="button" class="btn-green" data-toggle="modal" id="createmodal"> + เพิ่มใหม่ </button>
                        </div>   
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive col-md-12 table-color">
                            <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>วันที่</th>
                                        <th>จากจังหวัด</th>
                                        <th>ถึงจังหวัด</th>
                                        <th>ร้านค้า</th>
                                        @if($trip_header->trip_status == '0')
                                        <th class="text-center">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($trip_detail))
                                    @foreach($trip_detail as $key => $value)
                                        @php
                                            list($year_date, $month_date, $day_date) = explode("-", $value['trip_detail_date']);
                                            $year_date_thai = $year_date+543;
                                            $trip_detail_date = $day_date."/".$month_date."/".$year_date_thai;
                                        @endphp
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $trip_detail_date }}</td>
                                        <td>{{ $value['trip_from'] }}</td>
                                        <td>{{ $value['trip_to'] }}</td>
                                        <td>
                                            <?php echo nl2br($value['customer_id']); ?>
                                        </td>
                                        @if($trip_header->trip_status == '0')
                                        <td style="text-align:center;">
                                            <button class="btn btn-icon btn-edit btn_edittrip"
                                                value="{{ $value['id'] }}">
                                                <h4 class="btn-icon-wrap" style="color: white;">
                                                    <i class="ion ion-md-create"></i></h4>
                                            </button>

                                            <button class="btn btn-icon btn-red mr-10 btn_deletetrip"
                                                value="{{ $value['id'] }}">
                                                <h4 class="btn-icon-wrap" style="color: white;"><i
                                                        class="ion ion-md-trash"></i></h4>
                                            </button>
                                        </td>
                                        @endif
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
    <!-- Row -->

</div>

<!-- /Container -->

<!-- Modal Insert -->
<div class="modal fade" id="Modalcreate" tabindex="-1" aria-labelledby="Modaltripdetail" aria-hidden="true">
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
                    <input type="hidden" class="form-control" name="trip_header_id" value="{{ $trip_header->id }}">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">วันที่ทริป</label>
                        @php 
                            $trip_date = strtotime($trip_header->trip_date);
                            $trip_lastday = date('Y-m-t',$trip_date);
                            // echo $trip_range;
                        @endphp 
                        <input type="date" class="form-control" name="trip_detail_date" id="trip_detail_date" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="namesale">จากจังหวัด</label>
                        <select name="formprovince" id="formprovince" class="form-control formprovince"
                            style="margin-left:5px; margin-right:5px;" required>
                            <option value="" selected>เลือกจังหวัด</option>
                            @if(isset($provinces) && !is_null($provinces))
                                @foreach($provinces as $key => $value)
                                    @if(!empty($value['identify']))
                                        <option value="{{ $value['identify'] }}">{{ $value['name_thai'] }}</option>
                                    @endif
                                @endforeach
                            @endif

                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">ถึงจังหวัด</label>
                        <select name="toprovince" id="toprovince" class="form-control toprovince"
                            style="margin-left:5px; margin-right:5px;" required>
                            <option value="" selected>เลือกจังหวัด</option>
                            @if(isset($provinces) && !is_null($provinces))
                                @foreach($provinces as $key => $value)
                                    @if(!empty($value['identify']))
                                        <option value="{{ $value['identify'] }}">{{ $value['name_thai'] }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        @php 
                            if(Auth::user()->status == 1){
                                $cust_required = "required"; //-- ผู้แทนขายต้องกรอกร้านค้า
                            }else{
                                $cust_required = "";
                            }
                        @endphp
                        <label for="inputEmail4">ร้านค้า</label>
                        <select class="select2 select2-multiple form-control customer_id" multiple="multiple" id="customer_id"
                        data-placeholder="Choose" name="customer_id[]" {{ $cust_required }}>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" id="btn_save" class="btn btn-primary">บันทึก</button>
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
                <h5 class="modal-title" id="exampleModalLabel">ทริปเดินทาง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <form id="form_edit" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <input type="hidden" class="form-control" id="trip_detail_id" name="trip_detail_id">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">วันที่ทริป</label>
                        <input type="date" class="form-control" name="trip_detail_date_edit" id="trip_detail_date_edit" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="namesale">จากจังหวัด</label>
                        <select name="formprovince_edit" id="formprovince_edit" class="form-control formprovince_edit"
                            style="margin-left:5px; margin-right:5px;" required>
                            <option value="" selected>เลือกจังหวัด</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">ถึงจังหวัด</label>
                        <select name="toprovince_edit" id="toprovince_edit" class="form-control toprovince_edit"
                            style="margin-left:5px; margin-right:5px;" required>
                            <option value="" selected>เลือกจังหวัด</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        @php 
                            if(Auth::user()->status == 1){ //-- ผู้แทนขายต้องกรอกร้านค้า
                                $cust_required = "required";
                            }else{
                                $cust_required = "";
                            }
                        @endphp
                        <label for="inputEmail4">ร้านค้า</label>
                        <select class="select2 select2-multiple form-control customer_id_edit" multiple="multiple" id="customer_id_edit"
                            data-placeholder="Choose" name="customer_id_edit[]" {{ $cust_required }}>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" id="btn_save_edit" class="btn btn-primary">บันทึก</button>
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
                    <input type="hidden" id="trip_detail_id_delete" name="trip_detail_id_delete" class="form-control">
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

    $(document).on('click', '#createmodal', function(){
        $("#Modalcreate").modal('show')
    });

    $(document).on('click', '.btn_deletetrip', function(e){
        e.preventDefault();
        let trip_id_delete = $(this).val();
        $('#trip_detail_id_delete').val(trip_id_delete);
        $('#ModalDelete').modal('show');
    });

    $(document).on('click', '.btn_edittrip', function(e){
        e.preventDefault();
        var trip_id = $(this).val();
        $.ajax({
            type:'GET',
            url: '{{ url("trip/detail/edit") }}/' + trip_id,
            success:function(response){
                // console.log(response);
                $("#trip_detail_id").val(response.trip_detail.id);
                $("#trip_detail_date_edit").val(response.trip_detail.trip_detail_date);
                var rows_provinces = response.provinces.length;
                $('.formprovince_edit').children().remove().end();
                $('.formprovince_edit').append('<option selected value="">เลือกจังหวัด</option>');
                $('.toprovince_edit').children().remove().end();
                $('.toprovince_edit').append('<option selected value="">เลือกจังหวัด</option>');
                for(let i=0 ;i<rows_provinces; i++){
                    if(response.provinces[i]['identify'] == response.trip_detail.trip_from){
                        $('.formprovince_edit').append('<option value="'+response.provinces[i]['identify']+'" selected>'+
                        response.provinces[i]['name_thai']+'</option>');
                    }else{
                        $('.formprovince_edit').append('<option value="'+response.provinces[i]['identify']+'">'+
                        response.provinces[i]['name_thai']+'</option>');
                    }
                    if(response.provinces[i]['identify'] == response.trip_detail.trip_to){
                        $('.toprovince_edit').append('<option value="'+response.provinces[i]['identify']+'" selected>'+
                        response.provinces[i]['name_thai']+'</option>');
                    }else{
                        $('.toprovince_edit').append('<option value="'+response.provinces[i]['identify']+'">'+
                        response.provinces[i]['name_thai']+'</option>');
                    }
                }

                $('.customer_id_edit').children().remove().end();
                let rows_tags = response.trip_detail.customer_id.split(",");
                $.each(rows_tags, function(tkey, tvalue){
                    $.each(response.customer_api, function(key, value){
                        if(response.customer_api[key]['identify'] == rows_tags[tkey]){
                            $('#customer_id_edit').append('<option value='+response.customer_api[key]['identify']+' selected>'+
                            response.customer_api[key]['title']+response.customer_api[key]['name']+'</option>');
                        }else{
                            $('#customer_id_edit').append('<option value='+response.customer_api[key]['identify']+'>'+
                            response.customer_api[key]['title']+response.customer_api[key]['name']+'</option>');
                        }
                    });
                });

                $("#Modaledit").modal('show');
            }
        });
    });

    $(document).on('change','.toprovince', function(e){
        e.preventDefault();
        let pvid = $(this).val();
        $('#btn_save').prop('disabled', true);
        $.ajax({
            method: 'GET',
            url: '{{ url("fetch_customer_province_api") }}/'+pvid,
            datatype: 'json',
            success: function(response){
                console.log(response);
                $('#btn_save').prop('disabled', false);
                if(response.status == 200){
                    console.log(response.customer_api);
                    $('.customer_id').children().remove().end();
                    let rows = response.customer_api.length;
                    for(let i=0 ;i<rows; i++){
                        $('.customer_id').append('<option value="'+response.customer_api[i]['identify']+'">'+response.customer_api[i]['title']+' '+response.customer_api[i]['name']+'</option>');
                    }
                }
            }
        });
    });

    $(document).on('change','.toprovince_edit', function(e){
        e.preventDefault();
        let pvid = $(this).val();
        $('#btn_save_edit').prop('disabled', true);
        $.ajax({
            method: 'GET',
            url: '{{ url("fetch_customer_province_api") }}/'+pvid,
            datatype: 'json',
            success: function(response){
                console.log(response);
                $('#btn_save_edit').prop('disabled', false);
                if(response.status == 200){
                    console.log(response.customer_api);
                    $('.customer_id_edit').children().remove().end();
                    let rows = response.customer_api.length;
                    for(let i=0 ;i<rows; i++){
                        $('.customer_id_edit').append('<option value="'+response.customer_api[i]['identify']+'">'+response.customer_api[i]['title']+' '+response.customer_api[i]['name']+'</option>');
                    }
                }
            }
        });
    });

    $("#form_insert").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("trip/detail/insert") }}',
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


    $("#form_edit").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("trip/detail/update") }}',
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
            url: '{{ url("trip/detail/delete") }}',
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
