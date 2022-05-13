
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ทะเบียนลูกค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        {{-- <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="clipboard"></i></span></span>ทะเบียนลูกค้า</h4>
            </div>
        </div> --}}

        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i class="ion ion-md-clipboard"></i> ทะเบียนลูกค้า</div>
            <div class="content-right d-flex"></div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <div class="topichead-bggrey" style="margin-bottom: 30px;">รายชื่อร้านค้า</div>
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
                                        <form action="{{ url($action_search) }}" method="post">
                                            @csrf
                                            <span class="form-inline pull-right pull-sm-center">
                                                <select name="province" id="province" class="form-control province" style="margin-left:5px; margin-right:5px;">
                                                    <option value="" selected>เลือกจังหวัด</option>
                                                    @if(isset($provinces) && !is_null($provinces))
                                                        @foreach($provinces as $key => $value)
                                                            @if(!empty($value['identify']))
                                                                <option value="{{ $value['identify'] }}">{{ $value['name_thai'] }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </select>

                                                <select name="amphur" id="amphur" class="form-control amphur" style="margin-left:5px; margin-right:5px;">
                                                    <option value="" selected>เลือกอำเภอ</option>
                                                </select>
                                                <!-- จำนวนเป้า
                                                <input type="number" name="campaign_count" style="width:80px;" class="form-control amphur"> -->

                                                <button id="btn_search" style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm">ค้นหา</button>
                                            </span>
                                        </form>
                                        <!-- ------ -->
                                    </div>
                                </div>
                                <div id="table_list" class="table-responsive table-color col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr class="table-bggrey">
                                                <th style="font-weight: bold;">#</th>
                                                <th style="font-weight: bold;">รูปภาพ</th>
                                                <th style="font-weight: bold;">รหัสร้าน</th>
                                                <th style="font-weight: bold;">ชื่อร้าน</th>
                                                <th style="font-weight: bold;">ที่อยู่</th>
                                                <th style="font-weight: bold;">เบอร์โทรศัพท์</th>
                                                <th style="font-weight: bold;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            @php
                                                $number = 0;
                                            @endphp

                                            @if(isset($customer_api) && !is_null($customer_api))
                                                @foreach ($customer_api as $key => $customer)
                                                    <tr>
                                                        <td>{{ ++$number }}</td>
                                                        <td>
                                                            @if(isset($customer['image_url']) && !is_null($customer['image_url']))
                                                                <img src="{{ $customer['image_url'] }}" style="max-height:20px;">
                                                            @endif
                                                        </td>
                                                        <td>{{ $customer['identify'] }}</td>
                                                        <td>{{ $customer['title'] }} {{ $customer['name'] }}</td>
                                                        <td>{{ $customer['amphoe_name'] }}, {{ $customer['province_name'] }}</td>
                                                        <td>{{ $customer['telephone'] }}, {{ $customer['mobile'] }}</td>
                                                        <td>
                                                            @php
                                                                $pathurl = url($path_detail).'/'.$customer['identify'];
                                                            @endphp
                                                            <a href="{{ $pathurl }}" class="btn btn-icon btn-purple mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                        </td>
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
    $('#btn_search').prop('disabled', true);
    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_amphur_api") }}/{{ $position_province }}/'+pvid,
        datatype: 'json',
        success: function(response){
            console.log(response);
            $('#btn_search').prop('disabled', false);
            if(response.status == 200){
                console.log(response.amphures);
                $('.amphur').children().remove().end();
                $('.amphur').append('<option selected value="">เลือกอำเภอ</option>');
                let rows = response.amphures.length;
                for(let i=0 ;i<rows; i++){
                    $('.amphur').append('<option value="'+response.amphures[i]['identify']+'">'+response.amphures[i]['name_thai']+'</option>');
                }
            }
        }
    });
});

</script>
