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
            /* border: 1px solid rosybrown; */
        }

    </style>

</head>
<body>

    <table>
        <tr>
            <td style="width:20%">
                <img class="brand-img d-inline-block" src="{{ asset('public/images/logo.png') }}" alt="Uraipaint"
                    style="max-height:100px;" />
            </td>
            <td style="text-align:center;">
                <span style="font-size:25px;"><strong>บริษัท ยู.อาร์ เคมิคอล จำกัด</strong></span>
            </td>
            <td style="width:20%"></td>
        </tr>
        <tr>
            <td style="width:20%"></td>
            <td style="text-align:center;">
                <span style="font-size:22px;"><strong>ใบเบิกค่าเบี้ยเลี้ยง ประจำเดือน {{date('M-Y')}}</strong></span>
            </td>
            <td style="width:20%"></td>
        </tr>
    </table>

    <table style="border: 1px solid rgb(182, 182, 182);">
        <tr style="text-align:center;">
            <th style="border: 1px solid rgb(182, 182, 182);" colspan="2">รหัสพนักงาน</th>
            <th style="border: 1px solid rgb(182, 182, 182);">ชื่อ-นามสกุล</th>
            <th style="border: 1px solid rgb(182, 182, 182);">อัตราเบี้ยเลี้ยงต่อวัน</th>
            <th style="border: 1px solid rgb(182, 182, 182);">จำนวนวันทำงาน</th>
            <th style="border: 1px solid rgb(182, 182, 182);">ค่าเบี้ยเลี้ยง (เบี้ยเลี้ยงคำนวนภาษีจำนวนวัน)</th>
            <th style="border: 1px solid rgb(182, 182, 182);">ยอดโอนเข้าบัญชี</th>
            <th style="border: 1px solid rgb(182, 182, 182);">หมายเหตุ</th>
        </tr>
            <tr style="text-align:center;">
                <td style="border: 1px solid rgb(182, 182, 182);">1</td>
                <td style="border: 1px solid rgb(182, 182, 182);">4401</td>
                <td style="border: 1px solid rgb(182, 182, 182);">คุณธนิต กมลจรรยาเลิศ</td>
                <td style="border: 1px solid rgb(182, 182, 182);">950</td>
                <td style="border: 1px solid rgb(182, 182, 182);">15</td>
                <td style="border: 1px solid rgb(182, 182, 182);">14,250</td>
                <td style="border: 1px solid rgb(182, 182, 182);">14,250</td>
                <td style="border: 1px solid rgb(182, 182, 182);"></td>
            </tr>
            <tfoot>
                <tr style="text-align:center;">
                    <td style="border: 1px solid rgb(182, 182, 182);" colspan="5">ยอดรวม</td>
                    <td style="border: 1px solid rgb(182, 182, 182);">409,800</td>
                    <td style="border: 1px solid rgb(182, 182, 182);">409,800</td>
                    <td style="border: 1px solid rgb(182, 182, 182);"></td>
                </tr>
            </tfoot>
    </table>

    <div class="mt-5">
        <table style="border: none; text-align: center;">
            <tr>
                <td style="background-color: #FFFFFF; border: none;">
                    <strong style="font-size: 18px;">ผู้จัดทำ</strong> <br><br>
                    <strong style="font-size: 18px;"> ...................................................
                    {{-- <strong style="font-size: 18px;"> <img src="{{ asset('public/upload/UserSignature/img-1655970853.jpg') }}" alt="" width="30%"> --}}
                    <br>(พัชรภ อัศวจารุพันธุ์)
                    <br>
                    <br>......./....../............
                    </strong>
                    <br>
                </td>
                <td style="background-color: #FFFFFF; border: none;">
                    <strong style="font-size: 18px;">ผู้อนุมัติ</strong><br><br>
                    <strong style="font-size: 18px;"> ...................................................
                        <br>(คุณธนิต กมลจรรยาเลิศ)
                        <br>ผู้จัดการฝ่าย
                        <br>......./....../............
                        </strong>
                    <br>
                </td>
            </tr>
        </table>
    </div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
