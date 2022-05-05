@extends('layouts.master')

@section('content')

    @php 

        $action_search = "/lead/search"; //-- action form
        if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
            $date_search = $date_filter;
        }else{
            $date_search = "";
        }

        // -- เงื่อนไขค้นหา แทป --
        $check_Radio_1 = "";
        $check_Radio_2 = "";
        $check_Radio_3 = "";
        $check_Radio_4 = "";
        $check_Radio_5 = "";
        if(isset($slugradio_filter)){
            switch($slugradio_filter){
                case "สำเร็จ" : $check_Radio_2 = "checked";
                    break;
                case "สนใจ" : $check_Radio_3 = "checked";
                    break;
                case "ไม่สนใจ" : $check_Radio_4 = "checked";
                    break;
                case "รอตัดสินใจ" : $check_Radio_5 = "checked";
                    break;
                default : $check_Radio_1 = "checked";
            }
        }else{
            $check_Radio_1 = "checked";
        }

        // -- จบ เงื่อนไขค้นหา แทป --
        

    @endphp

    @include('union.lead');

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')



