@extends('layouts.masterLead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active">การอนุมัติลูกค้าใหม่ (นอกแผน)</li>
            <li class="breadcrumb-item active" aria-current="page">รายการข้อมูลการอนุมัติลูกค้าใหม่ (นอกแผน)</li>
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
                <a href="{{ url('approval-customer-except')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
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
                                        @if($customer_except->shop_status == "0")
                                            <span class="btn_purple badge badge-info pa-10 float-left" style="font-size: 14px;">ลูกค้าใหม่</span>
                                        @elseif($customer_except->shop_status == "1")
                                            <span class="btn_purple badge badge-green pa-10 float-left" style="font-size: 14px;">สำเร็จ</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($customer_except->shop_profile_image)
                                            <img src="{{ isset($customer_except->shop_profile_image) ? asset('/public/upload/CustomerImage/' . $customer_except->shop_profile_image) : '' }}" alt="{{ $customer_except->shop_name }}" style="max-width:30%;">
                                        @else
                                            <img src="{{ asset('/public/images/people-33.png')}}" alt="" style="max-width:30%;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <span style="font-size: 18px; color:#6b73bd;">รายละเอียดลูกค้า</span>
                                    <p class="detail_listcus mt-10" style="font-size: 16px;"><span>ชื่อร้าน</span> : {{$customer_except->shop_name}}</p>
                                    <p class="detail_listcus mb-40" style="font-size: 16px;"><span>ที่อยู่</span> : {{$customer_except->shop_address}}</p>

                                    <span style="font-size: 18px; color:#6b73bd;">รายชื่อผู้ติดต่อ</span>
                                    <p class="detail_listcus mt-10" style="font-size: 16px;"><span>ชื่อ</span> : {{$customer_except->customer_contact_name}}</p>
                                    <p class="detail_listcus mb-40" style="font-size: 16px;"><span>เบอร์โทรศัพท์</span> : {{$customer_except->customer_contact_phone}}</p>
                                    <span style="font-size: 18px; color:#6b73bd;">ผู้รับผิดชอบ</span>
                                    <p class="detail_listcus mt-10" style="font-size: 16px;">
                                        <span>ชื่อพนักงาน</span> : {{$customer_except->name}}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Title -->
        <div class="hk-pg-header mb-10 mt-20">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-clock"></i></span>ประวัติความคิดเห็น</h4>
            </div>
            <div class="d-flex">
            </div>
        </div>
        <!-- /Title -->
        @php
            $even_number = 0;
        @endphp
        @foreach($customer_shops_saleplan as $key => $cust_shops_saleplan)
            <!-- ส่วนของแผน Saleman ---- -->
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
                                            @if(!empty($monthly_plans->month_date))
                                                {{ thaidate('F Y', $monthly_plans->month_date) }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="desc_cusnote">
                                            <blockquote class="blockquote mb-0">
                                                @php
                                                    $master_objective = DB::table('master_customer_new')
                                                        ->where('id', $cust_shops_saleplan->customer_shop_objective)
                                                        ->first();
                                                    if(!is_null($master_objective)){
                                                        $customer_shop_objective = $master_objective->cust_name;
                                                    }else{
                                                        $customer_shop_objective = "ไม่ระบุ";
                                                    }
                                                @endphp
                                                <p>	วัตถุประสงค์ : {{ $customer_shop_objective }}</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-15">
                                        @php
                                            list($sale_date, $sale_time) = explode(' ',$cust_shops_saleplan->created_at);
                                        @endphp
                                        วันที่ : {{ thaidate('d F Y',$sale_date) }} เวลา : {{ $sale_time }}
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </section>
                </div>
                <div class="col-2" style="text-align:center;">
                    @php
                        $user = DB::table('users')
                            ->where('id', $cust_shops_saleplan->created_by)
                            ->orderBy('id', 'desc')
                            ->first();
                    @endphp
                    <img src="{{ asset('/public/images/people-33.png')}}" alt="{{ $user->name }}" style="max-width:80%;">
                    <div>{{ $user->name }}</div>
                </div>
            </div>



            <!-- จบ ส่วนของแผน Saleman ---- -->

            <!-- ส่วนของ คอมเม้นต์ ผู้จัดการเขต ผู้จัดการฝ่าย admin  ---- -->
            @php
                $customer_shop_comments = DB::table('customer_shop_comments')
                    ->leftJoin('users', 'users.id', 'customer_shop_comments.created_by')
                    ->where('customer_shops_saleplan_id', $cust_shops_saleplan->id)
                    ->orderBy('customer_shop_comments.id', 'desc')
                    ->get();
            @endphp

            @foreach($customer_shop_comments as $comment)

                <div class="row">
                    <div class="col-2" style="text-align:center;">
                        <img src="{{ asset('/public/images/people-33.png')}}" alt="{{ $comment->name }}" style="max-width:80%;">
                        <div>{{ $comment->name }}</div>
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
                                                    <p>{{ $comment->customer_comment_detail }}</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-15">
                                            @php
                                                list($sale_date, $sale_time) = explode(' ',$comment->created_at);
                                            @endphp
                                            วันที่ : {{ thaidate('d F Y',$sale_date) }} เวลา : {{ $sale_time }}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </section>
                    </div>
                </div>


                @php $even_number++; @endphp

            @endforeach
            <!-- ส่วนของ คอมเม้นต์ ผู้จัดการเขต ผู้จัดการฝ่าย admin  ---- -->

            <!-- ส่วนของสรุปแผน result  ---- -->
            @php
                $customer_shops_saleplan_result = DB::table('customer_shops_saleplan_result')
                    ->leftJoin('users', 'users.id', 'customer_shops_saleplan_result.created_by')
                    ->where('customer_shops_saleplan_result.customer_shops_saleplan_id', $cust_shops_saleplan->id)
                    ->orderBy('customer_shops_saleplan_result.id', 'asc')
                    ->first();
            @endphp
            @if(!is_null($customer_shops_saleplan_result)) <!-- is_null -->

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
                                                    <p>{{ $customer_shops_saleplan_result->cust_result_detail }}</p>
                                                    @php
                                                        switch($customer_shops_saleplan_result->cust_result_status){
                                                            case 0: $result_status = "ไม่สนใจ";
                                                                break;
                                                            case 1: $result_status = "รอตัดสินใจ";
                                                                    break;
                                                            case 2: $result_status = "สนใจ";
                                                                break;
                                                        }
                                                    @endphp
                                                    <p>สถานะ : {{ $result_status }}</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-15">
                                        @php
                                            list($sale_date, $sale_time) = explode(' ',$customer_shops_saleplan_result->updated_at);
                                        @endphp
                                        วันที่ : {{ thaidate('d F Y',$sale_date) }} เวลา : {{ $sale_time }}
                                    </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </section>
                    </div>
                    <div class="col-2" style="text-align:center;">
                        <img src="{{ asset('/public/images/people-33.png')}}" alt="{{ $customer_shops_saleplan_result->name }}" style="max-width:80%;">
                        <div>{{ $customer_shops_saleplan_result->name }}</div>
                    </div>
                </div>

            @endif <!-- is_null -->
        @endforeach


    </div>

    <!-- /Container -->

@endsection
