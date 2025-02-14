<div class="modal" tabindex="-1" role="dialog" id="admincorospondenceModel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Admin Corospondence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="correspondencesForm" action="{{route('correspondence.save')}}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="assign_date">Subject<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="subject" value="" name="subject" autocomplete="off" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="subjectError"></div>

                            </div>
                        </div>

                    
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                            <label for="attachment">Content</label>
                                <textarea id="mytextareasuperadmin" value=""></textarea>

                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                            <label for="attachment">Attachment</label>

                            <input type="file" class="form-control form-control-lg" id="attachment" name="attachment" autocomplete="off" onchange="removeInvalidClass(this)">


                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveadmincorospondence">Save changes</button>
            </div>

        </div>
    </div>
</div>
