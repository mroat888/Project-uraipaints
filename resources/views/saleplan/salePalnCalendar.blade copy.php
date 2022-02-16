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
            {{-- <div class="d-flex">
            <button type="button" class="btn bg-teal btn-sm btn-rounded px-3 text-white" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
            </div> --}}
        </div>
        <!-- /Title -->

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    {{-- <h5 class="hk-sec-title">ปฏิทิน</h5> --}}
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{url('palncalendar')}}" type="button" class="btn bg-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <span class="btn-text">ปฎิทิน</span>
                            </a>

                            <a href="{{url('planDetail')}}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-list"></i>
                                </span>
                                <span class="btn-text">List</span>
                            </a>
                            <hr>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- Row -->
        {{-- <div class="row">
            <div class="col-xl-12 pa-0">
                <div class="calendarapp-wrap">
                    <div class="calendarapp-sidebar">
                        <div class="nicescroll-bar">

                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Row -->
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        {{-- @include('saleplan.salePlanForm') --}}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modalvisit" tabindex="-1" role="dialog" aria-labelledby="Modalvisit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผลการเข้าพบ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <input type="text" id="event_id">
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="address" cols="30" rows="5" placeholder="" value=""
                                type="text"> </textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select">
                                    <option selected>-- กรุณาเลือก --</option>
                                    <option value="1">ไม่สนใจ</option>
                                    <option value="2">รอตัดสินใจ</option>
                                    <option value="3">สนใจ/ตกลง</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />

    <script>
        $(document).ready(function() {
            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#calendar').fullCalendar({
                editable: true,
                events: "calendar",
                displayEventTime: false,
                editable: true,
                eventRender: function(event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },

                header: {
                    // center: 'prev, title, next',
                    // right: 'today,month,listMonth'
                },
                // selectable: true,
                // selectHelper: true,
                // select: function(start, end, allDay) {
                //     var title = prompt('Event Title:');
                //     if (title) {
                //         var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                //         var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                //         $.ajax({
                //             url: SITEURL + "/calendar/create",
                //             data: 'title=' + title + '&start=' + start + '&end=' + end,
                //             type: "POST",
                //             success: function(data) {
                //                 displayMessage("Added Successfully");
                //             }
                //         });
                //         calendar.fullCalendar('renderEvent', {
                //                 title: title,
                //                 start: start,
                //                 end: end,
                //                 allDay: allDay
                //             },
                //             true
                //         );
                //     }
                //     calendar.fullCalendar('unselect');
                // },
                // eventDrop: function(event, delta) {
                //     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                //     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                //     $.ajax({
                //         url: SITEURL + '/calendar/update',
                //         data: 'title=' + event.title + '&start=' + start + '&end=' + end +
                //             '&id=' + event.id,
                //         type: "POST",
                //         success: function(response) {
                //             displayMessage("Updated Successfully");
                //         }
                //     });
                // },
                eventClick: function(event) {
                    //var deleteMsg = confirm("Do you really want to delete?");
                    $('#Modalvisit').modal('show');
                    $('#event_id').val(event.id);
                    // if (deleteMsg) {
                    //     $.ajax({
                    //         type: "POST",
                    //         url: SITEURL + '/calendar/delete',
                    //         data: "&id=" + event.id,
                    //         success: function(response) {
                    //             if (parseInt(response) > 0) {
                    //                 $('#calendar').fullCalendar('removeEvents', event.id);
                    //                 displayMessage("Deleted Successfully");
                    //             }
                    //         }
                    //     });
                    // }
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


@endsection
