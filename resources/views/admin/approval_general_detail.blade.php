@extends('layouts.masterAdmin')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active">การขออนุมัติ</li>
            <li class="breadcrumb-item active" aria-current="page">รายการข้อมูลการขออนุมัติ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>รายการข้อมูลการขออนุมัติ</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{ url('admin/approvalgeneral') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('admin/approvalgeneral/history') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-list"></i>
                                </span>
                                <span class="btn-text">ประวัติ</span>
                            </a>
                            <hr>
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                            <div class="col-md-12">
                                <h5 class="hk-sec-title">ตารางรายการข้อมูลการขออนุมัติ</h5>
                            </div>
                            <div class="col-md-9">

                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>วันที่</th>
                                            <th>เรื่อง</th>
                                            <th>พนักงาน</th>
                                            <th>การอนุมัติ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($request_approval as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$value->assign_request_date}}</td>
                                            <td>

                                                @if ($value->assign_is_hot == 1)
                                                <span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>
                                                @endif

                                                {{$value->assign_title}}
                                            </td>
                                            <td>{{$value->name}}</td>
                                            <td>

                                                            @if ($value->status_approve == 1)
                                                                <span class="badge badge-soft-warning"
                                                                    style="font-size: 12px;">
                                                                    Pending
                                                                </span>
                                                            @else
                                                                <span class="badge badge-soft-success"
                                                                    style="font-size: 12px;">
                                                                    Approve
                                                                </span>
                                                            @endif
                                                {{-- <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span> --}}
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/comment_approval', [$value->id, $value->created_by]) }}" class="btn btn-icon btn-info mr-10">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i data-feather="message-square"></i>
                                                    </h4>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
        <!-- /Row -->
    </div>
    <!-- /Container -->

@endsection('content')

@section('scripts')


@endsection
