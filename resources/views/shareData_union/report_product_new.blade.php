<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานยอดขายสินค้าใหม่</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="file-text"></i> รายงานยอดขายสินค้าใหม่</div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row" style="margin-bottom: 30px;">

                        <div class="col-sm-12 col-md-12">
                            <!-- ------ -->
                            <form action="{{ url('manager/data_report_product-new/search') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <span class="form-inline pull-right pull-sm-center">
                                    ปี : 
                                    <select name="year_search" id="year_form_search" class="form-control form-control-sm mx-5" style="margin-left:5px; margin-right:5px;">
                                        @php
                                            $year_now = date("Y");
                                            $year_back = $year_now - 1;
                                            $year_form_search = array($year_now, $year_back);
                                        @endphp
                                        @if(isset($year_form_search))
                                            @foreach($year_form_search as $value_year)
                                                @php
                                                    $year_thai = $value_year+543;
                                                @endphp
                                                @if((isset($year_search)) && ($year_search == $value_year))
                                                    <option value="{{ $value_year }}" selected>{{ $year_thai }}</option>
                                                @else
                                                    <option value="{{ $value_year }}">{{ $year_thai }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>

                                    @if(Auth::user()->status == 4)
                                        @if(isset($users_head) && count($users_head) > 0)
                                            ผู้จัดการฝ่าย : 
                                            <select class="form-control form-control-sm mx-5" name="sel_head" id="sel_head">
                                                <option value="">ผู้จัดการฝ่าย</option>
                                                @foreach($users_head as $userhead)
                                                    <option value="{{ $userhead->api_identify }}">{{ $userhead->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    @endif

                                    @if(Auth::user()->status == 4 || Auth::user()->status == 3)
                                        @if(isset($users_lead) && count($users_lead) > 0)
                                        ผู้จัดการเขต : 
                                            <select class="form-control form-control-sm mx-5" name="sel_lead" id="sel_lead">
                                                <option value="">ผู้จัดการเขต</option>
                                                @foreach($users_lead as $userlead)
                                                    <option value="{{ $userlead->api_identify }}">{{ $userlead->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    @endif

                                    เป้า : 
                                    <select class="form-control form-control-sm mx-5" name="sel_campaign" id="sel_campaign">
                                        <option value="">เลือกแคมเปญ</option>
                                    </select>

                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-green">ค้นหา</button>
                                </span>
                            </form>
                            <!-- ------ -->
                        </div>
                    </div>

                    @include('shareData_union.report_product_new_table')

                </section>
            </div>

        </div>
        <!-- /Row -->
    </div>


<script>
     $( document ).ready(function() {
        let sel_year = $('#year_form_search').val();
        console.log(sel_year);
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_campaignpromotes") }}/'+sel_year, 
            datatype: 'json',
            success: function(response){
                if(response.status == 200){
                    console.log(response.campaignpromotes);
                    $('#sel_campaign').children().remove().end();
                    $('#sel_campaign').append('<option selected value="">เลือกแคมเปญ</option>');
                    let rows = response.campaignpromotes.length;
                    for(let i=0 ;i<rows; i++){
                        $('#sel_campaign').append('<option value="'+response.campaignpromotes[i]['campaign_id']+'">'+response.campaignpromotes[i]['description']+'</option>');
                    }
                }else{
                    console.log("ไม่พบ จังหวัด สินค้า");
                }
            }
        });
    });

    $(document).on('change','#year_form_search', function(e){
        e.preventDefault();
        let sel_year = $(this).val();
        console.log(sel_year);
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_campaignpromotes") }}/'+sel_year, 
            datatype: 'json',
            success: function(response){
                if(response.status == 200){
                    console.log(response.campaignpromotes);
                    $('#sel_campaign').children().remove().end();
                    $('#sel_campaign').append('<option selected value="">เลือกแคมเปญ</option>');
                    let rows = response.campaignpromotes.length;
                    for(let i=0 ;i<rows; i++){
                        $('#sel_campaign').append('<option value="'+response.campaignpromotes[i]['campaign_id']+'">'+response.campaignpromotes[i]['description']+'</option>');
                    }
                }else{
                    console.log("ไม่พบ จังหวัด สินค้า");
                }
            }
        });
    });

</script>