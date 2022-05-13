<!-- Row -->
<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-3">
                    <h5 class="hk-sec-title">รายชื่อร้านค้า (ทำเป้า) ปี {{ $year }}</h5>
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
                                        <select name="province" id="province" class="form-control province" style="margin-left:5px; margin-right:5px;">
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

                                        <select name="year_form_search" id="year_form_search" class="form-control" style="margin-left:5px; margin-right:5px;">
                                            @php 
                                                $year_now = date("Y");
                                                $year_back = $year_now - 1;
                                                $year_form_search = array($year_now, $year_back);
                                            @endphp
                                            @if(isset($year_form_search))
                                                @foreach($year_form_search as $value_year)
                                                    @if($year == $value_year)
                                                        <option value="{{ $value_year }}" selected>{{ $value_year }}</option>
                                                    @else 
                                                        <option value="{{ $value_year }}">{{ $value_year }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        

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
                                        <th style="font-weight: bold;">รหัส</th>
                                        <th style="font-weight: bold;">ชื่อร้าน</th>
                                        <th style="font-weight: bold;">ที่อยู่</th>
                                        <th style="font-weight: bold; text-align:right;">มูลค่าเป้า</th>
                                        <th style="font-weight: bold; text-align:right;">ยอดเบิกเป้า</th>
                                        <th style="font-weight: bold; text-align:right;">%</th>
                                        <th style="font-weight: bold;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                @if(isset($customer_api))
                                    @foreach ($customer_api['data'] as $key => $value)
                                        @php 
                                            $persent_TotalLimit = $value['TotalLimit'] - $value['TotalAmountSale'];
                                            if($persent_TotalLimit < 0){
                                                $text_red = "color:#FF0000;";
                                            }else{
                                                $text_red = "";
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $value['identify'] }}</td>
                                            <td>{{ $value['name'] }}</td>
                                            <td>{{ $value['amphoe_name'] }}, {{ $value['province_name'] }}</td>
                                            <td style="text-align:right;">{{ number_format($value['TotalLimit'],2) }}</td>
                                            <td style="text-align:right;">{{ number_format($value['TotalAmountSale'],2) }}</td>
                                            <td style="text-align:right;">
                                                <span style="{{ $text_red }}">{{ number_format($persent_TotalLimit,2) }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $pathurl = url($path_detail).'/'.$value['identify'];
                                                @endphp
                                                <a href="{{ $pathurl }}" class="btn btn-icon btn-success mr-10">
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

<div class="row">
    <div class="col-md-6">ข้อมูล ณ วันที่ {{ $customer_api['trans_last_date'] }}</div>
    <div class="col-md-6" style="text-align:right;">หน่วย : บาท</div>
</div>

<!-- /Row -->

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
                }
            }
        });
    });

</script>
