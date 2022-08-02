
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
        </div>
        <!-- /Title -->
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <ul class="nav nav-pills nav-fill bg-light pa-10 mb-40" role="tablist">
                                <li class="nav-item">
                                    <a href="{{ url($url_report_total) }}" class="nav-link" style="color: rgb(22, 21, 21);">ยอดขายตามหมวดสินค้า</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url($url_report_group) }}" class="nav-link" style="background: rgb(5, 90, 97); color:rgb(255, 255, 255);">เปรียบเทียบตาม Group</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-25">
                        <div class="col-sm-12 col-md-2">
                            <h5 class="hk-sec-title">เปรียบเทียบตามกลุ่มสินค้า</h5>
                        </div>
                        <div class="col-sm-12 col-md-10" style="text-align:right">
                            <span class="form-inline pull-right">
                                    <!-- เงื่อนไขการค้นหา -->
                                <form action="{{ url($action_search) }}" method="post">
                                    @csrf

                                    @if(Auth::user()->status > 1) <!-- เฉพาะสิทธ์ผู้จัดการและแอดมิน -->
                                        @if(count($team_sales) >= 1)
                                        <select name="selectteam_sales" class="form-control mr-2">
                                            <option value="">เลือกทีม</option>
                                            @foreach($team_sales as $team)
                                                @php 
                                                    $selected = '';
                                                    if(isset($sel_team_sales) && $sel_team_sales != ""){
                                                        if($sel_team_sales == $team->team_api){
                                                            $selected = 'selected';
                                                        }
                                                    }
                                                @endphp
                                                <option value="{{ $team->team_api }}" {{ $selected }}>{{ $team->team_name }}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    @endif

                                    @if(Auth::user()->status > 1)  <!-- เฉพาะสิทธ์ผู้จัดการและแอดมิน -->
                                    <select name="selectusers" class="form-control mr-2">
                                        <option value="">ผู้แทนขาย</option>
                                        @foreach($users as $user)
                                            @php 
                                                $selected = '';
                                                if(isset($sel_users) && $sel_users != ""){
                                                    if($sel_users == $user->api_identify){
                                                        $selected = 'selected';
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $user->api_identify }}" {{ $selected }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @endif

                                    @php 
                                        $month_array = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 
                                        'เมษายน', 'พฤษภาคม' ,'มิถุนายน', 'กรกฎาคม', 
                                        'สิงหาคม' ,'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม']
                                    @endphp 
                                    <select name="sel_month_form" id="sel_month_form" class="form-control mr-2">
                                        <option value="">--เลือกเดือน--</option>
                                        <?php
                                            $noindex = 0;
                                            for($i = 0; $i<count($month_array); $i++){
                                                $noindex++;
                                                if(isset($sel_month)){
                                                    if($sel_month == $noindex){
                                                        $selected = 'selected';
                                                    }else{
                                                        $selected = '';
                                                    }
                                                }
                                        ?>
                                                <option value="{{ $noindex }}" {{ $selected }}>
                                                    {{ $month_array[$i] }}
                                                </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <span id="selectdate" >
                                        เทียบระหว่างปี
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

                                        กับปี

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

                                        <button style="margin-left:5px; margin-right:5px;" class="btn btn-success" id="submit_request">ค้นหา</button>
                                    </span>
                                </form>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <section class="hk-sec-wrapper">
                                <div class="row mb-2">
                                    <div class="col-sm-12 col-md-6">
                                        <h5 class="hk-sec-title">ตารางรายงานเปรียบเทียบกลุ่มสินค้า</h5>
                                    </div>
                                    <div class="col-sm-12 col-md-6" style="text-align:right">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div id="table_list" class="table-responsive table-color col-md-12">
                                            @php 
                                                $year_1 =  $year_search[0];
                                                $year_2 =  $year_search[1];
                                                $year_thai_1 = $year_1+543;
                                                $year_thai_2 = $year_2+543;
                                            @endphp
                                            <table id="" class="table table-hover">
                                                <thead>
                                                    <tr style="text-align:center">
                                                        <th rowspan="2">#</th>
                                                        <th rowspan="2">รหัส Group</th>
                                                        <th rowspan="2" style="text-align:left;">ชื่อ Group</th>
                                                        <th colspan="3" style="text-align:center;">ยอดขายรวม</th>
                                                        <th rowspan="2">% ผลต่าง</th>
                                                    </tr>

                                                    <tr style="text-align:center">
                                                        <th>ปี {{ $year_thai_1 }}</th>
                                                        <th>ปี {{ $year_thai_2 }}</th>
                                                        <th>ผลต่าง</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if(isset($pdggroup_compare) && !is_null($pdggroup_compare))
                                                    @foreach($pdggroup_compare as $key => $value)
                                                        @php
                                                            if($value['sale_diff'] < 0){
                                                                $text_color = "text-danger";
                                                            }else{
                                                                $text_color = "text-success";
                                                            }
                                                        @endphp
                                                        <tr style="text-align:center">
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $value['pdgroup_id'] }}</td>
                                                            <td style="text-align:left;">{{ $value['pdgroup_name'] }}</td>
                                                            <td style="text-align:right">{{ number_format($value['sales_1'],2) }}</td>
                                                            <td style="text-align:right">{{ number_format($value['sales_2'],2) }}</td>
                                                            <td style="text-align:right" class="{{ $text_color }}">{{ number_format($value['sale_diff'],2) }}</td>
                                                            <td class="{{ $text_color }}">{{ number_format($value['persent_diff'],2) }}</td>
                                                        </tr>
                                                    @endforeach
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
                                      
                </section>
            </div>
        </div>

    </div>


<script>

    $(document).on('click','.btn_underten', function(){
        var rel = $(this).attr("rel");
        $('.underten[rel=' + rel + ']').toggle();
        $('.btn_underten[rel=' + rel + ']').toggle();
    });

    function swith_div(rel){
        $("#div_table_group").hide();
        $("#div_table_subgroup").hide();
        $("#div_table_ProductList").hide();
        console.log(rel);
        $(rel).fadeIn();
    }
</script>

 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>


