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
            <li class="breadcrumb-item active" aria-current="page">รายชื่อร้านค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>รายชื่อร้านค้า</h4>
            </div>
            <div class="d-flex">
                <button class="btn btn-primary btn-sm"><i data-feather="printer"></i> พิมพ์</button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <h5 class="hk-sec-title">ตาราง รายชื่อร้านค้า</h5>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <!-- ------ -->
                                <span class="form-inline pull-right">
                                         <input type="text" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" />
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
                                                <th>ชื่อร้านค้า/ลูกค้า</th>
                                                <th>พนักงานขาย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>รายชื่อร้านค้า</td>
                                                <td>เกรียงไกร</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Home Paint Outlet</td>
                                                <td>ชัยวุฒิ</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>เกรียงยงอิมเพ็กซ์</td>
                                                <td>จารุวรรณ</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>อิสระเพ้นท์ติ้ง</td>
                                                <td>อมรชัย</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>เกษมโฮมเพ้นท์</td>
                                                <td>ทิพวรรณ</td>
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

@endsection('content')

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

@endsection('scripts')