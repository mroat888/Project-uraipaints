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
                                    <a href="{{ url($url_report_total) }}" class="nav-link" style="background: rgb(5, 90, 97); color:rgb(255, 255, 255);">ยอดขายตามหมวดสินค้า</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url($url_report_group) }}" class="nav-link" style="color: rgb(22, 21, 21);">เปรียบเทียบตาม Group</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ค้นหารายงานสรุปยอด</h5>
                        </div>
                        <div class="col-sm-12 col-md-6" style="text-align:right">

                        </div>
                    </div>
                    <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-8" style="text-align:right "></div>
                        <div class="col-sm-12 col-md-4" style="text-align:right ">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <select name="sel_year" id="sel_year" class="form-control">
                                        <option value="">--ค้นหาปี--</option>
                                        @php
                                            list($year,$month,$day) = explode('-', date('Y-m-d'));
                                        @endphp

                                        @for($i = 0; $i<3; $i++)
                                            @php
                                                $year_thai = $year-$i + 543;
                                            @endphp
                                            <option value="{{ $year-$i}}">{{ $year_thai}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-teal btn-sm px-3 ml-2">ค้นหา</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-row">
                                <div class="form-inline col-md-12">
                                    <div class="col-4 form-group mb-2">
                                        <label for="sel_group" class="col-form-label">Group</label>
                                        <select id="sel_group" name="sel_group[]" class="select2 sel_group form-control" multiple="multiple">
                                            @foreach($group_api as $group)
                                                <option value="{{ $group['identify'] }}">{{ $group['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4 form-group mb-2">
                                        <label for="sel_subgroup" class="col-form-label">Subgroup</label>
                                        <select name="sel_subgroup[]" class="select2 sel_subgroup form-control"  multiple="multiple">
                                        </select>
                                    </div>

                                    <div class="col-4  form-group mb-2">
                                        <label for="sel_group" class="col-form-label">Product List</label>
                                        <select name="sel_productlist[]" class="select2 sel_productlist form-control"  multiple="multiple">
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    </form>
                </section>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <!-- <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">ตารางรายงานสรุปยอดทั้งปี</h5>
                        </div>
                        <div class="col-sm-12 col-md-6" style="text-align:right">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr style="text-align:center">
                                            <th rowspan="2">#</th>
                                            <th colspan="6" style="text-align:center;">รายงานสรุปยอด</th>
                                        </tr>

                                        <tr style="text-align:center">
                                            <th>ปี</th>
                                            <th>จำนวนร้านค้า</th>
                                            <th>ยอดขายรวม</th>
                                            <th>ยอดคืนรวม</th>
                                            <th>ยอดขายสุทธิ</th>
                                            <th>เปอร์เซ็นต์คืน</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div> -->
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title">รายงานสินค้าตามหมวดสินค้า</h5>
                        </div>
                        <div class="col-sm-12 col-md-6" style="text-align:right">
                            <!-- -- Tab ---- -->
                            <button type="button" id="btn_group" onclick="swith_div('#div_table_group');" class="btn btn-primary btn-sm">Group</button>
                            <button type="button" id="btn_subgroup" onclick="swith_div('#div_table_subgroup');" class="btn btn-warning btn-sm">SubGroup</button>
                            <button type="button" id="btn_productlist" onclick="swith_div('#div_table_ProductList');" class="btn btn-success btn-sm">ProductList</button>
                            <!-- --- Tab --- -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <div id="div_table_group">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="9" style="text-align:center;" class="bg-primary text-white">สินค้า TOP Group</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align:center;">#</th>
                                                <th style="text-align:center;">รหัส Group</th>
                                                <th>ชื่อ Group</th>
                                                <th style="text-align:center;">จำนวนร้านค้า</th>
                                                <th style="text-align:right;">ยอดขายรวม</th>
                                                <th style="text-align:right;">% ยอดขาย</th>
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($grouptop_api['code'] == 200)
                                            @php
                                                // dd($grouptop_api);
                                            @endphp
                                            @foreach($grouptop_api['data'] as $key => $value)
                                                @php
                                                    $sum_group_sales = $summary_group_api['sum_group_sales'];
                                                    $sale = $value['sales'];
                                                    $persent_sale = ($sale*100)/$sum_group_sales;

                                                    if(isset($value['pdgroup_id'])){
                                                        $pdgroup_id = $value['pdgroup_id'];
                                                    }elseif(isset($value['identify'])){
                                                        $pdgroup_id = $value['identify'];
                                                    }else{
                                                        $pdgroup_id = "";
                                                    }

                                                    if(isset($value['pdgroup_name'])){
                                                        $pdgroup_name = $value['pdgroup_name'];
                                                    }elseif(isset($value['name'])){
                                                        $pdgroup_name = $value['name'];
                                                    }else{
                                                        $pdgroup_name = "";
                                                    }

                                                @endphp
                                                @if($key < 15)
                                                    <tr>
                                                        <td style="text-align:center;">{{ ++$key }}</td>
                                                        <td style="text-align:center;">{{ $pdgroup_id }}</td>
                                                        <td>{{ $pdgroup_name }}</td>
                                                        <td style="text-align:center;">{{ number_format($value['customers']) }}</td>
                                                        <td style="text-align:right;">{{ number_format($sale,2) }}</td>
                                                        <td style="text-align:right;">{{ number_format($persent_sale,2) }}%</td>
                                                        <td style="text-align:center;">
                                                            @php
                                                                $pathurl = url($path_detail).'/pdgroups/'.$value['year']."/".$pdgroup_id;
                                                            @endphp
                                                            <a href="{{ $pathurl }}" class="btn btn-icon btn-purple mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @if($key == 10)
                                                    <tr class="btn_underten" rel="1">
                                                        <td colspan="8" class="bg-primary text-white" style="text-align:center;">
                                                            ดูรายการอื่นเพิ่มเติม
                                                        </td>
                                                    </tr>
                                                    @endif

                                                    <tr class="underten" rel="1">
                                                        <td style="text-align:center;">{{ ++$key }}</td>
                                                        <td style="text-align:center;">{{ $pdgroup_id }}</td>
                                                        <td>{{ $pdgroup_name }}</td>
                                                        <td style="text-align:center;">{{ number_format($value['customers']) }}</td>
                                                        <td style="text-align:right;">{{ number_format($sale,2) }}</td>
                                                        <td style="text-align:right;">{{ number_format($persent_sale,2) }}%</td>
                                                        <td style="text-align:center;">
                                                            @php
                                                                $pathurl = url($path_detail).'/pdgroups/'.$value['year']."/".$pdgroup_id;
                                                            @endphp
                                                            <a href="{{ $pathurl }}" class="btn btn-icon btn-purple mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot style="font-weight: bold; text-align:center">
                                            <td colspan="3" style="text-align:center;">ทั้งหมด</td>
                                            <td class="text-success">{{ number_format($summary_group_api['sum_group_customers'],0) }}</td>
                                            <td class="text-success" style="text-align:right;">{{ number_format($summary_group_api['sum_group_sales'],2) }}</td>
                                            <td class="text-danger" style="text-align:right;">{{ number_format(100) }}%</td>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                </div>

                                <div id="div_table_subgroup" style="display:none">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="9" style="text-align:center;" class="bg-warning text-white">สินค้า TOP Sub Group</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align:center;">#</th>
                                                <th style="text-align:center;">รหัส SubGroup</th>
                                                <th>ชื่อ SubGroup</th>
                                                <th style="text-align:center;">จำนวนร้านค้า</th>
                                                <th style="text-align:right;">ยอดขายรวม</th>
                                                <th style="text-align:right;">% ยอดขาย</th>
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($subgrouptop_api['code'] == 200)
                                            @foreach($subgrouptop_api['data'] as $key => $value)
                                                @php
                                                    $sum_subgroup_sales = $summary_subgroup_api['sum_subgroup_sales'];
                                                    $sale = $value['sales'];
                                                    $persent_sale = ($sale*100)/$sum_subgroup_sales;

                                                    if(isset($value['subgroup_id'])){
                                                        $subgroup_id = $value['subgroup_id'];
                                                    }elseif(isset($value['identify'])){
                                                        $subgroup_id = $value['identify'];
                                                    }else{
                                                        $subgroup_id = "";
                                                    }

                                                    if(isset($value['subgroup_name'])){
                                                        $subgroup_name = $value['subgroup_name'];
                                                    }elseif(isset($value['name'])){
                                                        $subgroup_name = $value['name'];
                                                    }else{
                                                        $subgroup_name = "";
                                                    }

                                                @endphp
                                                @if($key < 10)
                                                    <tr>
                                                        <td style="text-align:center;">{{ ++$key }}</td>
                                                        <td style="text-align:center;">{{ $subgroup_id }}</td>
                                                        <td>{{ $subgroup_name }}</td>
                                                        <td style="text-align:center;">{{ number_format($value['customers']) }}</td>
                                                        <td style="text-align:right;">{{ number_format($sale,2) }}</td>
                                                        <td style="text-align:right;">{{ number_format($persent_sale,2) }}%</td>
                                                        <td style="text-align:center;">
                                                            @php
                                                                $pathurl = url($path_detail).'/pdsubgroups/'.$value['year']."/".$subgroup_id;
                                                            @endphp
                                                            <a href="{{ $pathurl }}" class="btn btn-icon btn-purple mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @if($key == 10)
                                                    <tr class="btn_underten" rel="2">
                                                        <td colspan="8" class="bg-warning text-white" style="text-align:center;">
                                                            ดูรายการอื่นเพิ่มเติม
                                                        </td>
                                                    </tr>
                                                    @endif

                                                    <tr class="underten" rel="2">
                                                        <td style="text-align:center;">{{ ++$key }}</td>
                                                        <td style="text-align:center;">{{ $subgroup_id }}</td>
                                                        <td>{{ $subgroup_name }}</td>
                                                        <td style="text-align:center;">{{ number_format($value['customers']) }}</td>
                                                        <td style="text-align:right;">{{ number_format($sale,2) }}</td>
                                                        <td style="text-align:right;">{{ number_format($persent_sale,2) }}%</td>
                                                        <td style="text-align:center;">
                                                            @php
                                                                $pathurl = url($path_detail).'/pdsubgroups/'.$value['year']."/".$subgroup_id;
                                                            @endphp
                                                            <a href="{{ $pathurl }}" class="btn btn-icon btn-purple mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot style="font-weight: bold; text-align:center">
                                            <td colspan="3" style="text-align:center">ทั้งหมด</td>
                                            <td class="text-success">{{ number_format($summary_subgroup_api['sum_subgroup_customers'],0) }}</td>
                                            <td class="text-success" style="text-align:right;">{{ number_format($summary_subgroup_api['sum_subgroup_sales'],2) }}</td>
                                            <td class="text-danger" style="text-align:right;">{{ number_format(100) }}%</td>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                </div>

                                <div id="div_table_ProductList" style="display:none">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="9" style="text-align:center;" class="bg-success text-white">สินค้า TOP ProductList</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align:center;">#</th>
                                                <th style="text-align:center;">รหัสสินค้า</th>
                                                <th>ชื่อสินค้า</th>
                                                <th style="text-align:center;">จำนวนร้านค้า</th>
                                                <th style="text-align:right;">ยอดขายรวม</th>
                                                <th style="text-align:right;">% ยอดขาย</th>
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($pdlisttop_api['code'] == 200)
                                            @foreach($pdlisttop_api['data'] as $key => $value)
                                                @php
                                                    $sum_pdlist_sales = $summary_pdlist_api['sum_pdlist_sales'];
                                                    $sale = $value['sales'];
                                                    $persent_sale = ($sale*100)/$sum_pdlist_sales;

                                                    if(isset($value['pdlist_id'])){
                                                        $pdlist_id = $value['pdlist_id'];
                                                    }elseif(isset($value['identify'])){
                                                        $pdlist_id = $value['identify'];
                                                    }else{
                                                        $pdlist_id = "";
                                                    }

                                                    if(isset($value['pdlist_name'])){
                                                        $pdlist_name = $value['pdlist_name'];
                                                    }elseif(isset($value['name'])){
                                                        $pdlist_name = $value['name'];
                                                    }else{
                                                        $pdlist_name = "";
                                                    }

                                                @endphp
                                                @if($key < 10)
                                                    <tr>
                                                        <td style="text-align:center;">{{ ++$key }}</td>
                                                        <td style="text-align:center;">{{ $pdlist_id }}</td>
                                                        <td>{{ $pdlist_name }}</td>
                                                        <td style="text-align:center;">{{ number_format($value['customers']) }}</td>
                                                        <td style="text-align:right;">{{ number_format($sale,2) }}</td>
                                                        <td style="text-align:right;">{{ number_format($persent_sale,2) }}%</td>
                                                        <td style="text-align:center;">
                                                            @php
                                                                $pathurl = url($path_detail).'/pdlists/'.$value['year']."/".$pdlist_id;
                                                            @endphp
                                                            <a href="{{ $pathurl }}" class="btn btn-icon btn-purple mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @if($key == 10)
                                                    <tr class="btn_underten" rel="3">
                                                        <td colspan="8" class="bg-success text-white" style="text-align:center;">
                                                            ดูรายการอื่นเพิ่มเติม
                                                        </td>
                                                    </tr>
                                                    @endif

                                                    <tr class="underten" rel="3">
                                                        <td style="text-align:center;">{{ ++$key }}</td>
                                                        <td style="text-align:center;">{{ $pdlist_id }}</td>
                                                        <td>{{ $pdlist_name }}</td>
                                                        <td style="text-align:center;">{{ number_format($value['customers']) }}</td>
                                                        <td style="text-align:right;">{{ number_format($sale,2) }}</td>
                                                        <td style="text-align:right;">{{ number_format($persent_sale,2) }}%</td>
                                                        <td style="text-align:center;">
                                                            @php
                                                                $pathurl = url($path_detail).'/pdlists/'.$value['year']."/".$pdlist_id;
                                                            @endphp
                                                            <a href="{{ $pathurl }}" class="btn btn-icon btn-purple mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot style="font-weight: bold; text-align:center">
                                            <td colspan="3" style="text-align:center">ทั้งหมด</td>
                                            <td class="text-success">{{ number_format($summary_pdlist_api['sum_pdlist_customers'],0) }}</td>
                                            <td class="text-success" style="text-align:right;">{{ number_format($summary_pdlist_api['sum_pdlist_sales'],2) }}</td>
                                            <td class="text-danger" style="text-align:right;">{{ number_format(100) }}%</td>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <!-- /Row -->
    </div>

<style>
    .underten{
        display:none;
    }
</style>

<script>

    $(document).on('select2:select','#sel_group', function(e){
        var data = e.params.data;
        let group_id = data.id;
        // var group_id = $(e.target).val(); //-- multi
        // $('.sel_subgroup').children().remove().end();
        // $('.sel_productlist').children().remove().end();
        console.log(group_id);
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_subgroups") }}/'+group_id,
            datatype: 'json',
            success: function(response){
                //alert(response.AMPHUR_NAME);
                if(response.status == 200){
                    console.log(response);
                    // $('.sel_subgroup').append('<option selected value="">--Subgroup--</option>');
                    // $('.sel_productlist').append('<option selected value="">--Product List--</option>');

                    $.each(response.subgroups, function(key, value){
                        $('.sel_subgroup').append('<option value='+value.identify+'>'+value.name+'</option>')	;
                    });
                }
            }
        });
    });

    $(document).on('select2:select','.sel_subgroup', function(e){
        var data = e.params.data;
        let subgroup_id = data.id;
        // $('.sel_productlist').children().remove().end();
        console.log(subgroup_id);
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_pdglists") }}/'+subgroup_id,
            datatype: 'json',
            success: function(response){
                // console.log(response);
                if(response.status == 200){
                    // $('.sel_productlist').append('<option selected value="">--Product List--</option>');

                    $.each(response.pdglists, function(key, value){
                        $('.sel_productlist').append('<option value='+value.identify+'>'+value.name+'</option>')	;
                    });
                }
            }
        });
    });


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
<<<<<<< HEAD
=======


>>>>>>> 2f32830abcfba5447214e398f1be4cfddd31f917
