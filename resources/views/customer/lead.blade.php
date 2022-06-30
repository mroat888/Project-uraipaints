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
            <div class="topichead-bgred"><i data-feather="user"></i> ลูกค้าใหม่</div>
            <div class="content-right d-flex">
                <button type="button" class="btn btn-green" data-toggle="modal" data-target="#addCustomer"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="topic-secondgery">รายชื่อลูกค้าใหม่</div>
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
                                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
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
                                    $check_Radio_6 = "";
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
                                            case "รอตัดสินใจ" : $check_Radio_6 = "checked";
                                                break;
                                            default : $check_Radio_1 = "checked";
                                        }
                                    }else{
                                        $check_Radio_1 = "checked";
                                    }
                                @endphp

                                <div class="row">
                                    <div class="col-sm">
                                        <ul class="nav nav-pills nav-fill pa-15 mb-40" role="tablist">
                                            <li class="nav-item">
                                                <div class="form-check form-check-inline">
                                                    <label>
                                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio1" value="ทั้งหมด" {{ $check_Radio_1 }}>
                                                        <section class="customer-btn-green">
                                                                    <input type="hidden" name="count_customer_all" value="{{ $count_customer_all }}" >
                                                                    <div class="nav-link"><span class="customer-topic-numchart">ทั้งหมด </span> <span class="customer-numchart"><span class="customer-number txt-num">{{ $count_customer_all }}</span></span></div>
                                                        </section>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <div class="form-check form-check-inline">
                                                    <label>
                                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio1" value="รอดำเนินการ" {{ $check_Radio_6 }}>
                                                        <section class="customer-btn-green">
                                                                    <input type="hidden" name="count_customer_pending" value="{{ $count_customer_pending }}" >
                                                                    <div class="nav-link"><span class="customer-topic-numchart">รอดำเนินการ </span> <span class="customer-numchart"><span class="customer-number txt-num">{{ $count_customer_pending }}</span></span></div>
                                                        </section>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <div class="form-check form-check-inline">
                                                    <label>
                                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio2" value="สำเร็จ" {{ $check_Radio_2 }}>
                                                        <section class="customer-btn-green">
                                                                    <input type="hidden" name="count_customer_success" value="{{ $count_customer_success }}" >
                                                                    <div class="nav-link"><span class="customer-topic-numchart">สำเร็จ </span> <span class="customer-numchart"><span class="customer-number txt-num">{{ $count_customer_success }}</span></span></div>
                                                        </section>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <div class="form-check form-check-inline">
                                                    <label>
                                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio3" value="สนใจ" {{ $check_Radio_3 }}>
                                                        <section class="customer-btn-green">
                                                                    <input type="hidden" name="count_customer_result_1" value="{{ $count_customer_result_1 }}" >
                                                                    <div class="nav-link"><span class="customer-topic-numchart">สนใจ </span> <span class="customer-numchart"><span class="customer-number txt-num">{{ $count_customer_result_1 }}</span></span></div>
                                                        </section>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <div class="form-check form-check-inline">
                                                    <label>
                                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio4" value="ไม่สนใจ" {{ $check_Radio_4 }}>
                                                        <section class="customer-btn-green">
                                                                    <input type="hidden" name="count_customer_result_3" value="{{ $count_customer_result_3 }}" >
                                                                    <div class="nav-link"><span class="customer-topic-numchart">ไม่สนใจ </span> <span class="customer-numchart"><span class="customer-number txt-num">{{ $count_customer_result_3 }}</span></span></div>
                                                        </section>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <div class="form-check form-check-inline">
                                                    <label>
                                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio5" value="รอตัดสินใจ" {{ $check_Radio_5 }}>
                                                        <section class="customer-btn-green">
                                                                <input type="hidden" name="count_customer_result_2" value="{{ $count_customer_result_2 }}" >
                                                                <div class="nav-link"><span class="customer-topic-numchart">รอตัดสินใจ </span> <span class="customer-numchart"><span class="customer-number txt-num">{{ $count_customer_result_2 }}</span></span></div>
                                                        </section>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                </form>
                                <!-- จบเงื่อนไขการค้นหา -->
                                @php
                                    $user_level = "seller";
                                    $url_customer_detail = "customer_lead/detail";
                                @endphp

                                @include('union.lead_table')

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

<style>
    [type=radio] {
        position: absolute;
        opacity: 0;
    }

    [type=radio]+section {
        cursor: pointer;
        margin-right: 0.5rem;
    }

    /* [type=radio]:checked + section {
        outline: 5px solid orange;
    } */
</style>


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



