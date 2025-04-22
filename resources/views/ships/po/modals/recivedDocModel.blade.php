   <div class="modal fade" data-backdrop="static" id="recivedDocModel" tabindex="-1" role="dialog"
       aria-labelledby="relevantModalLabel">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Recived Document</h5>
                   <a href="#" class="close" data-dismiss="modal" aria-label="Close"
                       id="checkDataAddCloseBtn">
                       <span>×</span>
                   </a>
               </div>

               <form method="post" action="{{route('recivedDoc')}}" id="recivedDocForm"
                   enctype="multipart/form-data" >
                   <div class="modal-body"
                       style="overflow-x: auto; overflow-y: auto; max-height: calc(81vh - 1rem);">
                       @csrf

                       <input type="hidden" name="recived_order_id" id="recived_order_id">

                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                           <div class="col-12 col-md-12" id="chkName">
                               <div class="form-group mb-4">
                                   <label for="name">Remarks</label>
                                   <textarea class="form-control" id="recived_document_comment" name="recived_document_comment" rows="3"></textarea>

                               </div>
                           </div>

                           <div class="col-12 col-md-12" id="chkName">
                               <div class="form-group mb-4">
                                   <label for="name">Date</label>
                                   <input type="date" id="recived_document_date" name="recived_document_date" class="form-control"/>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="submit" class="btn btn-primary" id="reciveddocsave">Save</button>
                   </div>
               </form>
           </div>
       </div>
   </div>