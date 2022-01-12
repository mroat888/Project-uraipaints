@extends('layouts.masterAdmin')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">อนุมัติคำขออนุมัติ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>ข้อมูลอนุมัติคำขออนุมัติ</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn_purple btn-violet btn-sm btn-rounded px-3" id="btn_approve">อนุมัติ</button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{ url('admin/approvalgeneral') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('admin/approvalgeneral/history') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
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
                                <h5 class="hk-sec-title">ตารางข้อมูลอนุมัติคำขออนุมัติ</h5>
                            </div>
                            <div class="col-md-9">

                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customCheck4" onclick="chkAll(this);">
                                                    <label class="custom-control-label"
                                                        for="customCheck4">ทั้งหมด</label>
                                                </div>
                                            </th>
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
                                            <td>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input checkapprove"
                                                        name="checkapprove" id="customCheck41" value="1">
                                                    <label class="custom-control-label" for="customCheck41"></label>
                                                </div>
                                            </td>
                                            <td>1</td>
                                            <td>10/10/2021</td>
                                            <td>
                                                <span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>
                                                System Architect
                                            </td>
                                            <td>สมรักษ์</td>
                                            <td>
                                                <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-primary btn-link btn_showplan" value="3">
                                                    <i data-feather="file-text"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input checkapprove"
                                                        name="checkapprove" id="customCheck41" value="1">
                                                    <label class="custom-control-label" for="customCheck41"></label>
                                                </div>
                                            </td>
                                            <td>2</td>
                                            <td>05/10/2021</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>หทัยรัตน์</td>
                                            <td>
                                                <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-primary btn-link btn_showplan" value="3">
                                                    <i data-feather="file-text"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input checkapprove"
                                                        name="checkapprove" id="customCheck41" value="1">
                                                    <label class="custom-control-label" for="customCheck41"></label>
                                                </div>
                                            </td>
                                            <td>3</td>
                                            <td>01/10/2021</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>เกรียงศักดิ์</td>
                                            <td>
                                                <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-primary btn-link btn_showplan" value="3">
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
    @include('admin.saleplan_display')
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
    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }
</script>


<script type="text/javascript">
    function chkAll(checkbox) {

        var cboxes = document.getElementsByName('checkapprove');
        var len = cboxes.length;

        if (checkbox.checked == true) {
            for (var i = 0; i < len; i++) {
                cboxes[i].checked = true;
            }
        } else {
            for (var i = 0; i < len; i++) {
                cboxes[i].checked = false;
            }
        }
    }
</script>

<script>
    document.getElementById('btn_approve').onclick = function() {
        var markedCheckbox = document.getElementsByName('checkapprove');
        var saleplan_id_p = "";

        for (var checkbox of markedCheckbox) {
            if (checkbox.checked) {
                if (checkbox.value != "") {
                    saleplan_id_p += checkbox.value + ' ,';
                }
            }
        }
        if (saleplan_id_p != "") {
            $('#Modalapprove').modal('show');
            $('#saleplan_id').val(saleplan_id_p);
        } else {
            alert('กรุณาเลือกรายการด้วยค่ะ');
        }
    }

    function showselectdate() {
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate() {
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }
</script>



@endsection
