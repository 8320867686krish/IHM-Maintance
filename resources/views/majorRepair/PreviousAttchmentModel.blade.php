<div class="modal" tabindex="-1" role="dialog" id="PreviousAttachmentModel">
  <div class="modal-dialog modal-lg" role="document" style="max-width:50%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Previous Attachment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('previousAttachment.save')}}" id="PreviousAttachmentModelForm"
          enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id" id="id"/>
         
          <div class=" row">

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">

                <label for="name">Attachment Name</label>
                <input type="text" id="attachment_name" name="attachment_name" class="form-control @error('attachment_name') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="attachment_nameError"></div>

              </div>
           

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Date From</label>
                <input type="date" id="date_from" name="date_from" class="form-control @error('date_from') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="date_fromError"></div>

              </div>

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Date Till</label>
                <input type="date" id="date_till" name="date_till" class="form-control @error('date_till') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="date_tillError"></div>

              </div>

             

              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Maintained By</label>
                <input type="text" id="maintained_by" name="maintained_by" class="form-control @error('maintained_by') is-invalid @enderror" onchange="removeInvalidClass(this)">
                <div class="invalid-feedback error" id="maintained_byError"></div>

            </div>

           
              <div class="form-group col-6 col-md-6 col-lg-6 mb-4">
                <label for="name">Attachment</label>
                <input type="file" id="attachment" name="attachment" class="form-control @error('attachment') is-invalid @enderror" accept="application/pdf">
                <div class="invalid-feedback error" id="attachmentError"></div>

            </div>

            

             
            

           
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="savePreviousAttachmentModel">Save changes</button>
      </div>

    </div>
  </div>
</div>