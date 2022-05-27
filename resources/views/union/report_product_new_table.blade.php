<div class="row">
    <div class="col-sm">
        <div id="table_list" class="table-responsive table-color col-md-12">
            <table id="datable_1" class="table table-hover">
                <thead>
                    <tr>
                        <th colspan="4" style="text-align:center;">รายละเอียดเป้าสินค้าใหม่</th>
                        <th colspan="5" style="text-align:center;">ทำได้</th>
                    </tr>

                    <tr style="text-align:center">
                        <th>#</th>
                        <th>ชื่อเป้า</th>
                        <th>ระยะเวลา</th>
                        <th>เป้าทั้งหมด</th>
                        <th>#</th>
                        <th>ผู้แทนขาย</th>
                        <th>เป้าที่ทำได้</th>
                        <th>คงเหลือ</th>
                        <th>คิดเป็น%</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $no = 0;
                        $no_seller = 0;
                        $no_seller = 0;
                        $check_print = array();

                        $sum_sales = 0;
                    @endphp
                    @foreach($sellers_api as $key_seller => $sellers)  
                        @php 
                            $no_seller = $no_seller+1 ;
                        @endphp
                        @if(count($check_print) > 0)
                            @if(!in_array($sellers['campaign_id'], $check_print))
                            <tr>
                                <!-- <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td> -->
                                <td colspan="6"></td>
                                
                                <td>{{ number_format($sum_sales,2) }}</td>
                                <td>{{ number_format($sum_diff,2) }}</td>
                                <td>%</td>
                            </tr>
                                @php 
                                    $no_seller = 1;
                                @endphp
                            @endif
                        @endif                             
                    <tr>
                        @php
                        
                            if(in_array($sellers['campaign_id'], $campaign_api)){

                                if(!in_array($sellers['campaign_id'], $check_print)){
                                    $no = $no+1;
                                    $no_number = $no;
                                    $campaign_description = $sellers['description'];
                                    $campaign_date = $sellers['fromdate']."-".$sellers['todate'];
                                    
                                    $key_campaign_api = array_search($sellers['campaign_id'], $campaign_api);
                                    $campaign_target = $campaign_api_target[$key_campaign_api];

                                    $check_print[] = $sellers['campaign_id'];

                                    $sum_sales = 0;
                                    $sum_diff = 0;

                                }else{
                                    $campaign_description = "";
                                    $campaign_date = "";
                                    $campaign_target = "";
                                    $no_number = "";
                                }

                                $sum_sales += $sellers['Sales'];
                                $sum_diff += $sellers['Diff'];
                            }

                        @endphp

                        <td>{{ $no_number }}</td>
                        <td>{{ $campaign_description }}</td>
                        <td>{{ $campaign_date }}</td>
                        <td>
                            @if($campaign_target != "")
                                {{ number_format($campaign_target) }}
                            @endif
                        </td>

                        <td>{{ $no_seller }}</td>
                        <td>{{ $sellers['name'] }}</td>
                        <td>{{ number_format($sellers['Sales'],2) }}</td>
                        <td>{{ number_format($sellers['Diff'],2) }}</td>
                        <td>{{ number_format($sellers['persent_diff'],2) }}</td>
                    </tr>
                    @endforeach
                    
                    
                    @if(count($check_print) == count($campaign_api))
                        <tr>
                            <!-- <td colspan="6"></td> -->
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($sum_sales,2) }}</td>
                            <td>{{ number_format($sum_diff,2) }}</td>
                            <td></td>
                        </tr>
                    @endif
                    
                </tbody>
            </table>
            
        </div>
    </div>
</div>