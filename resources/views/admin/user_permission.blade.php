@extends('layouts.masterAdmin')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ข้อมูลผู้ใช้งานและกำหนดสิทธิ์</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="file-text"></i></span></span>บันทึกข้อมูลผู้ใช้งานและกำหนดสิทธิ์</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal"
                    data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">ตารางข้อมูลผู้ใช้งาน</h5>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="hk-pg-header mb-10">
                            <div>
                            </div>
                            <div class="d-flex">
                                <input type="text" name="" id="" class="form-control form-control-sm" placeholder="ค้นหา">
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ชื่อผู้ใช้งาน</th>
                                    <th>สิทธิ์การใช้งาน</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>ศิริลักษณ์</td>
                                    <td>siriluk</td>
                                    <td><span class="badge badge-soft-info" style="font-size: 14px;">ผู้แทนขาย</span></td>
                                    <td>
                                        <div class="button-list">
                                            <button class="btn btn-icon btn-warning mr-10">
                                                <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                            <button class="btn btn-icon btn-danger mr-10">
                                                <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>อิศรา</td>
                                    <td>itsara</td>
                                    <td><span class="badge badge-soft-indigo" style="font-size: 14px;">ผู้จัดการเขต</span></td>
                                    <td>
                                        <div class="button-list">
                                            <button class="btn btn-icon btn-warning mr-10">
                                                <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                            <button class="btn btn-icon btn-danger mr-10">
                                                <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /Container -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มบันทึกข้อมูลผู้ใช้งาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">ชื่อ-นามสกุล</label>
                                <select class="select2 select2-multiple form-control"
                                    data-placeholder="Choose">
                                    <option aria-readonly="ff">เลือกข้อมูล</option>
                                    {{-- <optgroup label="เลือกข้อมูล"> --}}
                                        <option value="1">ศิริลักษณ์</option>
                                        <option value="2">อิศรา</option>
                                        <option value="3">ดวงดาว</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อผู้ใช้งาน</label>
                                <input type="text" name="" id="" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">รหัสผ่าน</label>
                                <input class="form-control" placeholder="" value="" type="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สิทธิ์การใช้งาน</label>
                                <select class="form-control custom-select">
                                    <option selected>เลือกข้อมูล</option>
                                    <option value="1">ผู้แทนขาย</option>
                                    <option value="2">ผู้จัดการเขต</option>
                                    <option value="3">ผู้จัดการฝ่าย</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
