<style>
    th {
        border: 1px solid;
    }
</style>
<div class="row">
    <div class="col-sm">
        <div id="table_list" class="table-responsive table-color col-md-12">
            <table id="datable_1" class="table table-hover" >
                <thead>
                    <tr>
                        <th colspan="4" style="text-align:center; border: 1px solid;">รายละเอียดเป้าสินค้าใหม่</th>
                        <th colspan="5" style="text-align:center; border: 1px solid;">ทำได้</th>
                    </tr>

                    <tr style="text-align:center; border: 1px solid;">
                        <th>#</th>
                        <th style="text-align:left;">ชื่อเป้า</th>
                        <th>ระยะเวลา</th>
                        <th>เป้าทั้งหมด</th>
                        <th>เป้าที่ทำได้</th>
                        <th>คิดเป็น%</th>
                        <th>คงเหลือ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $camp_no = 0;
                    @endphp
                    @if(isset($campaign_api))

                        @foreach($campaign_api as $key => $campaign)
                        @php 
                            ++$camp_no;
                            $campaign_api_persent_sale = round($campaign_api_sales[$key]*100/$campaign_api_target[$key]);

                            if($campaign_api_persent_sale >= 100){
                                $text_status = "text-success";
                            }else{
                                $text_status = "text-danger";
                            }
                        @endphp
                        <tr class="tb_camp" rel="{{ $key }}" style="text-align:center;">
                            <td>{{ $camp_no }}</td>
                            <td style="text-align:left;">{{ $campaign_api_description[$key] }}</td>
                            <td>{{ $campaign_api_datetime[$key] }}</td>
                            <td>{{ number_format($campaign_api_target[$key]) }}</td>
                            <td>{{ number_format($campaign_api_sales[$key]) }}</td>
                            <td class="{{ $text_status }}">{{ number_format($campaign_api_persent_sale,2) }}</td>
                            <td class="{{ $text_status }}">{{ number_format($campaign_api_diff[$key]) }}</td>
                            <td style="text-align:center">
                                <a class="btn btn-icon btn-purple tb_camp" rel="{{ $key }}">
                                    <h4 class="btn-icon-wrap tb_camp" style="color: white;" rel="{{ $key }}"><i class="ion ion-md-pie"></i></h4>
                                </a>
                            </td>
                        </tr>
                        <tr class="tb_detail" rel="{{ $key }}">
                            <td colspan="8">
                                <div class="row my-3">
                                    <div class="col-6"><h5>รายละเอียดเป้าสินค้าใหม่ : {{ $campaign_api_description[$key] }}</h5></div>
                                    <!-- <div class="col-6" style="text-align:right;">หน่วยบาท</div> -->
                                </div>
                                <div class="table-responsive-sm">
                                    <table class="table table-sm table-hover table-bordered">
                                        <thead>
                                            <tr style="text-align:center">
                                                <th>#</th>
                                                <th style="text-align:left">ผู้แทนขาย</th>
                                                <th>เป้าทั้งหมด</th>
                                                <th>เป้าที่ทำได้</th>
                                                <th>คงเหลือ</th>
                                                <th>คิดเป็น%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sellers_api[$key] as $key_seller => $sellers)  

                                            @php 
                                                if($sellers['persent_sale'] >= 100){
                                                    $text_status = "text-success";
                                                }else{
                                                    $text_status = "text-danger";
                                                }
                                            @endphp
                                            <tr style="text-align:center">
                                                <td>{{ ++$key_seller }}</td>
                                                <td style="text-align:left">{{ $sellers['identify'] }}&nbsp;&nbsp;{{ $sellers['name'] }}</td>
                                                <td>{{ number_format($sellers['Target']) }}</td>
                                                <td>{{ number_format($sellers['Sales']) }}</td>
                                                <td class="{{ $text_status }}">{{ number_format($sellers['Diff']) }}</td>
                                                <td class="{{ $text_status }}">{{ number_format($sellers['persent_sale'],2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                            <tr class="tb_camp" rel="{{ $key }}">
                                                <td colspan="6" style="text-align:center;">
                                                    <button type="button" class="btn btn-green btn-sm btn-block">ย่อ</button>
                                                </td>
                                            </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            
        </div>
    </div>
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
