@extends('layouts.masterLead')

@section('content')



    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item">การขออนุมัติ</li>
            <li class="breadcrumb-item">รายการข้อมูลการขออนุมัติ</li>
            <li class="breadcrumb-item active" aria-current="page">เพิ่มความคิดเห็น</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i
                    data-feather="message-square"></i></span>เพิ่มความคิดเห็น</h4>
            </div>
        </div>
        <!-- /Title -->

        @if ($comment)
            <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form action="{{ url('lead/create_comment_request_approval') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                <div>
                                    <h5>ความคิดเห็น</h5>
                                </div>
                                <input type="hidden" name="id" value="{{$comment->assign_id}}">
                                <input type="hidden" name="createID" value="{{$createID}}">
                                    <div class="card-body">
                                        <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" value=""
                                        type="text">{{$comment->assign_comment_detail}}</textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('lead/approval_general_detail', $createID) }}" type="button" class="btn btn-secondary">ย้อนกลับ</a>
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- /Row -->

        @else
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form action="{{ url('lead/create_comment_request_approval') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                <div>
                                    <h5>ความคิดเห็น</h5>
                                </div>
                                <input type="hidden" name="id" value="{{$assignID}}">
                                <input type="hidden" name="createID" value="{{$createID}}">
                                    <div class="card-body">
                                        <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" value=""
                                        type="text"></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('lead/approval_general_detail', $createID) }}" type="button" class="btn btn-secondary">ย้อนกลับ</a>
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- /Row -->
        @endif

    </div>

@endsection

