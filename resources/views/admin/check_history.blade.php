@extends('layouts.masterAdmin')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ตรวจสอบประวัติการใช้งาน</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="pie-chart"></i> ตรวจสอบประวัติการใช้งาน</div>
        </div>
        <!-- /Title -->

        <section class="hk-sec-wrapper">
            <div class="topic-secondgery">รายการประวัติการใช้งาน</div>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="hk-pg-header mb-10">
                            <div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <!-- ------ -->

                                <span class="form-inline pull-right pull-sm-center">
                                    <form action="{{ url('admin/checkHistory/search') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                    <span id="selectdate">

                                        วันที่ : <input type="date" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" name="fromMonth"/>

                                        ถึงวันที่ : <input type="date" value="{{ date('Y-m') }}" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name="toMonth"/>

                                    <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm">ค้นหา</button>

                                    {{-- <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button> --}}
                                    </span>
                                </form>
                                </span>
                                <!-- ------ -->
                            </div>
                        </div>
                        <div class="table-responsive col-md-12 table-color">
                        <table id="datable_1" class="table table-hover w-100 display pb-30">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ชื่อผู้ใช้งาน</th>
                                    <th>สิทธิ์การใช้งาน</th>
                                    <th>วันที่เข้าใช้งาน</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $key => $value)
                                <tr>
                                    <td>{{ $key + 1}}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td><span class="badge badge-soft-violet" style="font-size: 14px;">{{ $value->permission_name }}</span></td>
                                    <td>{{ $value->date}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /Container -->
@endsection
