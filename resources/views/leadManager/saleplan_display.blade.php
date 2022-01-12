
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">ตาราง Sale Plan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div>
                <span>วันที่ส่ง : 10/11/2021</span>
            </div>
            <div class="card mt-10">
                <div class="card-body">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae sit dolorem laboriosam, ex mollitia odio ducimus sed placeat beatae velit tempore neque nulla ad molestiae modi error nobis? Consequuntur repudiandae voluptas dolor dicta porro unde? Sit temporibus molestiae, expedita dicta exercitationem recusandae obcaecati unde aliquid voluptas earum asperiores officia enim velit veritatis, aliquam impedit vero at delectus reiciendis aperiam consequuntur fugiat sint a fugit? Libero eos hic suscipit excepturi eligendi ex distinctio aliquam sequi qui. Sequi, in blanditiis? Perferendis non nulla repellendus earum culpa quod natus mollitia quam quas exercitationem recusandae quos distinctio obcaecati ipsum eveniet asperiores, repudiandae harum voluptate voluptatum tempora cum sapiente explicabo? Sint dolorum velit nihil dignissimos debitis corrupti nemo ex voluptatum distinctio illum quaerat rem recusandae possimus, similique deserunt consectetur pariatur sequi minus repudiandae cupiditate incidunt? Iure similique cupiditate amet sit atque libero vitae est quisquam voluptatum cum, praesentium quidem ullam, in porro expedita ratione adipisci facere, pariatur totam dignissimos provident fugit! Pariatur, est mollitia. Possimus, voluptatum! Consectetur asperiores animi facilis quidem quod eius rerum facere placeat saepe nostrum illo ullam quia quasi aliquam vero corrupti voluptatem, exercitationem vitae molestias tempora officia rem? Explicabo, ducimus corporis culpa repellat molestias maiores saepe cumque quia doloremque impedit quisquam.
                </div>
            </div>
            <div>
                <h5>ความคิดเห็น</h5>
            </div>
            <div class="card mt-10">
                <div class="card-body">
                    <textarea class="form-control" id="address" cols="30" rows="5" placeholder="" value=""
                    type="text"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            {{-- <button type="button" class="btn btn-danger bt_reject"><i data-feather="x" style="width:18px;"></i> ปฎิเสธ</button>
            <button type="button" class="btn btn-primary bt_saveapprove"><i data-feather="check" style="width:18px;"></i> อนุมัติ</button> --}}
        </div>
    </div>
</div>

<div class="modal fade" id="Modalapprov_reject" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" style="color:#FFF;">ยืนยันการปฎิเสธ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:center">
                <h3>ต้องการปฎิเสธ ใช่หรือไม่?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary bt_save"><i data-feather="check" style="width:18px;"></i> ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modalapprov_approve" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" style="color:#FFF;">ยืนยันการอนุมัติ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:center">
                <h3>ต้องการอนุมัติ ใช่หรือไม่?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary bt_save"><i data-feather="check" style="width:18px;"></i> ยืนยัน</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('click', '.bt_reject', function(){
       // alert('ไม่อนุมัติ');
       $('#Modalapprov_reject').modal("show");
    });

    $(document).on('click', '.bt_saveapprove', function(){
       // alert('ไม่อนุมัติ');
       $('#Modalapprov_approve').modal("show");
    });

</script>
