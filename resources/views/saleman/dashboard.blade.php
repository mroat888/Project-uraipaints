@extends('layouts.master')

@section('content')

 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">หน้าแรก</li>
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
                    <h6 class="hk-sec-title mb-30" style="font-weight: bold;">แผนทำงานประจำเดือน มกราคม/2565</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <section class="hk-sec-wrapper bg-light">
                                <div class="row">
                                    <div class="col-sm">
                                        <div id="e_chart_1" style="height:140px;"></div>
                                    </div>
                                    <div class="col-sm mt-30" style="color: black;">
                                            <p class="mb-10">แผนทำงาน 15</p>
                                            <p class="mb-10">ทำแล้ว 10</p>
                                            <p class="mb-10">รอดำเนินการ 5</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="hk-sec-wrapper bg-light">
                                <div class="row">
                                    <div class="col-sm">
                                        <div id="e_chart_5" style="height:140px;"></div>
                                    </div>
                                    <div class="col-sm mt-30" style="color: black;">
                                            <p class="mb-10">ลูกค้าใหม่ 15</p>
                                            <p class="mb-10">ผ่านแล้ว 10</p>
                                            <p class="mb-10">ไม่ผ่าน 5</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="hk-sec-wrapper bg-light">
                                <div class="row">
                                    <div class="col-sm">
                                        <div id="e_chart_3" style="height:140px;"></div>
                                    </div>
                                    <div class="col-sm mt-30" style="color: black;">
                                            <p class="mb-10">เยี่ยมลูกค้า 15</p>
                                            <p class="mb-10">ทำแล้ว 10</p>
                                            <p class="mb-10">รอดำเนินการ 5</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-8">
                <section class="hk-sec-wrapper">
                    {{-- <h6 class="hk-sec-title mb-10" style="font-weight: bold;">สรุปยอดขาย</h6> --}}
                    <div class="row mt-30">
                        <div class="col-md-6">
                            <div class="card card-sm text-white bg-danger">
                                <div class="card-body">
                                    <span class="d-block font-16 font-weight-500 text-uppercase mb-10">
                                        <button class="btn btn-icon btn-icon-circle btn-light btn-lg mr-25"><span class="btn-icon-wrap"><i
                                            data-feather="edit-2"></i></span></button>
                                        <span class="float-right">ขออนุมัติ {{$list_approval->count()}}</span>
                                    </span>
                                    {{-- <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>คำขออนุมัติ 5</span>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="d-flex align-items-end justify-content-between mt-10 font-16">
                                        <div>
                                            <span class="d-block">
                                                <span>อนุมัติ</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ด่วน</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between font-16">
                                        <div>
                                            <span class="d-block">
                                                <?php $approve = 0; ?>
                                                <span>
                                                    @foreach ($list_approval as $value)
                                                        @if ($value->assign_status == 1)
                                                            <?php $approve += 1 ?>

                                                        @endif
                                                    @endforeach
                                                    {{$approve}} </span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>2</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-sm text-white bg-success">
                                <div class="card-body">
                                    <span class="d-block font-16 font-weight-500 text-uppercase mb-10">
                                            <button class="btn btn-icon btn-icon-circle btn-light btn-lg mr-25"><span class="btn-icon-wrap"><i
                                                data-feather="clipboard"></i></span></button>
                                        <span class="float-right">คำสั่งงาน {{ $assignments->count() }}</span>
                                    </span>
                                    {{-- <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>คำสั่งงาน 8</span>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="d-flex align-items-end justify-content-between mt-10 font-16">
                                        <div>
                                            <span class="d-block">
                                                <span>ทำแล้ว</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>รอดำเนินการ</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between font-16">
                                        <div>
                                            <span class="d-block">
                                                <?php $success = 0; ?>
                                                <span>
                                                    @foreach ($assignments as $value)
                                                        @if ($value->assign_result_status != 0)
                                                            <?php $success += 1 ?>

                                                        @endif
                                                    @endforeach
                                                    {{$success}} </span>
                                            </span>
                                        </div>
                                        <div>
                                            <?php $unfinished = 0; ?>
                                            <span>
                                                @foreach ($assignments as $value)
                                                    @if ($value->assign_result_status == 0)
                                                        <?php $unfinished += 1 ?>

                                                    @endif
                                                @endforeach
                                                {{$unfinished}} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-sm text-white bg-warning">
                                <div class="card-body">
                                    <span class="d-block font-16 font-weight-500 text-uppercase mb-10">
                                        <button class="btn btn-icon btn-icon-circle btn-light btn-lg mr-25"><span class="btn-icon-wrap"><i
                                            data-feather="file"></i></span></button>
                                        <span class="float-right">บันทึกโน๊ต {{ $notes->count() }}</span></span>
                                        {{-- <div>
                                            <span class="d-block">
                                                <span>บันทึกโน๊ต 3</span>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>เลิกใช้</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ปักหมุด</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between font-16">
                                        <div>
                                            <span class="d-block">
                                                <?php $disuse = 0; ?>
                                            <span>
                                                @foreach ($notes as $value)
                                                    @if ($value->status_pin == "")
                                                        <?php $disuse += 1 ?>

                                                    @endif
                                                @endforeach
                                                {{$disuse}} </span>
                                            </span>
                                        </div>
                                        <div>
                                            <?php $pin = 0; ?>
                                            <span>
                                                @foreach ($notes as $value)
                                                    @if ($value->status_pin == 1)
                                                        <?php $pin += 1 ?>

                                                    @endif
                                                @endforeach
                                                {{$pin}} </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-sm text-white bg-info">
                                <div class="card-body">
                                    <span class="d-block font-16 font-weight-500 text-uppercase mb-10">
                                        <button class="btn btn-icon btn-icon-circle btn-light btn-lg mr-25"><span class="btn-icon-wrap"><i
                                            data-feather="users"></i></span></button>
                                        <span class="float-right">ลูกค้าใหม่ {{ $customer_shop->count() }}</span></span>
                                    {{-- <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>ลูกค้าใหม่ 6</span>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>ไม่ผ่าน</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>ตัดสินใจ</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between font-16">
                                        <div>
                                            <span class="d-block">
                                                <?php $fail = 0; ?>
                                            <span>
                                                @foreach ($customer_shop as $value)
                                                    @if ($value->shop_result_status == 0)
                                                        <?php $fail += 1 ?>

                                                    @endif
                                                @endforeach
                                                {{$fail}} </span>
                                            </span>
                                        </div>
                                        <div>
                                            <?php $wait = 0; ?>
                                            <span>
                                                @foreach ($customer_shop as $value)
                                                    @if ($value->shop_result_status == 2)
                                                        <?php $wait += 1 ?>

                                                    @endif
                                                @endforeach
                                                {{$wait}} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-4">
                <section class="hk-sec-wrapper">
                    <div class="row mt-30">
                        <div class="col-md-12">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"></span>
                                    <div class="mt-15">
                                            <span class="d-block">
                                                <div class="media-img-wrap text-center">
                                                    <div class="avatar avatar-sm">
                                                        <img src="" alt="user"
                                                        class="avatar-text avatar-text-inv-success rounded-circle">
                                                    </div>
                                                    <div class="avatar avatar-sm">
                                                        <img src="" alt="user"
                                                        class="avatar-text avatar-text-inv-pink rounded-circle">
                                                    </div>
                                                    <div class="avatar avatar-sm">
                                                        <img src="" alt="user"
                                                        class="avatar-text avatar-text-inv-info rounded-circle">
                                                    </div>
                                                    <div class="avatar avatar-sm">
                                                        <img src="" alt="user"
                                                        class="avatar-text avatar-text-inv-warning rounded-circle">
                                                    </div>
                                                </div>
                                            </span>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-5">
                                        <div>
                                            <span class="d-block">
                                                <span>ลูกค้าทั้งหมด</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>มีวันสำคัญในเดือน</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span>300</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>4 ร้าน <span class="ml-40">4 วัน</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                </div>
        </div>

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <h6 class="hk-sec-title mb-10" style="font-weight: bold;">สรุปยอดขาย</h6>
                    <div class="row">
                        <div class="col-md-8">
                            <div id="m_chart_4" style="height: 294px"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase mb-10"></span>
                                            <span class="d-block text-center">
                                                <span id="pie_chart_2" class="easy-pie-chart" data-percent="86">
                                                    <span class="percent head-font mt-25">86</span>
                                            </span>
                                            </span>
                                    <div class="d-flex align-items-end justify-content-between mt-10">
                                        <div>
                                            <span class="d-block">
                                                <span>เป้ายอดขาย</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span>เดือนนี้</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <span style="color: red;">99,999,999</span>
                                            </span>
                                        </div>
                                        <div>
                                            <span style="color: rgb(4, 18, 58);">99,999,999</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card card-sm">
                                <div class="card-body" style="color: black;">
                                    <span class="d-block font-11 font-weight-500 text-dark text-uppercase"></span>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div>
                                            <span class="d-block">
                                                <button class="btn btn-icon btn-info">
                                                    <span class="btn-icon-wrap"><i data-feather="home"></i>
                                                    </span>
                                                </button>
                                                {{-- <span><i data-feather="home" style="width:50px;"></i></span> --}}
                                            </span>
                                        </div>
                                        <div class="mb-5">
                                            <span style="font-weight: bold; font-size: 18px;">ร้านค้า</span>
                                        </div>
                                        <div class="mb-5">
                                            <span style="font-weight: bold; font-size: 18px;">3,000</span>
                                        </div>
                                    </div>
                                </div>
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

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
