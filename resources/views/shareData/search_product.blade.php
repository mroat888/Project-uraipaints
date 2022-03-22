@extends('layouts.master')

@section('content')

@php
    $action_search = "data_search_product/search";
@endphp

@include('shareData_union.search_product')  

@section('footer')
    @include('layouts.footer')
@endsection



<script>

$(document).on('change','#sel_pdglists', function(e){
    e.preventDefault();
    var pdglist = $(this).val();
    console.log(pdglist);
    $('.province').children().remove().end();
    $('.amphur').children().remove().end();
    $('.province').append('<option selected value="">เลือกจังหวัด</option>');
    $('.amphur').append('<option selected value="">เลือกอำเภอ</option>');

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

    $('#datable_1').DataTable({
        processing: false,
        serverSide: false,
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

    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_provinces_products") }}/'+pdglist,
        datatype: 'json',
        success: function(response){
            if(response.status == 200){
                console.log(response.provinces);
                $('.province').children().remove().end();
                $('.amphur').children().remove().end();
                $('.province').append('<option selected value="">เลือกจังหวัด</option>');
                $('.amphur').append('<option selected value="">เลือกอำเภอ</option>');
                let rows = response.provinces.length;
                for(let i=0 ;i<rows; i++){
                    $('.province').append('<option value="'+response.provinces[i]['identify']+'">'+response.provinces[i]['name_thai']+'</option>');
                }
            }
        }
    });

    //-- Table Customer
    var pdglist = $(this).val();
    var content2 = "<div id='table_list' class='table-responsive col-md-12'>";
            content2 += "<table id='datable_2' class='table table-hover data-table'>";
                content2 += "<thead>";
                    content2 += "<tr>";
                        content2 += "<th style='font-weight: bold;'>รหัสสินค้า</th>";
                        content2 += "<th style='font-weight: bold;'>ชื่อร้าน</th>";
                    content2 += "</tr>";
                content2 += "</thead>";
                content2 += "<tbody>";
                content2 += "<tbody>";
            content2 += "</table>";
        content2 += "</div>";

    $("#table_customer").html(content2);

    $('#datable_2').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            method:"GET",
            url:"{{url('fetch_datatable_customer_sellers_pdglist')}}/"+pdglist,
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
    //-- Table Customer


});

$(document).on('change','.province', function(e){

    e.preventDefault();
    let pvid = $(this).val();
    var pdglist = $("#sel_pdglists").val();

    var content = "<div id='table_list' class='table-responsive col-md-12'>";
            content += "<table id='datable_2' class='table table-hover data-table'>";
                content += "<thead>";
                    content += "<tr>";
                        content += "<th style='font-weight: bold;'>รหัสสินค้า</th>";
                        content += "<th style='font-weight: bold;'>ชื่อร้าน</th>";
                    content += "</tr>";
                content += "</thead>";
                content += "<tbody>";
                content += "<tbody>";
            content += "</table>";
        content += "</div>";

    $("#table_customer").html(content);
    
    $.fn.dataTable.ext.errMode = () => alert('Error while loading the table data. Please refresh');
    $('#datable_2').DataTable({
        
        processing: false,
        serverSide: false,
        ajax: {
            method:"GET",
            url:"{{url('fetch_datatable_customer_sellers_pdglist')}}/"+pdglist+'/'+pvid,
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


    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_amphur_products") }}/'+pdglist+'/'+pvid,
        datatype: 'json',
        success: function(response){
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



$(document).on('change','#amphur', function(e){
    e.preventDefault();
    var pdglist = $('#sel_pdglists').val();
    var pvid = $('#province').val();
    var ampid = $(this).val();
    console.log(pdglist);

    var content = "<div id='table_list' class='table-responsive col-md-12'>";
            content += "<table id='datable_2' class='table table-hover data-table'>";
                content += "<thead>";
                    content += "<tr>";
                        content += "<th style='font-weight: bold;'>รหัสสินค้า</th>";
                        content += "<th style='font-weight: bold;'>ชื่อร้าน</th>";
                    content += "</tr>";
                content += "</thead>";
                content += "<tbody>";
                content += "<tbody>";
            content += "</table>";
        content += "</div>";

    $("#table_customer").html(content);

    $('#datable_2').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            method:"GET",
            url:"{{url('fetch_datatable_customer_sellers')}}/"+pdglist+"/"+pvid+"/"+ampid,
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

});

</script>



@endsection
