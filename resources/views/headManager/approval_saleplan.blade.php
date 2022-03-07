@extends('layouts.masterHead')

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

         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>อนุมัติ Sale Plan</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <h5 class="hk-sec-title">ตารางอนุมัติแผนประจำเดือน<?php echo thaidate('F Y', date('Y-m', strtotime("+1 month"))); ?></h5>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <!-- ------ -->
                                <span class="form-inline pull-right">
                                    <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</button>
                                    <form action="{{ url('head/approvalsaleplan/search') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <span id="selectdate" style="display:none;">
                                             <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name ="selectdateTo" value="<?= date('Y-m-d'); ?>" />

                                            <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button>
                                        </span>
                                    </form>
                                    </span>
                                    <!-- ------ -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="table-responsive-sm">
                                    <table id="datable_1" class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                {{-- <th>วันที่</th> --}}
                                                <th>พนักงานขาย</th>
                                                <th>แผนงาน</th>
                                                <th>ลูกค้าใหม่</th>
                                                <th>เยียมลูกค้า</th>
                                                <th>การอนุมัติ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monthly_plan as $key => $value)
                                                    <tr>
                                                        <td>{{$key + 1}}</td>
                                                        {{-- <td>{{$value->month_date}}</td> --}}
                                                        <td>{{$value->name}}</td>
                                                        <td>{{$value->sale_plan_amount}}</td>
                                                        <td>{{$value->cust_new_amount}}</td>
                                                        <td>{{$value->cust_visits_amount}}</td>
                                                        <td>
                                                            @if ($value->status_approve == 1)
                                                                <span class="badge badge-soft-warning"
                                                                    style="font-size: 12px;">
                                                                    Pending
                                                                </span>
                                                            @elseif ($value->status_approve == 2)
                                                                <span class="badge badge-soft-success"
                                                                    style="font-size: 12px;">
                                                                    Approve
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('head/approvalsaleplan_detail', $value->id) }}" type="button" class="btn btn-icon btn-primary pt-5">
                                                                <i data-feather="file-text"></i>
                                                            </a>
                                                        </td>
                                                        {{-- <td>{{$key + 1}}</td>
                                                        <td>{{$value->month_date}}</td>
                                                        <td>{{$value->name}}</td>
                                                        <td>
                                                            @if ($value->status_approve == 1)
                                                                <span class="badge badge-soft-warning"
                                                                    style="font-size: 12px;">
                                                                    Pending
                                                                </span>
                                                            @elseif ($value->status_approve == 2)
                                                                <span class="badge badge-soft-success"
                                                                    style="font-size: 12px;">
                                                                    Approve
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('head/approvalsaleplan_detail', $value->id) }}" type="button" class="btn btn-icon btn-primary pt-5">
                                                                <i data-feather="file-text"></i>
                                                            </a>
                                                        </td> --}}
                                                    </tr>
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
