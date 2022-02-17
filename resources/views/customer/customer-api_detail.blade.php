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
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-people"></i></span>รายละเอียดลูกค้า</h4>
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
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <h2>{{ $customer_shop['title'] }} {{ $customer_shop['name'] }}</h2>
                                    <span style="font-size: 18px;">
                                        <p class="my-3">{{ $customer_shop['address1'] }} 
                                            {{ $customer_shop['adrress2'] }} 
                                            {{ $customer_shop['postal_id'] }}
                                        </p>
                                        <p class="my-3">Tel. {{ $customer_shop['telephone'] }} </p>
                                    </span>
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
                        <h5>ประวัติการแคมเปญ</h5>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div id="table_list" class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="font-weight: bold;">#</th>
                                                <th style="font-weight: bold;">ปี</th>
                                                <th style="font-weight: bold;">รหัสโปรโมชั่น</th>
                                                <th style="font-weight: bold;">ชื่อโปรโมชั่น</th>
                                                <th style="font-weight: bold;">ยอดซื้อเป้า</th>
                                                <th style="font-weight: bold;">ยอดซื้อเป้า ข้อความ</th>
                                                <th style="font-weight: bold;">ยอดซื้อเกิดจริง</th>
                                                <th style="font-weight: bold;">ยอดซื้อเกิดจริง ข้อความ</th>
                                                <th style="font-weight: bold;">ยอดผลต่าง</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">

                                            @foreach($cust_campaigns_api as $key => $value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $cust_campaigns_api[$key]['year'] }}</td>
                                                <td>{{ $cust_campaigns_api[$key]['campaign_id'] }}</td>
                                                <td>{{ $cust_campaigns_api[$key]['description'] }}</td>
                                                <td>{{ $cust_campaigns_api[$key]['saleamount'] }}</td>
                                                <td>{{ $cust_campaigns_api[$key]['amount_limit'] }}</td>
                                                <td>{{ $cust_campaigns_api[$key]['amount_diff'] }}</td>
                                                <td>{{ $cust_campaigns_api[$key]['amount_limit_th'] }}</td>
                                                <td>{{ $cust_campaigns_api[$key]['amount_net_th'] }}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
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

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')


