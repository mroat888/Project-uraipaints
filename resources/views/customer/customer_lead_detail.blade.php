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
                <a href="{{ url('lead')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
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
                                <div class="col-md-5">
                                    <div>
                                        @if($customer_shops->shop_status == "0")
                                            <span class="btn_purple badge badge-info pa-10 float-left" style="font-size: 14px;">ลูกค้าใหม่</span>
                                        @elseif($customer_shops->shop_status == "1")
                                            <span class="btn_purple badge badge-green pa-10 float-left" style="font-size: 14px;">สำเร็จ</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($customer_shops->shop_profile_image)
                                            <img src="{{ isset($customer_shops->shop_profile_image) ? asset('/public/upload/CustomerImage/' . $customer_shops->shop_profile_image) : '' }}" alt="{{ $customer_shops->shop_name }}" style="max-width:30%;">
                                        @else
                                            <img src="{{ asset('/public/images/people-33.png')}}" alt="" style="max-width:30%;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
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
                                    <p class="detail_listcus mb-40" style="font-size: 16px;"><span>เบอร์โทรศัพท์</span> :
                                        @if(!empty($customer_contacts->customer_contact_phone))
                                            {{ $customer_contacts->customer_contact_phone }}
                                        @endif
                                    </p>
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
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <div class="col-xl-12">
                <div class="row mt-2">
                    <div class="col-md-12">
                        <h5>ประวัติความคิดเห็น</h5>
                    </div>
                </div>
            </div>
        </div>
        @php 
            $even_number = 0;
        @endphp
        @foreach($customer_shops_saleplan as $key => $cust_shops_saleplan)
            @if(($even_number % 2) == 0) <!-- หารเอาเศษ เช็คเลขคู่ -->
            <div class="row">
                <div class="col-2">
                    @php
                        $user = DB::table('users')
                            ->where('id', $cust_shops_saleplan->created_by)
                            ->orderBy('id', 'desc')
                            ->first();
                    @endphp
                        {{ $user->name }}
                </div>
                <div class="col-10">

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
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="desc_cusnote">
                                            <blockquote class="blockquote mb-0">
                                                <p>	วัตถุประสงค์ : {{ $cust_shops_saleplan->customer_shop_objective }}</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </section>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-10">

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
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="desc_cusnote">
                                            <blockquote class="blockquote mb-0">
                                                <p>วัตถุประสงค์ : {{ $cust_shops_saleplan->customer_shop_objective }}</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </section>
                </div>
                <div class="col-2">
                    @php
                        $user = DB::table('users')
                            ->where('id', $cust_shops_saleplan->created_by)
                            ->orderBy('id', 'desc')
                            ->first();
                    @endphp
                        {{ $user->name }}
                </div>
            </div>
            @endif

            @php 
                $customer_shop_comments = DB::table('customer_shop_comments')
                    ->leftJoin('users', 'users.id', 'customer_shop_comments.created_by')
                    ->where('customer_shops_saleplan_id', $cust_shops_saleplan->id)
                    ->orderBy('customer_shop_comments.id', 'desc')
                    ->get();
            @endphp

            @foreach($customer_shop_comments as $comment)
                @if(($even_number % 2) == 0) <!-- หารเอาเศษ เช็คเลขคู่ -->
                <div class="row">
                    <div class="col-10">
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
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="desc_cusnote">
                                                    <blockquote class="blockquote mb-0">
                                                        <p>{{ $comment->customer_comment_detail }}</p>
                                                    </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </section>
                    </div>
                    <div class="col-2">{{ $comment->name }}</div>
                </div>
                @else
                <div class="row">
                    <div class="col-2">{{ $comment->name }}</div>
                    <div class="col-10">
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
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="desc_cusnote">
                                                    <blockquote class="blockquote mb-0">
                                                        <p>{{ $comment->customer_comment_detail }}</p>
                                                    </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </section>
                    </div>   
                </div>
                @endif

                @php 
                    $even_number++;
                @endphp
            @endforeach   

            @php 
                $customer_shops_saleplan_result = DB::table('customer_shops_saleplan_result')
                    ->leftJoin('users', 'users.id', 'customer_shops_saleplan_result.created_by')
                    ->where('customer_shops_saleplan_id', $cust_shops_saleplan->id)
                    ->orderBy('customer_shops_saleplan_result.id', 'desc')
                    ->get();
            @endphp
            @foreach($customer_shops_saleplan_result as $saleplan_result)

            <div class="row">
                    <div class="col-10">
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
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="desc_cusnote">
                                                    <blockquote class="blockquote mb-0">
                                                        <p>{{ $saleplan_result->cust_result_detail }}</p>
                                                        <p>{{ $saleplan_result->cust_result_status }}</p>
                                                        <p>{{ $cust_shops_saleplan->id }}ssd</p>
                                                    </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </section>
                    </div>
                    <div class="col-2">{{ $saleplan_result->name }}</div>
                </div>



            @php 
                    $even_number++;
                @endphp
            @endforeach  

            @php 
                $even_number++;
            @endphp
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


