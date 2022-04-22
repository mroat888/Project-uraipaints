@extends('layouts.masterLead')

@section('content')

 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">งานประจำวัน</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">ปฎิทินกิจกรรม</li> --}}
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="mt-30 mb-30">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                                    </li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ asset('/public/images/banner.jpg') }}">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ asset('/public/images/banner2.jpg') }}">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-30 mb-30">
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="row mt-30">
                        <div class="col-md-2">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"><i data-feather="edit-2"></i>
                                        <button type="button" class="btn btn-xs btn-outline-danger btn-rounded float-right">New</button></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>คำขออนุมัติ 5</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>อนุมัติ</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ด่วน</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>3</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>2</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"><i data-feather="user"></i>
                                        <button type="button" class="btn btn-xs btn-outline-success btn-rounded float-right">New</button></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>คำสั่งงาน 8</span>
                                            </span>
                                        </div>
                                        {{-- <div>
                                            <button type="button" class="btn btn-xs btn-outline-success btn-rounded">New</button>
                                        </div> --}}
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>ทำแล้ว</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ด่วน</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>6</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>2</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"><i data-feather="file"></i>
                                        <button type="button" class="btn btn-xs btn-outline-warning btn-rounded float-right">New</button></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>บันทึกโน๊ต 3</span>
                                            </span>
                                        </div>
                                        {{-- <div>
                                            <button type="button" class="btn btn-xs btn-outline-warning btn-rounded">New</button>
                                        </div> --}}
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>เลิกใช้</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ปักหมุด</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>1</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>2</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"><i data-feather="user"></i>
                                        <button type="button" class="btn btn-xs btn-outline-info btn-rounded float-right">New</button></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>ลูกค้าใหม่ 6</span>
                                            </span>
                                        </div>
                                        {{-- <div>
                                            <button type="button" class="btn btn-xs btn-outline-info btn-rounded">New</button>
                                        </div> --}}
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>ไม่ผ่าน</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ตัดสินใจ</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>3</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>3</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"></span>
                                    <div class="mt-15">
                                            <span class="d-block">
                                                <div class="media-img-wrap text-center">
                                                    <div class="avatar avatar-sm">
                                                        <img src="" alt="user"
                                                        class="avatar-text avatar-text-inv-success rounded-circle">
                                                    </div>
                                                    <div class="avatar avatar-sm">
                                                        <img src="" alt="user"
                                                        class="avatar-text avatar-text-inv-pink rounded-circle">
                                                    </div>
                                                    <div class="avatar avatar-sm">
                                                        <img src="" alt="user"
                                                        class="avatar-text avatar-text-inv-info rounded-circle">
                                                    </div>
                                                    <div class="avatar avatar-sm">
                                                        <img src="" alt="user"
                                                        class="avatar-text avatar-text-inv-warning rounded-circle">
                                                    </div>
                                                </div>
                                            </span>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-5">
                                        <div>
                                            <span class="d-block">
                                                <span>ลูกค้าทั้งหมด</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>มีวันสำคัญในเดือน</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>300</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>4 ร้าน <span class="ml-40">4 วัน</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                        <div class="hk-pg-header mb-10">
                            <div><h6 class="hk-sec-title mb-10" style="font-weight: bold;">แผนงานประจำเดือน มกราคม/2565</h6></div>
                        {{-- <div class="d-flex">
                            <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal"
                                data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
                            <button type="button" class="btn btn_purple btn-violet btn-sm btn-rounded px-3" id="btn_approve">ขออนุมัติ</button>
                        </div> --}}
                        </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10 mt-10">
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
                                                <th>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck4" onclick="chkAll(this);">
                                                        <label class="custom-control-label"
                                                            for="customCheck4">ทั้งหมด</label>
                                                    </div>
                                                </th>
                                                <th>#</th>
                                                <th>เรื่อง</th>
                                                {{-- <th>วันที่</th> --}}
                                                <th>ลูกค้า</th>
                                                <th>การอนุมัติ</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_saleplan as $key => $value)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input checkapprove"
                                                            name="checkapprove" id="customCheck41" value="1">
                                                        <label class="custom-control-label" for="customCheck41"></label>
                                                    </div>
                                                </td>
                                                <td>{{$key + 1}}</td>
                                                <td><span class="topic_purple">{{$value->sale_plans_title}}</span></td>
                                                {{-- <td>11/10/2021</td> --}}
                                                <td>{{$value->customer_shop_id}}</td>
                                                <td>
                                                    @if ($value->sale_plans_status == 0)
                                                    <span class="badge badge-soft-secondary" style="font-size: 12px;">Darf</span>
                                                    @elseif ($value->sale_plans_status == 1)
                                                    <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                                    @else
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-primary" data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                        <button class="btn btn-icon btn-pumpkin" data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                        <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#Modalvisit" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>

                                                        <button onclick="edit_modal({{ $value->id }})" class="btn btn-icon btn-warning mr-10"
                                                            data-toggle="modal" data-target="#saleplanEdit">
                                                            <span class="btn-icon-wrap"><i data-feather="edit"
                                                                ></i></span></button>
                                                        <a href="{{url('delete_saleplan', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                            <span class="btn-icon-wrap"><i data-feather="trash-2"
                                                                ></i></span></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </section>
            </div>


            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                        <div class="hk-pg-header mb-10">
                            <div><h6 class="hk-sec-title mb-10" style="font-weight: bold;">พบลูกค้าใหม่</h6></div>
                        {{-- <div class="d-flex">
                            <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal"
                                data-target="#exampleModalLarge02"> + เพิ่มใหม่ </button>
                        </div> --}}
                        </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10 mt-10">
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
                                                <th>#</th>
                                                <th>ชื่อร้าน</th>
                                                <th>อำเภอ,จังหวัด</th>
                                                <th>วัตถุประสงค์</th>
                                                <th>วันที่</th>
                                                <th>สถานะ</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>System Architect</td>
                                                <td>บางพลี,สมุทรปราการ</td>
                                                <td>เปิดตลาดใหม่</td>
                                                <td>01/11/2021</td>
                                                <td><span class="badge badge-soft-success mt-15 mr-10" style="font-size: 12px;">Finished</span></td>
                                                <td align="center">
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-indigo mr-10" data-toggle="modal" data-target="#exampleModalLarge01" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                        <button class="btn btn-icon btn-pumpkin mr-10" data-toggle="modal" data-target="#exampleModalLarge01" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                        <button class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#exampleModalLarge02">
                                                            <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                        <button class="btn btn-icon btn-danger mr-10">
                                                            <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>System Architect</td>
                                                <td>บางพลี,สมุทรปราการ</td>
                                                <td>เปิดตลาดใหม่</td>
                                                <td>01/11/2021</td>
                                                <td><span class="badge badge-soft-danger mt-15 mr-10" style="font-size: 12px;">Failed</span></td>
                                                <td colspan="4" align="center">
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-indigo mr-10" data-toggle="modal" data-target="#exampleModalLarge01" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                        <button class="btn btn-icon btn-pumpkin mr-10" data-toggle="modal" data-target="#exampleModalLarge01" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                        <button class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#exampleModalLarge02">
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
                </section>
            </div>


            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                        <div class="hk-pg-header mb-10">
                            <div><h6 class="hk-sec-title mb-10" style="font-weight: bold;">เยี่ยมลูกค้า</h6></div>
                        {{-- <div class="d-flex">
                            <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal"
                                data-target="#exampleModalLarge03"> + เพิ่มใหม่ </button>
                        </div> --}}
                        </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10 mt-10">
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
                                                <th>#</th>
                                                <th>ชื่อร้าน</th>
                                                <th>อำเภอ,จังหวัด</th>
                                                <th>ผู้ติดต่อ</th>
                                                <th>วันสำคัญ</th>
                                                <th>สถานะ</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>2</td>
                                                <td>System Architect</td>
                                                <td>บางพลี,สมุทรปราการ</td>
                                                <td>เปิดตลาดใหม่</td>
                                                <td>-</td>
                                                <td><span class="badge badge-soft-danger mt-15 mr-10" style="font-size: 12px;">Failed</span></td>
                                                <td colspan="4" align="center">
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#exampleModalLarge02">
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
                </section>
            </div>


        </div>
    </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
    aria-hidden="true">
    @include('saleplan.salePlanForm')
    </div>

    <!-- Modal Edit saleplan -->
    <div class="modal fade" id="saleplanEdit" tabindex="-1" role="dialog" aria-labelledby="saleplanEdit"
    aria-hidden="true">
    @include('saleplan.salePlanForm_edit')
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModalLarge02" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge02" aria-hidden="true">
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
                       <label for="firstName">รูปภาพ</label>
                       <input class="form-control" id="shop" placeholder="" value="" type="file" accept="image">
                   </div>
                   <div class="col-md-6 form-group">
                       <label for="firstName">เอกสารแนบ</label>
                       <input class="form-control" id="shop" placeholder="" value="" type="file">
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

<!-- Modal -->
<div class="modal fade" id="exampleModalLarge03" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge03" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Check-in 2 Check-out</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <div class="mt-20 text-center">
                   <button type="button" class="btn btn-primary" onclick="getLocation()">GetLocation</button>
                   <p id="demo" class="mt-5"></p>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
               <button type="button" class="btn btn-primary">บันทึก</button>
           </div>
       </div>
   </div>
</div>

<script>
   var x = document.getElementById("demo");

   function getLocation() {
       if (navigator.geolocation) {
           navigator.geolocation.getCurrentPosition(showPosition, showError);
       } else {
           x.innerHTML = "Geolocation is not supported by this browser.";
       }
   }

   function showPosition(position) {
       x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
   }

   function showError(error){
       switch(error.code){
           case error.PERMISSION_DENIED:
               x.innerHTML="User denied the request for Geolocation."
               reak;
           case error.POSITION_UNAVAILABLE:
               x.innerHTML="Location information is unavailable."
               break;
           case error.TIMEOUT:
               x.innerHTML="The request to get user location timed out."
               break;
           case error.UNKNOWN_ERROR:
               x.innerHTML="An unknown error occurred."
               break;
       }
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

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
