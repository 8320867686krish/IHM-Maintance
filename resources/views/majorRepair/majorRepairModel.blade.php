<div class="modal" tabindex="-1" role="dialog" id="majorRepairModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Major Repair</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('majorrepair.save')}}" id="majorRepairForm"
          enctype="multipart/form-data">
          @csrf
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
            <input type="hidden" name="id" id="id">
            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="nameError"></div>

              </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">Date</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="dateError"></div>

              </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">Location Name / Address</label>
                <input type="text" id="location_name" name="location_name" class="form-control @error('location_name') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="location_nameError"></div>

              </div>
            </div>

           
            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">Document</label>
                <input type="file" id="document" name="document" class="form-control @error('document') is-invalid @enderror" accept="application/pdf">
                <div class="invalid-feedback error" id="documentError"></div>

              </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">Document Upload By</label>
                <input type="text" id="document_uploaded_by" name="document_uploaded_by" class="form-control @error('document_uploaded_by') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="document_uploaded_byError"></div>

              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="savemajorRepair">Save changes</button>
      </div>

    </div>
  </div>
</div>