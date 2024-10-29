   <div class="modal fade" data-backdrop="static" id="relevantModal" tabindex="-1" role="dialog"
       aria-labelledby="relevantModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document" style="width: 70% !important; max-width: none !important;">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">HAZMAT selection</h5>
                   <a href="#" class="close" data-dismiss="modal" aria-label="Close"
                       id="checkDataAddCloseBtn">
                       <span aria-hidden="true">×</span>
                   </a>
               </div>

               <form method="post" action="#" id="checkHazmatAddForm"
                   enctype="multipart/form-data">
                   <div class="modal-body"
                       style="overflow-x: auto; overflow-y: auto; max-height: calc(81vh - 1rem);">
                       @csrf
                       <input type="hidden" name="shipId" id="shipId" >

                       <input type="hidden" name="po_order_id" id="po_order_id" >
                       <input type="hidden" name="id" id="id" >

                       <div class="offset-xl-1 col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 row">
                           <div class="col-6 col-md-6" id="chkName">
                               <div class="form-group mb-4">
                                   <label for="name">Description</label>
                                   <input type="text" id="description" name="description" class="form-control"
                                       readonly>
                               </div>
                           </div>


                           <div class="col-6 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="equipment">Part No"</label>
                                   <input type="text" id="part_no" name="part_no" class="form-control">
                               </div>
                           </div>
                           <div class="col-6 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="Qty">Qty</label>
                                   <input type="text" id="qty" name="qty"
                                       class="form-control">
                               </div>
                           </div>
                          
                           <div class="col-12 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="unit_price">Unit Price</label>
                                   <input type="text" id="unit_price" name="unit_price" class="form-control">
                               </div>
                           </div>

                           <div class="col-12 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="type_category">Type</label>
                                   <select class="form-control form-control-lg" name="type_category">
                                        <option value="Relevant">Relevant</option>
                                        <option value="Non relevant">Non relevant</option>
                                    </select>
                               </div>
                           </div>

                           
                           
                           <div class="col-12 col-md-6">
                               <div class="form-group mb-4">
                                   <label for="suspected_hazmat">Suspected Hazmat</label>
                                   <select class="form-control selectpicker" id="suspected_hazmat"
                                       name="suspected_hazmat[]" multiple>
                                       <option value="">Select Hazmat</option>
                                       @if (isset($hazmats))
                                       @foreach ($hazmats as $key => $value)
                                       <optgroup label="{{ strtoupper($key) }}">
                                           @foreach ($value as $hazmat)
                                           <option value="{{ $hazmat->id }}">
                                               {{ $hazmat->name }}
                                           </option>
                                           @endforeach
                                       </optgroup>
                                       @endforeach
                                       @endif
                                   </select>
                               </div>
                           </div>
                           <div class="col-12">
                               <div class="col-12 col-md-12 mb-4"
                                   style="background: #efeff6;border: 1px solid #efeff6;">
                                   <div class="pt-4">
                                       <h5 class="text-center mb-4" style="color:#757691">Document Analysis Results
                                       </h5>
                                       <div class="mb-4 col-12" id="showTableTypeDiv">

                                       </div>
                                   </div>
                               </div>


                           </div>


                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="submit" class="btn btn-primary" id="checkHazmatAddSubmitBtn">Save</button>
                   </div>
               </form>
           </div>
       </div>
   </div>
   @push('js')
   <script>
    var shipSave = "{{ route('poItems.hazmat') }}";
</script>
   @endpush