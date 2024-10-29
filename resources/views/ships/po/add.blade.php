@extends('layouts.app')
@section('shiptitle','Po Records')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
@endsection
@section('content')
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
                        <div class="row">
                            <div class="form-group col-6 mb-3">
                                <label for="assign_date">PO NO<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="po_no" value="{{@$poData->po_no}}" name="po_no" autocomplete="off" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="po_noError"></div>
                            </div>

                            <div class="form-group col-6 mb-3">
                                <label for="assign_date">Request NO<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="request_number" value="{{@$poData->request_number}}" name="request_number" name="po_no" autocomplete="off" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="request_noError"></div>
                            </div>


                            <div class="form-group col-6 mb-3">
                                <label for="vessel_no">Vessel No</label>
                                <input type="text" class="form-control form-control-lg" id="vessel_no" name="vessel_no" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->vessel_no}}">
                                <div class="invalid-feedback error" id="vessel_noError"></div>
                            </div>

                            <div class="form-group col-6 mb-3">
                                <label for="machinery">Machinery</label>
                                <input type="text" class="form-control form-control-lg" id="machinery" name="machinery" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->machinery}}">
                                <div class="invalid-feedback error" id="machineryError"></div>
                            </div>
                            <div class="form-group col-6 mb-3">
                                <label for="vessel_no">Make Model</label>
                                <input type="text" class="form-control form-control-lg" id="make_model" name="make_model" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->make_model}}">
                                <div class="invalid-feedback error" id="make_modelError"></div>
                            </div>




                            <div class="form-group col-6 mb-3">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" class="form-control form-control-lg" id="supplier_name" name="supplier_name" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->supplier_name}}">
                                <div class="invalid-feedback error" id="supplier_nameError"></div>
                            </div>

                            <div class="form-group col-6 mb-3">
                                <label for="supplier_name">Address</label>
                                <input type="text" class="form-control form-control-lg" id="address" name="address" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->address}}">
                                <div class="invalid-feedback error" id="addressError"></div>
                            </div>

                            <div class="form-group col-6 mb-3">
                                <label for="supplier_name">Contact Person</label>
                                <input type="text" class="form-control form-control-lg" id="contact_person" name="contact_person" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->contact_person}}">
                                <div class="invalid-feedback error" id="contact_personError"></div>
                            </div>


                            <div class="form-group col-6 mb-3">
                                <label for="supplier_name">Phone Number</label>
                                <input type="text" class="form-control form-control-lg" id="phone" name="phone" autocomplete="off" onchange="removeInvalidClass(this)" value="{{@$poData->phone}}">
                                <div class="invalid-feedback error" id="phoneError"></div>
                            </div>




                            <div class="form-group col-6 mb-3">
                                <label for="supplier_name">Email</label>
                                <input type="text" class="form-control form-control-lg" id="email" name="email" autocomplete="off" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="emailError"></div>
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
                                <label for="make_model">Part No</label>
                            </div>
                            <div class="form-group col-1 mb-3">
                                <label for="supplier_name">Qty</label>

                            </div>
                            <div class="form-group col-2 mb-3">
                                <label for="address">Unit Price</label>
                            </div>
                            <div class="form-group col-1 mb-3">
                                <label for="contact_person">Amount</label>

                            </div>
                            <div class="form-group col-1 mb-3">
                                <label for="contact_person">Type</label>

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
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][part_no]" autocomplete="off" placeholder="Part No" value="{{$item->part_no}}">
                                    <div class="invalid-feedback error"></div>
                                </div>

                                <div class="form-group col-1 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][qty]" autocomplete="off" placeholder="Qty" value="{{$item->qty}}">
                                    <div class="invalid-feedback error"></div>
                                </div>

                                <div class="form-group col-2 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][unit_price]" autocomplete="off" placeholder="Unit Price" value="{{$item->unit_price}}">
                                    <div class="invalid-feedback error"></div>
                                </div>

                                <div class="form-group col-1 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][amount]" autocomplete="off" placeholder="Amount" value="{{$item->amount}}">
                                    <div class="invalid-feedback error"></div>
                                </div>

                                <div class="form-group col-2 mb-3">
                                    <select class="form-control form-control-lg" name="items[{{$item->id}}][type_category]">
                                        <option value="Relevant" {{ $item->type_category === 'Relevant' ? 'selected' : '' }}>Relevant</option>
                                        <option value="Non relevant" {{ $item->type_category === 'Non relevant' ? 'selected' : '' }}>Non relevant</option>
                                    </select>
                                </div>
                                <div class="form-group col-1 mb-3">
                                    <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn"></i>
                                    @if($item->type_category === 'Relevant')
                                    <i class="fas fa-eye text-info ml-2 view-item-btn"></i>
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
            </div>
        </div>
    </div>
 
    @include('ships.po.modals.viewRelevent')
</div>
@endsection
@push('js')
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script src="{{ asset('assets/js/poOrder.js') }}"></script>
<script>
    var poItemGrid = "{{ url('ship/view') }}/{{ $ship_id }}#po-records"
</script>
@endpush