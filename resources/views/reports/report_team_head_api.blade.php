@extends('layouts.masterHead')

@section('content')

@php 
    $position = "header";
    $path_detail = "sellerdetail/".$position;
@endphp

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานยอดลูกทีมที่รับผิดชอบ</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานยอดลูกทีมที่รับผิดชอบ</h4>
            </div>
            <div class="d-flex">
                <!-- <button class="btn btn-primary btn-sm"><i data-feather="printer"></i> พิมพ์</button> -->
            </div>
        </div>
        <!-- /Title -->

        {{-- <div class="body-responsive">
        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Column Chart with Labels</h6>
            <div class="row">
                <div class="col-sm">
                    <div id="e_chart_11" class="echart responsive" style="height:400px;"></div>
                </div>
            </div>
        </section>
        </div> --}}
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr style="text-align:center">
                                        <th><strong>#</strong></th>
                                        <th><strong>พื้นที่</strong></th>
                                        <th><strong>รหัส</strong></th>
                                        <th><strong>ชื่อ-นามสกุล</strong></th>
                                        <th><strong>ผู้จัดการเขต (คน)</strong></th>
                                        <th><strong>ตัวแทนขาย (คน)</strong></th>
                                        <th><strong>ลูกค้าทั้งหมด (ราย)</strong></th>
                                        <th><strong>ลูกค้า Active (ราย)</strong></th>
                                        <th><strong>ลูกค้า InActive (ราย)</strong></th>
                                        <!-- <th><strong>Hold_total</strong></th> -->
                                        <th><strong>% ลูกค้า Actice</strong></th>
                                        <th><strong>Action</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($resteam_api))
                                        @php 
                                            $no = 0;
                                            $sum_leader_total = 0;
                                            $sum_seller_total = 0;
                                            $sum_customer_total = 0;
                                            $sum_active_total = 0;
                                            $sum_inactive_total = 0;
                                            $sum_hold_total = 0;
                                        @endphp

                                        @if(count($resteam_api[0]['Sale_Header']) > 0)
                                        @foreach($resteam_api[0]['Sale_Header'] as $key => $value)
                                            @php 
                                                $present_active = ($value['active_total'] * 100)/$value['customer_total'];
                                            @endphp
                                            <tr style="text-align:center">
                                                <th scope="row">{{ ++$no }}</th>
                                                <th scope="row">{{ $value['area_name'] }}</th>
                                                <td>{{ $value['saleheader_id'] }}</td>
                                                <td style="text-align:left">{{ $value['saleheader_name'] }}</td>
                                                <td>{{ number_format($value['leader_total']) }}</td>
                                                <td>{{ number_format($value['seller_total']) }}</td>
                                                <td>{{ number_format($value['customer_total']) }}</td>
                                                <td>{{ number_format($value['active_total']) }}</td>
                                                <td>{{ number_format($value['inactive_total']) }}</td>
                                                {{-- <!-- <td>{{ number_format($value['hold_total']) }}</td> --> --}}
                                                <td>{{ number_format($present_active,2) }}</td>
                                                <td>
                                                    @php
                                                        $pathurl_leader = url($path_detail).'/saleleaders/'.$value['saleheader_id'];
                                                    @endphp
                                                    <a href="{{ $pathurl_leader }}" class="btn btn-icon btn-purple mr-10">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                </td>
                                            </tr>
                                            @php 
                                                $sum_leader_total += $value['leader_total'];
                                                $sum_seller_total += $value['seller_total'];
                                                $sum_customer_total += $value['customer_total'];
                                                $sum_active_total += $value['active_total'];
                                                $sum_inactive_total += $value['inactive_total'];
                                                $sum_hold_total += $value['hold_total'];

                                                $sum_present_active = ($sum_active_total * 100) / $sum_customer_total;
                                            @endphp
                                        @endforeach
                                        @endif

                                    @endif
                                </tbody>
                                <tfoot style=" text-align:center">
                                    <td colspan="4"><strong>รวมทั้งหมด</strong></td>
                                    <td><strong>{{ number_format($sum_leader_total) }}</strong></td>
                                    <td><strong>{{ number_format($sum_seller_total) }}</strong></td>
                                    <td><strong>{{ number_format($sum_customer_total) }}</strong></td>
                                    <td><strong>{{ number_format($sum_active_total) }}</strong></td>
                                    <td><strong>{{ number_format($sum_inactive_total) }}</strong></td>
                                    <!-- <td><strong>{{ number_format($sum_hold_total) }}</strong></td> -->
                                    <td><strong>{{ number_format($sum_present_active,2) }}</strong></td>
                                    <td></td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ตารางยอดลูกทีมที่รับผิดชอบ</h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <!-- ------ -->
                            <span class="form-inline pull-right">

                            </span>
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div id="table_list" class="table-responsive col-md-12">
                                <table id="datable_2" class="table table-hover">
                                    <thead>
                                        <tr style="text-align:center">
                                            <th><strong>#</strong></th>
                                            <th><strong>พื้นที่</strong></th>
                                            <th><strong>รหัส</strong></th>
                                            <th><strong>ชื่อ-นามสกุล</strong></th>
                                            <th><strong>ลูกค้าทั้งหมด</strong></th>
                                            <th><strong>ลูกค้า Active</strong></th>
                                            <th><strong>ลูกค้า InActive</strong></th>
                                            <!-- <th><strong>Hold_total</strong></th> -->
                                            <th><strong>% ลูกค้า Actice</strong></th>
                                            <th><strong>Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($resteam_api))
                                            @php 
                                                $no = 0;
                                                $sum_customer_total = 0 ;
                                                $sum_active_total = 0;
                                                $sum_inactive_total = 0;
                                                $sum_hold_total = 0;
                                            @endphp
                                            @foreach($resteam_api[1]['Sale_Leader'] as $key => $value)
                                                @php 
                                                    $present_active = ($value['active_total'] * 100)/$value['customer_total'];
                                                @endphp
                                            <tr style="text-align:center">
                                                <th scope="row">{{ ++$no }}</th>
                                                <th scope="row">{{ $value['zone_id'] }}</th>
                                                <td>{{ $value['saleleader_id'] }}</td>
                                                <td style="text-align:left">{{ $value['saleleader_name'] }}</td>
                                                <td>{{ number_format($value['customer_total']) }}</td>
                                                <td>{{ number_format($value['active_total']) }}</td>
                                                <td>{{ number_format($value['inactive_total']) }}</td>
                                                {{-- <!-- <td>{{ number_format($value['hold_total']) }}</td> --> --}}
                                                <td>{{ number_format($present_active,2) }}</td>
                                                <td>
                                                    @php
                                                        $pathurl_seller = url($path_detail).'/saleleaders/'.$value['saleleader_id'];
                                                    @endphp
                                                    <a href="{{ $pathurl_seller }}" class="btn btn-icon btn-purple mr-10">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                </td>
                                            </tr>
                                                @php 
                                                    $sum_customer_total += $value['customer_total'];
                                                    $sum_active_total += $value['active_total'];
                                                    $sum_inactive_total += $value['inactive_total'];
                                                    $sum_hold_total += $value['hold_total'];

                                                    $sum_present_active = ($sum_active_total * 100) / $sum_customer_total;
                                                @endphp
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot style=" text-align:center">
                                        <td colspan="4"><strong>รวมทั้งหมด</strong></td>
                                        <td><strong>{{ number_format($sum_customer_total) }}</strong></td>
                                        <td><strong>{{ number_format($sum_active_total) }}</strong></td>
                                        <td><strong>{{ number_format($sum_inactive_total) }}</strong></td>
                                        <!-- <td><strong>{{ number_format($sum_hold_total) }}</strong></td> -->
                                        <td><strong>{{ number_format($sum_present_active,2) }}</strong></td>
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <!-- /Row -->
    </div>

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

