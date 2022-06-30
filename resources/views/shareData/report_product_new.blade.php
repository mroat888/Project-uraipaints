@extends('layouts.master')

@section('content')

<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานยอดขายสินค้าใหม่</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-document"></i></span>รายงานยอดขายสินค้าใหม่</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-4">
                            <!-- <h5 class="hk-sec-title">ตารางรายงานยอดขายสินค้าใหม่</h5> -->
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <!-- ------ -->
                            <span class="form-inline pull-right pull-sm-center">
                                <form action="{{ url('data_report_product-new/search') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <span id="selectdate">
                                        ปี :
                                        <select class="form-control form-control-sm mr-5" name="sel_year" id="sel_year">
                                            @php 
                                                $year_now = date("Y");
                                                $year_now_thai = $year_now+543;
                                             @endphp
                                            @for($i=0; $i < 2; $i++)
                                                @php 
                                                    $year = $year_now-$i;
                                                    $year_thai = $year_now_thai-$i;
                                                @endphp
                                                <option value="{{ $year }}">{{ $year_thai }}</option>
                                            @endfor
                                        </select>
                                        เป้า : 
                                        <select class="form-control form-control-sm mr-5" name="sel_campaign" id="sel_campaign">
                                            <option value="">เลือกแคมเปญ</option>
                                        </select>

                                    <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm">ค้นหา</button>
                                    </span>
                                </form>
                            </span>
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row mt-50">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th colspan="3" style="text-align:center;">รายละเอียดเป้าสินค้าใหม่</th>
                                            <th colspan="5" style="text-align:center;">ผลงาน</th>
                                            <!-- <th colspan="3" style="text-align:center;">รายการยอดขายสินค้าใหม่</th>
                                            <th colspan="2" style="text-align:center;">คิดเป็นเปอร์เซ็น (%)</th> -->
                                        </tr>

                                        <tr style="text-align:center">
                                            <th>ชื่อเป้า</th>
                                            <th>ระยะเวลา</th>
                                            <th>เป้าทั้งหมด<br>(หน่วย)</th>
                                            <th>เป้าที่ทำได้<br>(หน่วย)</th>
                                            <th>คิดเป็น%</th>
                                            <th>คงเหลือ<br>(หน่วย)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $rows = count($sellers_api);
                                        $no=0;
                                        for($i=0 ; $i< $rows; $i++){
                                            list($fyear,$fmonth,$fday) = explode("-",$sellers_api[$i]['fromdate']);
                                            $fyear_thai = $fyear+543;
                                            $fromdate = $fday."/".$fmonth."/".$fyear_thai;

                                            list($tyear,$tmonth,$tday) = explode("-",$sellers_api[$i]['todate']);
                                            $tyear_thai = $tyear+543;
                                            $todate = $tday."/".$tmonth."/".$tyear_thai;

                                            if($sellers_api[$i]['persent_sale'] >= 100){
                                                $text_status = "text-success";
                                            }else{
                                                $text_status = "text-danger";
                                            }
                                    ?>

                                        <tr style="text-align:center">
                                            <th scope="row">{{ ++$no }}</th>
                                            <td style="text-align:left;">{{ $sellers_api[$i]['description'] }}</td>
                                            <td>{{ $fromdate }} - {{ $todate }}</td>
                                            <td>{{ number_format($sellers_api[$i]['Target'],0) }}</td>
                                            <td>{{ number_format($sellers_api[$i]['Sales'],0) }}</td>
                                            <td class="{{ $text_status }}">{{ number_format($sellers_api[$i]['persent_sale'],2)}}%</td>
                                            <td class="{{ $text_status }}">{{ number_format($sellers_api[$i]['Diff'],0) }}</td>
                                        </tr>
                                        
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot style="font-weight: bold; text-align:center">
                                        @php 
                                            if($summary_sellers_api['sum_persent_sale'] >= 100){
                                                $text_status = "text-success";
                                            }else{
                                                $text_status = "text-danger";
                                            }
                                        @endphp
                                        <td colspan="3" style="text-align:center;">ทั้งหมด</td>
                                        <td class="text-success">{{ number_format($summary_sellers_api['sum_target'],0) }}</td>
                                        <td class="text-success">{{ number_format($summary_sellers_api['sum_sales'],0) }}</td>
                                        <td class="{{ $text_status }}">{{ number_format($summary_sellers_api['sum_persent_sale'],2) }}%</td>
                                        <td class="{{ $text_status }}">{{ number_format($summary_sellers_api['sum_diff'],0) }}</td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            หน่วย หมายถึง ...................
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            ข้อมูล ณ วันที่ {{ $trans_last_date }}
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <!-- /Row -->
    </div>


<script>
    $( document ).ready(function() {
        let sel_year = $('#sel_year').val();
        console.log(sel_year);
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_campaignpromotes") }}/'+sel_year, 
            datatype: 'json',
            success: function(response){
                if(response.status == 200){
                    console.log(response.campaignpromotes);
                    $('#sel_campaign').children().remove().end();
                    $('#sel_campaign').append('<option selected value="">เลือกแคมเปญ</option>');
                    let rows = response.campaignpromotes.length;
                    for(let i=0 ;i<rows; i++){
                        $('#sel_campaign').append('<option value="'+response.campaignpromotes[i]['campaign_id']+'">'+response.campaignpromotes[i]['description']+'</option>');
                    }
                }else{
                    console.log("ไม่พบ จังหวัด สินค้า");
                }
            }
        });
    });

    $(document).on('change','#sel_year', function(e){
        e.preventDefault();
        let sel_year = $(this).val();
        console.log(sel_year);
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_campaignpromotes") }}/'+sel_year, 
            datatype: 'json',
            success: function(response){
                if(response.status == 200){
                    console.log(response.campaignpromotes);
                    $('#sel_campaign').children().remove().end();
                    $('#sel_campaign').append('<option selected value="">เลือกแคมเปญ</option>');
                    let rows = response.campaignpromotes.length;
                    for(let i=0 ;i<rows; i++){
                        $('#sel_campaign').append('<option value="'+response.campaignpromotes[i]['campaign_id']+'">'+response.campaignpromotes[i]['description']+'</option>');
                    }
                }else{
                    console.log("ไม่พบ จังหวัด สินค้า");
                }
            }
        });
    });

</script>

@endsection

@section('footer')
    @include('layouts.footer')
@endsection


