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
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-pie"></i></span>รายละเอียดลูกค้า</h4>
            </div>
            <div class="d-flex">

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
                                {{-- <div class="row"> --}}
                                    <div class="col-md-2 mb-20">
                                    <img src="{{ asset('/public/template/dist/img/avatar1.jpg') }}" alt="">
                                    </div>
                                {{-- </div> --}}
                                <div class="col-md-10 pl-50">
                                    <span style="font-size: 18px; color:steelblue;">รายละเอียดลูกค้า</span>
                                    <span class="badge badge-violet pa-10 float-right" style="font-size: 14px;">ลูกค้าเป้าหมาย</span>
                                    <p class="mt-10" style="font-size: 16px;"><span style="font-weight:bold;">ชื่อร้าน</span> : บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</p>
                                    <p class="mb-40" style="font-size: 16px;"><span>ที่อยู่</span> : 825/1-2 ตรงข้าม, ถนนdพรานนก แขวงบ้านช่างหล่อ เขตบางกอกน้อย กรุงเทพ 10700</p>

                                    <span style="font-size: 18px; color:steelblue;">รายชื่อผู้ติดต่อ</span>
                                    <p class="mt-10" style="font-size: 16px;"><span style="font-weight:bold;">ชื่อ</span> : สมชาย นามดี</p>
                                    <p style="font-size: 16px;"><span style="font-weight:bold;">เบอร์โทรศัพท์</span> : 085-6325366</p>
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
                                    <span style="font-size: 18px; color:steelblue;">ผู้รับผิดชอบ</span>
                                    <p class="mt-10" style="font-size: 16px;"><span style="font-weight:bold;">ชื่อพนักงาน</span> : เดชพงษ์</p>
                                    <hr>

                                    <span style="font-size: 18px; color:steelblue;">สถานะลูกค้า <span style="font-size: 16px; color:black;"> เปลี่ยนสถานะลูกค้าเป็นลูกค้าใหม่ หรือลบออก</span></span>
                                    <p class="mt-10">
                                        <button type="button" class="btn btn-teal btn-sm btn-rounded" style="font-size: 16px;">อัพเดตเป็นลูกค้าใหม่</button>
                                    <button type="button" class="btn btn-danger btn-sm btn-rounded" style="font-size: 16px;">ลบออก</button>
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
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <p><i class="ion ion-md-calendar"></i><span style="font-weight:bold;"> วันที่</span> : 2021-11-05</p>
                                </div>
                                <div class="col-md-3">
                                    <p><i class="ion ion-md-person"></i><span style="font-weight:bold;"> พนักงาน</span> : เดชพงศ์</p>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <p>
                                        Lorem ipsum dolor sit libero dignissimos aliquid non corrupti adipisci qui quis, expedita deserunt vero neque alias accusamus tempore dolorem iure molestias voluptatum cumque quibusdam. Deserunt labore repellat molestias tempore doloribus exercitationem aperiam quaerat, explicabo rem rerum provident delectus optio voluptate excepturi cumque commodi qui asperiores eligendi suscipit cum aliquid? Magnam, provident maiores alias quasi vero dolorem rerum quo unde dignissimos doloremque labore adipisci consectetur incidunt mollitia voluptatum aut laborum quaerat itaque porro? Illo, tempore. Beatae fuga cumque laboriosam maiores voluptatum corrupti, repellendus repudiandae ipsum assumenda nisi. Iusto, distinctio officia autem blanditiis laudantium odit natus similique saepe voluptas, sequi facere aut recusandae repellendus doloremque temporibus aperiam eveniet obcaecati debitis fuga hic cupiditate, provident quidem? Iure voluptatem repudiandae saepe id perspiciatis animi reprehenderit, libero error.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
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
                                <div class="col-md-2">
                                    <p><i class="ion ion-md-calendar"></i> วันที่ : 2021-11-05</p>
                                </div>
                                <div class="col-md-3">
                                    <p><i class="ion ion-md-person"></i> พนักงาน : เดชพงศ์</p>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <p>
                                        Lorem ipsum dolor sit libero dignissimos aliquid non corrupti adipisci qui quis, expedita deserunt vero neque alias accusamus tempore dolorem iure molestias voluptatum cumque quibusdam. Deserunt labore repellat molestias tempore doloribus exercitationem aperiam quaerat, explicabo rem rerum provident delectus optio voluptate excepturi cumque commodi qui asperiores eligendi suscipit cum aliquid? Magnam, provident maiores alias quasi vero dolorem rerum quo unde dignissimos doloremque labore adipisci consectetur incidunt mollitia voluptatum aut laborum quaerat itaque porro? Illo, tempore. Beatae fuga cumque laboriosam maiores voluptatum corrupti, repellendus repudiandae ipsum assumenda nisi. Iusto, distinctio officia autem blanditiis laudantium odit natus similique saepe voluptas, sequi facere aut recusandae repellendus doloremque temporibus aperiam eveniet obcaecati debitis fuga hic cupiditate, provident quidem? Iure voluptatem repudiandae saepe id perspiciatis animi reprehenderit, libero error.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- /Container -->
    </div>


 <!-- Modal Check Approve -->
 <div class="modal fade" id="Modalapprove" tabindex="-1" role="dialog" aria-labelledby="Modalapprove" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เปลี่ยนสถานะลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <h3>ยืนยันสถานะลูกค้าใหม่ ใช่หรือไม่ ?</h3>
                    <form action="#">
                        <input class="form-control" id="saleplan_id" type="hidden"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

 <script>
    // document.getElementById('btn_update_status').onclick = function() {
    //     $('#Modalapprove').modal('show');
    // }
    $(document).on('click', '.btn_update_status', function(){
        $('#Modalapprove').modal('show');
    })
 </script>


@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')


