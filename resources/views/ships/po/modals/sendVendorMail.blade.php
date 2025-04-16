  


   <div class="modal fade" id="sendVendorMail" tabindex="-1" role="dialog" aria-labelledby="sendVendorMail">
    <div class="modal-dialog modal-lg" role="document" style="max-width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendVendorMail">Send Email</h5>
                <button type="button" class="close checkDataAddCloseBtn" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('send.mail')}}" id="sendEmailForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                    <input type="hidden" name="shipId" id="shipId" value="{{$ship_id}}">
                    <input type="hidden" name="order_id" id="order_id" value="{{@$poData->id}}">

                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Subject <span class="text-danger">*</span></label>
                                <input type="text" id="email_subject" name="email_subject" class="form-control @error('email_subject') is-invalid @enderror" value="Urgent MD & SDOC Request For {{$client_name}}">
                                <div class="invalid-feedback error" id="email_subjectError"></div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12" id="chkName">
                               <div class="form-group mb-4">
                                   <label for="name">Description</label>
                                   <textarea  id="email_body" name="email_body" rows="3"></textarea>
                               </div>
                           </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Attachments <span class="text-danger">*</span></label>
                                <input type="file" id="attachments" name="attachments[]" multiple class="form-control">
                                <div class="invalid-feedback error" id="attachmentsError"></div>

                            </div>
                        </div>
                      
                       
                      
                     
                     
                       
                      
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendEmail">Save changes</button>
            </div>
        </div>
    </div>
</div>
