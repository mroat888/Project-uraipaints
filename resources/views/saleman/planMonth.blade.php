@extends('layouts.master')

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
                            <div>
                                <h6 class="hk-sec-title mb-10" style="font-weight: bold;">แผนสรุปรายเดือน ปี 2565</h6>
                            </div>
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
                                                    {{-- <th>ดำเนินการแล้ว</th> --}}
                                                    <th>คงเหลือ</th>
                                                    <th>สำเร็จ %</th>
                                                    <th>เยี่ยมลูกค้า</th>
                                                    <th>สถานะ</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($monthly_plan as $key => $value)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $value->month_date }}</td>
                                                        <td>{{ $value->sale_plan_amount }}</td>
                                                        <td>{{ $value->cust_new_amount }}</td>
                                                        <td>{{ $value->total_plan }}</td>
                                                        <td>{{ $value->outstanding_plan }}</td>
                                                        <td>{{ $value->success_plan }}</td>
                                                        <td>{{ $value->cust_visits_amount }}</td>
                                                        <td>
                                                            @if ($value->status_approve == 0)
                                                                <span class="badge badge-soft-secondary"
                                                                    style="font-size: 12px;">
                                                                    Draf
                                                                </span>
                                                            @elseif ($value->status_approve == 1)
                                                                <span class="badge badge-soft-warning"
                                                                    style="font-size: 12px;">
                                                                    Pending
                                                                </span>
                                                            @else
                                                                <span class="badge badge-soft-success"
                                                                    style="font-size: 12px;">
                                                                    Approve
                                                                </span>
                                                            @endif
                                                            </span>
                                                        </td>
                                                        <td align="center">
                                                            <div class="button-list">
                                                                {{-- <a href="{{url('approve_monthly_plan', $monthly_plan_id)}}" class="btn btn-icon btn-teal">
                                                                <span class="btn-icon-wrap"><i
                                                                        data-feather="edit"></i></span></a> --}}
                                                                <form
                                                                    action="{{ url('approve_monthly_plan', $monthly_plan_id) }}"
                                                                    method="GET">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-teal requestApproval">
                                                                        <span class="btn-icon-wrap"><i
                                                                                data-feather="edit"></i></span></button>

                                                                    <button class="btn btn-icon btn-danger ml-2">
                                                                        <span class="btn-icon-wrap"><i
                                                                                data-feather="pie-chart"></i></span></button>
                                                                </form>

                                                            </div>
                                                        </td>
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
                                                <span style="font-weight: bold; font-size: 18px;">
                                                    <?php
                                                    $sum_saleplan = 0;
                                                    foreach ($list_saleplan as $key => $value) {
                                                    if ($monthly_plan_id == $value->monthly_plan_id) {
                                                        $sum_saleplan++
                                                    ?>
                                                    <?php } } ?>
                                                    {{ $sum_saleplan }}
                                                </span>
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
                                                <span
                                                    style="font-weight: bold; font-size: 18px;">{{ $customer_new->count() }}</span>
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
                                                <span style="font-weight: bold; font-size: 18px;">
                                                    <?php
                                                    $sum_visit = 0;
                                                    foreach ($list_visit as $key => $value) {
                                                    if ($monthly_plan_id == $value->monthly_plan_id) {
                                                        $sum_visit++
                                                    ?>
                                                    <?php } } ?>
                                                    {{ $sum_visit }}
                                                </span>
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
                            <div class="d-flex">
                                <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10"
                                    data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
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
                                        <table id="datable_1" class="table table-hover">
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
                                                @foreach ($list_saleplan as $key => $value)
                                                    <?php
                                                if ($monthly_plan_id == $value->monthly_plan_id) {
                                          ?>
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td><span
                                                                class="topic_purple">{{ $value->sale_plans_title }}</span>
                                                        </td>
                                                        {{-- <td>11/10/2021</td> --}}
                                                        <td>{{ $value->shop_name }}</td>
                                                        <td><span class="badge badge-soft-indigo mt-15 mr-10"
                                                                style="font-size: 12px;">Comment</span></td>
                                                        <td align="center">
                                                            <div class="button-list">
                                                                <button class="btn btn-icon btn-warning mr-10 btn_editshop"
                                                                    onclick="edit_modal({{ $value->id }})"
                                                                    data-toggle="modal" data-target="#saleplanEdit">
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-create"></i></h4>
                                                                </button>
                                                                <button class="btn btn-icon btn-danger mr-10">
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-trash"></i></h4>
                                                                </button>
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
                            <div class="d-flex">
                                <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10"
                                    data-toggle="modal" data-target="#exampleModalLarge02"> + เพิ่มใหม่ </button>
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
                                        <table id="datable_1_2" class="table table-hover">
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
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $value->shop_name }}</td>
                                                        <td>{{ $value->PROVINCE_NAME }}</td>
                                                        <td>
                                                            <span class="badge badge-soft-indigo mt-15 mr-10"
                                                                style="font-size: 12px;">ลูกค้าใหม่</span>
                                                        </td>
                                                        <td align="center">
                                                            <div class="button-list">
                                                                {{-- <button class="btn btn-icon btn-warning mr-10"
                                                                data-toggle="modal" data-target="#exampleModalLarge02">
                                                                <span class="btn-icon-wrap"><i
                                                                        data-feather="edit"></i></span></button> --}}
                                                                <button class="btn btn-icon btn-warning mr-10 btn_editshop"
                                                                    value="{{ $value->id }}">
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-create"></i></h4>
                                                                </button>
                                                                <button id="btn_delete"
                                                                    class="btn btn-icon btn-danger mr-10"
                                                                    value="{{ $value->id }}">
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i
                                                                            class="ion ion-md-trash"></i></h4>
                                                                </button>
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
                            <div class="d-flex">
                                <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10"
                                    data-toggle="modal" data-target="#addCustomerVisit"> + เพิ่มใหม่ </button>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        @include('saleplan.salePlanForm')
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="saleplanEdit" tabindex="-1" role="dialog" aria-labelledby="saleplanEdit"
        aria-hidden="true">
        @include('saleplan.salePlanForm_edit')
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge02" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge02"
        aria-hidden="true">
        @include('customer.lead_insert')
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomer"
        aria-hidden="true">
        @include('customer.lead_edit')
    </div>

    <!-- Modal VisitCustomer -->
    <div class="modal fade" id="addCustomerVisit" tabindex="-1" role="dialog" aria-labelledby="addCustomerVisit"
        aria-hidden="true">
        @include('saleman.visitCustomers_add')
    </div>



    <!-- Modal -->
    <div class="modal fade" id="ModalSalePlan" tabindex="-1" role="dialog" aria-labelledby="ModalSalePlan"
        aria-hidden="true">
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

    <!-- Modal Delete Customer Approve -->
    <div class="modal fade" id="ModalapproveDelete" tabindex="-1" role="dialog" aria-labelledby="Modalapprove"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_cus_delete" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบข้อมูลลูกค้าใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบข้อมูลลูกค้า ใช่หรือไม่ ?</h3>
                        <input class="form-control" id="shop_id_delete" name="shop_id_delete" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
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
        $(document).on('click', '#btn_update', function() {
            let shop_id = $(this).val();
            $('#shop_id').val(shop_id);
            $('#Modalapprove').modal('show');
        });

        $(document).on('click', '#btn_delete', function() {
            let shop_id_delete = $(this).val();
            $('#shop_id_delete').val(shop_id_delete);
            $('#ModalapproveDelete').modal('show');
        });

        $("#from_cus_update").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('/leadtocustomer') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Update Success',
                        text: "เปลี่ยนสถานะลูกค้าเรียบร้อยแล้วค่ะ",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#Modalapprove').modal('hide');
                    $('#shop_status_name_lead').text('ลูกค้าใหม่')
                    $('#btn_update').prop('disabled', true);
                    //location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });

        $("#from_cus_delete").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('/customerdelete') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: "ลบข้อมูลลูกค้าเรียบร้อยแล้วค่ะ",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalapproveDelete').modal('hide');
                    $('#shop_status_name_lead').text('ลบข้อมูลลูกค้าเรียบร้อย')
                    $('#btn_update').prop('disabled', true);
                    $('#btn_delete').prop('disabled', true);

                    //location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.requestApproval').click(function(evt) {
                var form = $(this).closest("form");
                evt.preventDefault();

                swal({
                    title: `ต้องการขออนุมัติแผนงานหรือไม่ ?`,
                    // text: "ถ้าลบแล้วไม่สามารถกู้คืนข้อมูลได้",
                    icon: "warning",
                    // buttons: true,
                    buttons: [
                        'ยกเลิก',
                        'ขออนุมัติ'
                    ],
                    infoMode: true
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                })

            });

        });
    </script>


@section('footer')
    @include('layouts.footer')
@endsection

@endsection
