<div class="modal fade" id="DesignatedModel" tabindex="-1" role="dialog" aria-labelledby="DesignatedModellLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DesignatedModellLabel">Designated Person Details</h5>
                <button type="button" class="close DesignatedModelClose" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('designatedPerson')}}" id="designatedForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                        <input type="hidden" id="id" name="id" class="form-control">
                        <input type="hidden" id="currentUserRoleLevel" name="currentUserRoleLevel" value="{{$currentUserRoleLevel}}">

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                 @if(@$currentUserRoleLevel == 6)
                                <label for="name">Rank <span class="text-danger">*</span></label>
                                @else
                                 <label for="name">Desgnation <span class="text-danger">*</span></label>
                                @endif
                                <input type="text" id="rank" name="rank" class="form-control">
                                <div class="invalid-feedback error" id="rankError"></div>

                            </div>
                        </div>
                        @if(@$currentUserRoleLevel == 6)
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Passport Number <span class="text-danger">*</span></label>
                                <input type="text" id="passport_number" name="passport_number" class="form-control">
                                <div class="invalid-feedback error" id="passport_numberError"></div>

                            </div>
                        </div>
                        @endif
                        @if(@$currentUserRoleLevel == 6)
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
                        @else
                        <input type="hidden" name="position" value="SuperDp">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Ship <span class="text-danger">*</span></label>

                                <select class="form-control selectpicker" name="ship_id[]" id="designatedpersionships" multiple>
                                    <option value="">Select Ship</option>
                                    @foreach($ships as $value)
                                        <option value="{{$value['id']}}">{{$value['ship_name']}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback error" id="ship_idError"></div>



                            </div>
                        </div>
                        @endif
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">{{$currentUserRoleLevel == 6 ? 'Sign On Date
                                    ' : 'Start Date'}} <span class="text-danger">*</span></label>
                                <input type="date" id="sign_on_date" name="sign_on_date" class="form-control">
                                <div class="invalid-feedback error" id="sign_on_dateError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">{{$currentUserRoleLevel == 6 ? 'Sign Off Date
                                ' : 'End Date'}}</label>
                                <input type="date" id="sign_off_date" name="sign_off_date" class="form-control">
                                <div class="invalid-feedback error" id="sign_off_dateError"></div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="designatedSave">Save changes</button>
            </div>
        </div>
    </div>
</div>