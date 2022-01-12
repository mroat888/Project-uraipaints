@extends('layouts.masterAdmin')

@section('content')

 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">แผนประจำเดือน</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">ปฎิทินกิจกรรม</li> --}}
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="mt-30 mb-30">
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div><h6 class="hk-sec-title mb-10" style="font-weight: bold;">แผนสรุปรายเดือน ปี 2565</h6></div>
                    <div class="d-flex">
                        <input type="month" class="form-control" name="" id="">
                        <input type="month" class="form-control ml-5" name="" id="">
                        <button type="button" class="btn btn_purple btn-violet btn-sm ml-5">ค้นหา</button>
                    </div>
                    </div>
                    {{-- <h5 class="hk-sec-title">แผนสรุปรายเดือน ปี 2565</h5> --}}
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>เดือน</th>
                                            <th>แผนทำงาน</th>
                                            <th>ลูกค้าใหม่</th>
                                            <th>รวมงาน</th>
                                            <th>ดำเนินการแล้ว</th>
                                            <th>คงเหลือ</th>
                                            <th>สำเร็จ %</th>
                                            <th>เยี่ยมลูกค้า</th>
                                            <th>สถานะ</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>มกราคม</td>
                                            <td>15</td>
                                            <td>6</td>
                                            <td>21</td>
                                            <td>14</td>
                                            <td>7</td>
                                            <td>77%</td>
                                            <td>15</td>
                                            <td><span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span></td>
                                            <td>
                                                <div class="button-list">
                                                    <button class="btn btn-icon btn-warning" data-toggle="modal" data-target="#exampleModalLarge01">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                        <button  class="btn btn-icon btn-danger">
                                                            <span class="btn-icon-wrap"><i data-feather="pie-chart"></i></span></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>กุมภาพันธ์</td>
                                            <td>15</td>
                                            <td>6</td>
                                            <td>21</td>
                                            <td>14</td>
                                            <td>7</td>
                                            <td>77%</td>
                                            <td>15</td>
                                            <td><span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span></td>
                                            <td>
                                                <div class="button-list">
                                                    <button class="btn btn-icon btn-warning" data-toggle="modal" data-target="#exampleModalLarge01">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                        <button  class="btn btn-icon btn-danger">
                                                            <span class="btn-icon-wrap"><i data-feather="pie-chart"></i></span></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>มีนาคม</td>
                                            <td>15</td>
                                            <td>6</td>
                                            <td>21</td>
                                            <td>14</td>
                                            <td>7</td>
                                            <td>77%</td>
                                            <td>15</td>
                                            <td><span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span></td>
                                            <td>
                                                <div class="button-list">
                                                    <button class="btn btn-icon btn-warning" data-toggle="modal" data-target="#exampleModalLarge01">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                        <button  class="btn btn-icon btn-danger">
                                                            <span class="btn-icon-wrap"><i data-feather="pie-chart"></i></span></button>
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

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">แผนงานประจำเดือน มกราคม/2565</h5>
                    <div class="row mt-30">
                        <div class="col-md-4">
                            <div class="card card-sm" style="background: rgb(184, 108, 255);">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase"></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <button class="btn btn-icon btn-light btn-lg">
                                                    <span class="btn-icon-wrap"><i data-feather="briefcase"></i>
                                                    </span>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="mb-10">
                                            <span style="font-weight: bold; font-size: 18px;">แผนทำงาน</span>
                                        </div>
                                        <div class="mb-10">
                                            <span style="font-weight: bold; font-size: 18px;">15</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-sm" style="background: rgb(4, 196, 106);">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase"></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <button class="btn btn-icon btn-light btn-lg">
                                                    <span class="btn-icon-wrap"><i data-feather="user-plus"></i>
                                                    </span>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="mb-10">
                                            <span style="font-weight: bold; font-size: 18px;">พบลูกค้าใหม่</span>
                                        </div>
                                        <div class="mb-10">
                                            <span style="font-weight: bold; font-size: 18px;">6</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-sm" style="background: rgb(255, 208, 108);">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase"></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <button class="btn btn-icon btn-light btn-lg">
                                                    <span class="btn-icon-wrap"><i data-feather="log-in"></i>
                                                    </span>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="mb-10">
                                            <span style="font-weight: bold; font-size: 18px;">เยี่ยมลูกค้า</span>
                                        </div>
                                        <div class="mb-10">
                                            <span style="font-weight: bold; font-size: 18px;">15</span>
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
                                                <th>#</th>
                                                <th>เรื่อง</th>
                                                <th>ลูกค้า</th>
                                                <th>ความคิดเห็น</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><span class="topic_purple">แนะนำสินค้า</span></td>
                                                {{-- <td>11/10/2021</td> --}}
                                                <td>บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</td>
                                                <td><span class="badge badge-soft-indigo mt-15 mr-10" style="font-size: 12px;">Comment</span></td>
                                                <td>
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalSalePlan" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                        <button class="btn btn-icon btn-warning mr-10"
                                                            data-toggle="modal" data-target="#exampleModalLarge01">
                                                            <span class="btn-icon-wrap"><i data-feather="edit"
                                                                ></i></span></button>
                                                        <button class="btn btn-icon btn-danger mr-10">
                                                            <span class="btn-icon-wrap"><i data-feather="trash-2"
                                                                ></i></span></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><span class="topic_purple">แนะนำสินค้า Home Paint Outlet</span></td>
                                                {{-- <td>20/10/2021</td> --}}
                                                <td>Home Paint Outlet</td>
                                                <td><span class="badge badge-soft-indigo mt-15 mr-10" style="font-size: 12px;">Comment</span></td>
                                                <td>
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalSalePlan" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                        <button class="btn btn-icon btn-warning mr-10"
                                                            data-toggle="modal" data-target="#exampleModalLarge01">
                                                            <span class="btn-icon-wrap"><i data-feather="edit"
                                                                ></i></span></button>
                                                        <button class="btn btn-icon btn-danger mr-10">
                                                            <span class="btn-icon-wrap"><i data-feather="trash-2"
                                                                ></i></span></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><span class="topic_purple">แนะนำสินค้า</span></td>
                                                {{-- <td>11/10/2021</td> --}}
                                                <td>บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</td>
                                                <td><span class="badge badge-soft-indigo mt-15 mr-10" style="font-size: 12px;">Comment</span></td>
                                                <td>
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#ModalSalePlan" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                        <button class="btn btn-icon btn-warning mr-10"
                                                            data-toggle="modal" data-target="#exampleModalLarge01">
                                                            <span class="btn-icon-wrap"><i data-feather="edit"
                                                                ></i></span></button>
                                                        <button class="btn btn-icon btn-danger mr-10">
                                                            <span class="btn-icon-wrap"><i data-feather="trash-2"
                                                                ></i></span></button>
                                                    </div>
                                                    </a>
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
                            <div><h6 class="hk-sec-title mb-10" style="font-weight: bold;">พบลูกค้าใหม่</h6></div>
                        <div class="d-flex">
                            <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal"
                                data-target="#exampleModalLarge02"> + เพิ่มใหม่ </button>
                        </div>
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
                                                {{-- <th>วันที่</th> --}}
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
                                                {{-- <td>01/11/2021</td> --}}
                                                <td><span class="badge badge-soft-success mt-15 mr-10" style="font-size: 12px;">Finished</span></td>
                                                <td align="center">
                                                    <div class="button-list">
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
                                                {{-- <td>01/11/2021</td> --}}
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

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                        <div class="hk-pg-header mb-10">
                            <div><h6 class="hk-sec-title mb-10" style="font-weight: bold;">เยี่ยมลูกค้า</h6></div>
                        <div class="d-flex">
                            <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal"
                                data-target="#exampleModalLarge03"> + เพิ่มใหม่ </button>
                        </div>
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
                                                <td>1</td>
                                                <td>System Architect</td>
                                                <td>บางพลี,สมุทรปราการ</td>
                                                <td>เปิดตลาดใหม่</td>
                                                <td>01/11/2021,วันเกิด</td>
                                                <td><span class="badge badge-soft-success mt-15 mr-10" style="font-size: 12px;">Finished</span></td>
                                                <td>
                                                    <div class="button-list">
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
                                                <td>-</td>
                                                <td><span class="badge badge-soft-danger mt-15 mr-10" style="font-size: 12px;">Failed</span></td>
                                                <td colspan="4">
                                                    <div class="button-list">
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
                        <!-- <div class="form-group col-md-6">
                            <label for="username">สถานะ</label>
                            <select class="form-control custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div> -->
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

<!-- Modal -->
<div class="modal fade" id="ModalSalePlan" tabindex="-1" role="dialog" aria-labelledby="ModalSalePlan" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผล Sale plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="address" cols="30" rows="5" placeholder="" value=""
                                type="text"> </textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select">
                                    <option selected>-- กรุณาเลือก --</option>
                                    <option value="1">ไม่สนใจ</option>
                                    <option value="2">รอตัดสินใจ</option>
                                    <option value="3">สนใจ/ตกลง</option>
                                </select>
                            </div>
                        </div>
                    </form>
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
