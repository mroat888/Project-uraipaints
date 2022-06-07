<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">ยอดขายร้านค้า เทียบปีต่อปี</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container-fluid px-xxl-65 px-xl-20">
    <!-- Title -->
    <div class="hk-pg-header mb-10">
        <div>
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>ยอดขายร้านค้า เทียบปีต่อปี</h4>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-12">
                        <h5 class="hk-sec-title">รายงานยอดขายร้านค้า เทียบปีต่อปี</h5>
                    </div>
                    <div class="col-sm-12 col-md-12" style="text-align:right;">
                        <!-- ------ -->
                        <span class="form-inline pull-right">
                                <!-- เงื่อนไขการค้นหา -->
                            <form action="{{ url($action_search) }}" method="post">
                                @csrf
                                <span id="selectdate" >

                                    <select name="province" class="form-control form-control-sm province" aria-label=".form-select-lg example">
                                        <option value="">--เลือกจังหวัด--</option>
                                        @foreach($provinces as $province)
                                            @if(isset($keysearch_provinces) && ($keysearch_provinces == $province['identify']))
                                                <option value="{{ $province['identify'] }}" selected>{{ $province['name_thai'] }}</option>
                                            @else 
                                                <option value="{{ $province['identify'] }}">{{ $province['name_thai'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    <select name="amphur" class="form-control form-control-sm amphur" aria-label=".form-select-lg example">
                                        <option value="" selected>--เลือกอำเภอ--</option>
                                    </select>

                                    เทียบระหว่างปี
                                    <select name="sel_year_form" id="sel_year_form" class="form-control form-control-sm" required>
                                        <option value="">--ค้นหาปี--</option>
                                        <?php
                                            list($year,$month,$day) = explode("-", date("Y-m-d"));
                                            for($i = 0; $i<3; $i++){
                                        ?>
                                                <option value="{{ $year-$i }}">
                                                    @php 
                                                        $year_thai = ($year-$i)+543
                                                    @endphp
                                                    {{ $year_thai }}
                                                </option>
                                        <?php
                                            }
                                        ?>
                                    </select>

                                    กับปี

                                    <select name="sel_year_to" id="sel_year_to" class="form-control form-control-sm" required>
                                        <option value="">--ค้นหาปี--</option>
                                        <?php
                                            list($year,$month,$day) = explode("-", date("Y-m-d"));
                                            for($i = 0; $i<3; $i++){
                                        ?>
                                                <option value="{{ $year-$i }}">
                                                    @php 
                                                        $year_thai = ($year-$i)+543
                                                    @endphp
                                                    {{ $year_thai }}
                                                </option>
                                        <?php
                                            }
                                        ?>
                                    </select>

                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm" id="submit_request">ค้นหา</button>
                                </span>

                            </form>
                        </span>
                            <!-- จบเงื่อนไขการค้นหา -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <div class="table-responsive-sm table-color">
                            @php 
                                $year_1 =  $year_search[0];
                                $year_2 =  $year_search[1];
                                $year_thai_1 = $year_1+543;
                                $year_thai_2 = $year_2+543;
                            @endphp
                                <table id="datable_1" class="table table-sm table-hover">
                                <thead>
                                    <tr style="text-align:center">
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">รหัสร้านค้า</th>
                                        <th rowspan="2">ชื่อร้านค้า</th>
                                        <th colspan="3">ยอดขาย</th>
                                        <th rowspan="2">%<br>ผลต่าง</th>
                                    </tr>
                                    <tr style="text-align:center">
                                        <th>ปี {{ $year_thai_1 }}</th>
                                        <th>ปี {{ $year_thai_2 }}</th>
                                        <th>ผลต่าง</th>
                                    </tr>
                                </thead>
                                @if(isset($customer_compare_api))
                                <tbody>
                                    @foreach($customer_compare_api as $key => $customer)
                                    <tr style="text-align:center">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $customer['identify'] }}</td>
                                        <td style="text-align:left">{{ $customer['name'] }}</td>
                                        <td>{{ $customer['sales_th'] }}</td>
                                        <td>{{ $customer['compare_sales_th'] }}</td>
                                        <td style="text-align:right">{{ number_format($customer['customer_diff'],2) }}</td>
                                        <td style="text-align:right">{{ number_format($customer['persent_diff'],2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="font-weight: bold; text-align:center">
                                    <tr>
                                        @php 
                                            $sum_sales = $summary_customer_compare_api['sum_sales']/1000000;
                                            $sum_compare_sale = $summary_customer_compare_api['sum_compare_sale']/1000000;
                                            $sum_customer_diff = $summary_customer_compare_api['sum_customer_diff']/1000000;
                                            $sum_persent_diff = $summary_customer_compare_api['sum_persent_diff'];
                                        @endphp
                                        <td colspan = "3">รวม</td>
                                        <td>{{ number_format($sum_sales,2) }} ล้าน</td>
                                        <td>{{ number_format($sum_compare_sale,2) }} ล้าน</td>
                                        <td style="text-align:right">{{ number_format($sum_customer_diff,2) }} ล้าน</td>
                                        <td style="text-align:right">{{ number_format($sum_persent_diff,2) }}</td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                        <div class="mt-3" style="text-align:left;">
                            ข้อมูลสิ้นสุด ณ วันที่ 
                            @if(isset($customer_compare_api))
                                @php 
                                    list($lat_year, $lat_month, $lat_day) = explode("-",$trans_last_date);
                                    $lat_year_thai = $lat_year+543;
                                    $trans_last_date = $lat_day."/".$lat_month."/".$lat_year_thai;
                                @endphp
                                {{ $trans_last_date }}
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <!-- /Row -->
    
</div>

<script>

$(document).on('change','.province', function(e){
    e.preventDefault();
    let pvid = $(this).val();
    // console.log(pvid);
    if(pvid != ""){
        $(":submit").attr("disabled", true);
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_amphur_api") }}/{{ $position_province }}/'+pvid,
            datatype: 'json',
            success: function(response){
                console.log(response);
                if(response.status == 200){
                    console.log(response.amphures);
                    $('.amphur').children().remove().end();
                    $('.amphur').append('<option selected value="">เลือกอำเภอ</option>');
                    let rows = response.amphures.length;
                    for(let i=0 ;i<rows; i++){
                        $('.amphur').append('<option value="'+response.amphures[i]['identify']+'">'+response.amphures[i]['name_thai']+'</option>');
                    }
                    $(":submit").attr("disabled", false);
                }
            }
        });
    }
});


</script>