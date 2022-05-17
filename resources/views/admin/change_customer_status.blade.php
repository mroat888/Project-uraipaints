@extends('layouts.masterAdmin')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">ลูกค้า</a></li>
            <li class="breadcrumb-item active" aria-current="page">เปลี่ยนสถานะลูกค้าใหม่</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i
                            class="ion ion-md-person"></i></span>เปลี่ยนสถานะลูกค้าใหม่</h4>
            </div>
            <div class="d-flex"></div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="topichead-bggreen" style="margin-bottom: 30px;">รายชื่อลูกค้าใหม่</div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <!-- เงื่อนไขการค้นหา -->
                                @php
                                    $action_search = 'admin/change_customer_status/search'; //-- action form
                                    if (isset($date_filter)) {
                                        //-- สำหรับ แสดงวันที่ค้นหา
                                        $date_search = $date_filter;
                                    } else {
                                        $date_search = '';
                                    }
                                @endphp
                                <form action="{{ url($action_search) }}" method="post">
                                    @csrf
                                    <div class="hk-pg-header mb-10">
                                        <div class="col-sm-12 col-md-12">
                                            <span class="form-inline pull-right pull-sm-center">
                                            <span id="selectdate">
                                                @if(count($team_sales) > 1)
                                                <select name="selectteam_sales" class="form-control form-control-sm" aria-label=".form-select-lg example">
                                                    <option value="" selected>เลือกทีม</option>
                                                    @php 
                                                        $checkteam_sales = "";
                                                        if(isset($selectteam_sales)){
                                                            $checkteam_sales = $selectteam_sales;
                                                        }
                                                    @endphp
                                                    @foreach($team_sales as $team)
                                                        @if($checkteam_sales == $team->id)
                                                            <option value="{{ $team->id }}" selected>{{ $team->team_name }}</option>
                                                        @else
                                                            <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @endif
                                                <select name="selectusers" class="form-control form-control-sm" aria-label=".form-select-lg example">
                                                    <option value="" selected>ผู้แทนขาย</option>
                                                    @php 
                                                        $checkusers = "";
                                                        if(isset($selectusers)){
                                                            $checkusers = $selectusers;
                                                        }
                                                    @endphp
                                                    @foreach($users as $user)
                                                        @if($checkusers == $user->id)
                                                            <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                                        @else
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span id="selectdate">
                                                   <input type="month" id="selectdateFrom" name="selectdateFrom"
                                                        value="{{ $date_search }}" class="form-control form-control-sm"
                                                        style="margin-left:10px; margin-right:10px;" />
                                                    <button style="margin-left:5px; margin-right:5px;"
                                                        class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    @php
                                        $check_Radio_1 = '';
                                        $check_Radio_2 = '';
                                        $check_Radio_3 = '';
                                        $check_Radio_4 = '';
                                        $check_Radio_5 = '';
                                        if (isset($slugradio_filter)) {
                                            switch ($slugradio_filter) {
                                                case 'สำเร็จ':
                                                    $check_Radio_2 = 'checked';
                                                    break;
                                                case 'สนใจ':
                                                    $check_Radio_3 = 'checked';
                                                    break;
                                                case 'ไม่สนใจ':
                                                    $check_Radio_4 = 'checked';
                                                    break;
                                                case 'รอตัดสินใจ':
                                                    $check_Radio_5 = 'checked';
                                                    break;
                                                default:
                                                    $check_Radio_1 = 'checked';
                                            }
                                        } else {
                                            $check_Radio_1 = 'checked';
                                        }
                                    @endphp
                                    <div class="hk-pg-header mb-10">
                                        <div class="form-check form-check-inline">
                                            <label>
                                                <input class="form-check-input checkRadio" type="radio" name="slugradio"
                                                    id="inlineRadio1" value="ทั้งหมด" {{ $check_Radio_1 }}>
                                                <!-- <label class="form-check-label" for="inlineRadio1">ทั้งหมด</label> -->
                                                <section class="bg-orange hk-sec-wrapper mt-3">
                                                    <div class="row">
                                                        <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                            <input type="hidden" name="count_customer_all"
                                                                value="{{ $count_customer_all }}">
                                                            <p class="mb-10">
                                                            <div class="topic-numchart">ทั้งหมด</div>
                                                            <div class="red-numchart">
                                                                <div class="wrap_txt-numchart txt-numchart">
                                                                    {{ $count_customer_all }}</div>
                                                            </div>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline ">
                                            <label>
                                                <input class="form-check-input checkRadio" type="radio" name="slugradio"
                                                    id="inlineRadio2" value="สำเร็จ" {{ $check_Radio_2 }}>
                                                <!-- <label class="form-check-label" for="inlineRadio2">สำเร็จ</label> -->
                                                <section class="bg-blue hk-sec-wrapper">
                                                    <div class="row">
                                                        <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                            <input type="hidden" name="count_customer_success"
                                                                value="{{ $count_customer_success }}">
                                                            <p class="mb-10">
                                                            <div class="topic-numchart">สำเร็จ</div>
                                                            <div class="red-numchart">
                                                                <div class="wrap_txt-numchart txt-numchart">
                                                                    {{ $count_customer_success }}</div>
                                                            </div>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <label>
                                                <input class="form-check-input checkRadio" type="radio" name="slugradio"
                                                    id="inlineRadio3" value="สนใจ" {{ $check_Radio_3 }}>
                                                <!-- <label class="form-check-label" for="inlineRadio3">สนใจ</label> -->
                                                <section class="bg-purple hk-sec-wrapper">
                                                    <div class="row">
                                                        <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                            <input type="hidden" name="count_customer_result_1"
                                                                value="{{ $count_customer_result_1 }}">
                                                            <p class="mb-10">
                                                            <div class="topic-numchart">สนใจ</div>
                                                            <div class="red-numchart">
                                                                <div class="wrap_txt-numchart txt-numchart">
                                                                    {{ $count_customer_result_1 }}</div>
                                                            </div>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <label>
                                                <input class="form-check-input checkRadio" type="radio" name="slugradio"
                                                    id="inlineRadio4" value="ไม่สนใจ" {{ $check_Radio_4 }}>
                                                <!-- <label class="form-check-label" for="inlineRadio4">ไม่สนใจ</label> -->
                                                <section class="bg-purple hk-sec-wrapper">
                                                    <div class="row">
                                                        <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                            <input type="hidden" name="count_customer_result_3"
                                                                value="{{ $count_customer_result_3 }}">
                                                            <p class="mb-10">
                                                            <div class="topic-numchart">ไม่สนใจ</div>
                                                            <div class="red-numchart">
                                                                <div class="wrap_txt-numchart txt-numchart">
                                                                    {{ $count_customer_result_3 }}</div>
                                                            </div>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <label>
                                                <input class="form-check-input checkRadio" type="radio" name="slugradio"
                                                    id="inlineRadio5" value="รอตัดสินใจ" {{ $check_Radio_5 }}>
                                                <!-- <label class="form-check-label" for="inlineRadio5">รอตัดสินใจ</label> -->
                                                <section class="bg-purple hk-sec-wrapper mt-3">
                                                    <div class="row">
                                                        <div class="col-12 mb-topic" style="color: #fff; width:100%;">
                                                            <input type="hidden" name="count_customer_result_2"
                                                                value="{{ $count_customer_result_2 }}">
                                                            <p class="mb-10">
                                                            <div class="topic-numchart">รอตัดสินใจ</div>
                                                            <div class="red-numchart">
                                                                <div class="wrap_txt-numchart txt-numchart">
                                                                    {{ $count_customer_result_2 }}</div>
                                                            </div>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </section>
                                            </label>
                                        </div>
                                    </div>
                                </form>
                                <!-- จบเงื่อนไขการค้นหา -->
                                @php
                                    $btn_edit_hide = 'display:block;';
                                    $url_customer_detail = 'customer_lead/detail';
                                @endphp

                                <div class="table-responsive table-color col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="font-weight: bold;">#</th>
                                                <th style="font-weight: bold;">รูปภาพ</th>
                                                <th style="font-weight: bold;">ชื่อร้าน</th>
                                                <th style="font-weight: bold;">ที่อยู่</th>
                                                <th style="font-weight: bold;">ชื่อผู้ติดต่อ</th>
                                                <th style="font-weight: bold;">เบอร์โทรศัพท์</th>
                                                <th style="font-weight: bold;">สถานะลูกค้า</th>
                                                <th style="font-weight: bold;" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_shops as $key => $shop)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        <div class="media-img-wrap">
                                                            <div class="avatar avatar-sm">
                                                                @if ($shop->shop_profile_image)
                                                                    <img src="{{ isset($shop->shop_profile_image) ? asset('/public/upload/CustomerImage/' . $shop->shop_profile_image) : '' }}"
                                                                        alt="{{ $shop->shop_name }}"
                                                                        class="avatar-img">
                                                                @else
                                                                    <img src="{{ asset('/public/images/people-33.png') }}"
                                                                        alt="" class="avatar-img">
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $shop->shop_name }}</td>
                                                    <td>{{ $shop->PROVINCE_NAME }}</td>
                                                    @php
                                                        $customer_contact_name = '';
                                                        $customer_contact_phone = '';
                                                        foreach ($customer_contacts as $value) {
                                                            if ($value->customer_shop_id == $shop->id) {
                                                                if (!empty($value->customer_contact_name)) {
                                                                    $customer_contact_name = $value->customer_contact_name;
                                                                }
                                                                if (!empty($value->customer_contact_phone)) {
                                                                    $customer_contact_phone = $value->customer_contact_phone;
                                                                }
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    <td>{{ $customer_contact_name }}</td>
                                                    <td>{{ $customer_contact_phone }}</td>
                                                    <td>
                                                        @if ($shop->shop_status == 1)
                                                            <span class="badge badge-soft-success"
                                                                style="font-size: 12px;">สำเร็จ</span>
                                                        @elseif($shop->saleplan_shop_aprove_status == 3)
                                                            <span class="badge badge-soft-purple"
                                                                style="font-size: 12px;">ไม่ผ่านอนุมัติ</span>
                                                        @else
                                                            @if (!is_null($shop->cust_result_status))
                                                                @if ($shop->cust_result_status == 2)
                                                                    <!-- สนใจ	 -->
                                                                    <span class="badge badge-soft-orange"
                                                                        style="font-size: 12px;">สนใจ</span>
                                                                @elseif($shop->cust_result_status == 1)
                                                                    <!-- รอตัดสินใจ -->
                                                                    <span class="badge badge-soft-primary"
                                                                        style="font-size: 12px;">รอตัดสินใจ</span>
                                                                @elseif($shop->cust_result_status == 0)
                                                                    <!-- ไม่สนใจ  -->
                                                                    <span class="badge badge-soft-danger"
                                                                        style="font-size: 12px;">ไม่สนใจ</span>
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="button-list">
                                                            @if ($shop->shop_status == 0)
                                                                <button class="btn btn-icon btn-info btn_change_status_shop" value="{{ $shop->id }}">
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">create</span></h4>
                                                                </button>
                                                            @endif

                                                            @if ($shop->shop_status == 1)
                                                                <button class="btn btn-icon btn-edit btn_editshop"
                                                                    value="{{ $shop->id }}">
                                                                    <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-create"></i></h4>
                                                                </button>
                                                            @endif

                                                            <a href="{{ url($url_customer_detail, $shop->id) }}" class="btn btn-icon btn-purple">
                                                                <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4>
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
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

    <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomer"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขข้อมูลลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form action="{{ url('update_customerLead') }}" method="post" enctype="multipart/form-data"> -->
                <form id="form_edit" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control" id="edit_shop_id" name="edit_shop_id" type="hidden">
                        <input class="form-control" id="edit_cus_contacts_id" name="edit_cus_contacts_id" type="hidden">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อร้าน</label>
                                <input class="form-control" id="edit_shop_name" name="edit_shop_name" type="text"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อผู้ติดต่อ</label>
                                <input class="form-control" id="edit_contact_name" placeholder=""
                                    name="edit_contact_name" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">เบอร์โทรศัพท์</label>
                                <input class="form-control" id="edit_customer_contact_phone" placeholder=""
                                    name="edit_customer_contact_phone" type="text" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="edit_shop_address">ที่อยู่</label>
                                <textarea class="form-control" placeholder="" id="edit_shop_address" name="edit_shop_address" rows="3"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">จังหวัด</label>
                                <select name="edit_province" id="edit_province" class="form-control province" required>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">อำเภอ/เขต</label>
                                <select name="edit_amphur" id="edit_amphur" class="form-control amphur">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ตำบล/แขวง</label>
                                <select name="edit_district" id="edit_district" class="form-control district">
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="username">รหัสไปรษณีย์</label>
                                <input class="form-control postcode" id="edit_shop_zipcode" placeholder=""
                                    name="edit_shop_zipcode" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input class="form-control" id="edit_image" name="edit_image" type="file">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">เอกสารแนบ</label>
                                <input class="form-control" id="edit_shop_fileupload" name="edit_shop_fileupload"
                                    type="file">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal Edit -->
    <div class="modal fade" id="customer_change_status" tabindex="-1" role="dialog" aria-labelledby="customer_change_status" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">บันทึกเปลี่ยนสถานะลูกค้าใหม่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_status_update" enctype="multipart/form-data">
                    {{-- <form action="{{url('admin/change_customer_status_update')}}" method="POST" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <input class="form-control" id="shop_id" name="shop_id" type="text">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รหัสลูกค้า (MRP)</label>
                                <input class="form-control" id="mrp_identify" name="mrp_identify" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">สถานะ</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">--โปรดเลือก--</option>
                                    <option value="1">สำเร็จ</option> <!-- ทะเบียนลูกค้า -->
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อร้าน</label>
                                <input class="form-control" id="shop_name"  name="shop_name" type="text" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อผู้ติดต่อ</label>
                                <input class="form-control" id="contact_name" name="contact_name" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="shop_address">ที่อยู่</label>
                                <textarea class="form-control" id="shop_address" name="shop_address" rows="3" readonly></textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">เบอร์โทรศัพท์</label>
                                <input class="form-control" id="customer_contact_phone" name="customer_contact_phone" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">จังหวัด</label>
                                <input class="form-control" id="province" name="province" type="text" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">อำเภอ/เขต</label>
                                <input class="form-control" id="amphur" name="amphur" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ตำบล/แขวง</label>
                                <input class="form-control" id="district" name="district" type="text" readonly>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="username">รหัสไปรษณีย์</label>
                                <input class="form-control" id="shop_zipcode" name="shop_zipcode" type="text" readonly>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_edit">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <style>
        [type=radio] {
            position: absolute;
            opacity: 0;
        }

        [type=radio]+section {
            cursor: pointer;
            margin-right: 0.5rem;
        }

    </style>


    <script>
        $(document).on('click','.btn_change_status_shop', function(e){
        e.preventDefault();
        let shop_id = $(this).val();
        $("#shop_id").val(shop_id);

        $.ajax({
            method: 'GET',
            url: "{!! url('admin/change_customer_status_edit/"+shop_id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data){
                // console.log(response);

                    $("#mrp_identify").val(data.dataCustomer.mrp_identify);
                    $("#shop_name").val(data.dataCustomer.shop_name);
                    $("#contact_name").val(data.dataCustomer.customer_contact_name);
                    $("#shop_address").val(data.dataCustomer.shop_address);
                    $("#customer_contact_phone").val(data.dataCustomer.customer_contact_phone);
                    $("#province").val(data.dataCustomer.province);
                    $("#amphur").val(data.dataCustomer.amphur);
                    $("#district").val(data.dataCustomer.district);
                    $("#shop_zipcode").val(data.dataCustomer.shop_zipcode);

                    $("#customer_change_status").modal('show');
            }
        });

    });

    $("#form_status_update").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: '{{ url("admin/change_customer_status_update") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                $("#editCustomer").modal('hide');
                location.reload();
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

        $(document).ready(function() {

            $('#is_monthly_plan').val('N'); // กำหนดสถานะ Y = อยู่ในแผน , N = ไม่อยู่ในแผน (เพิ่มระหว่างเดือน)

            $("#customer_shops").on("change", function(e) {
                e.preventDefault();
                let shop_id = $(this).val();
                if (shop_id != "") {
                    $('#customer_shops_id').val(shop_id);
                    $('#shop_name').attr('readonly', true);
                    $('#contact_name').attr('readonly', true);
                    $('#shop_phone').attr('readonly', true);
                    $('#shop_address').attr('readonly', true);
                    $('#province').attr('disabled', 'disabled');
                    $('#amphur').attr('disabled', 'disabled');
                    $('#district').attr('disabled', 'disabled');
                    $('#postcode').attr('readonly', true);
                } else {
                    $('#customer_shops_id').val('');
                    $('#shop_name').attr('readonly', false);
                    $('#contact_name').attr('readonly', false);
                    $('#shop_phone').attr('readonly', false);
                    $('#shop_address').attr('readonly', false);
                    $('#province').removeAttr("disabled");
                    $('#amphur').removeAttr("disabled");
                    $('#district').removeAttr("disabled");
                    $('#postcode').attr('readonly', false);
                }
                $.ajax({
                    method: 'GET',
                    url: '{{ url('admin/edit_customerLead') }}/' + shop_id,
                    datatype: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            $("#customer_shops_id").val(shop_id);
                            $("#shop_name").val(response.dataEdit.shop_name);
                            if (response.customer_contacts != null) {
                                $("#contact_name").val(response.customer_contacts
                                    .customer_contact_name);
                                $("#shop_phone").val(response.customer_contacts
                                    .customer_contact_phone);
                            }
                            $("#shop_address").val(response.dataEdit.shop_address);

                            $.each(response.shop_province, function(key, value) {
                                if (value.PROVINCE_ID == response.dataEdit
                                    .shop_province_id) {
                                    $('#province').append('<option value=' + value
                                        .PROVINCE_ID + ' selected>' + value
                                        .PROVINCE_NAME + '</option>');
                                } else {
                                    $('#province').append('<option value=' + value
                                        .PROVINCE_ID + '>' + value.PROVINCE_NAME +
                                        '</option>');
                                }
                            });

                            $.each(response.shop_amphur, function(key, value) {
                                if (value.AMPHUR_ID == response.dataEdit
                                    .shop_amphur_id) {
                                    $('#amphur').append('<option value=' + value
                                        .AMPHUR_ID + ' selected>' + value
                                        .AMPHUR_NAME + '</option>');
                                } else {
                                    $('#amphur').append('<option value=' + value
                                        .AMPHUR_ID + '>' + value.AMPHUR_NAME +
                                        '</option>');
                                }
                            });

                            $.each(response.shop_district, function(key, value) {
                                if (value.DISTRICT_ID == response.dataEdit
                                    .shop_district_id) {
                                    $('#district').append('<option value=' + value
                                        .DISTRICT_ID + ' selected>' + value
                                        .DISTRICT_NAME + '</option>');
                                } else {
                                    $('#district').append('<option value=' + value
                                        .DISTRICT_ID + '>' + value.DISTRICT_NAME +
                                        '</option>');
                                }
                            });

                            $("#postcode").val(response.dataEdit.shop_zipcode);
                        }
                    }
                });

            });
        });

        $(document).on('click', '.btn_editshop', function(e) {
            e.preventDefault();
            let shop_id = $(this).val();

            $.ajax({
                method: 'GET',
                url: "{!! url('admin/edit_customerLead/"+shop_id+"') !!}",
                datatype: 'json',
                success: function(response) {
                    //console.log(response);
                    if (response.status == 200) {
                        $("#editCustomer").modal('show');
                        $("#edit_shop_id").val(shop_id);
                        $("#edit_shop_name").val(response.dataEdit.shop_name);
                        if (response.customer_contacts != null) {
                            $("#edit_cus_contacts_id").val(response.customer_contacts.id);
                            $("#edit_contact_name").val(response.customer_contacts
                                .customer_contact_name);
                            $("#edit_customer_contact_phone").val(response.customer_contacts
                                .customer_contact_phone);
                        }
                        $("#edit_shop_address").val(response.dataEdit.shop_address);

                        $.each(response.shop_province, function(key, value) {
                            if (value.PROVINCE_ID == response.dataEdit.shop_province_id) {
                                $('#edit_province').append('<option value=' + value
                                    .PROVINCE_ID + ' selected>' + value.PROVINCE_NAME +
                                    '</option>');
                            } else {
                                $('#edit_province').append('<option value=' + value
                                    .PROVINCE_ID + '>' + value.PROVINCE_NAME + '</option>');
                            }
                        });

                        $.each(response.shop_amphur, function(key, value) {
                            if (value.AMPHUR_ID == response.dataEdit.shop_amphur_id) {
                                $('#edit_amphur').append('<option value=' + value.AMPHUR_ID +
                                    ' selected>' + value.AMPHUR_NAME + '</option>');
                            } else {
                                $('#edit_amphur').append('<option value=' + value.AMPHUR_ID +
                                    '>' + value.AMPHUR_NAME + '</option>');
                            }
                        });

                        $.each(response.shop_district, function(key, value) {
                            if (value.DISTRICT_ID == response.dataEdit.shop_district_id) {
                                $('#edit_district').append('<option value=' + value
                                    .DISTRICT_ID + ' selected>' + value.DISTRICT_NAME +
                                    '</option>');
                            } else {
                                $('#edit_district').append('<option value=' + value
                                    .DISTRICT_ID + '>' + value.DISTRICT_NAME + '</option>');
                            }
                        });

                        $("#edit_shop_zipcode").val(response.dataEdit.shop_zipcode);


                    }
                }
            });

        })

        $("#form_edit").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/update_customerLead') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $("#editCustomer").modal('hide');
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });

        $(document).on('change', '.province', function(e) {
            e.preventDefault();
            let pvid = $(this).val();
            $.ajax({
                method: 'GET',
                url: '{{ url('/fetch_amphur') }}/' + pvid,
                datatype: 'json',
                success: function(response) {
                    //alert(response.AMPHUR_NAME);
                    if (response.status == 200) {
                        //console.log(response)
                        $('.amphur').children().remove().end();
                        $('.district').children().remove().end();
                        $('.amphur').append('<option selected value="0">--โปรดเลือก--</option>');
                        $('.district').append('<option selected value="0">--โปรดเลือก--</option>');
                        $('.postcode').val('');
                        $.each(response.amphurs, function(key, value) {
                            $('.amphur').append('<option value=' + value.AMPHUR_ID + '>' + value
                                .AMPHUR_NAME + '</option>');
                        });
                    }
                }
            });
        });

        $(document).on('change', '.amphur', function(e) {
            e.preventDefault();
            let amid = $(this).val();
            $.ajax({
                method: 'GET',
                url: '{{ url('/fetch_district') }}/' + amid,
                datatype: 'json',
                success: function(response) {
                    //alert(response.AMPHUR_NAME);
                    if (response.status == 200) {
                        //console.log(response)
                        $('.district').children().remove().end();
                        $('.district').append('<option selected value="0">--โปรดเลือก--</option>');
                        $('.postcode').val('');
                        $.each(response.districts, function(key, value) {
                            $('.district').append('<option value=' + value.DISTRICT_ID + '>' +
                                value.DISTRICT_NAME + '</option>');
                        });
                    }
                }
            });
        });

        $(document).on('change', '.district', function(e) {
            e.preventDefault();
            let disid = $(this).val();
            $.ajax({
                method: 'GET',
                url: '{{ url('/fetch_postcode') }}/' + disid,
                datatype: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        //console.log(response)
                        let postcode = response.postcode.POSTCODE;
                        $('.postcode').val(postcode);
                    }
                }
            });
        });

        $(document).on('click', '.checkRadio', function() {
            $("#submit_request").trigger("click");
        });
    </script>

    <script>
        function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function() {
                $(".success").fadeOut();
            }, 1000);
        }

        // function showselectdate(){
        //     $("#selectdate").css("display", "block");
        //     $("#bt_showdate").hide();
        // }

        // function hidetdate(){
        //     $("#selectdate").css("display", "none");
        //     $("#bt_showdate").show();
        // }
    </script>

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
