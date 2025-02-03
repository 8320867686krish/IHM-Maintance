<div class="modal" tabindex="-1" role="dialog" id="smsModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sms</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('sms.save')}}" id="smsForm"
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
                <label for="name">Client</label>
                <select class="form-control  @error('client_company_id') is-invalid @enderror" name="client_company_id" id="client_company_id">
                  <option value="">Select Client</option>

                  @foreach($clientCompany as $value)
                  <option value="{{$value['id']}}">{{$value['name']}}</option>

                  @endforeach
                </select>
                <div class="invalid-feedback error" id="client_company_idError"></div>


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
        <button type="button" class="btn btn-primary" id="saveSms">Save changes</button>
      </div>

    </div>
  </div>
</div>