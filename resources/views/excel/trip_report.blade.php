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
<table style="border: 1px solid rgb(182, 182, 182);">
    <tr style="text-align:center;">
        <th style="border: 1px solid rgb(182, 182, 182);" colspan="2">รหัสพนักงาน</th>
        <th style="border: 1px solid rgb(182, 182, 182);">ชื่อ-นามสกุล</th>
        <th style="border: 1px solid rgb(182, 182, 182);">เบี้ยเลี้ยง/วัน</th>
        <th style="border: 1px solid rgb(182, 182, 182);">จำนวนวันทำงาน</th>
        <th style="border: 1px solid rgb(182, 182, 182);">รวมค่าเบี้ยเลี้ยง</th>
        <th style="border: 1px solid rgb(182, 182, 182);">ยอดโอนเข้าบัญชี</th>
        <th style="border: 1px solid rgb(182, 182, 182);">หมายเหตุ</th>
    </tr>
    
    @php 
        $total_sum_allowance = 0;
    @endphp
    @foreach($trip_header as $key => $value)
        @php 
            $allowance = 0; 
            $sum_allowance = 0;
            if($value->sum_allowance > 0){
                $total_sum_allowance += $value->sum_allowance;
                $sum_allowance = $value->sum_allowance;
            }
            
            if($value->allowance > 0){
                $allowance = $value->allowance;
            }
        @endphp

        <tr style="text-align:center;">
            <td style="border: 1px solid rgb(182, 182, 182);">{{ ++$key }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);">{{ $value->api_employee_id }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);">{{ $value->name }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);">{{ number_format($allowance) }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);">{{ $value->trip_day }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);">{{ number_format($sum_allowance) }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);">{{ number_format($sum_allowance) }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);"></td>
        </tr>
    @endforeach

    <tfoot>
        <tr style="text-align:center;">
            <td style="border: 1px solid rgb(182, 182, 182);" colspan="5">ยอดรวม</td>
            <td style="border: 1px solid rgb(182, 182, 182);">{{ number_format($total_sum_allowance) }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);">{{ number_format($total_sum_allowance) }}</td>
            <td style="border: 1px solid rgb(182, 182, 182);"></td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #FFFFFF; border: none;">
                <strong style="font-size: 18px;">ผู้จัดทำ</strong> <br><br>
                <strong style="font-size: 18px;"> ...................................................
                {{-- <strong style="font-size: 18px;"> <img src="{{ asset('public/upload/UserSignature/img-1655970853.jpg') }}" alt="" width="30%"> --}}
                <br>(พัชรภ อัศวจารุพันธุ์)
                <br>
                <br>......./....../............
                </strong>
                <br>
            </td>
            
            <td colspan="4" style="background-color: #FFFFFF; border: none;">
                <strong style="font-size: 18px;">ผู้อนุมัติ</strong><br><br>
                <strong style="font-size: 18px;"> ...................................................
                    <br>({{ $user_head->name }})
                    <br>ผู้จัดการฝ่าย
                    <br>......./....../............
                    </strong>
                <br>
            </td>
            
        </tr>

    </tfoot>
</table>

