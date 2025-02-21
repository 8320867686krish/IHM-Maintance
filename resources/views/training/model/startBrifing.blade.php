<div class="modal" tabindex="-1" role="dialog" id="startBrifingModel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Briefing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('brifing.save')}}" id="startBrifingForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                    <input type="hidden" id="id" name="id">

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Number Of Attendance</label>
                                <input type="mumber" id="number_of_attendance" name="number_of_attendance" class="form-control @error('number_of_attendance') is-invalid @enderror" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="number_of_attendanceError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Briefing Date</label>
                                <input type="date" id="brifing_date" name="brifing_date" class="form-control @error('brifing_date') is-invalid @enderror" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="brifing_dateError"></div>

                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Briefing By</label>
                                <select class="form-control  @error('designated_people_id') is-invalid @enderror" name="designated_people_id" id="designated_people_id">
                                    <option value="">Select Designated Person</option>
                                    @if(@$designatedPerson)
                                        @foreach($designatedPerson as $value)
                                            <option value="{{$value['id']}}">{{$value['name']}}</option>
                                        @endforeach
                                    @endif

                                </select>
                                <div class="invalid-feedback error" id="designated_people_idError"></div>


                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveBrifing">Save changes</button>
            </div>

        </div>
    </div>
</div>