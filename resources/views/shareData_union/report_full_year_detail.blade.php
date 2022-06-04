<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">ยอดขายตามหมวดสินค้า</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>ยอดขายตามหมวดสินค้า</h4>
            </div>
            <div class="d-flex">
                <a href="javascript:history.back();" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายงานยอดขายตาม Group</h5>
                        </div>
                        <div class="col-sm-12 col-md-6" style="text-align:right">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm table-color">
                                <table id="datable_1" class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">รหัส Group</th>
                                            <th>ชื่อ Group</th>
                                            <th style="text-align:right;">ยอดขายรวม</th>
                                            <th style="text-align:right;">% ยอดขาย</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($pdgroup_api))
                                        <tr>
                                            <td  style="text-align:center;">{{ $pdgroup_api['identify'] }}</td>
                                            <td>{{ $pdgroup_api['name'] }}</td>
                                            <td style="text-align:right;">{{ number_format($pdgroup_api['sum_sales'],2) }}</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                    <tfoot style="font-weight: bold; text-align:center">

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
        <!-- /Row -->
        
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายงานยอดขายร้านค้าตาม Group</h5>
                        </div>
                        <div class="col-sm-12 col-md-6" style="text-align:right">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm table-color">
                                <table id="datable_2" class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">#</th>
                                            <th style="text-align:center;">รหัสร้านค้า</th>
                                            <th>ชื่อร้านค้า</th>
                                            <th style="text-align:center;">อำเภอ, จังหวัด</th>
                                            <th style="text-align:right;">ยอดขายรวม</th>
                                            <th style="text-align:right;">% ยอดขาย</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($customer_api))
                                        @foreach($customer_api['data'] as $key => $customer)
                                            @php 
                                                $present_sale = ($customer['sales']*100)/$pdgroup_api['sum_sales'];
                                            @endphp
                                        <tr>
                                            <td style="text-align:center;">{{ ++$key  }}</td>
                                            <td style="text-align:center;">{{ $customer['identify'] }}</td>
                                            <td>{{ $customer['title'] }} {{ $customer['name'] }}</td>
                                            <td >{{ $customer['amphoe_name'] }}, {{ $customer['province_name'] }}</td>
                                            <td style="text-align:right;">{{ $customer['sales_th'] }}</td>
                                            <td style="text-align:right;">{{ number_format($present_sale,2) }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot style="font-weight: bold; text-align:center">
                                        <tr>
                                            <td colspan="4">รวม</td>
                                            <td style="text-align:right;">{{ number_format($pdgroup_api['sum_sales'],2) }}</td>
                                            <td></td>
                                        </tr>
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