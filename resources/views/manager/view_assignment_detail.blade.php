
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">งานที่ได้รับมอบหมาย</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>งานที่ได้รับมอบหมาย
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
                            <h5 class="hk-sec-title">ตารางงานที่ได้รับมอบหมาย</h5>
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
                                            <th>เรื่อง</th>
                                            <th>วันที่</th>
                                            <th>ลูกค้า</th>
                                            {{-- <th>การอนุมัติ</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>แนะนำสินค้า</td>
                                            <td>11/10/2021</td>
                                            <td>บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</td>
                                            {{-- <td><span class="badge badge-success">Approval</span></td> --}}
                                            <td>
                                                <span class="badge badge-soft-danger" style="font-weight: bold; font-size: 12px;">Fail</span>
                                                <span class="badge badge-soft-info" style="font-weight: bold; font-size: 12px;">Finished</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>แนะนำสินค้า Home Paint Outlet</td>
                                            <td>20/10/2021</td>
                                            <td>Home Paint Outlet</td>
                                            {{-- <td><span class="badge badge-success">Approval</span></td> --}}
                                            <td>
                                                <span class="badge badge-soft-success" style="font-weight: bold; font-size: 12px;">Finished</span>
                                                <span class="badge badge-soft-info" style="font-weight: bold; font-size: 12px;">Finished</span>
                                            </td>
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
