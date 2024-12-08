<div class="modal fade" id="partmanuelModel" tabindex="-1" role="dialog" aria-labelledby="partmanuelModellLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="partmanuelModellLabel">Part Manual</h5>
                <button type="button" class="close partmanuelModelClose" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('partManual')}}" id="addPartManualForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                    <input type="hidden" id="id" name="id" class="form-control">

                        <input type="hidden" id="ship_id" name="ship_id" class="form-control" value="{{$ship_id}}">
                        <input type="hidden" id="hazmat_companies_id" name="hazmat_companies_id" class="form-control" value="{{$hazmat_companies_id}}">

                        
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" id="title" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Version</label>
                                <input type="text" id="version" name="version" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Document</label>
                                <input type="file" id="document" name="document" class="form-control">
                                <span id="documentshow"></span>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Uploaded By</label>
                                <input type="text" id="uploaded_by" name="uploaded_by" class="form-control">
                              
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Date</label>
                                <input type="date" id="date" name="date" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="partManualSave">Save changes</button>
            </div>
        </div>
    </div>
</div>