<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">ข้อมูลร้านค้า (ทำเป้า)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>ข้อมูลร้านค้า (ทำเป้า)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <div class="topichead-bgred" style="margin-bottom: 30px;">สรุปยอดทำเป้า เทียบปี</div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <!-- ------ -->

                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm table-color">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr class="table-bggrey">
                                            <th style="text-align:center">#</th>
                                            <th style="text-align:center">ปี</th>
                                            <th style="text-align:center">จำนวนร้านค้า</th>
                                            <th style="text-align:center">จำนวนเป้า</th>
                                            <th style="text-align:center">ยอดเป้า</th>
                                            <th style="text-align:center">ยอดเบิกเป้า</th>
                                            <th style="text-align:center">% field</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $no = 0;
                                        $sum_TotalLimit = 0;
                                        $sum_TotalPromotion = 0;
                                        $sum_TotalCustomer = 0;
                                        $sum_TotalAmountSale = 0;
                                        $sum_persent_TotalAmountSale = 0;
                                    @endphp
                                    @if(isset($campaigns_year))
                                        @foreach($campaigns_year as $key => $value)
                                        @php
                                            $sum_TotalLimit += $value['TotalLimit'];
                                            $sum_TotalPromotion += $value['TotalPromotion'];
                                            $sum_TotalCustomer += $value['TotalCustomer'];
                                            $sum_TotalAmountSale += $value['TotalAmountSale'];
                                            $persent_TotalAmountSale = ($value['TotalAmountSale'] / $value['TotalLimit']) * 100;
                                        @endphp
                                        <tr class="tb_camp" rel="{{ $key }}">
                                            <td style="text-align:center">{{ ++$no }}</td>
                                            <td style="text-align:center">{{ $value['year'] }}</td>
                                            <td style="text-align:right">{{ number_format($value['TotalCustomer']) }}</td>
                                            <td style="text-align:right">{{ number_format($value['TotalPromotion']) }}</td>
                                            <td style="text-align:right">{{ number_format($value['TotalLimit'],2) }}</td>
                                            <td style="text-align:right">{{ number_format($value['TotalAmountSale'],2) }}</td>
                                            <td style="text-align:right">{{ number_format($persent_TotalAmountSale,2) }}</td>
                                        </tr>
                                        <tr class="tb_detail" rel="{{ $key }}">
                                            @if(isset($customer_campaigns))
                                            <td colspan="7">
                                                <div class="row">
                                                    <div class="col-6"><h5>รายละเอียดร้านค้าทำเป้า</h5></div>
                                                    <div class="col-6" style="text-align:right;">หน่วยบาท</div>
                                                </div>
                                                <div class="table-responsive-sm">
                                                    <table class="table table-sm table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:center">#</th>
                                                                <th style="text-align:center">รหัสร้านค้า</th>
                                                                <th style="text-align:center">ชื่อร้านค้า</th>
                                                                <th style="text-align:center">อำเภอ</th>
                                                                <th style="text-align:center">จำนวนเป้า</th>
                                                                <th style="text-align:center">มูลค่าเป้า</th>
                                                                <th style="text-align:center">ยอดเบิกเป้า</th>
                                                                <th style="text-align:center">%</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $province_name_check = "";
                                                            $sum_sub_TotalPromotion = 0;
                                                            $sum_sub_TotalLimit = 0;
                                                            $sum_sub_TotalAmountSale = 0;
                                                            // dd($customer_campaigns) ;
                                                        @endphp

                                                        @foreach($customer_campaigns[$key] as $key_cam => $cust_campaigns_value)
                                                            @if(($province_name_check != $cust_campaigns_value['province_name']))

                                                                @if(($province_name_check != ""))
                                                                    @php 
                                                                        if($sum_sub_TotalAmountSale > 0 && $sum_sub_TotalLimit > 0){
                                                                            $persent_sub_camTotalAmountSale = ($sum_sub_TotalAmountSale / $sum_sub_TotalLimit) * 100;
                                                                        }else{
                                                                            $persent_sub_camTotalAmountSale = 0;
                                                                        }
                                                                    @endphp
                                                                    <tr>
                                                                        <td colspan="4">
                                                                            <strong>รวมจังหวัด {{ $province_name_check }}</strong>
                                                                        </td>
                                                                        <td style="text-align:center"><strong>{{ number_format($sum_sub_TotalPromotion) }}</strong></td>
                                                                        <td style="text-align:center"><strong>{{ number_format($sum_sub_TotalLimit,2) }}</strong></td>
                                                                        <td style="text-align:center"><strong>{{ number_format($sum_sub_TotalAmountSale,2) }}</strong></td>
                                                                        <td style="text-align:center"><strong>{{ number_format($persent_sub_camTotalAmountSale,2) }}</strong></td>
                                                                    </tr>
                                                                    @php 
                                                                        $province_name_check = "";
                                                                        $sum_sub_TotalPromotion = 0;
                                                                        $sum_sub_TotalLimit = 0;
                                                                        $sum_sub_TotalAmountSale = 0;
                                                                    @endphp

                                                                @endif
                                                                <tr>
                                                                    <td colspan="8">
                                                                        <strong>จังหวัด {{ $cust_campaigns_value['province_name'] }}</strong>
                                                                    </td>
                                                                </tr>

                                                                @php             
                                                                    $province_name_check = $cust_campaigns_value['province_name']; 
                                                                @endphp
                                                            @endif
                                                            <tr>

                                                            @php
                                                                $sum_sub_TotalPromotion += $cust_campaigns_value['TotalPromotion'];
                                                                $sum_sub_TotalLimit += $cust_campaigns_value['TotalLimit'];
                                                                $sum_sub_TotalAmountSale += $cust_campaigns_value['TotalAmountSale'];

                                                                $persent_camTotalAmountSale = ($cust_campaigns_value['TotalAmountSale'] / $cust_campaigns_value['TotalLimit']) * 100;
                                                            @endphp

                                                            <tr>
                                                                <td>{{ ++$key_cam }}</td>
                                                                <td>{{ $cust_campaigns_value['identify'] }}</td>
                                                                <td>{{ $cust_campaigns_value['name'] }}</td>
                                                                <td>{{ $cust_campaigns_value['amphoe_name'] }}</td>
                                                                <td style="text-align:center">{{ number_format($cust_campaigns_value['TotalPromotion']) }}</td>
                                                                <td style="text-align:right">{{ number_format($cust_campaigns_value['TotalLimit'],2) }}</td>
                                                                <td style="text-align:right">{{ number_format($cust_campaigns_value['TotalAmountSale'],2) }}</td>
                                                                <td style="text-align:right">{{ number_format($persent_camTotalAmountSale,2) }}</td>
                                                            </tr>
                                                        @endforeach

                                                       @if(($province_name_check != ""))
                                                            <tr>
                                                                <td colspan="4">
                                                                    <strong>รวมจังหวัด {{ $province_name_check }}</strong>
                                                                </td>
                                                                <td style="text-align:center"><strong>{{ number_format($sum_sub_TotalPromotion) }}</strong></td>
                                                                <td style="text-align:center"><strong>{{ number_format($sum_sub_TotalLimit,2) }}</strong></td>
                                                                <td style="text-align:center"><strong>{{ number_format($sum_sub_TotalAmountSale,2) }}</strong></td>
                                                                <td style="text-align:center"><strong>{{ number_format($persent_sub_camTotalAmountSale,2) }}</strong></td>
                                                            </tr>
                                                        @endif

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </td>
                                            @endif

                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot style="font-weight: bold; text-align:center; background: #ddd;">
                                        @php
                                            $sum_persent_TotalAmountSale =  ($sum_TotalAmountSale / $sum_TotalLimit) * 100;
                                        @endphp
                                        <tr style="font-weight: bold;">
                                            <td colspan="2" style=" text-align:center; font-weight: bold;">ทั้งหมด</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_TotalCustomer) }}</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_TotalPromotion) }}</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_TotalLimit,2) }}</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_TotalAmountSale,2) }}</td>
                                            <td style="font-weight: bold; text-align:right">{{ number_format($sum_persent_TotalAmountSale,2) }}</td>
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

        <!-- /Row -->                                                        
            @include('shareData_union.check_name_store_campaigns_table') 
        <!-- /Row -->
    </div>

<style>
    .tb_detail{
        display:none;
    }
</style>

<script>
    $(document).on('click', '.tb_camp', function(){
        let rel = $(this).attr("rel");
        $('.tb_detail[rel=' + rel + ']').toggle();
    });
</script>
