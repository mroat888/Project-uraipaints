@extends('layouts.masterAdmin')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานเทียบย้อนหลัง (รายเดือน)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานเทียบย้อนหลัง (รายเดือน)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายงานเทียบย้อนหลัง (รายเดือน)</h5>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <!-- ------ -->
                            <span class="form-inline pull-right">
                                <!-- <span class="mr-5">เลือก</span> -->
                                <!-- <input type="month" name="" id="" class="form-control"> -->
                                {{-- <button class="btn btn-primary btn-sm ml-10 mr-15"><i data-feather="printer"></i> พิมพ์</button> --}}
                                </span>

                            </span>
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div id="table_list" class="table-responsive col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                    <?php
                                    for($i=0; $i<3; $i++){
                                        $rel3 = 3+$i;
                                        $rel4 = 4+$i;
                                    ?>
                                        
                                            <th>ปี</th>
                                            <th>เดือน</th>
                                            <th class="hide" rel="{{ $rel3 }}">พนักงานขาย</th>
                                            <th class="hide" rel="{{ $rel4 }}"> จำนวนร้านค้า</th>
                                            <th>ยอดขายรวม</th>
                                            <th>ยอดคืนรวม</th>
                                            <th>ยอดขายสุทธิ</th>
                                            <th>เปอร์เซ็นต์คืน</th>
                                        
                                    <?php
                                    }
                                    ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    @if(!empty($month_api))
                                        @foreach($month_api['data'] as $value)
                                        <tr>
                                            <?php
                                                for($i=0; $i<3; $i++){
                                                    $rel3 = 3+$i;
                                                    $rel4 = 4+$i;
                                            ?>
                                            <td>{{ $value['year'] }}</td>
                                            <td>{{ $value['month'] }}</td>
                                            <td class="hide" rel="{{ $rel3 }}">{{ number_format($value['Sellers']) }}</td>
                                            <td class="hide" rel="{{ $rel4 }}">{{ number_format($value['customers']) }}</td>
                                            <td>{{ number_format($value['sales']) }}</td>
                                            <td>{{ number_format($value['credits']) }}</td>
                                            <td>{{ number_format($value['netSales']) }}</td>
                                            <td>{{ number_format($value['%Credit'],2) }}%</td>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                        @endforeach
                                    @endif
                                    
                                    </tbody>
                                    <!-- <tfoot style="font-weight: bold;">
                                        <td colspan="2" align="center">ทั้งหมด</td>
                                        <td>3</td>
                                        <td>3</td>
                                        <td>3</td>
                                        <td>60,000</td>
                                    </tfoot> -->
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

<script>
    $(document).on('click', '.hide', function(){
        var rel = $(this).attr("rel");
        console.log(rel);
        $('.hide[rel=' + rel + ']').fadeOut();
    });
</script>

 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>
@endsection

