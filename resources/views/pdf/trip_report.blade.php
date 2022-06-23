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
        }

    </style>

</head>
<body>

    <table>
        <tr>
            <td style="width:20%">
                <img class="brand-img d-inline-block" src="{{ asset('public/images/logo.png') }}" alt="Uraipaint"
                    style="max-height:30px;" />
            </td>
            <td style="text-align:center;">
                <span style="font-size:25px;"><strong>บริษัท ยู.อาร์ เคมิคอล จำกัด</strong></span>
            </td>
            <td style="width:20%"></td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="text-align:center;">
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
        @if(isset($trip_header))
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

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>