<form method="post" class="needs-validation" novalidate="" id="avilabletemplateForm" enctype="multipart/form-data" action="{{route('avilabletemplate.save')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{@$configration->id}}">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="name">Training Materials</label>
                                    <input type="file" class="form-control " id="name" value="" name="training_material" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                                @if(@$configration['client_company'])
                                    <a href="{{asset('uploads/avilable/'.$configration['training_material'])}}" target="_blank">View Attachment</a>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="name">Briefing Materials</label>
                                    <input type="file" class="form-control " id="briefing_material" value="" name="briefing_material" placeholder="Comapny Name..." autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                                @if(@$configration['briefing_material'])
                                    <a href="{{asset('uploads/avilable/'.$configration['briefing_material'])}}" target="_blank">View Attachment</a>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="name">SMS Extract</label>
                                    <input type="file" class="form-control " id="sms_extract" value="" name="sms_extract" placeholder="Comapny Name..." autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                                @if(@$configration['sms_extract'])
                                    <a href="{{asset('uploads/avilable/'.$configration['sms_extract'])}}" target="_blank">View Attachment</a>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                                <div class="form-group mb-3">
                                    <label for="name">Operation Manual</label>
                                    <input type="file" class="form-control " id="operation_manual" value="" name="operation_manual" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                                @if(@$configration['operation_manual'])
                                    <a href="{{asset('uploads/avilable/'.$configration['operation_manual'])}}" target="_blank">View Attachment</a>
                                @endif
                            </div>

                        </div>
                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <button class="btn btn-primary float-right" type="button" id="avilableTemplateSave">Save</button>
                            </div>
                        </div>
                    </form>