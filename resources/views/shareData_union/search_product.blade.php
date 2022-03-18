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
                            <span>
                                <div class="form-group col-md-12">
                                    <select name="sel_pdglists" id="sel_pdglists" class="form-control sel_pdglists" required>
                                        <option value="">--ค้นหารายการสินค้า--</option>
                                        @foreach($pdglists['data'] as $value)
                                            <option value="{{ $value['identify'] }}">{{ $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </span>
                            <!-- ------ -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 col-md-6">
                            <p class="mb-40">ข้อมูลรายการสินค้า</p>
                            <div class="row">
                                <div class="col-sm" id="table_product">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </section>
            </div>
        </div>


    </div>
    <!-- /Container -->

<script>

// $(document).ready(function (){

    

// }

$(document).on('change','#sel_pdglists', function(e){
        e.preventDefault();
        var pdglist = $(this).val();
        console.log(pdglist)

        var content = "<div id='table_list' class='table-responsive col-md-12'>";
                content += "<table id='datable_1' class='table table-hover data-table'>";
                    content += "<thead>";
                        content += "<tr>";
                            content += "<th style='font-weight: bold;'>รหัสสินค้า</th>";
                            content += "<th style='font-weight: bold;'>ชื่อสินค้า</th>";
                        content += "</tr>";
                    content += "</thead>";
                    content += "<tbody>";
                    content += "<tbody>";
                content += "</table>";
            content += "</div>";

        $("#table_product").html(content);


            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method:"GET",
                    url:"{{url('fetch_products')}}/"+pdglist,
                    dataType: 'json',
                    data:{
                            "_token": "{{ csrf_token() }}",
                        },
                    },
                    columns: [
                        {data: 'identify', name: 'identify'},
                        {data: 'name', name: 'name'},
                    ]
            });



        // $.ajax({
        //     method: 'GET',
        //     url: '{{ url("/fetch_products") }}/'+pdglist,
        //     datatype: 'json',
        //     success: function(response){
        //         if(response.status == 200){
        //             console.log(response.products)
                    
        //         }
        //     }
        // });
    });

</script>