@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">หน้าแรก</a></li>
            <li class="breadcrumb-item active" aria-current="page">ลูกค้าใหม่</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-person"></i></span>ลูกค้าใหม่</h4>
            </div>
            <div class="d-flex">
                <button class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal" data-target="#addCustomer"> + เพิ่มใหม่ </button>
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
                                    $action_search = "/lead/search";
                                    if(isset($date_filter)){
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
                                            <td>{{$key + 1}}</td>
                                            <td>
                                                <div class="media-img-wrap">
                                                    <div class="avatar avatar-sm">
                                                        @if ($shop->shop_profile_image)
                                                        <img src="{{ isset($shop->shop_profile_image) ? asset('/public/upload/CustomerImage/' . $shop->shop_profile_image) : '' }}"
                                                        alt="{{ $shop->shop_name }}" class="avatar-img">

                                                        @else
                                                        <img src="{{ asset('/public/images/people-33.png')}}" alt="" class="avatar-img">
                                                        @endif

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $shop->shop_name }}</td>
                                            <td>{{ $shop->PROVINCE_NAME }}</td>
                                                @php
                                                    $customer_contact_name = "";
                                                    $customer_contact_phone = "";
                                                    foreach($customer_contacts as $value){
                                                        if($value->customer_shop_id == $shop->id){
                                                            if(!empty($value->customer_contact_name)){
                                                                $customer_contact_name = $value->customer_contact_name;
                                                            }
                                                            if(!empty($value->customer_contact_phone)){
                                                                $customer_contact_phone = $value->customer_contact_phone;
                                                            }
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                            <td>{{ $customer_contact_name }}</td>
                                            <td>{{ $customer_contact_phone }}</td>
                                            <td>
                                                @if($shop->shop_status == 1)
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">สำเร็จ</span>
                                                @elseif($shop->saleplan_shop_aprove_status == 3)
                                                    <span class="badge badge-soft-purple" style="font-size: 12px;">ไม่ผ่านอนุมัติ</span>
                                                @else
                                                    @if(!is_null($shop->cust_result_status))
                                                        @if($shop->cust_result_status == 2) <!-- สนใจ	 -->
                                                            <span class="badge badge-soft-orange" style="font-size: 12px;">สนใจ</span>
                                                        @elseif($shop->cust_result_status == 1) <!-- รอตัดสินใจ -->
                                                            <span class="badge badge-soft-primary" style="font-size: 12px;">รอตัดสินใจ</span>
                                                        @elseif($shop->cust_result_status == 0) <!-- ไม่สนใจ  -->
                                                            <span class="badge badge-soft-danger" style="font-size: 12px;">ไม่สนใจ</span>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                @if($shop->shop_status != 1)
                                                    <button class="btn btn-icon btn-warning mr-10 btn_editshop" value="{{ $shop->id }}">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-create"></i></h4></button>
                                                @endif
                                                    <a href="{{ url('/customer_lead/detail', $shop->id) }}" class="btn btn-icon btn-success mr-10">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
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

    <!-- Modal -->
    <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomer" aria-hidden="true">
        @include('customer.lead_insert')
    </div>
     <!-- Modal -->
     <!-- Modal Edit -->
    <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomer" aria-hidden="true">
        @include('customer.lead_edit')
    </div>


<script>
    $(document).ready(function() {

        $('#is_monthly_plan').val('N'); // กำหนดสถานะ Y = อยู่ในแผน , N = ไม่อยู่ในแผน (เพิ่มระหว่างเดือน)

        $("#customer_shops").on("change", function (e) {
            e.preventDefault();
            let shop_id = $(this).val();
            if(shop_id != ""){
                $('#customer_shops_id').val(shop_id);
                $('#shop_name').attr('readonly', true);
                $('#contact_name').attr('readonly', true);
                $('#shop_phone').attr('readonly', true);
                $('#shop_address').attr('readonly', true);
                $('#province').attr('disabled', 'disabled');
                $('#amphur').attr('disabled', 'disabled');
                $('#district').attr('disabled', 'disabled');
                $('#postcode').attr('readonly', true);
            }else{
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
                url: '{{ url("/edit_customerLead") }}/'+shop_id,
                datatype: 'json',
                success: function(response){
                    console.log(response);
                    if(response.status == 200){
                        $("#customer_shops_id").val(shop_id);
                        $("#shop_name").val(response.dataEdit.shop_name);
                        if(response.customer_contacts != null){
                            $("#contact_name").val(response.customer_contacts.customer_contact_name);
                            $("#shop_phone").val(response.customer_contacts.customer_contact_phone);
                        }
                        $("#shop_address").val(response.dataEdit.shop_address);

                        $.each(response.shop_province, function(key, value){
                            if(value.PROVINCE_ID == response.dataEdit.shop_province_id){
                                $('#province').append('<option value='+value.PROVINCE_ID+' selected>'+value.PROVINCE_NAME+'</option>')	;
                            }else{
                                $('#province').append('<option value='+value.PROVINCE_ID+'>'+value.PROVINCE_NAME+'</option>')	;
                            }
                        });

                        $.each(response.shop_amphur, function(key, value){
                            if(value.AMPHUR_ID == response.dataEdit.shop_amphur_id){
                                $('#amphur').append('<option value='+value.AMPHUR_ID+' selected>'+value.AMPHUR_NAME+'</option>')	;
                            }else{
                                $('#amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                            }
                        });

                        $.each(response.shop_district, function(key, value){
                            if(value.DISTRICT_ID == response.dataEdit.shop_district_id){
                                $('#district').append('<option value='+value.DISTRICT_ID+' selected>'+value.DISTRICT_NAME+'</option>')	;
                            }else{
                                $('#district').append('<option value='+value.DISTRICT_ID+'>'+value.DISTRICT_NAME+'</option>')	;
                            }
                        });

                        $("#postcode").val(response.dataEdit.shop_zipcode);
                    }
                }
            });

        });
    });

    $(document).on('click','.btn_editshop', function(e){
        e.preventDefault();
		let shop_id = $(this).val();

        $.ajax({
            method: 'GET',
            url: '{{ url("/edit_customerLead") }}/'+shop_id,
            datatype: 'json',
            success: function(response){
                //console.log(response);
                if(response.status == 200){
                    $("#editCustomer").modal('show');
                    $("#edit_shop_id").val(shop_id);
                    $("#edit_shop_name").val(response.dataEdit.shop_name);
                    if(response.customer_contacts != null){
                        $("#edit_cus_contacts_id").val(response.customer_contacts.id);
                        $("#edit_contact_name").val(response.customer_contacts.customer_contact_name);
                        $("#edit_customer_contact_phone").val(response.customer_contacts.customer_contact_phone);
                    }
                    $("#edit_shop_address").val(response.dataEdit.shop_address);

                    $.each(response.shop_province, function(key, value){
                        if(value.PROVINCE_ID == response.dataEdit.shop_province_id){
                            $('#edit_province').append('<option value='+value.PROVINCE_ID+' selected>'+value.PROVINCE_NAME+'</option>')	;
                        }else{
                            $('#edit_province').append('<option value='+value.PROVINCE_ID+'>'+value.PROVINCE_NAME+'</option>')	;
                        }
                    });

                    $.each(response.shop_amphur, function(key, value){
                        if(value.AMPHUR_ID == response.dataEdit.shop_amphur_id){
                            $('#edit_amphur').append('<option value='+value.AMPHUR_ID+' selected>'+value.AMPHUR_NAME+'</option>')	;
                        }else{
                            $('#edit_amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                        }
                    });

                    $.each(response.shop_district, function(key, value){
                        if(value.DISTRICT_ID == response.dataEdit.shop_district_id){
                            $('#edit_district').append('<option value='+value.DISTRICT_ID+' selected>'+value.DISTRICT_NAME+'</option>')	;
                        }else{
                            $('#edit_district').append('<option value='+value.DISTRICT_ID+'>'+value.DISTRICT_NAME+'</option>')	;
                        }
                    });

                    $("#edit_shop_zipcode").val(response.dataEdit.shop_zipcode);


                }
            }
        });

    })

    $(document).on('change','.province', function(e){
        e.preventDefault();
		let pvid = $(this).val();
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_amphur") }}/'+pvid,
            datatype: 'json',
            success: function(response){
                //alert(response.AMPHUR_NAME);
                if(response.status == 200){
                    //console.log(response)
                    $('.amphur').children().remove().end();
                    $('.district').children().remove().end();
                    $('.amphur').append('<option selected value="0">--โปรดเลือก--</option>');
                    $('.district').append('<option selected value="0">--โปรดเลือก--</option>');
                    $('.postcode').val('');
                    $.each(response.amphurs, function(key, value){
                        $('.amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                    });
                }
            }
        });
    });

    $(document).on('change','.amphur', function(e){
        e.preventDefault();
		let amid = $(this).val();
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_district") }}/'+amid,
            datatype: 'json',
            success: function(response){
                //alert(response.AMPHUR_NAME);
                if(response.status == 200){
                    //console.log(response)
                    $('.district').children().remove().end();
                    $('.district').append('<option selected value="0">--โปรดเลือก--</option>');
                    $('.postcode').val('');
                    $.each(response.districts, function(key, value){
                        $('.district').append('<option value='+value.DISTRICT_ID+'>'+value.DISTRICT_NAME+'</option>')	;
                    });
                }
            }
        });
    });

    $(document).on('change','.district', function(e){
        e.preventDefault();
		let disid = $(this).val();
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_postcode") }}/'+disid,
            datatype: 'json',
            success: function(response){
                if(response.status == 200){
                    //console.log(response)
                    let postcode = response.postcode.POSTCODE;
                    $('.postcode').val(postcode);
                }
            }
        });
    });

    $(document).on('click', '.checkRadio', function(){
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



