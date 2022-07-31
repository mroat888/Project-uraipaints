
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายการสั่งงาน</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
     <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="clipboard"></i> รายการสั่งงาน</div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="topic-secondgery">รายการสั่งงาน</div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10">
                                        <div>
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <!-- ------ -->

                                            <span class="form-inline pull-right pull-sm-center">
                                                <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                <span id="selectdate" >

                                                    เดือน : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" name="fromMonth"/>

                                                    ถึง : <input type="month" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name="toMonth"/>

                                                <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm">ค้นหา</button>
                                                </span>
                                            </form>
                                            </span>
                                            <!-- ------ -->
                                        </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12 table-color">
                                        <table id="datable_1" class="table table-hover">
                                        <thead style="text-align:center;">
                                            <tr>
                                                <th>#</th>
                                                <th style="text-align:left">เรื่อง</th>
                                                <th style="width:10%">รูปภาพ</th>
                                                <th>ผู้แทนขาย</th>
                                                <th>วันกำหนดส่ง</th>
                                                <th>สถานะ</th>
                                                <th>ประเมินผล</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:center;">
                                            @foreach ($assignments as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td style="text-align:left">{{$value->assign_title}}</td>
                                            <td>
                                                @php
                                                    $assign_file = App\Assignment_gallery::where('assignment_id', $value->id)->where('status', 0)->first();
                                                @endphp
                                                @if ($assign_file)
                                                <a href="{{url('assignment_view_image', $value->id)}}">
                                                    <img class="card-img" src="{{ isset($assign_file->image) ? asset('public/upload/AssignmentFile/' . $assign_file->image) : '' }}"
                                                    alt="{{ $value->assign_title }}" style="max-width:80%;">
                                                </a>
                                                @endif
                                            </td>
                                            <td>{{$value->name}}</td>
                                            <td>{{Carbon\Carbon::parse($value->assign_work_date)->addYear(543)->format('d/m/Y')}}</td>
                                            <td>
                                                @if ($value->assign_result_status == 0)
                                                @if ($value->assign_work_date < Carbon\Carbon::today()->format('Y-m-d'))
                                                <span class="btn-expired" style="font-size: 12px;">Expired</span>
                                                    @else
                                                    <span class="btn-draf" style="font-size: 12px;">รอดำเนินการ</span>
                                                @endif
                                                @elseif ($value->assign_result_status == 1 || $value->assign_result_status == 2 || $value->assign_result_status == 3)
                                                    <span class="btn-approve" style="font-size: 12px;">ดำเนินการแล้ว</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->assign_result_status == 1)
                                                    <span class="btn-approve" style="font-size: 12px;">สำเร็จ</span>
                                                    @elseif ($value->assign_result_status == 2)
                                                    <span class="btn-failed" style="font-size: 12px;">ไม่สำเร็จ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                    @php
                                                        if(($value->assign_result_status != 0) || ($value->assign_work_date < date('Y-m-d'))){
                                                            $btn_disabled = "disabled";
                                                            $btn_result_hidden = "hidden='hidden'";
                                                            $btn_result_show_hidden = "";
                                                        }else{
                                                            $btn_disabled = "";
                                                            $btn_result_hidden = "";
                                                            $btn_result_show_hidden = "hidden='hidden'";
                                                        }
                                                    @endphp
                                                    <button class="btn btn-icon btn-teal mr-10" data-toggle="modal"
                                                        data-target="#ModalResult"
                                                        onclick="assignment_result({{$value->id}})" {{ $btn_result_hidden }}>
                                                        <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i class="ion ion-md-book"></i></h4>
                                                    </button>
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-view" data-toggle="modal"
                                                        data-target="#ModalResult_show"
                                                        onclick="assignment_show_result({{$value->id}})" {{ $btn_result_show_hidden }}>
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i
                                                            class="ion ion-md-list"></i></h4></button>
                                                        </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                    </section>
                </div>
            </div>
            <!-- /Row -->
    </div>

@include('union.assignment_modal_submitwork')
@include('union.assignment_modal_showresult')

<script>
    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }

    function showselectdate(){
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }

</script>
