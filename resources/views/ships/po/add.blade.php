@extends('layouts.app')
@section('shiptitle','Po Records')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/css/summernote-bs4.css')}}">

<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header"> <a href="{{url($backurl)}}"><span class="icon"><i class="fas fa-arrow-left"></i></span> Back</a> <span class="ml-1">{{ $head_title ?? '' }} PO</span></h5>
                <form method="post" action="{{route('po.store')}}" class="needs-validation" novalidate
                    id="POForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="deleted_id" id="deleted_id" value="">

                        <input type="hidden" name="ship_id" id="ship_id" value="{{$ship_id}}">
                        <input type="hidden" name="po_id" id="po_id" value="{{@$poData->id}}">
                        <div class="row mb-5">
                            <div class="col-12 text-center">
                                <label class="mr-2">Status: </label>
                                <select class="form-control-lg" name="postatus">
                                        <option value="PO Created" {{ $poData->postatus == 'PO Created' ? 'selected' : '' }}>PO Created</option>
                                        <option value="Communication In Progress" {{ $poData->postatus == 'Communication In Progress' ? 'selected' : '' }}>Communication In Progress</option>
                                        <option value="Completed" {{ $poData->postatus == 'Completed' ? 'selected' : '' }}>Completed</option>

                                </select>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control form-control-lg" id="po_no" value="{{@$poData->po_no}}" name="po_no" autocomplete="off" onchange="removeInvalidClass(this)" placeholder="">
                                    <label for="assign_date">PO NO<span class="text-danger">*</span></label>
                                    <div class="invalid-feedback error" id="po_noError"></div>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="date" class="form-control form-control-lg" id="po_date" value="{{@$poData->po_date}}" name="po_date" autocomplete="off" onchange="removeInvalidClass(this)" placeholder="">
                                    <label for="assign_date">PO Date<span class="text-danger">*</span></label>
                                    <div class="invalid-feedback error" id="po_dateError"></div>
                                </div>
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control form-control-lg" id="machinery" name="machinery" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->machinery}}" placeholder="">
                                    <label for="machinery">Machinery</label>
                                    <div class="invalid-feedback error" id="machineryError"></div>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control form-control-lg" id="make_model" name="make_model" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->make_model}}" placeholder="">
                                    <label for="make_model">Make Model</label>
                                    <div class="invalid-feedback error" id="make_modelError"></div>
                                </div>
                            </div>




                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control form-control-lg" id="supplier_name" name="supplier_name" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->supplier_name}}" placeholder="">
                                    <label for="supplier_name">Supplier Name</label>
                                    <div class="invalid-feedback error" id="supplier_nameError"></div>
                                </div>
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control form-control-lg" id="address" name="address" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->address}}" placeholder="">
                                    <label for="supplier_name">Supplier Address</label>
                                    <div class="invalid-feedback error" id="addressError"></div>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-group   input-label-group">
                                    <input type="text" class="form-control form-control-lg" id="contact_person" name="contact_person" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->contact_person}}" placeholder="">
                                    <label for="supplier_name">Supplier Contact Person</label>

                                    <div class="invalid-feedback error" id="contact_personError"></div>
                                </div>
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control form-control-lg" id="phone" name="phone" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->phone}}" placeholder=" ">
                                    <label for="supplier_name">Supplier Phone Number</label>
                                    <div class="invalid-feedback error" id="phoneError"></div>
                                </div>
                            </div>



                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">
                                    <input type="text" class="form-control form-control-lg" id="email" name="email" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->email}}" placeholder="">
                                    <label for="supplier_name">Supplier Email <span class="text-danger">*</span></label>

                                    <div class="invalid-feedback error" id="emailError"></div>
                                </div>
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="date" class="form-control form-control-lg" id="onboard_reciving_date" name="onboard_reciving_date" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->onboard_reciving_date}}" placeholder="">
                                    <label for="onboard_reciving_date">Onboard reciving date</label>
                                    <div class="invalid-feedback error" id="onboard_reciving_dateError"></div>
                                </div>
                            </div>

                            <div class="col-4 mb-2">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control form-control-lg" id="delivery_location" name="delivery_location" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->delivery_location}}" placeholder="">
                                    <label for="delivery_location">Delivery Location</label>
                                    <div class="invalid-feedback error" id="delivery_locationError"></div>
                                </div>
                            </div>





                        </div>

                    </div>
                    <hr />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>Order Items</h4>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="button" id="addItemBtn"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="row new-item-row">
                            <div class="form-group col-3 mb-3">
                                <label for="machinery">Description</label>
                            </div>
                            <div class="form-group col-2 mb-3">
                                <label for="contact_person">IMPA NO.(if available)</label>

                            </div>
                            <div class="form-group col-2 mb-3">
                                <label for="make_model">Part No</label>
                            </div>
                            <div class="form-group col-1 mb-3">
                                <label for="supplier_name">Qty</label>

                            </div>
                            <div class="form-group col-1 mb-3">
                                <label for="address">Unit</label>
                            </div>

                            <div class="form-group col-1 mb-3">
                                <label for="contact_person">Relevancy</label>

                            </div>
                        </div>
                        <div id="orderItemsContainer">
                            @if(@$poData->poOrderItems && count($poData->poOrderItems) > 0)
                            @foreach($poData->poOrderItems as $key=>$item)
                            <div class="row new-item-row" data-id="{{$item->id}}" data-item="{{$item}}">
                                <div class="form-group col-3 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][description]" autocomplete="off" placeholder="Description" value="{{$item->description}}">
                                    <div class="invalid-feedback error"></div>
                                </div>
                                <div class="form-group col-2 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][impa_no]" autocomplete="off" placeholder="IMPA NO" value="{{$item->impa_no   }}">
                                    <div class="invalid-feedback error"></div>
                                </div>
                                <div class="form-group col-2 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][part_no]" autocomplete="off" placeholder="Part No" value="{{$item->part_no}}">
                                    <div class="invalid-feedback error"></div>
                                </div>

                                <div class="form-group col-1 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][qty]" autocomplete="off" placeholder="Qty" value="{{$item->qty}}">
                                    <div class="invalid-feedback error"></div>
                                </div>

                                <div class="form-group col-1 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][unit]" autocomplete="off" placeholder="Unit" value="{{$item->unit}}">
                                    <div class="invalid-feedback error"></div>
                                </div>



                                <div class="form-group col-2 mb-3">
                                    <select class="form-control form-control-lg" name="items[{{$item->id}}][type_category]" required>
                                        <option value="">Please select relevancy</option>
                                        <option value="Relevant" {{ $item->type_category === 'Relevant' ? 'selected' : '' }}>Relevant</option>
                                        <option value="Non relevant" {{ $item->type_category === 'Non relevant' ? 'selected' : '' }}>Non relevant</option>

                                    </select>
                                    <div id="items_{{$item->id}}_type_categoryError" class="invalid-feedback error"></div>

                                </div>
                                <div class="form-group col-1 mb-3">
                                    <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn" title="Delete"></i>
                                    @if($item->type_category == 'Relevant')
                                    <a href="{{ route('po.relevent', $item->id) }}" title="Edit">
                                        <i class="fas fa-edit text-primary ml-2 view-item-btn"></i></a>
                                    @endif
                                </div>


                            </div>
                            @endforeach
                            @else
                            <div class="form-group col-12 mb-3 text-center" id="emptyMsg">
                                <label for="address">There are No Items in this Order</label>
                            </div>
                            @endif
                        </div>
                        <div class="form-group col-12 mb-3 text-center" id="msgShow" style="display:none">
                            <label for="address">There are No Items in this Order</label>
                        </div>


                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary float-right mb-3"
                                type="submit">Save</button>
                        </div>
                    </div>
                </form>
                @if(@$poData->id)
                <hr />
                <div class="card-body mb-2">
                    <div class="row">
                        <div class="col-6">
                            <h4>Email History With Vendor</h4>
                        </div>
                        @if($currentUserRoleLevel == 2)
                        <div class="col-6">
                            <div class="form-group">

                                <button class="btn btn-primary float-right" type="button" id="sendtovendor"><i class="fas fa-paper-plane"></i> &nbsp;&nbsp;Email To Vendor</button>


                            </div>
                        </div>
                        @endif

                        <div class="col-12">
                            <h5>Document Received Date :
                                {!! $poData['isRecivedDoc'] == 0
                                ? '<span class="text-danger">Not Received</span>'
                                : \Carbon\Carbon::parse($poData['recived_document_date'])->format('d/m/y') !!}</h5>
                        </div>
                        <div class="col-12">
                            <div class="mt-2 mb-4">
                                <table class="table table-striped table-bordered first dataTable no-footer">

                                    <thead>
                                        <tr>
                                            <th>From</th>
                                            <th>To Email(Supplier)</th>
                                            <th>CC Email(Company)</th>
                                            <th>CC Email (Accounting)</th>
                                            <th>Sent Date</th>

                                        </tr>

                                    </thead>
                                    <tbody>
                                        @forelse(@$filteredEmailHVendoristory as $history)
                                        <tr>
                                            <td>{{$history['from_email']}}</td>
                                            <td>{{$history['suppliear_email']}}</td>
                                            <td>{{$history['company_email']}}</td>
                                            <td>{{$history['accounting_email']}}</td>

                                            <td>{{ \Carbon\Carbon::parse(trim($history['created_at']))->setTimezone('Asia/Kolkata')->format('d/m/y g:i A') }}

                                            </td>


                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No email history available.</td>
                                        </tr>
                                        @endforelse



                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <div class="form-group ">
                                <button class="btn btn-primary" type="button" id="FromVendor">
                                    <i class="fas fa-inbox"></i>&nbsp;&nbsp;Received Documents
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="card-body mb-4">
                    <div class="row">
                        <div class="col-6">
                            <h4>Email History With Ship</h4>
                        </div>

                        <div class="col-12">
                            <div class="mt-2 mb-4">
                                <table class="table table-striped table-bordered first dataTable no-footer">

                                    <thead>
                                        <tr>
                                            <th>From Email</th>
                                            <th>To Email(Supplier)</th>
                                            <th>CC Email(Company)</th>
                                            <th>CC Email (Accounting)</th>
                                            <th>CC Email (Ship Staff)</th>
                                            <th>Sent Date</th>

                                        </tr>

                                    </thead>
                                    <tbody>
                                        @forelse(@$filteredEmailHistory as $history)
                                        <tr>
                                            <td>{{$history['from_email']}}</td>
                                            <td>{{$history['suppliear_email']}}</td>
                                            <td>{{$history['company_email']}}</td>
                                            <td>{{$history['accounting_email']}}</td>
                                            <td>{{$history['shipstaff_email']}}</td>

                                            <td>{{ \Carbon\Carbon::parse(trim($history['created_at']))->setTimezone('Asia/Kolkata')->format('d/m/y g:i A') }}

                                            </td>


                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No email history available.</td>
                                        </tr>
                                        @endforelse



                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

</div>


@endsection
@include('ships.po.modals.sendVendorMail')
@include('ships.po.modals.recivedDocModel')

@push('js')
<!-- <script type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script> -->
<script src="{{ asset('assets/vendor/summernote/js/summernote-bs4.js') }}"></script>

<script>
    var poItemGrid = "{{ url('ship/view') }}/{{ $ship_id }}#po-records"
    var itemIndex = "{{ isset($poData->poOrderItems) ? count($poData->poOrderItems) : 0 }}";
    var editorInstance;

    document.addEventListener('DOMContentLoaded', function() {
        $('#summernote').summernote({
            height: 300,
            lineHeights: ['0.5', '1.0', '1.2', '1.5', '2.0'],
            codemirror: { // codemirror options
                theme: 'monokai'
            }
        });


    });
</script>
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script src="{{ asset('assets/js/poOrder.js') }}"></script>

@endpush