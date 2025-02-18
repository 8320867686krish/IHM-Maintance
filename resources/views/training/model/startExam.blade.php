<div class="modal" tabindex="-1" role="dialog" id="satrtExamModel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <form  method="post"  action="{{route('start.exam')}}" id="stratExamForm">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                                <div class="form-group">
                                <label class="custom-control custom-checkbox">Have you read the training materials completely
                                </label>

                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="dontread">No</button>
                    <button type="submit" class="btn btn-success" id="finalstart">Yes</button>
                </div>
            </form>

        </div>
    </div>
</div>