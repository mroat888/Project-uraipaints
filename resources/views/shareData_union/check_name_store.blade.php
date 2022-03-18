
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ตรวจสอบรายชื่อร้านค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="clipboard"></i></span></span>ตรวจสอบรายชื่อร้านค้า</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ตารางข้อมูลรายชื่อร้านค้า</h5>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <!-- ------ -->
                                        <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <span class="form-inline pull-right pull-sm-center">
                                                <select name="province" id="province" class="form-control province" style="margin-left:5px; margin-right:5px;" required>
                                                    <option value="" selected>เลือกจังหวัด</option>
                                                    @if($provinces['code'] == 200)
                                                        @foreach($provinces['data'] as $key => $value)
                                                            <option value="{{ $value['identify'] }}">{{ $value['name_thai'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                <select name="amphur" id="amphur" class="form-control amphur" style="margin-left:5px; margin-right:5px;">
                                                    <option value="" selected>เลือกอำเภอ</option>
                                                </select>
                                                จำนวนเป้า
                                                <input type="number" name="campaign_count" style="width:80px;" class="form-control amphur">

                                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm">ค้นหา</button>

                                            </span>
                                        </form>
                                        <!-- ------ -->
                                    </div>
                                </div>
                                <div id="table_list" class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="font-weight: bold;">#</th>
                                                <th style="font-weight: bold;">ชื่อร้าน</th>
                                                <th style="font-weight: bold;">ที่อยู่</th>
                                                <th style="font-weight: bold;">จำนวนวันสำคัญ<br />ในเดือน (วัน)</th>
                                                <th style="font-weight: bold;">จำนวนวันสำคัญ<br />รวม (วัน)</th>
                                                <th style="font-weight: bold;">จำนวนเป้าที่ซื้อในปี</th>
                                                <th style="font-weight: bold;">ยอดเป้ารวม</th>
                                                <th style="font-weight: bold;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            @php 
                                                @$row = count($customer_api)
                                            @endphp

                                            @foreach ($customer_api as $key => $value)
                                                <tr>
                                                    <td>{{ $customer_api[$key]['identify'] }}</td>
                                                    <td>{{ $customer_api[$key]['shopname'] }}</td>
                                                    <td>{{ $customer_api[$key]['address'] }}</td>
                                                    <td>{{ $customer_api[$key]['InMonthDays'] }}</td>
                                                    <td>{{ $customer_api[$key]['TotalDays'] }}</td>
                                                    <td>{{ $customer_api[$key]['TotalCampaign'] }}</td>
                                                    <td>{{ number_format($customer_api[$key]['TotalLimit'],2) }}</td>
                                                    <td>
                                                        @php
                                                            $pathurl = url($path_detail).'/'.$customer_api[$key]['identify'];
                                                        @endphp
                                                        <a href="{{ $pathurl }}" class="btn btn-icon btn-success mr-10">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                    </td>
                                                </tr>
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
    <!-- /Container -->

    <script>

function displayMessage(message) {
    $(".response").html("<div class='success'>" + message + "</div>");
    setInterval(function() {
        $(".success").fadeOut();
    }, 1000);
}

function showselectdate(){
    $("#selectdate").css("display", "block");
    $("#bt_showdate").hide();
}

function hidetdate(){
    $("#selectdate").css("display", "none");
    $("#bt_showdate").show();
}

$(document).on('change','.province', function(e){
    e.preventDefault();
    let pvid = $(this).val();
    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_amphur_api") }}/'+pvid,
        datatype: 'json',
        success: function(response){
            if(response.status == 200){
                console.log(response.amphures['data']);
                $('.amphur').children().remove().end();
                $('.amphur').append('<option selected value="">เลือกอำเภอ</option>');
                let rows = response.amphures['data'].length;
                for(let i=0 ;i<rows; i++){
                    $('.amphur').append('<option value="'+response.amphures['data'][i]['identify']+'">'+response.amphures['data'][i]['name_thai']+'</option>');
                }
            }
        }
    });
});

</script>
