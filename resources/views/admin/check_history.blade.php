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
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="pie-chart"></i></span></span>ตรวจสอบประวัติการใช้งาน</h4>
            </div>
            {{-- <div class="d-flex">
                <button type="button" class="btn btn-primary btn-sm btn-rounded px-3" data-toggle="modal"
                    data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div> --}}
        </div>
        <!-- /Title -->

        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">ตารางประวัติการใช้งาน</h5>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
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
                                <tr>
                                    <td>1</td>
                                    <td>ศิริลักษณ์</td>
                                    <td>siriluk</td>
                                    <td><span class="badge badge-soft-info" style="font-size: 14px;">ผู้แทนขาย</span></td>
                                    <td>11/10/2564</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>อิศรา</td>
                                    <td>itsara</td>
                                    <td><span class="badge badge-soft-indigo" style="font-size: 14px;">ผู้จัดการเขต</span></td>
                                    <td>11/10/2564</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /Container -->
@endsection
