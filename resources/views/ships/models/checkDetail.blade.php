 <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="checkDataAddModal" tabindex="-1" role="dialog"
            aria-labelledby="checkDataAddModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="margin-left:15%;max-width:none">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Checks</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close"
                            id="checkDataAddCloseBtn">
                            <span aria-hidden="true">×</span>
                        </a>
                    </div>

                    <form method="post" action="{{route('check.save')}}" id="checkDataAddForm"
                        enctype="multipart/form-data">
                        <div class="modal-body"
                            style="overflow-x: auto; overflow-y: auto; max-height: calc(81vh - 1rem);">
                            @csrf
                            <input type="hidden" id="allCheck" name="allCheck">
                            <input type="hidden" id="check_id" name="id">
                            <input type="hidden" id="formType" value="add">
                            <input type="hidden" id="ship_id" name="ship_id"
                                value="{{ $deck->ship_id ?? '' }}">
                            <input type="hidden" id="deck_id" name="deck_id" value="{{ $deck->id ?? '' }}">
                            <input type="hidden" id="position_left" name="position_left">
                            <input type="hidden" id="position_top" name="position_top">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row">
                                <div class="col-4 col-md-4 mb-2" id="chkName">
                                    <div class="form-group">
                                        <label for="name">Sample NO</label>
                                        <input type="text" id="chksName" name="name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-4 col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="type">Type <span class="text-danger">*</span></label>
                                        <select name="type" id="chkType" class="form-control">
                                            <option value>Select Type</option>
                                            <option value="sample">Sample</option>
                                            <option value="visual">Visual</option>
                                        </select>
                                        <div class="invalid-feedback error" id="typeError"></div>
                                    </div>
                                </div>
                               
                           
                              

                            
                              
                                <div class="col-12 mb-2">
                                <button class="btn btn-primary float-right btn-rounded addNewItemBtn" type="button">Add Item</button>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="col-12 col-md-12  pt-4"
                                        style="background: #efeff6;border: 1px solid #efeff6;" id="showTableHazmat">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="checkDataAddSubmitBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>