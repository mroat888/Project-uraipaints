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
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-person"></i></span>เปลี่ยนสถานะลูกค้าใหม่</h4>
            </div>
            <div class="d-flex">
                {{-- <button class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal" data-target="#addCustomer"> + เพิ่มใหม่ </button> --}}
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">รายชื่อลูกค้าใหม่</h5>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <!-- เงื่อนไขการค้นหา -->
                                @php
                                    $action_search = "/lead/search"; //-- action form
                                    if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                        $date_search = $date_filter;
                                    }else{
                                        $date_search = "";
                                    }
                                @endphp
                                <form action="{{ url($action_search) }}" method="post">
                                @csrf
                                <div class="hk-pg-header mb-10">
                                    <div class="col-sm-12 col-md-12">
                                        <span class="form-inline pull-right pull-sm-center">
                                            <span id="selectdate">
                                                ปี/เดือน : <input type="month" id="selectdateFrom" name="selectdateFrom"
                                                value="{{ $date_search }}" class="form-control form-control-sm"
                                                style="margin-left:10px; margin-right:10px;"/>
                                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request">ค้นหา</button>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                @php
                                    $check_Radio_1 = "";
                                    $check_Radio_2 = "";
                                    $check_Radio_3 = "";
                                    $check_Radio_4 = "";
                                    $check_Radio_5 = "";
                                    if(isset($slugradio_filter)){
                                        switch($slugradio_filter){
                                            case "สำเร็จ" : $check_Radio_2 = "checked";
                                                break;
                                            case "สนใจ" : $check_Radio_3 = "checked";
                                                break;
                                            case "ไม่สนใจ" : $check_Radio_4 = "checked";
                                                break;
                                            case "รอตัดสินใจ" : $check_Radio_5 = "checked";
                                                break;
                                            default : $check_Radio_1 = "checked";
                                        }
                                    }else{
                                        $check_Radio_1 = "checked";
                                    }
                                @endphp
                                <div class="hk-pg-header mb-10">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio1" value="ทั้งหมด" {{ $check_Radio_1 }}>
                                        <label class="form-check-label" for="inlineRadio1">ทั้งหมด</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio2" value="สำเร็จ" {{ $check_Radio_2 }}>
                                        <label class="form-check-label" for="inlineRadio2">สำเร็จ</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio3" value="สนใจ" {{ $check_Radio_3 }}>
                                        <label class="form-check-label" for="inlineRadio3">สนใจ</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio4" value="ไม่สนใจ" {{ $check_Radio_4 }}>
                                        <label class="form-check-label" for="inlineRadio4">ไม่สนใจ</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio5" value="รอตัดสินใจ" {{ $check_Radio_5 }}>
                                        <label class="form-check-label" for="inlineRadio5">รอตัดสินใจ</label>
                                    </div>
                                </div>
                                </form>
                                <!-- จบเงื่อนไขการค้นหา -->

                                <div class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="font-weight: bold;">#</th>
                                                <th style="font-weight: bold;">วันที่เพิ่มลูกค้าใหม่</th>
                                                <th style="font-weight: bold;">วันที่อนุมัติ</th>
                                                <th style="font-weight: bold;">ผู้แทนขาย</th>
                                                <th style="font-weight: bold;">ชื่อร้าน</th>
                                                <th style="font-weight: bold;">อำเภอ, จังหวัด</th>
                                                <th style="font-weight: bold;">การอนุมัติ</th>
                                                <th style="font-weight: bold;">สถานะ</th>
                                                <th style="font-weight: bold;" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_customer_new as $key => $value)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{Carbon\Carbon::parse($value->created_at)->format('Y-m-d')}}</td>
                                                <td></td>
                                                <td>{{ $value->saleman }}</td>
                                                <td>{{ $value->shop_name }} {{ $value->shop_id }}</td>
                                                <td>{{ $value->AMPHUR_NAME }}, {{ $value->PROVINCE_NAME }}</td>
                                                <td>
                                                    @if ($value->shop_aprove_status == 2)
                                                    <span class="btn-approve" style="font-size: 12px;">Approve</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($value->shop_status == 0)
                                                    <span>ลูกค้าใหม่</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-icon btn-edit mr-10 btn_change_status_shop" value="{{$value->shop_id}}">
                                                        <span class="btn-icon-wrap"><i data-feather="edit-3"></i></span></button>
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
    </script>

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')



