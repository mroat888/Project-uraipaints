<!-- Modal -->
<div class="modal fade" id="bdatesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header topic-bggreen">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#FFF;">
           รายละเอียดวันสำคัญร้านค้า เดือน <?php echo thaidate('F', date("M")); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive col-md-12">
                <table id="datable_1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อร้าน</th>
                            <th>อำเภอ,จังหวัด</th>
                            <th>เบอร์โทร</th>
                            <th>วันสำคัญ</th>
                            <th>ชื่อวัน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($res_bdates_api))
                            @if ($res_bdates_api['code'] == 200)
                                @foreach ($res_bdates_api['data'] as $key => $value)
                                    @php
                                        $createdAt = Carbon\Carbon::parse($value['focusDate']);
                                        $date = date('Y-m');

                                    @endphp

                                    @if ($createdAt->format('Y-m') == $date)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value['name'] }}</td>
                                            <td>{{ $value['adrress2'] }}</td>
                                            <td>{{ $value['telephone'] }}</td>
                                            <td>{{ $value['fDateInfo'] }}</td>
                                            <td>{{ $value['descripDate'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                    <tr>
                                        <td colspan="6"style="text-align:center;">{{ $res_bdates_api['data'] }}</td>
                                    </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
    </div>
  </div>
</div>

<style>
    #bdate{
        cursor: pointer;
    }
</style>
<script>
    $(document).on('click','#bdate', function(){
       $('#bdatesModal').modal('show');
    })
</script>