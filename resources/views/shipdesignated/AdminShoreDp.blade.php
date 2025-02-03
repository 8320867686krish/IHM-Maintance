<div class="modal fade" id="AdminShoreDpModel" tabindex="-1" role="dialog" aria-labelledby="DesignatedModellLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DesignatedModellLabel">Designated Person Details</h5>
                <button type="button" class="close DesignatedModelClose" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('designatedPerson.admin')}}" id="adminshoredpForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                        <input type="hidden" id="id" name="id" class="form-control">
                        <input type="hidden" name="type" id="type" value="shore">
                        <input type="hidden" name="main_ship_id" id="main_ship_id" value="{{$ship_id}}">
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
                                <label for="name">Rank <span class="text-danger">*</span></label>
                                <input type="text" id="rank" name="rank" class="form-control">
                                <div class="invalid-feedback error" id="rankError"></div>

                            </div>
                        </div>
                      
                      
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
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Start Date <span class="text-danger">*</span></label>
                                <input type="date" id="sign_on_date" name="sign_on_date" class="form-control">
                                <div class="invalid-feedback error" id="sign_on_dateError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">End Date</label>
                                <input type="date" id="sign_off_date" name="sign_off_date" class="form-control">
                                <div class="invalid-feedback error" id="sign_off_dateError"></div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="shoredpSave">Save changes</button>
            </div>
        </div>
    </div>
</div>