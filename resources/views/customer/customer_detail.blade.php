@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">ข้อมูลลูกค้า</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดลูกค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-people"></i></span>รายละเอียดลูกค้า</h4>
            </div>
            <div class="d-flex">
                <a href="{{ url('customer')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">

                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    @if ($customer_shops->shop_profile_image)
                                    <img src="{{ isset($customer_shops->shop_profile_image) ? asset('/public/upload/CustomerImage/' . $customer_shops->shop_profile_image) : '' }}"
                                    alt="{{ $customer_shops->shop_name }}" style="max-width:30%;">

                                    @else
                                    <img src="{{ asset('/public/images/people-33.png')}}" alt="" style="max-width:30%;">
                                    @endif

                                </div>
                                <div class="col-md-6">
                                @if($customer_shops->shop_status == "0")
                                    <span id="shop_status_name_lead" class="btn_purple badge badge-info pa-10 float-right" style="font-size: 14px;">ลูกค้าใหม่</span>
                                @elseif($customer_shops->shop_status == "1")
                                    <span id="shop_status_name_cus" class="btn_purple badge badge-green pa-10 float-right" style="font-size: 14px;">ทะเบียนลูกค้า</span>
                                @elseif($customer_shops->shop_status == "2")
                                    <span id="shop_status_name_cus" class="btn_purple badge badge-danger pa-10 float-right" style="font-size: 14px;">ลูกค้าที่ถูกลบ</span>
                                @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <span style="font-size: 18px; color:#6b73bd;">รายละเอียดลูกค้า</span>
                                    <!-- <span class="btn_purple badge badge-violet pa-10 float-right" style="font-size: 14px;">ลูกค้าเป้าหมาย</span> -->
                                    <p class="detail_listcus mt-10" style="font-size: 16px;"><span>ชื่อร้าน</span> : {{ $customer_shops->shop_name }}</p>
                                    <p class="detail_listcus mb-40" style="font-size: 16px;"><span>ที่อยู่</span> : {{ $customer_shops->shop_address }}</p>

                                    <span style="font-size: 18px; color:#6b73bd;">รายชื่อผู้ติดต่อ</span>
                                    <p class="detail_listcus mt-10" style="font-size: 16px;"><span>ชื่อ</span> :
                                        @if(isset($customer_contacts->customer_contact_name))
                                            {{  $customer_contacts->customer_contact_name }}
                                        @endif
                                    </p>
                                    <p class="detail_listcus" style="font-size: 16px;"><span>เบอร์โทรศัพท์</span> :
                                        @if(!empty($customer_contacts->customer_contact_phone))
                                            {{ $customer_contacts->customer_contact_phone }}
                                        @endif
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <span style="font-size: 18px; color:#6b73bd;">ผู้รับผิดชอบ</span>
                                    <p class="detail_listcus mt-10" style="font-size: 16px;">
                                        <span>ชื่อพนักงาน</span> :
                                        @php
                                            $user = DB::table('users')
                                                ->where('id', $customer_shops->created_by)
                                                ->orderBy('id', 'desc')
                                                ->first();
                                        @endphp
                                            {{ $user->name }}
                                    </p>
                                    <hr>

                                    <span style="font-size: 18px; color:#6b73bd;">สถานะลูกค้า <span style="font-size: 14px; color:black;"> เปลี่ยนสถานะลูกค้าเป็นลูกค้าใหม่ หรือลบออก</span></span>
                                    <p class="mt-10">

                                    @php
                                        if($customer_shops->shop_status == "1"){
                                            $is_disabled = "disabled";
                                        }else{
                                            $is_disabled = "";
                                        }
                                    @endphp

                                        <button type="button" id="btn_update" class="btn btn_default btn_green btn-teal btn-sm btn-rounded" value="{{ $customer_shops->id }}" style="font-size: 14px;" {{ $is_disabled }}>อัพเดตเป็นลูกค้าใหม่</button>
                                        <!-- <button type="button" id="btn_delete" class="btn btn_default btn-danger btn-sm btn-rounded" value="{{ $customer_shops->id }}" style="font-size: 14px;">ลบออก</button> -->
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="row mt-2">
                    <div class="col-md-12 mb-10">
                        <h5>ประวัติการติดต่อ</h5>
                    </div>
                </div>
            </div>
        </div>

            @foreach($customer_shops_saleplan as $cust_shops_saleplan)
            <div class="row">
                <div class="col-xl-12">

                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4 col-lg-4">
                                        <p class="detail_listcus">
                                            <i class="ion ion-md-calendar"></i>
                                            <span> เดือน</span> :
                                            @php
                                                $monthly_plans = DB::table('monthly_plans')
                                                ->where('id', $cust_shops_saleplan->monthly_plan_id)
                                                ->first();
                                            @endphp
                                            {{ thaidate('F Y', $monthly_plans->month_date) }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <p class="detail_listcus"><i class="ion ion-md-person"></i>
                                            <span> พนักงาน</span> :
                                            @php
                                                $user = DB::table('users')
                                                    ->where('id', $cust_shops_saleplan->created_by)
                                                    ->orderBy('id', 'desc')
                                                    ->first();
                                            @endphp
                                                {{ $user->name }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <p class="detail_listcus"><i class="ion ion-md-person"></i>
                                            <span> สถานะลูกค้า</span> :
                                            @if($cust_shops_saleplan->is_monthly_plan == "N")
                                                <span class="badge badge-soft-danger" style="font-size: 12px;">นอกแผน</span>
                                            @else
                                                <span class="badge badge-soft-success" style="font-size: 12px;">ในแผน</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="desc_cusnote">
                                            @php
                                                $cust_result = DB::table('customer_shops_saleplan_result')
                                                ->where('customer_shops_saleplan_id', $cust_shops_saleplan->id)
                                                ->first();
                                            @endphp

                                            @if($cust_result != "")
                                                <blockquote class="blockquote mb-0">
                                                    <p>{{ $cust_result->cust_result_detail }}</p>
                                                </blockquote>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </section>
                </div>
            </div>
            @endforeach


    </div>

    <!-- /Container -->
    </div>


    <!-- Modal Update Lead To Customer Approve -->
    <div class="modal fade" id="Modalapprove" tabindex="-1" role="dialog" aria-labelledby="Modalapprove" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_cus_update" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เปลี่ยนสถานะลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <h3>ยืนยันสถานะลูกค้าใหม่ ใช่หรือไม่ ?</h3>
                    <input class="form-control" id="shop_id" name="shop_id" type="hidden"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_edit">บันทึก</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete Customer Approve -->
    <div class="modal fade" id="ModalapproveDelete" tabindex="-1" role="dialog" aria-labelledby="Modalapprove" aria-hidden="true">
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
                    <input class="form-control" id="shop_id_delete" name="shop_id_delete" type="hidden"/>
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

    $(document).on('click', '#btn_update', function(){
        let shop_id = $(this).val();
        $('#shop_id').val(shop_id);
        $('#Modalapprove').modal('show');
    });

    $(document).on('click', '#btn_delete', function(){
        let shop_id_delete = $(this).val();
        $('#shop_id_delete').val(shop_id_delete);
        $('#ModalapproveDelete').modal('show');
    });

    $("#from_cus_update").on("submit", function (e) {
        e.preventDefault();
        //var formData = $(this).serialize();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/leadtocustomer") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
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
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

    $("#from_cus_delete").on("submit", function (e) {
        e.preventDefault();
        //var formData = $(this).serialize();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/customerdelete") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: "ลบข้อมูลลูกค้าเรียบร้อยแล้วค่ะ",
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#ModalapproveDelete').modal('hide');
                $('#shop_status_name_lead').text('ลบข้อมูลลูกค้าเรียบร้อย')
                $('#btn_update').prop('disabled', true);
                $('#btn_delete').prop('disabled', true);

                //location.reload();
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


