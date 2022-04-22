@extends('layouts.masterHead')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item">อนุมัติ Sale Plan</li>
            <li class="breadcrumb-item">รายละเอียด Sale Plan</li>
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

        @if ($data)
            <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form action="{{ url('head/create_comment_saleplan') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                <div>
                                    <h5>แสดงความคิดเห็นเรื่อง : {{$title->sale_plans_title}}</h5>
                                </div>
                                <input type="hidden" name="id" value="{{$data->saleplan_id}}">
                                <input type="hidden" name="createID" value="{{$createID}}">
                                    <div class="card-body">
                                        <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" value=""
                                        type="text">{{$data->saleplan_comment_detail}}</textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('head/approvalsaleplan_detail', $createID) }}" type="button" class="btn btn-secondary">ย้อนกลับ</a>
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
                            <form action="{{ url('head/create_comment_saleplan') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                <div>
                                    <h5>แสดงความคิดเห็นเรื่อง : {{$title->sale_plans_title}}</h5>
                                </div>
                                <input type="hidden" name="id" value="{{$saleplanID}}">
                                <input type="hidden" name="createID" value="{{$createID}}">
                                    <div class="card-body">
                                        <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" value=""
                                        type="text"></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('head/approvalsaleplan_detail', $createID) }}" type="button" class="btn btn-secondary">ย้อนกลับ</a>
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


        @foreach($sale_plan_comments as $value)

            <div class="card">
                <div class="card-header">
                    Comment
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                    <p>{{ $value->saleplan_comment_detail }}</p>
                    <footer class="blockquote-footer">
                        @php
                            $users_comment = DB::table('users')->where('id', $value->created_by)->first();
                        @endphp
                        {{ $users_comment->name }}
                        <cite title="Source Title">{{ $value->created_at }}</cite>
                    </footer>
                    </blockquote>
                </div>
            </div>

        @endforeach

    </div>

@endsection

