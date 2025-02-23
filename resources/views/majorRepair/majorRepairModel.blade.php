<div class="modal" tabindex="-1" role="dialog" id="majorRepairModel">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Repair</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('majorrepair.save')}}" id="majorRepairForm"
          enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id" id="id"/>
         
          <div class=" row">

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">

                <label for="name">Document Title</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="nameError"></div>

              </div>
              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Document Upload By</label>
                <input type="text" id="document_uploaded_by" name="document_uploaded_by" class="form-control @error('document_uploaded_by') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="document_uploaded_byError"></div>

            </div>

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Entry Date</label>
                <input type="date" id="entry_date" name="entry_date" class="form-control @error('entry_date') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="entry_dateError"></div>

              </div>

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Document Date</label>
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="dateError"></div>

              </div>

             

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Location Name / Address</label>
                <input type="text" id="location_name" name="location_name" class="form-control @error('location_name') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="location_nameError"></div>

            </div>

           
              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Document</label>
                <input type="file" id="document" name="document" class="form-control @error('document') is-invalid @enderror" accept="application/pdf">
                <div class="invalid-feedback error" id="documentError"></div>

            </div>

            

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Before Image</label>
                <input type="file" id="before_image" name="before_image" class="form-control @error('before_image') is-invalid @enderror">
                <div class="invalid-feedback error" id="before_imageError"></div>

            </div>
            <div class="form-group col-6 col-md-6 col-lg-6  mb-4">
                <label for="name">After Image</label>
                <input type="file" id="after_image" name="after_image" class="form-control @error('after_image') is-invalid @enderror">
                <div class="invalid-feedback error" id="after_imageError"></div>

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