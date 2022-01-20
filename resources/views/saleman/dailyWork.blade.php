@extends('layouts.master')

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
                                        <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"><i
                                                data-feather="edit-2"></i>
                                            <button type="button"
                                                class="btn btn-xs btn-outline-danger btn-rounded float-right">New</button></span>
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
                                        <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"><i
                                                data-feather="user"></i>
                                            <button type="button"
                                                class="btn btn-xs btn-outline-success btn-rounded float-right">New</button></span>
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div>
                                                <span class="d-block">
                                                    <span>คำสั่งงาน 8</span>
                                                </span>
                                            </div>
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
                                        <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"><i
                                                data-feather="file"></i>
                                            <button type="button"
                                                class="btn btn-xs btn-outline-warning btn-rounded float-right">New</button></span>
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div>
                                                <span class="d-block">
                                                    <span>บันทึกโน๊ต 3</span>
                                                </span>
                                            </div>
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
                                        <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"><i
                                                data-feather="user"></i>
                                            <button type="button"
                                                class="btn btn-xs btn-outline-info btn-rounded float-right">New</button></span>
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div>
                                                <span class="d-block">
                                                    <span>ลูกค้าใหม่ 6</span>
                                                </span>
                                            </div>
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
                            <div>
                                <h6 class="hk-sec-title mb-10" style="font-weight: bold;">แผนงานประจำเดือน มกราคม/2565</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10 mt-10">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table  id="datable_1" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>เรื่อง</th>
                                                    <th>ลูกค้า</th>
                                                    <th>สถานะ</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($list_saleplan as $key => $value)
                                                <?php $date = Carbon\Carbon::parse($value->sale_plans_date)->format('Y-m');
                                                      $dateNow = Carbon\Carbon::today()->format('Y-m');
                                                      if ($date == $dateNow && $value->sale_plans_status == 2) {
                                                ?>
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td><span class="topic_purple">{{ $value->sale_plans_title }}</span></td>
                                                        <td>{{ $value->shop_name }}</td>
                                                        <td><span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span></td>
                                                        <td align="center">
                                                            <div class="button-list">
                                                                @if ($value->status_result == 1)
                                                                    <button class="btn btn-icon btn-primary"
                                                                        data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})" disabled>
                                                                        <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                    <button class="btn btn-icon btn-pumpkin"
                                                                    data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})">
                                                                    <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                    <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})" disabled>
                                                                    <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>

                                                                @elseif ($value->status_result == 2)
                                                                    <button class="btn btn-icon btn-primary"
                                                                    data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})" disabled>
                                                                    <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                    <button class="btn btn-icon btn-pumpkin"
                                                                    data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})" disabled>
                                                                    <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                    <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})">
                                                                    <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>

                                                                @elseif ($value->status_result == 3)
                                                                    <button class="btn btn-icon btn-primary"
                                                                    data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})" disabled>
                                                                    <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                    <button class="btn btn-icon btn-pumpkin"
                                                                    data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})" disabled>
                                                                    <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                    <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})">
                                                                    <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>

                                                                    @else
                                                                        <button class="btn btn-icon btn-primary"
                                                                        data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})">
                                                                        <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                        <button class="btn btn-icon btn-pumpkin"
                                                                        data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation({{ $value->id }})" disabled>
                                                                        <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                        <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})" disabled>
                                                                        <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                                @endif

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
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
                            <div>
                                <h6 class="hk-sec-title mb-10" style="font-weight: bold;">พบลูกค้าใหม่</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10 mt-10">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table  id="datable_1_2" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ชื่อร้าน</th>
                                                    <th>อำเภอ,จังหวัด</th>
                                                    <th>สถานะ</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer_new as $key => $value)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$value->shop_name}}</td>
                                                    <td>{{$value->PROVINCE_NAME}}</td>
                                                    <td><span class="badge badge-soft-indigo mt-15 mr-10"
                                                        style="font-size: 12px;">ลูกค้าใหม่</span></td>
                                                    <td align="center">
                                                        <div class="button-list">
                                                            {{-- @if ($value->status_result == 1)
                                                                <button class="btn btn-icon btn-primary"
                                                                    data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})" disabled>
                                                                    <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                <button class="btn btn-icon btn-pumpkin"
                                                                data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})">
                                                                <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})" disabled>
                                                                <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>

                                                            @elseif ($value->status_result == 2)
                                                                <button class="btn btn-icon btn-primary"
                                                                data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})" disabled>
                                                                <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                <button class="btn btn-icon btn-pumpkin"
                                                                data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})" disabled>
                                                                <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})">
                                                                <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>

                                                            @elseif ($value->status_result == 3)
                                                                <button class="btn btn-icon btn-primary"
                                                                data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})" disabled>
                                                                <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                <button class="btn btn-icon btn-pumpkin"
                                                                data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})" disabled>
                                                                <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})">
                                                                <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>

                                                                @else
                                                                    <button class="btn btn-icon btn-primary"
                                                                    data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})">
                                                                    <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                                    <button class="btn btn-icon btn-pumpkin"
                                                                    data-toggle="modal" data-target="#ModalcheckinCust" onclick="getLocation({{ $value->id }})" disabled>
                                                                    <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                                    <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalResult" onclick="saleplan_result({{ $value->id }})" disabled>
                                                                    <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                            @endif --}}

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
                            <div>
                                <h6 class="hk-sec-title mb-10" style="font-weight: bold;">เยี่ยมลูกค้า</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-wrap">
                                    <div class="hk-pg-header mb-10 mt-10">
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table id="datable_1_3" class="table table-hover">
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
                                                @foreach ($list_visit as $key => $value)
                                                <?php $date = Carbon\Carbon::parse($value->customer_visit_date)->format('Y-m');
                                                      $dateNow = Carbon\Carbon::today()->format('Y-m');
                                                    //   if ($date == $dateNow && $value->sale_plans_status == 2) {
                                                ?>
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $value->shop_name }}</td>
                                                        <td>{{ $value->PROVINCE_NAME }}</td>
                                                        <td>{{ $value->customer_contact_name }}</td>
                                                        <td>-</td>
                                                        <td>
                                                            @if ($value->cust_visit_status == 0)
                                                                <span class="badge badge-soft-secondary mt-15 mr-10"
                                                                    style="font-weight: bold; font-size: 12px;">ยังไม่เสร็จ</span>
                                                            @elseif ($value->cust_visit_status == 1)
                                                                <span class="badge badge-soft-success mt-15 mr-10"
                                                                    style="font-weight: bold; font-size: 12px;">สำเร็จ</span>
                                                            @elseif ($value->cust_visit_status == 2)
                                                                <span class="badge badge-soft-danger mt-15 mr-10"
                                                                    style="font-weight: bold; font-size: 12px;">ไม่สำเร็จ</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="button-list">
                                                                <a href="{{ url('delete_visit', $value->id) }}"
                                                                    class="btn btn-icon btn-danger mr-10"
                                                                    onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-trash"></i></h4>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    //  }
                                                    ?>
                                                @endforeach
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

    <!-- Modal Check-in/Out Saleplan -->
    <div class="modal fade" id="Modalcheckin" tabindex="-1" role="dialog" aria-labelledby="Modalcheckin"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ url('saleplan_checkin') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Check-in 2 Check-out</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-20 text-center">
                            {{-- <button type="button" class="btn btn-primary" onclick="getLocation()">GetLocation</button> --}}
                            <input type="hidden" id="lat" name="lat">
                            <input type="hidden" id="lon" name="lon">
                            <p id="demo"></p>
                        </div>
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Check-in/Out Curtomer -->
    <div class="modal fade" id="ModalcheckinCust" tabindex="-1" role="dialog" aria-labelledby="ModalcheckinCust"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ url('coutomer_new_checkin') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Check-in 2 Check-out</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-20 text-center">
                            {{-- <button type="button" class="btn btn-primary" onclick="getLocation()">GetLocation</button> --}}
                            <input type="hidden" id="lat" name="lat">
                            <input type="hidden" id="lon" name="lon">
                            <p id="demo"></p>
                        </div>
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Result -->
<div class="modal fade" id="ModalResult" tabindex="-1" role="dialog" aria-labelledby="ModalResult" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผล Sale plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('saleplan_Result') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="saleplan_id" id="get_saleplan_id">
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="get_detail" cols="30" rows="5" placeholder="" name="saleplan_detail"
                                type="text"> </textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select" id="get_result" name="saleplan_result">
                                    <option selected>-- กรุณาเลือก --</option>
                                    <option value="0">ไม่สนใจ</option>
                                    <option value="1">รอตัดสินใจ</option>
                                    <option value="2">สนใจ/ตกลง</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        var x = document.getElementById("demo");

        function getLocation(id) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
            $("#id").val(id);
        }

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
            $("#lat").val(position.coords.latitude);
            $("#lon").val(position.coords.longitude);
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    reak;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }
    </script>

    {{-- <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>
    var x = document.getElementById("demo");

    function getLocation(id) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
        // var saleplan_id = id;
        $("#id").val(id);
    }

    function showPosition(position) {
        x.innerHTML = "Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude;
        $("#lat").val(position.coords.latitude);
        $("#lon").val(position.coords.longitude);
    }
    </script> --}}


    <script>
        function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function() {
                $(".success").fadeOut();
            }, 1000);
        }
    </script>

<script>
    //Edit
    function saleplan_result(id) {
        $("#get_saleplan_id").val(id);
        $.ajax({
            type: "GET",
            url: "{!! url('saleplan_result_get/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#get_saleplan_id').val(data.dataResult.sale_plan_id);
                $('#get_detail').val(data.dataResult.sale_plan_detail);
                $('#get_result').val(data.dataResult.sale_plan_status);

                $('#ModalResult').modal('toggle');
            }
        });
    }
</script>

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
