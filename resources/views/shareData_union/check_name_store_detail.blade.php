<!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">ทะเบียนลูกค้า</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดร้านค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        {{-- <div class="hk-pg-header mb-10">
            <div>
                <h4 class="topichead-bgred"><span class="pg-title-icon"><i class="ion ion-md-people"></i></span>รายละเอียดร้านค้า</h4>
            </div>
            <div class="d-flex">
                <a href="javascript:history.back();" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div> --}}

        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i class="ion ion-md-document"></i> รายละเอียดร้านค้า</div>
            <div class="content-right d-flex">
                {{-- <button class="btn btn-green btn-sm" data-toggle="modal" data-target="#addCustomer"> + เพิ่มใหม่ </button> --}}
                <a href="javascript:history.back();" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

        {{-- <h4 class="topichead-bgred"><span class="pg-title-icon"><i class="ion ion-md-people"></i></span>รายละเอียดร้านค้า</h4> --}}

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">

                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                            @if($customer_shop['code'] == 200)
                                @php
                                    $customer_shop = $customer_shop['data'][0];

                                    /* ดึงรายชื่อผู้แทนขาย */
                                    $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER").'/sellers/'.$customer_shop['SellerCode']);
                                    $res_api = $response->json();

                                    if($res_api['code'] == "200"){
                                        $SellerCode = $res_api['data'][0];
                                        $salename = $SellerCode['name'];
                                    }else{

                                        if(!is_null($customer_shop['SellerCode'])){
                                            $salename = $customer_shop['SellerCode'];
                                        }else{
                                            $salename = "-";
                                        }
                                    }

                                @endphp
                                <div class="col-md-5">
                                    @if(isset($customer_shop['image_url']) && !is_null($customer_shop['image_url']))
                                        <img src="{{ $customer_shop['image_url'] }}" style="max-width:100%">
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>ข้อมูลร้านค้า</h5>
                                            <div class="col-12 my-3">
                                                <p>ชื่อร้าน : {{ $customer_shop['title'] }} {{ $customer_shop['name'] }}</p>
                                                <p>{{ $customer_shop['address1'] }}
                                                    {{ $customer_shop['adrress2'] }}
                                                    {{ $customer_shop['postal_id'] }}
                                                </p>
                                            </div>
                                            <h5>การติดต่อ</h5>
                                            <div class="col-12 my-3">
                                                <p>ชื่อผู้ติดต่อ : {{ $customer_shop['contact'] }} </p>
                                                <p>เบอร์โทร : {{ $customer_shop['telephone'] }} </p>
                                            </div>
                                            <h5>ผู้แทนขาย</h5>
                                            <div class="col-12 my-3">
                                                <p>{{ $salename }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <div class="col-12 my-5" style="text-align:center;">
                                        <h4>{{ $customer_shop['data'] }}</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Row -->

    </div>

    <!-- /Container -->
    </div>


<script>

    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }

    function showselectdate(){
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }

</script>
