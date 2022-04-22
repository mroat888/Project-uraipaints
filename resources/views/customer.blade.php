@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ทะเบียนลูกค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-people"></i></span>ทะเบียนลูกค้า</h4>
            </div>
            <div class="d-flex">
            {{-- <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button> --}}
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">ตารางทะเบียนลูกค้า</h5>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                    <div class="box_search d-flex">
                                        <span class="txt_search">Search:</span>
                                        <input type="text" name="" id="" class="form-control form-control-sm" placeholder="ค้นหา">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th style="font-weight: bold;">#</th>
                                            <th style="font-weight: bold;">รูปภาพ</th>
                                            <th style="font-weight: bold;">วันที่</th>
                                            <th style="font-weight: bold;">ชื่อร้าน</th>
                                            <th style="font-weight: bold;">ชื่อผู้ติดต่อ</th>
                                            <th style="font-weight: bold;">ที่อยู่</th>
                                            <th style="font-weight: bold;">เบอร์โทรศัพท์</th>
                                            <th style="font-weight: bold;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <div class="media-img-wrap">
                                                    <div class="avatar avatar-sm">
                                                        <img src="{{ asset('/public/template/dist/img/avatar1.jpg') }}" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>29/10/2021</td>
                                            <td><span class="topic_purple">บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</span></td>
                                            <td>สมชาย</td>
                                            <td>นนทบุรี</td>
                                            <td>0565258569</td>
                                            <td>
                                                <div class="button-list">
                                                    <button class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#exampleModalLarge01">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                    <button class="btn btn-icon btn_blue btn-info mr-10">
                                                        <span class="btn-icon-wrap"><i data-feather="calendar"></i></span></button>
                                                    <a href="{{ url('/customer/detail') }}" class="btn btn-icon btn-success mr-10">
                                                        <span class="btn-icon-wrap"><i data-feather="pie-chart"></i></span></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>
                                                <div class="media-img-wrap">
                                                    <div class="avatar avatar-sm">
                                                        <img src="{{ asset('/public/template/dist/img/avatar1.jpg') }}" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>25/10/2021</td>
                                            <td><span class="topic_purple">Home Paint Outlet</span></td>
                                            <td>พงษ์ศักดิ์</td>
                                            <td>กรุงเทพ</td>
                                            <td>0985632516</td>
                                            <td>
                                                <div class="button-list">
                                                    <button class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#exampleModalLarge01">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                    <button class="btn btn-icon btn_blue btn-info mr-10">
                                                        <span class="btn-icon-wrap"><i data-feather="calendar"></i></span></button>
                                                    <a href="{{ url('/customer/detail') }}" class="btn btn-icon btn-success mr-10">
                                                        <span class="btn-icon-wrap"><i data-feather="pie-chart"></i></span></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>
                                                <div class="media-img-wrap">
                                                    <div class="avatar avatar-sm">
                                                        <img src="{{ asset('/public/template/dist/img/avatar1.jpg') }}" alt="user"
                                                            class="avatar-img">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>15/10/2021</td>
                                            <td><span class="topic_purple">เกรียงยงอิมเพ็กซ์</span></td>
                                            <td>กิตติศักดิ์</td>
                                            <td>กรุงเทพ</td>
                                            <td>0652352658</td>
                                            <td>
                                                <div class="button-list">
                                                    <button class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#exampleModalLarge01">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                    <button class="btn btn-icon btn_blue btn-info mr-10">
                                                        <span class="btn-icon-wrap"><i data-feather="calendar"></i></span></button>
                                                    <a href="{{ url('/customer/detail') }}" class="btn btn-icon btn-success mr-10">
                                                        <span class="btn-icon-wrap"><i data-feather="pie-chart"></i></span></a>
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
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

     <!-- Modal -->
     <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มข้อมูลลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อร้าน</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อผู้ติดต่อ</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">เบอร์โทรศัพท์</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่</label>
                                <input class="form-control" type="date" name="date" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label for="firstName">เลขที่</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="firstName">ซอย</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="firstName">ถนน</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ตำบล/แขวง</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">อำเภอ/เขต</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">จังหวัด</label>
                                <input class="form-control" id="shop" placeholder="" value="" type="text">
                            </div>
                        <div class="col-md-6 form-group">
                            <label for="username">รหัสไปรษณีย์</label>
                            <input class="form-control" id="shop" placeholder="" value="" type="text">
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                            <label for="firstName">เอกสารแนบ</label>
                            <input class="form-control" id="shop" placeholder="" value="" type="file">
                        </div>
                            <div class="form-group col-md-6">
                                <label for="username">สถานะ</label>
                                <select class="form-control custom-select">
                                    <option selected>Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
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

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
