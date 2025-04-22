<div class="modal fade" id="AuditModel" tabindex="-1" role="dialog" aria-labelledby="AuditModelLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AuditModelLabel">Audit Records</h5>
                <button type="button" class="close DesignatedModelClose" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('auditrecords.store')}}" id="auditrecordsForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                        <input type="hidden" name="client_company_id" value="{{ $client_company_id }}" id="client_company_id">
                        <input type="hidden" name="hazmat_companies_id" value="{{ $hazmat_companies_id }}" id="hazmat_companies_id">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Audit Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="" value="{{$auditiname}}">
                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Auditee Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="" value="{{$auditieename}}">

                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" name="date" value="">
                                <div class="invalid-feedback error" id="nameError"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Attachment<span class="text-danger">*</span></label>
                                <input type="file" class="form-control form-control-lg" name="attachment" value="">
                                <div class="invalid-feedback error" id="nameError"></div>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="auditSave">Save changes</button>
            </div>
        </div>
    </div>
</div>