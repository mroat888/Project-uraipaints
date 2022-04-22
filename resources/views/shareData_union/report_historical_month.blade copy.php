
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
                                        <th>เดือน</th>
                                        <th class="bg-success text-white">ปี</th>
                                        <th class="bg-success text-white">พนักงานขาย</th>
                                        <th class="bg-success text-white"> จำนวนร้านค้า</th>
                                        <th class="bg-success text-white">ยอดขายรวม</th>
                                        <th class="bg-success text-white">ยอดคืนรวม</th>
                                        <th class="bg-success text-white">ยอดขายสุทธิ</th>
                                        <th class="bg-success text-white">เปอร์เซ็นต์คืน</th>

                                        <th class="bg-info text-white">ปี</th>
                                        <th class="bg-info text-white">พนักงานขาย</th>
                                        <th class="bg-info text-white"> จำนวนร้านค้า</th>
                                        <th class="bg-info text-white">ยอดขายรวม</th>
                                        <th class="bg-info text-white">ยอดคืนรวม</th>
                                        <th class="bg-info text-white">ยอดขายสุทธิ</th>
                                        <th class="bg-info text-white">เปอร์เซ็นต์คืน</th>

                                        <th class="bg-warning text-dark">ปี</th>
                                        <th class="bg-warning text-dark">พนักงานขาย</th>
                                        <th class="bg-warning text-dark"> จำนวนร้านค้า</th>
                                        <th class="bg-warning text-dark">ยอดขายรวม</th>
                                        <th class="bg-warning text-dark">ยอดคืนรวม</th>
                                        <th class="bg-warning text-dark">ยอดขายสุทธิ</th>
                                        <th class="bg-warning text-dark">เปอร์เซ็นต์คืน</th>
                                
                                
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $month_array = [
                                            'มกราคม', 'กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                                            'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'
                                            ];
                                    ?>
                                    @if(!empty($month_api))
                                        @for($i=0 ;$i<12; $i++)
                                            <tr>
                                                <td><?php echo $month_array[$i]; ?></td>
                                                @php 
                                                    $key_year = 0;
                                                @endphp
                                                <td class="bg-success text-white">
                                                    @if(!empty($month_api[$key_year][$i]['year']))
                                                        {{ $month_api[$key_year][$i]['year'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['Sellers']))
                                                        {{ number_format($month_api[$key_year][$i]['Sellers']) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['customers']))
                                                        {{ number_format($month_api[$key_year][$i]['customers']) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['sales']))
                                                        {{ number_format($month_api[$key_year][$i]['sales'],2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['credits']))
                                                        {{ number_format($month_api[$key_year][$i]['credits'],2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['netSales']))
                                                        {{ number_format($month_api[$key_year][$i]['netSales'],) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['%Credit']))
                                                        {{ number_format($month_api[$key_year][$i]['%Credit'],2) }}%
                                                    @endif
                                                </td>


                                                @php 
                                                    $key_year = 1;
                                                @endphp
                                                <td class="bg-info text-white">
                                                    @if(!empty($month_api[$key_year][$i]['year']))
                                                        {{ $month_api[$key_year][$i]['year'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['Sellers']))
                                                        {{ number_format($month_api[$key_year][$i]['Sellers']) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['customers']))
                                                        {{ number_format($month_api[$key_year][$i]['customers']) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['sales']))
                                                        {{ number_format($month_api[$key_year][$i]['sales'],2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['credits']))
                                                        {{ number_format($month_api[$key_year][$i]['credits'],2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['netSales']))
                                                        {{ number_format($month_api[$key_year][$i]['netSales'],) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['%Credit']))
                                                        {{ number_format($month_api[$key_year][$i]['%Credit'],2) }}%
                                                    @endif
                                                </td>


                                                @php 
                                                    $key_year = 2;
                                                @endphp
                                                <td class="bg-warning text-dark">
                                                    @if(!empty($month_api[$key_year][$i]['year']))
                                                        {{ $month_api[$key_year][$i]['year'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['Sellers']))
                                                        {{ number_format($month_api[$key_year][$i]['Sellers']) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['customers']))
                                                        {{ number_format($month_api[$key_year][$i]['customers']) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['sales']))
                                                        {{ number_format($month_api[$key_year][$i]['sales'],2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['credits']))
                                                        {{ number_format($month_api[$key_year][$i]['credits'],2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['netSales']))
                                                        {{ number_format($month_api[$key_year][$i]['netSales'],) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($month_api[$key_year][$i]['%Credit']))
                                                        {{ number_format($month_api[$key_year][$i]['%Credit'],2) }}%
                                                    @endif
                                                </td>
                                                
                                            </tr>
                                        @endfor
                                    @endif
                                    
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

 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>


