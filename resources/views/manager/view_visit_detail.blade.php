
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">เข้าพบลูกค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>ข้อมูลการเข้าพบลูกค้า
                </h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ตารางข้อมูลการเข้าพบลูกค้า</h5>
                        </div>
                        <div class="col-sm-12 col-md-9">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover table-sm w-100 display pb-30"
                                    data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch
                                    data-tablesaw-minimap data-tablesaw-mode-switch>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อร้าน</th>
                                            {{-- <th>ที่อยู่</th> --}}
                                            <th>วันที่</th>
                                            <th>รายการนำเสนอ</th>
                                            <th>วัตถุประสงค์</th>
                                            {{-- <th>การอนุมัติ</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>System Architect</td>
                                            {{-- <td>Edinburgh</td> --}}
                                            <td>01/11/2021</td>
                                            <td>สีรองพื้นปูนกันชื้น</td>
                                            <td>เพิ่มยอดขาย</td>
                                            {{-- <td>อนุมัติ</td> --}}
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Senior Javascript Developer</td>
                                            {{-- <td>Edinburgh</td> --}}
                                            <td>01/11/2021</td>
                                            <td>4 in 1</td>
                                            <td>นำเสนอสินค้าใหม่</td>
                                            {{-- <td>รออนุมัติ</td> --}}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </section>
            </div>

        </div>
        <!-- /Row -->
    </div>
