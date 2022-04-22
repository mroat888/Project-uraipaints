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
                    } else {
                        event.allDay = false;
                    }
                },
                eventClick: function(event) {
                    // alert(event.id);
                    var eventid = event.id;
                    $('#Modalvisit').modal('show');
                    $('#header').text('');
                    $('#title').text('');
                    $('#shop_name').text('');
                    $.ajax({
                        type: "GET",
                        url: '{{ url("calendar/show") }}/'+eventid,
                        success: function(response) {
                            // console.log(response);
                            if(response.status == 200){
                                $('#header').text(response.data_show.header);
                                $('#title').text(response.data_show.title);
                                $('#shop_name').text(response.data_show.shop_name);
                            }
                        }
                    });
                }
            });
        });

        function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function() {
                $(".success").fadeOut();
            }, 1000);
        }
    </script>

    <!-- Modal -->
    <div class="modal fade" id="Modalvisit" tabindex="-1" role="dialog" aria-labelledby="Modalvisit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 id="title"></h3>
                    <h3 id="shop_name"></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>


@endsection
