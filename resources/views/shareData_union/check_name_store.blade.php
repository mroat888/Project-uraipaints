
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ทะเบียนลูกค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        {{-- <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="clipboard"></i></span></span>ทะเบียนลูกค้า</h4>
            </div>
        </div> --}}

        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i class="ion ion-md-clipboard"></i> ทะเบียนลูกค้า</div>
            <div class="content-right d-flex"></div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        @include('shareData_union.')
        <!-- /Row -->


    </div>
    <!-- /Container -->

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

$(document).on('change','.province', function(e){
    e.preventDefault();
    let pvid = $(this).val();
    $('#btn_search').prop('disabled', true);
    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_amphur_api") }}/{{ $position_province }}/'+pvid,
        datatype: 'json',
        success: function(response){
            console.log(response);
            $('#btn_search').prop('disabled', false);
            if(response.status == 200){
                console.log(response.amphures);
                $('.amphur').children().remove().end();
                $('.amphur').append('<option selected value="">เลือกอำเภอ</option>');
                let rows = response.amphures.length;
                for(let i=0 ;i<rows; i++){
                    $('.amphur').append('<option value="'+response.amphures[i]['identify']+'">'+response.amphures[i]['name_thai']+'</option>');
                }
            }
        }
    });
});

</script>
