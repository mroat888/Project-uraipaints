<div class="col-sm-12 col-md-12" style="margin-bottom: 30px;">
    <h5 class="hk-sec-title">{{ $title_header_table }}</h5>
</div>
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <!-- ------ -->
        <span class="form-inline pull-right">
            <!-- เงื่อนไขการค้นหา -->
            @php

                if(isset($checkteam_sales)){
                    $checkteam_sales = $checkteam_sales;
                }else{
                    $checkteam_sales = "";
                }
                if(isset($checkusers)){
                    $checkusers = $checkusers;
                }else{
                    $checkusers = "";
                }
                if(isset($checkdateFrom)){
                    $checkdateFrom = $checkdateFrom;
                }else{
                    $checkdateFrom = "";
                }

                if(isset($checkdateTo)){
                    $checkdateTo = $checkdateTo;
                }else{
                    $checkdateTo = "";
                }

            @endphp

            <form action="{{ url($action_search) }}" method="post">
            @csrf
            <span id="selectdate" >
                @if(count($team_sales) > 1)
                <select name="selectteam_sales" class="form-control" aria-label=".form-select-lg example">
                    <option value="" selected>เลือกทีม</option>
                        @foreach($team_sales as $team)
                            @if($checkteam_sales == $team->id)
                                <option value="{{ $team->id }}" selected>{{ $team->team_name }}</option>
                            @else
                                <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                            @endif
                        @endforeach
                </select>
                @endif
                <select name="selectusers" class="form-control" aria-label=".form-select-lg example">
                    <option value="" selected>ผู้แทนขาย</option>
                    @foreach($users as $user)
                        @if($checkusers == $user->id)
                            <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                        @else
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
                <input type="date" class="form-control" style="margin-left:10px; margin-right:10px;"
                id="selectdateFrom" name="selectdateFrom" value="{{ $checkdateFrom }}" />

                ถึง <input type="date" class="form-control" style="margin-left:10px; margin-right:10px;"
                id="selectdateTo" name="selectdateTo" value="{{ $checkdateTo }}" />

                <button style="margin-left:5px; margin-right:5px;" class="btn btn-green btn-sm" id="submit_request">ค้นหา</button>
            </span>

            </form>
            <!-- จบเงื่อนไขการค้นหา -->

        </span>
        <!-- ------ -->
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <div class="table-responsive-sm table-color">
            <table id="datable_1" class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ผู้แทนขาย</th>
                        <th>เรื่องด่วน</th>
                        <th>เรื่องขออนุมัติ</th>
                        <th>ชื่อร้าน</th>
                        <th>วันที่ขออนุมัติ</th>
                        <th>การอนุมัติ</th>
                        <th>ความคิดเห็น</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments_history as $key => $assignments)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $assignments->name }}</td>
                        <td>
                            @if($assignments->assign_is_hot == "1")
                                <span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>
                            @endif
                        </td>
                        <td>{{ $assignments->assign_title }}</td>
                        <td>{{ $assignments->api_customers_title }} {{ $assignments->api_customers_name }}</td>
                        <td>
                            {{Carbon\Carbon::parse($assignments->assign_request_date)->addYear(543)->format('d/m/Y')}}
                        </td>
                        <td>
                            @php
                                $status = "";
                                switch($assignments->assign_status){
                                    case "1" : $status = '<span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>';
                                        break;
                                    case "2" : $status = '<span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>';
                                        break;
                                    case "4" : $status = '<span class="badge badge-soft-danger" style="font-size: 12px;">Re-write</span>';
                                        break;
                                }
                            @endphp
                            <?php echo $status; ?>
                        </td>
                        <td>
                            @if ($assignments->assign_id)
                                <span class="badge badge-soft-indigo" style="font-size: 12px;">Comment</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-icon btn-view btn-link btn_asssign_show"
                                value="{{ $assignments->id }}">
                                <i data-feather="file-text"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ApprovalComment" tabindex="-1" role="dialog" >
    @include('union.general_history_display')
</div>


<script>
    $(document).on('click', '.btn_asssign_show', function(){
        let id = $(this).val();
        $('#div_assign_approve').children().remove().end();
        $.ajax({
            type: "GET",
            url: "{!! url('assignments_commentshow/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#div_comment').children().remove().end();
                $('#div_assign_status').children().remove().end();
                
                console.log(data['dataassign']);

                switch(data['dataassign'].assign_status) {
                    case 0 : span_assign_status = '<span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>';
                        break;
                    case 1 : span_assign_status = '<span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>';
                        break;
                    case 2 : span_assign_status = '<span class="badge badge-soft-secondary" style="font-size: 12px;">Reject</span>';
                        break;
                    default: span_assign_status = '<span class="badge badge-soft-warning" style="font-size: 12px;">ไม่มี</span>';
                }

                $('#assign_detail_comment').text(data['dataassign'].assign_detail);
                $('#header_title_comment').text('เรื่อง : '+data['dataassign'].assign_title);
                $('#header_approved_for_comment').text(data['dataassign'].masassign_title);
                $('#assign_request_name').text(data['dataassign'].assignments_request_name);
                $('#get_assign_request_name').text(data['dataassign'].assignments_request_name);

                $('#div_assign_status').append('<span>การอนุมัติ : </span>'+span_assign_status);

                $('#div_assign_approve').append('<span>ผู้อนุมัติ : '+data['dataassign'].assignments_approve_name+
                ' Date : '+data['dataassign'].assignments_approve_date+'</span>');

                $.each(data['comment'], function(key, value){
                        let get_created_at = value.created_at.split(" ");
                        let get_created_at2 = get_created_at[0].split("-");
                        let year_th_create = parseInt(get_created_at2[0])+543;
                        let date_create = get_created_at2[2]+"/"+get_created_at2[1]+"/"+year_th_create;

                    $('#div_comment').append('<div>Comment by: '+value.user_comment+' Date: '+date_create+'</div>');
                    $('#div_comment').append('<div class="alert alert-primary py-20" role="alert">'+value.assign_comment_detail+'</div>');
                });

                let get_work_date = data['dataassign'].assign_work_date.split("-");
                let year_th_work = parseInt(get_work_date[0])+543;
                let date_work = get_work_date[2]+"/"+get_work_date[1]+"/"+year_th_work;
                $('#get_assign_work_date_comment').text(date_work);

                let get_request_date = data['dataassign'].assign_request_date.split(" ");
                let get_request_date2 = get_request_date[0].split("-");
                let year_th_request = parseInt(get_request_date2[0])+543;
                let date_request = get_request_date2[2]+"/"+get_request_date2[1]+"/"+year_th_request;
                $('#get_assign_request_date').text(date_request);

                $('#ApprovalComment').modal('toggle');
            }
        });

    });

</script>
