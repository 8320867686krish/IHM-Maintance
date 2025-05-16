<div class="modal fade" id="AuditModel" tabindex="-1" role="dialog" aria-labelledby="AuditModelLabel">
    <div class="modal-dialog modal-lg" role="document">
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
                        <div class="col-6 col-md-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="name">Auditor Person Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="" value="" name="auditor_person_name" id="auditor_person_name">
                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="name">Auditee Person Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="" value="" name="auditee_person_name">

                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="name">Auditor Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="" value="{{$auditiname}}" readonly>
                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="name">Auditee Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="" value="{{$auditieename}}" readonly>

                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="name">Auditor Designation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="" value="" name="auditor_designation">
                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="name">Auditee Designation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="" value="" name="auditee_designation">

                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="name">Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" name="date" value="">
                                <div class="invalid-feedback error" id="nameError"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 mb-2 attachmentDiv">
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
                @can('auditrecords.add' || auditrecords.edit)
                <button type="button" class="btn btn-primary" id="auditSave">Save changes</button>
                @endcan
            </div>
        </div>
    </div>
</div>