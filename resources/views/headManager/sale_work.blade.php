@extends('layouts.masterHead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">หน้าแรก</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดงานของเซลล์</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i
                            class="ion ion-md-list"></i></span>รายละเอียดงานของเซลล์</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{url('head/palncalendar')}}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <span class="btn-text">ปฎิทิน</span>
                            </a>

                            <a href="{{url('head/saleWork')}}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-list"></i>
                                </span>
                                <span class="btn-text">List</span>
                            </a>
                            <hr>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <h5 class="hk-sec-title">ตารางข้อมูลรายละเอียดงานของเซลล์</h5>
                        </div>
                        <div class="col-sm-12 col-md-9">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                    <div class="d-flex">
                                        <input type="text" name="" id="" class="form-control form-control-sm"
                                            placeholder="ค้นหา">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ชื่อ</th>
                                                <th>Sale plan</th>
                                                <th>เข้าพบลูกค้า</th>
                                                <th>งานที่ได้รับมอบหมาย</th>
                                                {{-- <th colspan="3" style="text-align: center;">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>สมชาย</td>
                                                <td>
                                                    <a href="{{ url('head/viewSaleDetail') }}"
                                                        class="btn btn-icon btn-success">
                                                        <span class="btn-icon-wrap"><i data-feather="calendar"></i></span></a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('head/viewVisitDetail') }}"
                                                        class="btn btn-icon btn-info">
                                                        <span class="btn-icon-wrap"><i data-feather="home"></i></span></a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('head/viewAssignmentDetail') }}"
                                                        class="btn btn-icon btn-indigo">
                                                        <span class="btn-icon-wrap"><i data-feather="layers"></i></span></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>พงษ์ศักดิ์</td>
                                                <td>
                                                    <a href="{{ url('head/viewSaleDetail') }}"
                                                        class="btn btn-icon btn-success">
                                                        <span class="btn-icon-wrap"><i data-feather="calendar"></i></span></a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('head/viewVisitDetail') }}"
                                                        class="btn btn-icon btn-info">
                                                        <span class="btn-icon-wrap"><i data-feather="home"></i></span></a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('head/viewAssignmentDetail') }}"
                                                        class="btn btn-icon btn-indigo">
                                                        <span class="btn-icon-wrap"><i data-feather="layers"></i></span></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>กิตติศักดิ์</td>
                                                <td>
                                                    <a href="{{ url('head/viewSaleDetail') }}"
                                                        class="btn btn-icon btn-success">
                                                        <span class="btn-icon-wrap"><i data-feather="calendar"></i></span></a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('head/viewVisitDetail') }}"
                                                        class="btn btn-icon btn-info">
                                                        <span class="btn-icon-wrap"><i data-feather="home"></i></span></a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('head/viewAssignmentDetail') }}"
                                                        class="btn btn-icon btn-indigo">
                                                        <span class="btn-icon-wrap"><i data-feather="layers"></i></span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /Row -->
        </div>
        <!-- /Container -->

    @endsection
