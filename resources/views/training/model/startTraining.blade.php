<div class="modal" tabindex="-1" role="dialog" id="startTrainingModel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Training</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('training.savedesignated')}}" id="trainingStart"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              
                  
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">

                       
                  

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name"></label>
                                <select class="form-control  @error('designated_people_id') is-invalid @enderror" name="designated_people_id" id="designated_people_id" required>
                                    <option value="">Select Designated Person</option>
                                    @if(@$designatedPerson)
                                        @foreach($designatedPerson as $value)
                                            <option value="{{$value['id']}}">{{$value['name']}}</option>
                                        @endforeach
                                    @endif

                                </select>


                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="startTraining">Strat Training</button>
            </div>
</form>

        </div>
    </div>
</div>