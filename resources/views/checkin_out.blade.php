@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ข้อมูล Check-in / Check-out</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-map"></i></span>ข้อมูล Check-in / Check-out</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">ตารางข้อมูล Check-in / Check-out</h5>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover w-100 display pb-30">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อร้าน</th>
                                            <th>ชื่อผู้ติดต่อ</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Melbourne VIC 3000, Australia</td>
                                            <td>Melbourne VIC 3000, Australia</td>
                                            <td><i data-feather="map-pin" data-toggle="modal" data-target="#exampleModalLarge01"></i></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>Melbourne VIC 3000, Australia</td>
                                            <td>Melbourne VIC 3000, Australia</td>
                                            <td><i data-feather="map-pin" data-toggle="modal" data-target="#exampleModalLarge01"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

     <!-- Modal -->
     <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Check-in 2 Check-out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <div class="col-xl-12 pa-0">
                        <div id="map_canvas" class="gmap"></div>
                    </div>
                    <div class="mt-20 text-center">
                        <button type="button" class="btn btn-primary">Check-in</button>
                    </div> -->
                    <div class="mt-20 text-center">
                        <button type="button" class="btn btn-primary" onclick="getLocation()">GetLocation</button>
                        <p id="demo" class="mt-5"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
@endsection    

@section('footer')
    @include('layouts.footer')

<script>
    var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
    }

    function showError(error){  
        switch(error.code){    
            case error.PERMISSION_DENIED:
                x.innerHTML="User denied the request for Geolocation."
                reak;     
            case error.POSITION_UNAVAILABLE:
                x.innerHTML="Location information is unavailable."
                break;     
            case error.TIMEOUT:
                x.innerHTML="The request to get user location timed out."
                break;     
            case error.UNKNOWN_ERROR:
                x.innerHTML="An unknown error occurred."       
                break;    
        }  
    }
    
</script>

@endsection  
