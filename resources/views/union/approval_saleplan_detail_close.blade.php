<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item">ประวัติการอนุมัติ Sale Plan</li>
            <li class="breadcrumb-item active" aria-current="page">รายงานสรุป Sale Plan</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i
                            class="ion ion-md-analytics"></i></span>รายงานสรุป Sale Plan</h4>
            </div>
            <div class="d-flex">
                <a href="javascript:back()" type="button" 
                class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title mb-10">รายงานสรุป Sale Plan ของ {{ $sale_name->name }}
                                ประจำเดือน <?php echo thaidate('F Y', $mon_plan->month_date); ?>
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">

                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ร้านค้า</th>
                                            <th style="width:15%;">อำเภอ,จังหวัด</th>
                                            <th style="width:10%;">วัตถุประสงค์</th>
                                            <th style="width:30%;">รายการนำเสนอ</th>
                                            <th style="width:9%;">จำนวนบิล</th>
                                            <th style="width:10%;">มูลค่าบิล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $sum_bills = 0;
                                            $sum_sales = 0;
                                            $total_bills = 0;
                                            $total_sales = 0; 
                                            $total_pglist = 0;
                                        @endphp
                                        @foreach ($list_saleplan as $key => $value)
                                            @php 
                                                $customer_name = "";
                                                $customer_address = "";
                                                // dd($saleplan_api);
                                                foreach($saleplan_api as $key_api => $value_api){
                                                    if($saleplan_api[$key_api]['customer_id'] == $value->customer_shop_id){
                                                        if($customer_name != $saleplan_api[$key_api]['customer_name']){
                                                            $customer_name = $saleplan_api[$key_api]['customer_name'];
                                                            $customer_address = $saleplan_api[$key_api]['amphoe_name'].", ".$saleplan_api[$key_api]['province_name'];
                                                        }
                                                    }
                                                }
                                            @endphp

                                            <tr>
                                                <td >{{ $key + 1 }}</td>
                                                <td> {{ $value->customer_shop_id }} {{ $customer_name }}</td>
                                                <td>{{ $customer_address }}</td>                                                      
                                                <td>
                                                    @php 
                                                        $sale_plans_objective = DB::table('master_objective_saleplans')
                                                            ->where('id', $value->sale_plans_objective)
                                                            ->first();
                                                    @endphp
                                                    {{  $sale_plans_objective->masobj_title }}
                                                </td>
                                                <td>
                                                    @php 
                                                        $listpresent = explode(',',$value->sale_plans_tags);
                                                        foreach($listpresent as $key_list => $value_list ){
                                                            $pdlist_name = "";
                                                            foreach($saleplan_api as $key_api => $value_api){
                                                                if($saleplan_api[$key_api]['pdlist_id'] == $value_list){
                                                                    $pdlist_name = $saleplan_api[$key_api]['pdlist_name'];
                                                                }
                                                            }
                                                            echo "[".$value_list."] ".$pdlist_name."<br>";

                                                            $total_pglist += 1;
                                                        }
                                                    @endphp
                                                </td>
                                                <td style="text-align:center;">
                                                    @php 
                                                        $listpresent = explode(',',$value->sale_plans_tags);
                                                        foreach($listpresent as $key_list => $value_list ){
                                                            $bills = 0;
                                                            foreach($saleplan_api as $key_api => $value_api){
                                                                if($saleplan_api[$key_api]['pdlist_id'] == $value_list){
                                                                    if($saleplan_api[$key_api]['customer_id'] == $value->customer_shop_id){
                                                                        if($saleplan_api[$key_api]['pdlist_name'] != ""){
                                                                            $bills= $saleplan_api[$key_api]['bills'];
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            echo $bills."<br>";
                                                            $sum_bills += $bills;
                                                        }
                                                    @endphp
                                                </td>
                                                <td style="text-align:right;">
                                                    @php 
                                                        $listpresent = explode(',',$value->sale_plans_tags);
                                                        foreach($listpresent as $key_list => $value_list ){
                                                            $sales = 0;
                                                            foreach($saleplan_api as $key_api => $value_api){
                                                                if($saleplan_api[$key_api]['pdlist_id'] == $value_list){
                                                                    if($saleplan_api[$key_api]['customer_id'] == $value->customer_shop_id){
                                                                        if($saleplan_api[$key_api]['pdlist_name'] != ""){
                                                                            $sales= $saleplan_api[$key_api]['sales'];
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            echo number_format($sales,2)."<br>";
                                                            $sum_sales += $sales;
                                                            
                                                        }
                                                    @endphp
                                                </td>
                                            </tr>
                                            <tr class="bg-teal text-white">
                                                <td colspan="5">รวมร้านค้า {{ $customer_name }}</td>
                                                <td style="text-align:center;">{{ $sum_bills }}</td>
                                                <td style="text-align:right;">{{ number_format($sum_sales,2) }}</td>
                                            </tr>
                                            @php
                                                $total_bills += $sum_bills;
                                                $total_sales += $sum_sales;

                                                $sum_bills = 0;
                                                $sum_sales = 0;
                                            @endphp  
                                        @endforeach
                                            <tr>
                                                <td colspan="5"><strong>รวมทั้งสิ้น</strong></td>
                                                <td style="text-align:center;"><strong>{{ number_format($total_bills) }}</strong></td>
                                                <td style="text-align:right;"><strong>{{ number_format($total_sales,2) }}</strong></td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div>
                            <h5 class="hk-sec-title">รายงานสรุป Sale Plan (ลูกค้าใหม่) ของ {{ $sale_name->name }}
                                ประจำเดือน <?php echo thaidate('F Y', $mon_plan->month_date); ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10 mt-10">
                                    <div>
                                    </div>
                                </div>
                                <div class="table-responsive col-md-12">
                                    <table id="datable_1_2" class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>รหัสลูกค้า</th>
                                                <th>ชื่อร้าน</th>
                                                <th>อำเภอ,จังหวัด</th>
                                                <th>จำนวนบิล</th>
                                                <th>ยอดขายรวม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                                $no = 0;
                                            @endphp
                                            @foreach ($customer_new as $key => $value)
                                                @php 
                                                    $sales = "-";
                                                    $bills = "-";
                                                @endphp
                                                @if($value->shop_status == 1 && $value->shop_aprove_status == 2)
                                                    @php
                                                        if(!is_null($value->mrp_identify)){
                                                            list($year, $month, $day) = explode('-',$value->month_date);
                                                            $path_search = "reports/years/".$year."/months/".$month."/sellers/".$value->api_identify."/customers/".$value->mrp_identify;
                                                            $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
                                                            $res_customer_api = $response->json();
                                                            if($res_customer_api['code'] == 200){
                                                                $sales = number_format($res_customer_api['data'][0]['sales'],2);
                                                                $bills = number_format($res_customer_api['data'][0]['bills']);
                                                            }
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ ++$no }}</td>
                                                        <td>{{ $value->mrp_identify }}</td>
                                                        <td>{{ $value->shop_name }}</td>
                                                        <td>{{ $value->PROVINCE_NAME }}</td>
                                                        <td style="text-align:center;">{{ $bills }}</td>
                                                        <td style="text-align:right;">{{ $sales }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
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

       <script type="text/javascript">
        function chkAll(checkbox) {

            var cboxes = document.getElementsByName('checkapprove[]');
            var len = cboxes.length;

            if (checkbox.checked == true) {
                for (var i = 0; i < len; i++) {
                    cboxes[i].checked = true;
                }
            } else {
                for (var i = 0; i < len; i++) {
                    cboxes[i].checked = false;
                }
            }
        }
    </script>

<script type="text/javascript">
    function chkAll_customer(checkbox) {

        var cboxes = document.getElementsByName('checkapprove_cust[]');
        var len = cboxes.length;

        if (checkbox.checked == true) {
            for (var i = 0; i < len; i++) {
                cboxes[i].checked = true;
            }
        } else {
            for (var i = 0; i < len; i++) {
                cboxes[i].checked = false;
            }
        }
    }
</script>