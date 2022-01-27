@extends('layouts.masterLead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item">การขออนุมัติ</li>
            <li class="breadcrumb-item">ประวัติการขออนุมัติ</li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดประวัติการขออนุมัติ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>รายละเอียดประวัติการขออนุมัติ</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{ url('/approvalgeneral') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('approvalgeneral/history') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-list"></i>
                                </span>
                                <span class="btn-text">ประวัติ</span>
                            </a>
                            <hr>
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                            <div class="col-md-3">
                                <h5 class="hk-sec-title">ตารางรายละเอียดประวัติการขออนุมัติ</h5>
                            </div>
                            <div class="col-md-9">
                                <!-- ------ -->
                                <span class="form-inline pull-right">

                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกวันที่</button>
                                    <span id="selectdate" style="display:none;">
                                    date : <input type="date" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" value="<?= date('Y-m-d'); ?>" />

                                        to <input type="date" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" value="<?= date('Y-m-d'); ?>" />

                                        <button style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button>
                                    </span>

                                </span>
                                <!-- ------ -->
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover">
                                    <thead align="center">
                                        <tr>
                                            <th>#</th>
                                            <th>วันที่อนุมัติ</th>
                                            <th>เรื่อง</th>
                                            <th>พนักงาน</th>
                                            <th>การอนุมัติ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody align="center">
                                        @foreach ($history as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$value->assign_approve_date}}</td>
                                            <td>{{$value->assign_title}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>
                                                @if ($value->assign_status == 1)
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>
                                                @elseif ($value->assign_status == 2)
                                                    <span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>
                                                @endif

                                                @if ($value->assign_id)
                                                    <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->assign_id)
                                                <a href="{{ url('comment_approval', [$value->id, $value->created_by]) }}" class="btn btn-icon btn-info mr-10">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i data-feather="message-square"></i>
                                                    </h4>
                                                </a>
                                                @endif
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
    <!-- /Container -->


<!-- Modal -->
<div class="modal fade" id="Modalsaleplan" tabindex="-1" role="dialog" >
    @include('leadManager.general_history_display')
</div>


@endsection('content')

@section('scripts')

<script>
    $(document).on('click', '.btn_showplan', function(){
        let plan_id = $(this).val();
        //alert(goo);
        $('#Modalsaleplan').modal("show");
    });
</script>

    <script>
        function showselectdate(){
        $("#selectdate").css("display", "block");
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
    }
    </script>

@endsection