@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item">กลุ่มและทีม</li>
        <li class="breadcrumb-item active">รายละเอียดกลุ่มและทีม</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="users"></i></span></span>รายละเอียดกลุ่มและทีม</h4>
            </div>
            <div class="d-flex">
                <a href="{{ url('admin/teamSales')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">ตารางรายละเอียดกลุ่มและทีม</h5>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header mb-10">
                                <div>
                                </div>
                            </div>
                            <div class="table-responsive col-md-12">
                                <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อพนักงาน</th>
                                        <th>ตำแหน่งงาน</th>
                                        <th>ชื่อทีม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teamSalesDetail as $key => $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->permission_name }}</td>
                                        <td>{{ $value->team_name }}</td>
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
    <!-- /Container -->
@endsection
