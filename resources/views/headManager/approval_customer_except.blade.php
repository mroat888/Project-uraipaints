@extends('layouts.masterHead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ตรวจสอบลูกค้าใหม</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        @if (session('error'))
        <div class="alert alert-inv alert-inv-warning alert-wth-icon alert-dismissible fade show" role="alert">
            <span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i>
            </span> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>ตรวจสอบลูกค้าใหม่</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">รายชื่อลูกค้าใหม่</h5>
                    <div class="row mb-2">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <!-- เงื่อนไขการค้นหา -->
                                @php 
                                    $action_search = "/head/approvalcustomer-except/search"; //-- action form
                                    if(isset($date_filter)){ //-- สำหรับ แสดงวันที่ค้นหา
                                        $date_search = $date_filter;
                                    }else{
                                        $date_search = "";
                                    }
                                @endphp
                                <form action="{{ url($action_search) }}" method="post">
                                @csrf
                                <div class="hk-pg-header mb-10">
                                    <div class="col-sm-12 col-md-12">
                                        <span class="form-inline pull-right pull-sm-center">
                                            <span id="selectdate">
                                                <select name="selectteam_sales" class="form-control form-control-sm" aria-label=".form-select-lg example">
                                                    <option value="" selected>เลือกทีม</option>
                                                    @php 
                                                        $checkteam_sales = "";
                                                        $checkusers = "";

                                                        if(isset($selectteam_sales)){
                                                            $checkteam_sales = $selectteam_sales;
                                                        }
                                                        if(isset($selectusers)){
                                                            $checkusers = $selectusers;
                                                        }
                                                    @endphp
                                                    @foreach($team_sales as $team)
                                                        @if($checkteam_sales == $team->id)
                                                            <option value="{{ $team->id }}" selected>{{ $team->team_name }}</option>
                                                        @else
                                                            <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <select name="selectusers" class="form-control form-control-sm" aria-label=".form-select-lg example">
                                                    <option value="" selected>ผู้แทนขาย</option>
                                                    @foreach($users as $user)
                                                        @if($checkusers == $user->id)
                                                            <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                                        @else
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                
                                                <!-- ปี/เดือน :  -->
                                                <input type="month" id="selectdateFrom" name="selectdateFrom" 
                                                value="{{ $date_search }}" class="form-control form-control-sm" 
                                                style="margin-left:10px; margin-right:10px;"/>
                                                <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm" id="submit_request">ค้นหา</button>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                @php 
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
                                @endphp
                                <div class="hk-pg-header mb-10">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio1" value="ทั้งหมด" {{ $check_Radio_1 }}>
                                        <label class="form-check-label" for="inlineRadio1">ทั้งหมด</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio2" value="สำเร็จ" {{ $check_Radio_2 }}>
                                        <label class="form-check-label" for="inlineRadio2">สำเร็จ</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio3" value="สนใจ" {{ $check_Radio_3 }}>
                                        <label class="form-check-label" for="inlineRadio3">สนใจ</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio4" value="ไม่สนใจ" {{ $check_Radio_4 }}>
                                        <label class="form-check-label" for="inlineRadio4">ไม่สนใจ</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkRadio" type="radio" name="slugradio" id="inlineRadio5" value="รอตัดสินใจ" {{ $check_Radio_5 }}>
                                        <label class="form-check-label" for="inlineRadio5">รอตัดสินใจ</label>
                                    </div>
                                </div>
                                </form>
                                <!-- จบเงื่อนไขการค้นหา -->
                                
                                @php 
                                    $btn_edit_hide = "display:none;";
                                    $url_customer_detail = "head/approval_customer_except_detail";
                                @endphp
                                @include('union.lead_table')

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
        <!-- /Row -->
    </div>
    <!-- /Container -->

<script type="text/javascript">
    function chkAll(checkbox) {

        var cboxes = document.getElementsByName('checkapprove[]');
        var len = cboxes.length;

        if (checkbox.checked == true) {
            for (var i = 0; i < len; i++) {
                cboxes[i].checked = true;
            }
        } else {
            for (var i = 0; i < len; i++) {
                cboxes[i].checked = false;
            }
        }
    }
</script>

@endsection

@section('scripts')

<script>
    $(document).on('click', '.btn_showplan', function(){
        let plan_id = $(this).val();
        //alert(goo);
        $('#Modalsaleplan').modal("show");
    });

    $(document).on('click', '.checkRadio', function(){
        $("#submit_request").trigger("click");
    });

</script>

<script>
    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }
</script>


{{-- <script type="text/javascript">
    function chkAll(checkbox) {

        var cboxes = document.getElementsByName('checkapprove');
        var len = cboxes.length;

        if (checkbox.checked == true) {
            for (var i = 0; i < len; i++) {
                cboxes[i].checked = true;
            }
        } else {
            for (var i = 0; i < len; i++) {
                cboxes[i].checked = false;
            }
        }
    }
</script> --}}

<script>
    document.getElementById('btn_approve').onclick = function() {
        var markedCheckbox = document.getElementsByName('checkapprove');
        var saleplan_id_p = "";

        for (var checkbox of markedCheckbox) {
            if (checkbox.checked) {
                if (checkbox.value != "") {
                    saleplan_id_p += checkbox.value + ' ,';
                }
            }
        }
        if (saleplan_id_p != "") {
            $('#Modalapprove').modal('show');
            $('#saleplan_id').val(saleplan_id_p);
        } else {
            alert('กรุณาเลือกรายการด้วยค่ะ');
        }
    }

    function showselectdate() {
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate() {
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }

</script>

@endsection