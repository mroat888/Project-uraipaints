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
                <form id="form_trip_update" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" name="trip_header_id" id="trip_header_id" value="{{ $trip_header->id }}">
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
                                    list($year_start, $month_start, $day_start) = explode("-", $trip_header->trip_start);
                                    $year_start_thai = $year_start+543;
                                    $trip_start_thai = $day_start."/".$month_start."/".$year_start_thai;

                                    list($year_end, $month_end, $day_end) = explode("-", $trip_header->trip_end);
                                    $year_end_thai = $year_end+543;
                                    $trip_end_thai = $day_end."/".$month_end."/".$year_end_thai;
                                @endphp
                                {{ $trip_start_thai }} ถึง
                                {{ $trip_end_thai }}
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">จำนวนวัน</label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" name="trip_day" id="trip_day" 
                                value="{{ $trip_header->trip_day }}" onkeyup="calculator_allowance();" 
                                onchange="calculator_allowance();" onclick="calculator_allowance();" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox checkbox-info my-2">
                                <input type="checkbox" class="custom-control-input checkapprove"
                                    name="checkapprove" id="customCheck" value="approve" checked>
                                <label class="custom-control-label" for="customCheck">อนุมัติ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">อัตราเบี้ยเลี้ยง</label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" name="allowance" id="allowance" 
                                value="{{ $trip_header->allowance }}" onkeyup="calculator_allowance()" 
                                onchange="calculator_allowance();" onclick="calculator_allowance();" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">รวมค่าเบี้ยเลี้ยง</label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" name="sum_allowance" id="sum_allowance" 
                                value="{{ $trip_header->sum_allowance }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-green">บันทึกแก้ไข & อนุมัติ</button>
                        </div>
                    </div>
                </form>
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
                    <div class="content-right d-flex">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive col-md-12 table-color">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>วันที่</th>
                                        <th>จากจังหวัด</th>
                                        <th>ถึงจังหวัด</th>
                                        <th>ร้านค้า</th>
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
                                        <td><?php echo  nl2br($value['customer_id']); ?></td>
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

    @php
        $check_menager_comment = "N"; //-- ใช้เช็คค่ามีการคอมเม้นต์แล้วหรือไม่
    @endphp

    @foreach($trip_comments as $comment)
        @if($comment->created_by != Auth::user()->id)
            <!-- Row Show Comment -->
            <div class="row my-30">
                <div class="col-2" style="text-align:center;">
                    <img src="{{ asset('/public/images/people-33.png')}}" alt="{{ $comment->name }}" style="max-width:80%;">
                    <div>{{ $comment->name }}</div>
                </div>
                <div class="col-10">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <!-- <div class="col-md-4 col-lg-4">
                                        <p class="detail_listcus">
                                            <i class="ion ion-md-calendar"></i>
                                            <span> เดือน</span> :

                                        </p>
                                    </div> -->
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="desc_cusnote">
                                            <blockquote class="blockquote mb-0">
                                                <p>{{ $comment->trip_comment_detail }}</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-15">
                                        @php
                                            list($sale_date, $sale_time) = explode(' ',$comment->created_at);
                                        @endphp
                                        วันที่ : {{ thaidate('d F Y',$sale_date) }} เวลา : {{ $sale_time }}
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </section>
                </div>
            </div>
            <!-- Row -->
        @else
            @php
                $check_menager_comment = "ํY"; //-- มีค่าคอมเม้นต์แล้ว
            @endphp
            <!-- Row Create Comment -->
            <div class="row">
                <div class="col-xl-12">

                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="form_comment_update" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="ml-20">
                                            <h5>แก้ไขแสดงความคิดเห็น : </h5>
                                        </div>
                                        <input type="hidden" name="trip_header_id" value="{{ $comment->trip_header_id }}">
                                        <input type="hidden" name="trip_comment_id" value="{{ $comment->id }}">
                                        <div class="card-body">
                                            <textarea class="form-control" name="comment_detail" cols="30" rows="5"
                                            placeholder="เพิ่มความคิดเห็น" value=""type="text">{{ $comment->trip_comment_detail	}}</textarea>
                                        </div>

                                        <div class="col-md-12">
                                            @php
                                                list($sale_date, $sale_time) = explode(' ',$comment->created_at);
                                            @endphp
                                            วันที่ : {{ thaidate('d F Y',$sale_date) }} เวลา : {{ $sale_time }}
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary float-right">บันทึก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
            <!-- End Row Create Comment -->
        @endif

    @endforeach

    @if($check_menager_comment == "N")

        <!-- Row Create Comment -->
        <div class="row">
            <div class="col-xl-12">

                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form_comment_insert" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="ml-20">
                                        <h5>แสดงความคิดเห็น : </h5>
                                    </div>
                                    <input type="hidden" name="trip_header_id" value="{{ $trip_header->id }}">
                                    <input type="hidden" name="trip_comment_id" value="">
                                    <div class="card-body">
                                        <textarea class="form-control" name="comment_detail" cols="30" rows="5"
                                        placeholder="เพิ่มความคิดเห็น" value=""type="text"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary float-right">บันทึก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <!-- End Row Create Comment -->

    @endif



</div>

<!-- /Container -->

<script>

    function calculator_allowance(){
        let trip_day = parseInt($('#trip_day').val());
        let allowance = parseInt($('#allowance').val());

        let sum_allowance = trip_day*allowance;

        $('#sum_allowance').val(sum_allowance);
    }

     $("#form_trip_update").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("lead/approve_trip/update") }}',
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


    $("#form_comment_insert").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("manager/trip/comment/create") }}',
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

    $("#form_comment_update").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("manager/trip/comment/create") }}',
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
