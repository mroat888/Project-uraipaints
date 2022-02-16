@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ตารางรายการ Sale Plan</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
     <div class="container-fluid px-xxl-65 px-xl-20">

         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>ตารางรายการ Sale Plan</h4>
            </div>
            <div class="d-flex">
                {{-- <button type="button" class="btn btn-primary btn-sm btn-rounded px-3" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button> --}}
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <a href="{{url('palncalendar')}}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                    <span class="icon-label">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <span class="btn-text">ปฎิทิน</span>
                                </a>

                                <a href="{{url('planDetail')}}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                    <span class="icon-label">
                                        <i class="fa fa-list"></i>
                                    </span>
                                    <span class="btn-text">List</span>
                                </a>
                                <hr>
                                <div id="calendar"></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-3">
                                <h5 class="hk-sec-title">ตาราง Sale Plan</h5>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <!-- ------ -->
                                <span class="form-inline pull-right pull-sm-center">
                                    <div class="box_search d-flex">
                                        <span class="txt_search">Search:</span>
                                            <input type="text" name="" id="" class="form-control form-control-sm" placeholder="ค้นหา">
                                        </div>

                                    <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกวันที่</button>
                                    <span id="selectdate" style="display:none;">

                                    Date : <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateFrom" value="<?= date('Y-m-d'); ?>" />

                                        to <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" value="<?= date('Y-m-d'); ?>" />

                                        <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button>
                                    </span>

                                    {{-- <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-teal btn-sm">ประเภทข้อมูล</button> --}}
                                    <select class="form-control custom-select form-control-sm">
                                        <option selected>ประเภทข้อมูล</option>
                                        <option value="1">แผนงาน</option>
                                        <option value="2">พบลูกค้าใหม่</option>
                                        <option value="3">เยี่ยมลูกค้า</option>
                                        <option value="3">คำขออนุมัติ</option>
                                        <option value="3">คำสั่งงาน</option>
                                    </select>

                                </span>
                                <!-- ------ -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm mt-10">
                                <div class="table-responsive-sm">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>เรื่อง</th>
                                                <th>วันที่</th>
                                                <th>ลูกค้า</th>
                                                <th>การอนุมัติ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>แนะนำสินค้า</td>
                                                <td>11/10/2021</td>
                                                <td>บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</td>
                                                <td><span class="badge badge-soft-success mt-15 mr-10" style="font-size: 12px;">Approval</span></td>
                                                <td>
                                                    <span class="badge badge-soft-danger mt-15 mr-10" style="font-size: 12px;">Fail</span>
                                                    <span class="badge badge-soft-info mt-15 mr-10" style="font-size: 12px;">Finished</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>แนะนำสินค้า Home Paint Outlet</td>
                                                <td>20/10/2021</td>
                                                <td>Home Paint Outlet</td>
                                                <td><span class="badge badge-soft-success mt-15 mr-10" style="font-size: 12px;">Approval</span></td>
                                                <td>
                                                    <div class="button-list">
                                                    <button class="btn btn-icon btn-primary" data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation()">
                                                        <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                    <button class="btn btn-icon btn-pumpkin" data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation()">
                                                        <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                    <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#Modalvisit" onclick="getLocation()">
                                                        <span class="btn-icon-wrap"><i data-feather="book"></i></span></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </section>
                </div>
            </div>
            <!-- /Row -->
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        {{-- @include('saleplan.salePlanForm') --}}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modalvisit" tabindex="-1" role="dialog" aria-labelledby="Modalvisit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผลการเข้าพบ</h5>
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

    @include('saleplan.salePlanCheckin')


    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" /> --}}


    <script>
        function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function() {
                $(".success").fadeOut();
            }, 1000);
        }


    function showselectdate(){
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }

    </script>




@endsection
