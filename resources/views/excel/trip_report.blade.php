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
    <tr style="text-align:center;">
        <th>#</th>
        <th>วันที่ขออนุมัติ</th>
        <th>จาก</th>
        <th>ถึง</th>
        <th>ชื่อ</th>
        <th>ตำแหน่ง</th>
        <th>จำนวนวัน</th>
        <th>เบี้ยเลี้ยง</th>
        <th>สถานะ</th>
    </tr>
    @if($trip_header != "")
        @foreach($trip_header as $key => $value)
            @php 
                list($date_approve, $time_approve) = explode(" ", $value->approve_at);

                switch($value->status){
                    case 1 : $user_level = "ผู้แทนขาย";
                        break;
                    case 2 : $user_level = "ผู้จัดการเขต";
                        break;
                    case 3 : $user_level = "ผู้จัดการฝ่าย";
                        break;
                }
                switch($value->trip_status){
                    case 2 : $trip_status = "อนุมัติ";
                        break;
                    case 3 : $trip_status = "ปฎิเสธ";
                        break;
                    case 4 : $trip_status = "ปิดทริป";
                        break;
                }
            @endphp
        <tr style="text-align:center;">
            <td>{{ ++$key }}</td>
            <td>{{ $date_approve }}</td>
            <td>{{ $value->trip_start }}</td>
            <td>{{ $value->trip_end }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $user_level }}</td>
            <td>{{ $value->trip_day }}</td>
            <td>{{ number_format($value->sum_allowance) }}</td>
            <td>{{ $trip_status }}</td>
        </tr>
        @endforeach
    @endif

</table>