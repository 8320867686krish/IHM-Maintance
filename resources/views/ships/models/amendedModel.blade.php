<div class="modal" tabindex="-1" role="dialog" id="amendedModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Amended</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('amended')}}" id="amendedForm"
          enctype="multipart/form-data">
          @csrf
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">

            <input type="hidden" id="ship_id" name="ship_id" class="form-control" value="{{$ship_id}}">


            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">Current IHM Version</label>
                <input type="text" id="current_ihm_version" name="current_ihm_version" readonly class="form-control" value="{{$ship->current_ihm_version ?? ""}}">
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">IHM Version Updated Date</label>
                <input type="text" id="ihm_version_updated_date" name="ihm_version_updated_date" class="form-control" value="{{$ship->ihm_version_updated_date ?? ""}}" readonly>
              </div>
            </div>





            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">New IHM Version</label>
                <input type="text" id="new_ihm_version" name="new_ihm_version" class="form-control">

              </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">New Version Updated Date</label>
                <input type="date" id="new_version_date" name="new_version_date" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="saveAmended">Save changes</button>
      </div>

    </div>
  </div>
</div>