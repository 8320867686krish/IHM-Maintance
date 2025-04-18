@extends('layouts.app')
@section('shiptitle','Po Records')

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <form method="post" action="{{route('auditrecords.store')}}" class="needs-validation" novalidate
                    id="AuditForm" enctype="multipart/form-data">
                    @csrf
                   
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>Audit Records</h4>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="button" id="addAuditRecordsBtn"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="row new-audit-row">
                            <div class="form-group col-3 mb-3">
                                <label for="auditname">Audit Name</label>
                            </div>
                            <div class="form-group col-3 mb-3">
                                <label for="auditee_name">Auditee Name</label>
                            </div>
                            <div class="form-group col-3 mb-3">
                                <label for="date">Date</label>
                            </div>
                            <div class="form-group col-3 mb-3">
                                <label for="attachments">Attachments</label>
                            </div>
                        </div>
                        <div id="AuditItemsContainer">
                            @if(@$poData->poOrderItems && count($poData->poOrderItems) > 0)
                            @foreach($poData->poOrderItems as $key=>$item)
                            <div class="row new-audit-row" data-id="{{$item->id}}" data-item="{{$item}}">
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
                                    <select class="form-control form-control-lg" name="items[{{$item->id}}][type_category]">
                                        <option value="Relevant" {{ $item->type_category === 'Relevant' ? 'selected' : '' }}>Relevant</option>
                                        <option value="Non relevant" {{ $item->type_category === 'Non relevant' ? 'selected' : '' }}>Non relevant</option>
                                    </select>
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

</div>


@endsection

@push('js')

<script>
  
var auditIndex = 0;;
  
</script>

<script src="{{ asset('assets/js/auditRecords.js') }}"></script>

@endpush