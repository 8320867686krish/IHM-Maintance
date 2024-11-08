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
                <form method="post" action="{{route('poItems.hazmat')}}" class="needs-validation" novalidate
                    id="checkHazmatAddForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="deleted_id" id="deleted_id" value="">

                        <input type="hidden" name="ship_id" id="ship_id" value="{{$poItem->ship_id}}">
                        <input type="hidden" name="po_order_item_id" id="po_order_item_id" value="{{@$poItem->id}}">
                        <input type="hidden" name="po_order_id" id="po_order_id" value="{{@$poItem->po_order_id}}">


                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="equipment">Description</label>
                                    <input type="text" id="description" name="description" class="form-control" value="{{$poItem->description}}">
                                </div>
                            </div>

                            <div class="col-6 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="equipment">IMPA No.(if available)</label>
                                    <input type="text" id="impa_no" name="impa_no" class="form-control" value="{{$poItem->impa_no}}">
                                </div>
                            </div>

                            <div class="col-6 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="equipment">Part No</label>
                                    <input type="text" id="part_no" name="part_no" class="form-control" value="{{$poItem->part_no}}">
                                </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="Qty">Qty</label>
                                    <input type="text" id="qty" name="qty"
                                        class="form-control" value="{{$poItem->qty}}">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-4">
                                    <label for="unit">Unit</label>
                                    <input type="text" id="unit" name="unit" class="form-control" value="{{$poItem->unit}}">
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
                                            <option value="{{ $hazmat->id }}" data-table='{{$hazmat->table_type}}'>
                                                {{ $hazmat->name }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-12"
                            style="background: #efeff6;border: 1px solid #efeff6;">
                            <div class="pt-4">
                                <h5 class="text-center mb-4" style="color:#757691">Document Analysis Results
                                </h5>
                                <div class="mb-4 col-12" id="showTableTypeDiv">
                                    @if(@$poItem->poOrderItemsHazmets)
                                    @foreach($poItem->poOrderItemsHazmets as $value)
                                    <input type="hidden" name="hazmats[{{$value['hazmat_id']}}][id]" id="id" value="{{@$value->id}}">

                                    <div class="col-12 col-md-12 col-lg-12 cloneTableTypeDiv mb-3 card" id="cloneTableTypeDiv{{$value['hazmat_id']}}">
                                        <label for="table_type" id="tableTypeLable" class="mr-5 mt-3 tableTypeLable card-header">{{$value['hazmat']['name']}}</label>
                                        <div class="row card-body">
                                            <div class="col-4 table_typecol">
                                                <div class="form-group mb-3">
                                                    <select class="form-control table_type tableType{{$value['hazmat_id']}}" id="table_type_{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][hazmat_type]" data-findTable="{{ explode('-', $value['hazmat']['table_type'])[0] }}" data-divValue="{{$value['hazmat_id']}}">
                                                        <option value="Contained" {{ $value->hazmat_type == 'Contained' ? 'selected' : '' }}>Contained
                                                        </option>
                                                        <option value="Not Contained" {{ $value->hazmat_type == 'Not Contained' ? 'selected' : '' }}>
                                                            Not Contained</option>
                                                        <option value="PCHM" {{ $value->hazmat_type == 'PCHM' ? 'selected' : '' }}>
                                                            PCHM</option>
                                                        <option value="Unknown" {{ $value->hazmat_type == 'Unknown' ? 'selected' : '' }}>
                                                            Unknown</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-4 imagehazmat" id="imagehazmat{{$value['hazmat_id']}}">
                                                <div class="form-group mb-3">
                                                    <input type="file" class="form-control" accept="*/*" id="image_{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][image]">
                                                </div>
                                            </div>

                                            <div class="col-4 dochazmat" id="dochazmat{{$value['hazmat_id']}}">
                                                <div class="form-group mb-3">
                                                    <input type="file" class="form-control" id="doc_{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][doc]">
                                                </div>
                                                <div style="font-size: 13px; margin-bottom: 10px;" id="docNameShow_${selectedValue}">
                                                </div>
                                            </div>
                                        </div>
                                        @if( explode('-', $value['hazmat']['table_type'])[0] == 'A')
                                        @if($value->hazmat_type === 'Contained' || $value->hazmat_type === 'PCHM')
                                        <div class="col-12 col-md-12 col-lg-12  mb-3  onboard{{$value['hazmat_id']}}">
                                            <h5>Item arrived on board?</h5>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isArrived{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isArrived]" value='yes' class="custom-control-input isArrivedChoice" data-isArrived="{{$value['hazmat_id']}}" {{ $value->isArrived == 'yes' ? 'checked' : '' }}><span class="custom-control-label">Yes</span>
                                            </label>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isArrived{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isArrived]" value="no" class="custom-control-input isArrivedChoice" data-isArrived="{{$value['hazmat_id']}}" {{ $value->isArrived == 'no' ? 'checked' : '' }}><span class="custom-control-label">No</span>
                                            </label>

                                        </div>
                                        <div class="col-12 col-md-12 col-lg-12  mb-3  returnItem{{$value['hazmat_id']}}">
                                            <h5>return of item initiated ?</h5>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isReturn_yes{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isReturn]" value="yes" class="custom-control-input isReturnChoice" data-isReturn="{{$value['hazmat_id']}}" {{ $value->isReturn === 'yes' ? 'checked' : ''}}><span class="custom-control-label">Yes</span>
                                            </label>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isReturn_no{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isReturn]" value="no" class="custom-control-input isReturnChoice" data-isReturn="{{$value['hazmat_id']}}" {{ $value->isReturn === 'no' ? 'checked' : ''}}><span class="custom-control-label">No</span>
                                            </label>

                                        </div>
                                        @if( $value->isReturn == 'yes')
                                        <div class="row col-12 mb-3 returnItemDetails{{$value['hazmat_id']}}">
                                            <div class="col-4">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="hazmats[{{$value['hazmat_id']}}][location]" id="location{{$value['hazmat_id']}}" class="form-control" placeholder="Location" value="{{$value['location']}}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group mb-3">
                                                    <input type="date" name="hazmats[{{$value['hazmat_id']}}][date]" id="date{{$value['hazmat_id']}}" class="form-control" placeholder="Date" value="{{$value['date']}}">
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @if($value['isArrived'] == 'yes')
                                        <div class="col-12 col-md-12 col-lg-12  mb-3  itemInstall{{$value['hazmat_id']}}">

                                            <h5>Is Installed?</h5>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isInstalled_yes{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isInstalled]" value="yes" class="custom-control-input isInstalledChoice" data-isInstalled="{{$value['hazmat_id']}}" {{ $value->isInstalled === 'yes' ? 'checked' : ''}}>
                                                <span class="custom-control-label">Yes</span>
                                            </label>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isInstalled_no{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isInstalled]" value="no" class="custom-control-input isInstalledChoice" data-isInstalled="{{$value['hazmat_id']}}" {{ $value->isInstalled === 'no' ? 'checked' : ''}}>
                                                <span class="custom-control-label">No</span>
                                            </label>
                                        </div>
                                        @endif
                                        @endif

                                        @if($value->isInstalled == 'yes')
                                        <div class="col-12 col-md-12 col-lg-12  mb-3  ihmUpdated{{$value['hazmat_id']}}">
                                            <h5>ihm been updated ?</h5>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isIHMUpdated_yes{{$value['hazmat_id']}}" name="hazmats[{{$value['hazmat_id']}}][isIHMUpdated]" value="yes" class="custom-control-input isIHMUpdatedChoice" data-isIHMUpdated="{{$value['hazmat_id']}}" {{ $value->isIHMUpdated === 'no' ? 'checked' : ''}}><span class="custom-control-label">Yes</span>
                                            </label>


                                        </div>
                                        @endif

                                        <div class="col-12 col-md-12 col-lg-12  mb-3  removeItem{{$value['hazmat_id']}}">
                                            <h5>remove the item?</h5>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isRemove${divValue}" name="hazmats[{{$value['hazmat_id']}}][isRemove]" value="yes" class="custom-control-input isRemoveChoice" data-isRemove="{{$value['hazmat_id']}}" {{ $value->isRemove === 'yes' ? 'checked' : '' }}><span class="custom-control-label">Yes</span>
                                            </label>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="isRemove${divValue}" name="hazmats[{{$value['hazmat_id']}}][isRemove]" value="no" class="custom-control-input isRemoveChoice" data-isRemove="{{$value['hazmat_id']}}" {{ $value->isRemove === 'no' ? 'checked' : '' }}><span class="custom-control-label">No</span>
                                            </label>

                                        </div>
                                        @if( $value->isRemove === 'yes')
                                        <div class="row  col-12 mb-3  removeItemDetails{{$value['hazmat_id']}}">
                                            <div class="col-4">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="hazmats[{{$value['hazmat_id']}}][service_supplier_name]" id="service_supplier_name{{$value['hazmat_id']}}" class="form-control" placeHolder="Service Supplier Name" value="{{$value['service_supplier_name']}}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="hazmats[{{$value['hazmat_id']}}][service_supplier_address]" id="service_supplier_address{{$value['hazmat_id']}}" class="form-control" placeHolder="Service Supplier Address" value="{{$value['service_supplier_address']}}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group mb-3">
                                                    <input type="date" name="hazmats[{{$value['hazmat_id']}}][removal_date]" id="removal_date{{$value['hazmat_id']}}" class="form-control" placeHolder="Removal Date" value="{{$value['removal_date']}}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="hazmats[{{$value['hazmat_id']}}][removal_location]" id="removal_location{{$value['hazmat_id']}}" class="form-control" placeHolder="Removal Location" value="{{$value['removal_location']}}">
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group mb-3">
                                                    <input type="file" name="hazmats[{{$value['hazmat_id']}}][attachment]" id="attachment{{$value['hazmat_id']}}" class="form-control" placeHolder="Attachment">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="hazmats[{{$value['hazmat_id']}}][po_no]" id="po_no{{$value['hazmat_id']}}" class="form-control" placeHolder="PO No" value="{{$value['po_no']}}">
                                                </div>
                                            </div>

                                        </div>
                                        @endif

                                        @endif

                                        @endif
                                    </div>
                                    @endforeach
                                    @endif


                                </div>
                            </div>
                        </div>


                    </div>

                    <hr />

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

</div>
@endsection
@push('js')
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script src="{{ asset('assets/js/poOrder.js') }}"></script>
<script>
    var hazmatIdsvalue = JSON.parse($hazmatIds);

    $(document).ready(function() {
        $('#checkHazmatAddForm #suspected_hazmat').selectpicker('val', hazmatIdsvalue);

    });
</script>
@endpush