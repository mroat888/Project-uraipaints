@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ปฎิทินกิจกรรม</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
     <div class="container-fluid px-xxl-65 px-xl-20">
         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-calendar"></i></span>ปฎิทินกิจกรรม</h4>
            </div>
        </div>
        <!-- /Title -->

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    {{-- <h5 class="hk-sec-title">ปฏิทิน</h5> --}}
                    <div class="row">
                        <div class="col-sm">

                            <div id="calendar"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#calendar').fullCalendar({
                editable: true,
                events: "calendar", // -- แก้ไข url ได้
                displayEventTime: false,
                editable: true,
                eventColor: '#6A5ACD',
                eventTextColor: '#FFFFFF',
                eventRender: function(event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                        alert("OK");
                    } else {
                        event.allDay = false;
                        alert("OK2");
                    }
                },
            });
        });

        function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function() {
                $(".success").fadeOut();
            }, 1000);
        }
    </script>


@endsection
