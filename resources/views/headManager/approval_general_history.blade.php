@extends('layouts.masterHead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">การขออนุมัติ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>ประวัติการขออนุมัติ</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{ url('head/approvalgeneral') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('head/approvalgeneral/history') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
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
                                <h5 class="hk-sec-title">ตารางประวัติการขออนุมัติ</h5>
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
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>วันที่</th>
                                            <th>เรื่อง</th>
                                            <th>พนักงาน</th>
                                            <th>การอนุมัติ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>10/10/2021</td>
                                            <td>
                                                System Architect
                                            </td>
                                            <td>สมรักษ์</td>
                                            <td>
                                                <span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-info btn-link btn_showplan" value="3">
                                                    <i data-feather="file-text"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>05/10/2021</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>หทัยรัตน์</td>
                                            <td><span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>
                                                <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-icon btn-info btn-link btn_showplan" value="3">
                                                        <i data-feather="file-text"></i>
                                                    </button>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>01/10/2021</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>เกรียงศักดิ์</td>
                                            <td><span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>
                                                <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-icon btn-info btn-link btn_showplan" value="3">
                                                        <i data-feather="file-text"></i>
                                                    </button>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>01/10/2021</td>
                                            <td>Javascript Developer</td>
                                            <td>หทัยรัตน์</td>
                                            <td><span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>
                                                <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-icon btn-info btn-link btn_showplan" value="3">
                                                        <i data-feather="file-text"></i>
                                                    </button>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>01/10/2021</td>
                                            <td>Senior Python Developer</td>
                                            <td>เกรียงศักดิ์</td>
                                            <td><span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>
                                                <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-icon btn-info btn-link btn_showplan" value="3">
                                                        <i data-feather="file-text"></i>
                                                    </button>
                                                </td>
                                        </tr>
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
    @include('headManager.general_history_display')
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
