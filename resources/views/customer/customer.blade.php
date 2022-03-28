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
            {{-- <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button> --}}
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
                                    <div class="col-sm-12 col-md-9">
                                        <!-- ------ -->
                                        <!-- <span class="form-inline pull-right pull-sm-center">
                                            <select class="form-control custom-select form-control-sm" style="margin-left:5px; margin-right:5px;">
                                                <option selected>เลือกจังหวัด</option>
                                                <option value="1">กรุงเทพมหานคร</option>
                                                <option value="2">เชียงใหม่</option>
                                                <option value="3">สงขลา</option>
                                                <option value="3">ชัยภูมิ</option>
                                                <option value="3">ปราจีนบุรี</option>
                                            </select>

                                            <select class="form-control custom-select form-control-sm" style="margin-left:5px; margin-right:5px;">
                                                <option selected>เลือกอำเภอ</option>
                                            </select>

                                            <select class="form-control custom-select form-control-sm" style="margin-left:5px; margin-right:5px;">
                                                <option selected>เลือกตำบล</option>
                                            </select>

                                            <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm">ค้นหา</button>

                                        </span> -->
                                        <!-- ------ -->
                                    </div>
                                </div>
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
                                        @foreach ($customer_shop as $key => $shop)
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
                                                @php 
                                                    $customer_shops_saleplan = DB::table('customer_shops_saleplan')
                                                        ->where('customer_shop_id', $shop->id)
                                                        ->where('is_monthly_plan', 'N')
                                                        ->get();
                                                @endphp

                                                @if($customer_shops_saleplan->isNotEmpty())
                                                     <span class="badge badge-soft-danger" style="font-size: 12px;">นอกแผน</span>
                                                @else
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">ในแผน</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                    <!-- <button class="btn btn-icon btn-warning mr-10" onclick="edit_modal({{ $shop->id }})" data-toggle="modal" data-target="#editCustomer">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-create"></i></h4></button> -->
                                                    <button class="btn btn-icon btn-warning mr-10 btn_editshop" value="{{ $shop->id }}">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-create"></i></h4></button>
                                                    <!-- <button class="btn btn-icon btn-info mr-10">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-calendar"></i></h4></button> -->
                                                    <a href="{{ url('/customer/detail', $shop->id) }}" class="btn btn-icon btn-success mr-10">
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

     <!-- Modal Edit -->
     <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomer" aria-hidden="true">
        @include('customer.lead_edit')
    </div>

    <script>
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
</script>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection



