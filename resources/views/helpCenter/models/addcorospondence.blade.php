<div class="modal" tabindex="-1" role="dialog" id="corospondenceModel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Correspondence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addcorrespondencesForm" action="{{route('correspondence.save')}}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @if($ships)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">

                        <div class="form-group col-12 mb-3">
                            <label for="assign_date">Ships<span class="text-danger">*</span></label>

                            <select name="ship_id" id="ship_id" class="form-control form-control-lg">
                                @foreach($ships as $ship)
                                <option value="{{$ship['id']}}">{{$ship['ship_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
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
                            <textarea id="mytextarea" value=""></textarea>

                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                        <div class="form-group">
                            <label for="attachment">Attachment</label>

                            <input type="file" class="form-control form-control-lg" id="attachment" name="attachment" autocomplete="off" onchange="removeInvalidClass(this)">


                        </div>
                    </div>

                    <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="button" id="correspondencesSave">Save</button>
                                </div>
                            </div>
            </div>
            </form>
        </div>

    </div>
</div>
</div>