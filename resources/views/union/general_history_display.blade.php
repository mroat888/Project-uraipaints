<!-- Modal ApprovalComment -->

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">รายละเอียดการขออนุมัติ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">

                <div class="card text-white bg-secondary" id="assign_parent" style="display:none">
                        <div class="card-body">
                            <h5 id="title_parent" class="card-title text-white"></h5>

                            <div class="my-3"><span>ขออนุมัติสำหรับ : </span>
                                <span id="approved_for_parent"></span>
                            </div>

                            <div class="my-3"><span>ชื่อผู้ขอ : </span>
                                <span id="assign_request_name"></span>
                            </div>
                            
                            <div class="my-3"><span>วันที่ขออนุมัติ : </span>
                                <span id="assign_request_date"></span>
                            </div>

                            <div class="my-3"><span>วันที่ต้องการ : </span>
                                <span id="assign_work_date_parent"></span>
                            </div>

                            <div class="my-3">
                                <p>รายละเอียด : </p>
                                <p  id="assign_detail_parent" class="card-text"></p>
                            </div>
                        </div>
                </div>

                <div class="card">
                    <div class="card-body">
                    
                        <h5 id="header_title_comment" class="card-title"></h5>

                        <div class="my-3"><span>ขออนุมัติสำหรับ : </span>
                            <span id="header_approved_for_comment"></span>
                        </div>

                        <div class="my-3"><span>ชื่อผู้ขอ : </span>
                                <span id="get_assign_request_name"></span>
                            </div>

                        <div class="my-3"><span>วันที่ขออนุมัติ : </span>
                            <span id="get_assign_request_date"></span>
                        </div>

                        <div class="my-3"><span>วันที่ต้องการ : </span>
                            <span id="get_assign_work_date_comment"></span>
                        </div>

                        <div class="my-3">
                            <p>รายละเอียด : </p>
                            <p  id="assign_detail_comment" class="card-text"></p>
                        </div>

                    </div>
                </div>
                <div class="my-10" id="div_assign_status">

                </div>
                <div class="my-10" id="div_assign_approve">
   
                </div>

                <div class="form-group">

                    <div id="div_comment">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            </div>
    </div>
</div>
