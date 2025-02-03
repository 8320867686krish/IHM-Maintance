<div class="modal" tabindex="-1" role="dialog" id="credentialModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Credential</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('credential.save')}}" id="credentialForm"
          enctype="multipart/form-data">
          @csrf
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">

          <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">Title</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="titleError"></div>

              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12 mb-2">
              <div class="form-group">
                <label for="name">Document</label>
                <input type="file" id="document" name="document" class="form-control @error('document') is-invalid @enderror" accept="application/pdf">
                <div class="invalid-feedback error" id="documentError"></div>

              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="saveCredential">Save changes</button>
      </div>

    </div>
  </div>
</div>