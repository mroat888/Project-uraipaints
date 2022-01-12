@extends('layouts.masterLead')

@section('content')



<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sale Plan</li>
    </ol>
</nav>
    <!-- /Breadcrumb -->

<!-- Container -->
<div class="container-fluid px-xxl-65 px-xl-20">
    <!-- Title -->
    <div class="hk-pg-header mb-10">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>Sale Plan</h4>
        </div>
        <div class="d-flex">
            {{-- <button type="button" class="btn btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button> --}}
            <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" id="btn_approve">อนุมัติ</button>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-3">
                        <h5 class="hk-sec-title">ตาราง Sale Plan</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <div class="table-responsive-sm">
                            <table id="myTable" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox checkbox-success">
                                                <input type="checkbox" class="custom-control-input" id="customCheck4" onclick="chkAll(this);">
                                                <label class="custom-control-label" for="customCheck4">ทั้งหมด</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>เรื่อง</th>
                                        <th>วันที่</th>
                                        <th>ลูกค้า</th>
                                        <th>การอนุมัติ</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox checkbox-success">
                                                <input type="checkbox" class="custom-control-input checkapprove" name="checkapprove" id="customCheck41" value="1">
                                                <label class="custom-control-label" for="customCheck41"></label>
                                            </div>
                                        </td>
                                        <td>1</td>
                                        <td class="topic_purple">แนะนำสินค้า</td>
                                        <td>11/10/2021</td>
                                        <td>บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</td>
                                        <td><span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span></td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-info btn-link btn_showplan" value="1">
                                                <i data-feather="file-text"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox checkbox-success">
                                                <input type="checkbox" class="custom-control-input checkapprove" name="checkapprove" id="customCheck42" value="2">
                                                <label class="custom-control-label" for="customCheck42"></label>
                                            </div>
                                        </td>
                                        <td>2</td>
                                        <td class="topic_purple">แนะนำสินค้า Home Paint Outlet</td>
                                        <td>20/10/2021</td>
                                        <td>Home Paint Outlet</td>
                                        <td><span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span></td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-info btn-link btn_showplan" value="1">
                                                <i data-feather="file-text"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox checkbox-success">
                                                <input type="checkbox" class="custom-control-input checkapprove" name="checkapprove" id="customCheck43" value="3">
                                                <label class="custom-control-label" for="customCheck43"></label>
                                            </div>
                                        </td>
                                        <td>3</td>
                                        <td class="topic_purple">แนะนำสินค้า</td>
                                        <td>11/10/2021</td>
                                        <td>บจก. ชัยรุ่งเรือง เวิร์ลเพ็นท์</td>
                                        <td><span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span></td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-info btn-link btn_showplan" value="1">
                                                <i data-feather="file-text"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
    <!-- /Row -->
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        @include('saleplan.salePlanForm')
    </div>


<!-- Modal -->
<div class="modal fade" id="Modalsaleplan" tabindex="-1" role="dialog" >
    @include('leadManager.saleplan_display')
</div>

@endsection('content')


@section('scripts')

<script>
    $(document).on('click', '.btn_showplan', function(){
        let plan_id = $(this).val();
        //alert(goo);
        $('#Modalsaleplan').modal("show");
    });
</script>




@endsection('scripts')
