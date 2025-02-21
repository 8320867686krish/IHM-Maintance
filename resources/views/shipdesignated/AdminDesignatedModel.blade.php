<div class="modal fade" id="adminDesignatedModel" tabindex="-1" role="dialog" aria-labelledby="adminDesignatedModellLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminDesignatedModellLabel">Designated Person Details</h5>
                <button type="button" class="close adminDesignatedModelClose" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('designatedPerson.admin')}}" id="admindesignatedForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                        <input type="hidden" id="id" name="id" class="form-control">
                        <input type="hidden" name="ship_staff_id" id="ship_staff_id" value="{{$ship->user_id}}">

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Rank <span class="text-danger">*</span></label>
                                <input type="text" id="rank" name="rank" class="form-control">
                                <div class="invalid-feedback error" id="rankError"></div>

                            </div>
                        </div>
                      
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Passport Number <span class="text-danger">*</span></label>
                                <input type="text" id="passport_number" name="passport_number" class="form-control">
                                <div class="invalid-feedback error" id="passport_numberError"></div>

                            </div>
                        </div>
                      
                     
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Position <span class="text-danger">*</span></label>


                                <select class="form-control" name="position" id="position">
                                    <option value="">Select Position</option>
                                    <option value="responsible">Responsible Person</option>
                                    <option value="incharge">Incharge Person</option>
                                </select>
                                <div class="invalid-feedback error" id="positionError"></div>


                            </div>
                        </div>
                     
                      
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Start On Date <span class="text-danger">*</span></label>
                                <input type="date" id="sign_on_date" name="sign_on_date" class="form-control">
                                <div class="invalid-feedback error" id="sign_on_dateError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Sign Off Date</label>
                                <input type="date" id="sign_off_date" name="sign_off_date" class="form-control">
                                <div class="invalid-feedback error" id="sign_off_dateError"></div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="admindesignatedSave">Save changes</button>
            </div>
        </div>
    </div>
</div>