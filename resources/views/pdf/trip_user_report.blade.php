<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
    integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <style>
        @font-face{
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('public/fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face{
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ asset('public/fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face{
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ asset('public/fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face{
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ asset('public/fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body{
            font-family: 'THSarabunNew';
        }

        table{
            width:100%;
            border: 1px solid;
            border-left: 0px;
            border-right: 0px;
            border-bottom: 0px;
            padding-bottom:25px;
        }

        th {
            /* height: 40px; */
        }

        td {
            /* padding: 5px; */
            vertical-align: middle;
        }

        .topic {
            padding-bottom: 15px;
        }

    </style>

</head>
<body>


    <img class="brand-img d-inline-block" src="{{ asset('public/images/logo.png') }}" alt="Uraipaint" style="max-height:30px;" />
    <table>
        <tr>
            <td class="topic" style="text-align:center;" colspan="6">
                <span style="font-size:25px;"><strong>บริษัท ยู.อาร์ เคมิคอล จำกัด</strong></span>
            </td>
        </tr>

        <tr>
            <td style="text-align:center;" colspan="6">
                <span>สรุปใบเบิกค่าเบี้ยเลี้ยง</span>
            </td>
        </tr>

        <tr>
             <td>ชื่อผู้เบิก : {{ $trip_header->name }}</td>
            <td></td>
            <td>รหัสพนักงาน : {{ $trip_header->api_identify }}</td>
            <td>ตำแหน่ง : 
                @php 
                    $master_permission = DB::table('master_permission')->where('id', $trip_header->status)->first();
                    $user_status = "ผู้แทนขาย";
                    if(!is_null($master_permission)){
                        $user_status = $master_permission->permission_name;
                    }else{
                        $user_status = "-";
                    }

                @endphp
                {{ $user_status }}
            </td>
            <td colspan="2">ทริปเดือน :
                @php
                    // list($date_approve_at, $time_approve_at) = explode(' ', $trip_header->request_approve_at);
                    if(!is_null($trip_header->trip_date)){
                        list($year_at, $month_at, $day_at) = explode('-', $trip_header->trip_date);
                        $year_at_thai = $year_at+543;
                        $approve_at = $month_at."/".$year_at_thai;
                    }else{
                        $approve_at = "-";
                    }
                @endphp
                {{ $approve_at }}
            </td>
        </tr>
        <tr>
            {{-- <td>ค่าเบี้ยเลื้ยง</td> --}}
            <td colspan="2">ค่าเบี้ยเลื้ยง &nbsp;&nbsp;&nbsp; จากวันที่ :
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
                <th style="width:8%;">#</th>
                <th style="width:15%;">วันที่</th>
                <th style="width:15%;">จากจังหวัด</th>
                <th style="width:15%;">ถึงจังหวัด</th>
                <th style="width:32%;">ร้านค้า</th>
                <th style="width:15%;">หมายเหตุ</th>
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
                <td style="vertical-align: top;">{{ ++$key }}</td>
                <td style="vertical-align: top;">{{ $trip_detail_date }}</td>
                <td style="vertical-align: top;">{{ $value['trip_from'] }}</td>
                <td style="vertical-align: top;">{{ $value['trip_to'] }}</td>
                <td style="text-align:left; vertical-align: top;"><?php echo nl2br($value['customer_id']); ?></td>
                <td style="vertical-align: top;"></td>
            </tr>
            @endforeach
        @endif
        </tbody>

        <tfoot>
            <tr>
                <td colspan="6">
                    <span>หมายเหตุ : แบบฟอร์มนี้ใช้สำหรับเบิกค่าเบี้ยเลี้ยง</span>
                </td>
            </tr>
            
        </tfoot>
    </table>
    <table>
        <tr>
            <td><span>ผู้ขอเบิก</span></td>
            <td><span>ผู้อนุมัติ</span></td>
        </tr>
        <tr>
            <td><span>ลงชื่อ .......................................................... วันที่ ...............................</span></td>
            <td><span>ลงชื่อ .......................................................... วันที่ ...............................</span></td>
        </tr>
    </table>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
