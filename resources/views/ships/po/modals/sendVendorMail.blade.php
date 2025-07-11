  


   <div class="modal fade" id="sendVendorMail" tabindex="-1" role="dialog" aria-labelledby="sendVendorMail">
    <div class="modal-dialog modal-lg" role="document">
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
                    <input type="hidden" name="history_type" id="history_type" value="vendor">

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
                                <textarea class="form-control" id="summernote" name="email_body" rows="6" placeholder="Write Descriptions"></textarea>
                               </div>
                           </div>
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="name">Attachments <span class="text-danger">*</span></label>
                                <input type="file" id="attachments" name="attachments[]" multiple class="form-control">
                              
                                <div class="invalid-feedback error" id="attachmentsError"></div>

                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-12 ml-4">
                                  <ul id="fileList"></ul>
                            </div>
                        </div>
                        
                      
                       
                      
                     
                     
                       
                      
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendEmail">Send Mail</button>
            </div>
        </div>
    </div>
</div>
