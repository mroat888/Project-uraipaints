<table>
    <tr>
        <td style="width:20%">
            
        </td>
        <td>
            <span style="font-size:25px;"><strong>บริษัท ยู.อาร์ เคมิคอล จำกัด</strong></span>
        </td>
        <td style="width:20%"></td>
    </tr>
</table>
<table>
    <tr>
        <td>
            <span>สรุปใบเบิกค่าเบี้ยเลี้ยง</span>
        </td>
    </tr>
</table>
<table>
        <tr>
            <td colspan="3">ชื่อผู้เบิก : {{ $trip_header->name }}</td>
            <td>รหัสพนักงาน : {{ $trip_header->api_identify }}</td>
            <td>ตำแหน่ง : {{ $trip_header->status }}</td>
            <td>วัน / Date : 
                @php 
                    list($date_approve_at, $time_approve_at) = explode(' ', $trip_header->request_approve_at);
                    list($year_at, $month_at, $day_at) = explode('-', $date_approve_at);
                    $year_at_thai = $year_at+543;
                    $approve_at = $day_at."/".$month_at."/".$year_at_thai;
                @endphp
                {{ $approve_at }}
            </td>
        </tr>
        <tr>
            <td>ค่าเบี้ยเลื้ยง</td>
            <td>จากวันที่ : 
                @php 
                    list($year_start, $month_start, $day_start) = explode('-', $trip_header->trip_start);
                    $year_start_thai = $year_start+543;
                    $trip_start = $day_start."/".$month_start."/".$year_start_thai;
                @endphp
                {{ $trip_start }}
            </td>
            <td>ถึงวันที่ : 
                @php 
                    list($year_end, $month_end, $day_end) = explode('-', $trip_header->trip_end);
                    $year_end_thai = $year_end+543;
                    $trip_end = $day_end."/".$month_end."/".$year_end_thai;
                @endphp
                {{ $trip_end }}
            </td>
            <td>อัตราเบี้ยเลี้ยง/วัน : {{ number_format($trip_header->allowance) }}</td>
            <td>จำนวนวัน : {{ $trip_header->trip_day }}</td>
            <td>รวมค่าเบี้ยเลี้ยง : {{ number_format($trip_header->sum_allowance) }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>วันที่</th>
                <th>จากจังหวัด</th>
                <th>ถึงจังหวัด</th>
                <th>ร้านค้า</th>
                <th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
        @if(isset($trip_detail))
            @foreach($trip_detail as $key => $value)
                @php 
                    list($year_date, $month_date, $day_date) = explode("-", $value['trip_detail_date']);
                    $year_date_thai = $year_date+543;
                    $trip_detail_date = $day_date."/".$month_date."/".$year_date_thai;
                @endphp
            <tr style="text-align:center;">
                <td>{{ ++$key }}</td>
                <td>{{ $trip_detail_date }}</td>
                <td>{{ $value['trip_from'] }}</td>
                <td>{{ $value['trip_to'] }}</td>
                <td>{{ $value['customer_id'] }}</td>
                <td></td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <table>
        <tr>
            <td>
                <span>หมายเหตุ : แบบฟอร์มนี้ใช้สำหรับเบิกค่าเบี้ยเลี้ยง</span>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td><span>ผู้ขอเบิก</span></td>
            <td><span>ผู้ขออนุมัติ</span></td>
        </tr>
        <tr>
            <td><span>ลงชื่อ .......................................................... วันที่ ...............................</span></td>
            <td><span>ลงชื่อ .......................................................... วันที่ ...............................</span></td>
        </tr>
    </table>
