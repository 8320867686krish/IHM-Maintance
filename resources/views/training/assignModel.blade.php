<div class="modal" tabindex="-1" role="dialog" id="assignModel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('assigntraining')}}" id="assignTrainingForm"  enctype="multipart/form-data">
            @csrf
                <div class="modal-body">

                  
                    <input type="hidden" id="training_sets_id" name="training_sets_id">
                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                        <div class="form-group">
                            <label for="name">Hazmat Company</label>
                            <select class="form-control @error('hazmat_companies_id') is-invalid @enderror" name="hazmat_companies_id" id="hazmat_companies_id"  onchange="removeInvalidClass(this)">
                                <option value="">Select Company</option>
                                @foreach($hazmatCompany as $value)
                                <option value="{{$value['id']}}">{{$value['name']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback error" id="hazmat_companies_idError"></div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary assign">Save</button>
                </div>
            
                </form>

        </div>
    </div>
</div>