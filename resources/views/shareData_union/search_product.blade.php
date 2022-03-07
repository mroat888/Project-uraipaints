<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item active">ค้นหารายการสินค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
        
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ค้นหารายการสินค้า</h5>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <!-- ------ -->
                                <form action="{{ url($action_search) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">

                                    <div class="form-group col-md-3">
                                            <select name="sel_productgroup" id="sel_productgroup" class="form-control sel_productgroup">
                                                <option value="">--ค้นหากลุ่มสินค้า--</option>
                                                @foreach($groups_api['data'] as $value)
                                                    <option value="{{ $value['identify'] }}">{{ $value['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <select name="sel_productsubgroup" id="sel_productsubgroup" class="form-control sel_productgroup">

                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <select name="sel_pdglists" id="sel_pdglists" class="form-control sel_pdglists" required>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-teal btn-sm px-3 ml-2">ค้นหา</button>
                                        </div>
                                    </div>
                                </form>

                            </span>
                            <!-- ------ -->
                        </div>
                    </div>
                  
                    {{-- <p class="mb-40">ข้อมูลรายการสินค้า</p> --}}
                    <div class="row">
                        <div class="col-sm">
                            
                        @if(isset($product_api))
                            @if(!is_null($product_api))
                                <div class="row">
                                @foreach($product_api['data'] as $value)
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <div class="card mb-20">
                                            <img class="card-img-top" src="{{ asset('public/dist/img/cropper.jpg')}}" alt="Card image cap">
                                            <div class="card-body">
                                                <div style="min-height:70px;">
                                                    <h5 class="card-title">{{ $value['name'] }}</h5>
                                                </div>
                                                <div>
                                                    <p class="card-text">
                                                        <p>Code : {{ $value['identify'] }}</p>
                                                        <p>Shade : {{ $value['shade'] }}</p>
                                                        @if($value['color'] != "")
                                                            <p>Shade : {{ $value['color'] }}</p>
                                                        @endif
                                                    </p>
                                                    <p class="card-text">
                                                        <small class="text-muted">listcode : {{ $value['list_code'] }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            @endif
                        @endif
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div> --}}
                                <!-- <nav class="pagination-wrap d-inline-block mt-30 float-right" aria-label="Page navigation example">
                                    <ul class="pagination custom-pagination">
                                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                        <li class="page-item active active-gold"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item"><a class="page-link" href="#">15</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav> -->
                            {{-- </div> --}}
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </div>
    <!-- /Container -->

    <script>
    $(document).on('change','#sel_productgroup', function(e){
        e.preventDefault();
        let group_id = $(this).val();
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_subgroups") }}/'+group_id,
            datatype: 'json',
            success: function(response){
                //alert(response.AMPHUR_NAME);
                if(response.status == 200){
                    console.log(response.subgroups)
                    $('#sel_productsubgroup').children().remove().end();
                    $('#sel_pdglists').children().remove().end();
                    $('#sel_productsubgroup').append('<option selected value="">--โปรดเลือก--</option>');
                    $('#sel_pdglists').append('<option selected value="">--โปรดเลือก--</option>');

                    $.each(response.subgroups, function(key, value){
                        $('#sel_productsubgroup').append('<option value='+value['identify']+'>'+value['name']+'</option>')	;
                    });

                }
            }
        });
    });

    $(document).on('change','#sel_productsubgroup', function(e){
        e.preventDefault();
        let subgroup_id = $(this).val();
        console.log(subgroup_id)
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_pdglists") }}/'+subgroup_id,
            datatype: 'json',
            success: function(response){
                if(response.status == 200){
                    console.log(response.pdglists)
                    $('#sel_pdglists').children().remove().end();

                    $.each(response.pdglists, function(key, value){
                        $('#sel_pdglists').append('<option value='+value['identify']+'>'+value['name']+'</option>')	;
                    });

                }
            }
        });
    });
</script>