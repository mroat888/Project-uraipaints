@extends('layouts.masterLead')

@section('content')

@php

    $date = date('m-d-Y');

    $date1 = str_replace('-', '/', $date);

    $yesterday = date('Y-m-d',strtotime($date1 . "-1 days"));



    $date1 = str_replace('-', '/', $date);

    $yesterday2 = date('Y-m-d',strtotime($date1 . "-2 days"));

@endphp
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">อนุมัติ Sale Plan</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        @if (session('error'))
        <div class="alert alert-inv alert-inv-warning alert-wth-icon alert-dismissible fade show" role="alert">
            <span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i>
            </span> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>อนุมัติ Sale Plan</h4>
            </div>
            <div class="d-flex">
                <form action="{{ url('lead/approval_saleplan_confirm_all') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn_purple btn-violet btn-sm btn-rounded px-3" name="approve" value="approve">อนุมัติ</button>

                <button type="submit" class="btn btn_purple btn-danger btn-sm btn-rounded px-3 ml-5" name="failed" value="failed">ไม่อนุมัติ</button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <h5 class="hk-sec-title">ตารางอนุมัติ Sale Plan</h5>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <!-- ------ -->
                                <span class="form-inline pull-right">

                                    <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</button>
                                    <span id="selectdate" style="display:none;">
                                         <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" value="<?= date('Y-m-d'); ?>" />

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
                                                <th>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck4" onclick="chkAll(this);" name="CheckAll" value="Y">
                                                        <label class="custom-control-label"
                                                            for="customCheck4">ทั้งหมด</label>
                                                    </div>
                                                </th>
                                                <th>#</th>
                                                <th>วันที่</th>
                                                <th>พนักงานขาย</th>
                                                <th>การอนุมัติ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monthly_plan as $key => $value)
                                            <?php
                                            $date = Carbon\Carbon::parse($value->month_date)->format('Y-m');
                                            $dateNow = Carbon\Carbon::today()->addMonth(1)->format('Y-m');
                                            // if ($date == $dateNow) {
                                      ?>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox checkbox-info">
                                                                <input type="checkbox" class="custom-control-input checkapprove"
                                                                    name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$value->id}}">
                                                                <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{$key + 1}}</td>
                                                        <td>{{$value->month_date}}</td>
                                                        <td>{{$value->name}}</td>
                                                        <td><span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span></td>
                                                        <td>
                                                            <a href="{{ url('/approvalsaleplan_detail', $value->id) }}" type="button" class="btn btn-icon btn-primary pt-5">
                                                                <i data-feather="file-text"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                // }
                                                ?>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <!-- /Row -->
    </div>

    <script type="text/javascript">
        function chkAll(checkbox) {

            var cboxes = document.getElementsByName('checkapprove[]');
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

@endsection

@section('scripts')


<script>
    function showselectdate(){
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }
</script>

<script>
    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }
</script>

<script>
    function showselectdate() {
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate() {
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }
</script>

@endsection('scripts')
