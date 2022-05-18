<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active">รายงานยอดลูกทีมที่รับผิดชอบ</li>
        <li class="breadcrumb-item active" aria-current="page">รายละเอียดผู้จัดการเขต</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container-fluid px-xxl-65 px-xl-20">
    <!-- Title -->
    <div class="hk-pg-header mb-10">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-people"></i></span>ข้อมูล ผจก เขต</h4>
        </div>
        <div class="d-flex">
            <a href="javascript:history.back();" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">

            <section class="hk-sec-wrapper">
                <div class="row">
                    @if(isset($res_api) && $res_api['code'] == 200)
                    <div class="col-md-12">
                        @foreach($res_api['data'] as $key => $value)
                        <div class="row">
                            <div class="col-md-4">
                                <div>
                                    <img src="{{ asset('/public/images/people-33.png')}}" alt="" style="max-width:50%;">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <span style="font-size: 18px; color:#6b73bd;">รายละเอียดส่วนตัว</span>
                                <p class="detail_listcus mt-10" style="font-size: 16px;"><span>ชื่อ</span> : {{ $value['employee_name'] }}</p>
                                <p class="detail_listcus mb-40" style="font-size: 16px;"><span>เบอร์ติดต่อ</span> : {{ $value['mobile_no'] }}</p>

                                <span style="font-size: 18px; color:#6b73bd;">เขตพื้นที่ขาย</span>
                                <p class="detail_listcus mt-10" style="font-size: 16px;">{{ $value['description'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>

<!-- /Container -->