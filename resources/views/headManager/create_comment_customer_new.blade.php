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
                            <form action="{{ url('head/create_comment_customer_new') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                <div>
                                    <h5>แสดงความคิดเห็นร้าน : {{$customer->shop_name}}</h5>
                                </div>
                                <input type="hidden" name="cust_shops_saleplan_id" value="{{$data->customer_shops_saleplan_id}}">
                                <input type="hidden" name="customer_shops_id" value="{{$data->customer_id}}">
                                <input type="hidden" name="monthly_plans_id" value="{{$createID}}">
                                    <div class="card-body">
                                        <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" value=""
                                        type="text">{{$data->customer_comment_detail}}</textarea>
                                    </div>
                            </div>
                            {{-- <div class="modal-footer"> --}}
                                <button type="submit" class="btn btn-primary float-right">บันทึก</button>
                            {{-- </div> --}}
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
                            <form action="{{ url('head/create_comment_customer_new') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                <div>
                                    <h5>แสดงความคิดเห็นร้าน : {{$customer->shop_name}}</h5>
                                </div>
                                <input type="hidden" name="id" value="{{$customerID}}">
                                <input type="hidden" name="createID" value="{{$createID}}">
                                    <div class="card-body">
                                        <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" value=""
                                        type="text"></textarea>
                                    </div>
                            </div>
                            {{-- <div class="modal-footer"> --}}
                                <button type="submit" class="btn btn-primary float-right">บันทึก</button>
                            {{-- </div> --}}
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

