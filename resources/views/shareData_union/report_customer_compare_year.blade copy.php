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
                                        <option value="">--โปรดเลือก--</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province['identify'] }}">{{ $province['name_thai'] }}</option>
                                        @endforeach
                                    </select>

                                    <select name="amphur" class="form-control form-control-sm amphur" aria-label=".form-select-lg example">
                                        <option value="" selected>--โปรดเลือก--</option>
                                    </select>

                                    <select name="sel_year_form" id="sel_year_form" class="form-control" required>
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

                                    ถึง 

                                    <select name="sel_year_to" id="sel_year_to" class="form-control" required>
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
                                        <th>ปี {{-- $year_1 --}}</th>
                                        <th>ปี {{-- $year_2 --}}</th>
                                        <th>ผลต่าง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($customer_api))
                                        @php 
                                            $count_1 = count($customer_api[$year_1]);
                                            $count_2 = count($customer_api[$year_2]);

                                            if($count_1 > $count_2){
                                                $customer_count = $customer_api[$year_1];
                                                $compare_year = $year_2;
                                            }else{
                                                $customer_count = $customer_api[$year_2];
                                                $compare_year = $year_1;
                                            }

                                            // dd($customer_api[$year_1], $customer_api[$year_2]);

                                        @endphp

                                        @foreach($customer_count as $key => $customer)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $customer['identify'] }}</td>
                                                <td>{{ $customer['name'] }}</td>
                                                <td>{{ $customer['sales_th'] }}</td>
                                                <td>
                                                    @foreach($customer_api[$compare_year] as $customer_2)
                                                        @if($customer_2['identify'] == $customer['identify'])
                                                            {{ $customer_2['sales_th'] }}
                                                            @php 
                                                                $cust_diff = $customer_2['sales'] - $customer['sales'];
                                                                $persent_diff = ($cust_diff*100)/$customer['sales'];
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ number_format($cust_diff,2) }}</td>
                                                <td>{{ number_format($persent_diff) }}</td>
                                            </tr>
                                            @php 
                                                $cust_diff = 0;
                                                $persent_diff = 0 ;
                                            @endphp
                                        @endforeach

                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            ข้อมูลสิ้นสุด ณ วันที่ 
                            @php 
                                list($lat_year, $lat_month, $lat_day) = explode("-",$trans_last_date);
                                $lat_year_thai = $lat_year+543;
                                $trans_last_date = $lat_day."/".$lat_month."/".$lat_year_thai;
                            @endphp
                            {{ $trans_last_date }}
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
});


</script>