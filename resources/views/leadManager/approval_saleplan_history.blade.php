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
            <li class="breadcrumb-item active" aria-current="page">ประวัติการอนุมัติ Sale Plan</li>
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
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>ประวัติการอนุมัติ Sale Plan</h4>
            </div>
            <div class="d-flex">

            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <a href="{{ url('/approvalsaleplan') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                    <span class="icon-label">
                                        <i class="fa fa-file"></i>
                                    </span>
                                    <span class="btn-text">รออนุมัติ</span>
                                </a>

                                <a href="{{ url('lead/approvalsaleplan-history') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
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
                            <div class="col-sm-12 col-md-6">
                                <h5 class="hk-sec-title">ตารางประวัติการอนุมัติ Sale Plan</h5>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <!-- ------ -->
                                <span class="form-inline pull-right">
                                <a style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</a>
                                <form action="{{ url('lead/approvalsaleplan-history/search') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- <input type="text" id="knowledgeSearch" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" /> --}}

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
                                <div class="mb-20">
                                </div>
                                    <div class="table-responsive-sm">
                                    <table class="table table-sm table-hover">
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
                                                            <span class="badge badge-soft-success" style="font-size: 12px;">Approval</span></td>
                                                        <td>
                                                            <a href="{{url('lead/approvalsaleplan-history-detail', $value->created_by)}}" class="btn btn-icon btn-primary btn-link btn_showplan pt-5">
                                                                <i data-feather="file-text"></i>
                                                            </a>
                                                            <?php
                                                            $status_saleplan = App\SalePlan::where('monthly_plan_id', $value->id)
                                                            ->whereIn('sale_plans_status', [2,3])->count();

                                                            $status_customer = App\Customer::where('monthly_plan_id', $value->id)
                                                            ->whereIn('shop_aprove_status', [2,3])->count();

                                                            ?>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="float:right;">
                                    {{ $monthly_plan->links() }}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- /Row -->
    </div>


    <script type="text/javascript">
        function showselectdate(){
            $("#selectdate").css("display", "block");
            $("#bt_showdate").hide();
        }

        function hidetdate(){
            $("#selectdate").css("display", "none");
            $("#bt_showdate").show();
        }

        function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function() {
                $(".success").fadeOut();
            }, 1000);
        }

    </script>

@endsection

@section('scripts')


@endsection('scripts')
