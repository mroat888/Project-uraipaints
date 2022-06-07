@extends('layouts.masterHead')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">อายุจัดเก็บสินค้า</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="clock"></i> อายุจัดเก็บสินค้า</div>
        </div>
        <!-- /Title -->

        @include('product_age_main')

    </div>
    <!-- /Container -->

    <script>
        //Edit
        function view_modal(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('head/view_product_age_detail/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#view_img_show').children().remove().end();

                    $('#view_date').text(data.dataEdit.updated_at);
                    $('#view_description').text(data.dataEdit.description);
                    $('#view_url').text(data.dataEdit.url);

                    $.each(data.editGroups, function(key, value){
                        if(data.editGroups[key]['id'] == data.dataEdit.category_id){
                            $('#view_category_id').text(data.editGroups[key]['group_name']);
                        }
                    });

                    $.each(data.editBrands, function(key, value){
                        if(data.editBrands[key]['id'] == data.dataEdit.brand_id){
                            $('#view_brand_id').text(data.editBrands[key]['brand_name']);
                        }
                    });

                    let img_name = '{{ asset('/public/upload/ProductAge') }}/' + data.dataEdit.image;
                    if (data.dataEdit.image != "") {
                        ext = data.dataEdit.image.split('.').pop().toLowerCase();
                        console.log(img_name);
                        if (img_name) {
                            $('#view_img_show').append('<img class="img_1" src = "' + img_name + '" style="max-width:100%;">');
                        }
                    }

                    $('#viewProductAge').modal('toggle');
                }
            });
        }
    </script>
@endsection
