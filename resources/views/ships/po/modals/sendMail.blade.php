   <div class="modal fade" data-backdrop="static" id="relevantModal" tabindex="-1" role="dialog"
       aria-labelledby="relevantModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document" style="  width: 50% !important;
    max-width: none !important;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: center; ">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Send Email</h5>
                   <a href="#" class="close" data-dismiss="modal" aria-label="Close"
                       id="checkDataAddCloseBtn">
                       <span aria-hidden="true">×</span>
                   </a>
               </div>

               <form method="post" action="{{route('send.mail')}}" id="sendEmailForm"
                   enctype="multipart/form-data" >
                   <div class="modal-body"
                       style="overflow-x: auto; overflow-y: auto; max-height: calc(81vh - 1rem);">
                       @csrf
                       <input type="hidden" name="shipId" id="shipId">

                       <input type="hidden" name="order_id" id="order_id">

                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                           <div class="col-12 col-md-12" id="chkName">
                               <div class="form-group mb-4">
                                   <label for="name">Subject</label>
                                   <input type="text" id="email_subject" name="email_subject" class="form-control"/>
                               </div>
                           </div>

                           <div class="col-12 col-md-12" id="chkName">
                               <div class="form-group mb-4">
                                   <label for="name">Description</label>
                                   <textarea class="form-control" id="email_body" name="email_body" rows="3"></textarea>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="submit" class="btn btn-primary" id="sendEmail">Save</button>
                   </div>
               </form>
           </div>
       </div>
   </div>