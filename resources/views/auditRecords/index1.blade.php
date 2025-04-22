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
                    <input type="hidden" name="client_company_id" value="{{ $client_company_id }}" id="client_company_id">
                    <input type="hidden" name="hazmat_companies_id" value="{{ $hazmat_companies_id }}" id="hazmat_companies_id">
                    <input type="hidden" name="deleted_id" id="deleted_id">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>Audit Records</h4>
                            </div>
                            <div class="col-6">
                                @can('auditrecords.add')
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="button" id="addAuditRecordsBtn"><i class="fas fa-plus"></i> Add</button>
                                </div>
                                @endcan
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
                            <div class="form-group col-2 mb-3">
                                <label for="attachments">Attachments</label>
                            </div>
                        </div>
                        <div id="AuditItemsContainer">
                            @if(@$auditRecords)
                            @foreach($auditRecords as $key=>$item)
                            
                            <div class="row new-audit-row" data-id="{{$item->id}}" data-item="{{$item}}">
                                <div class="form-group col-3 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][audit_name]" autocomplete="off" placeholder="Description" value="{{$auditiname}}">
                                    <div class="invalid-feedback error"></div>
                                </div>
                                <div class="form-group col-3 mb-3">
                                    <input type="text" class="form-control form-control-lg" name="items[{{$item->id}}][auditee_name]" autocomplete="off" placeholder="IMPA NO" value="{{$auditieename}}">
                                    <div class="invalid-feedback error"></div>
                                </div>
                                <div class="form-group col-3 mb-3">
                                    <input type="date" class="form-control form-control-lg" name="items[{{$item->id}}][date]" autocomplete="off" placeholder="Part No" value="{{$item->date}}">
                                    <div class="invalid-feedback error"></div>
                                </div>

                                <div class="form-group col-2 mb-3">
                                    <input type="file" class="form-control form-control-lg" name="items[{{$item->id}}][attachment]" autocomplete="off" placeholder="Qty" value="">
                                    <div class="invalid-feedback error"></div>
                                </div>





                                <div class="form-group col-1 mb-3">
                                    @can('auditrecords.remove')
                                    <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn" title="Delete"></i>
                                    @endcan
                                    <a href="{{ asset('uploads/auditrecords/' . $item['client_company_id'] . '/' . $item['attachment']) }}"
                                        download="{{ $item['attachment'] }}" class="ml-2 mt-3">
                                        <i class="fa fa-download"></i>
                                    </a>
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
                    @can('auditrecords.add')
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary float-right mb-3"
                                type="submit">Save</button>
                        </div>
                    </div>
                    @endcan
                </form>


            </div>
        </div>
    </div>

</div>


@endsection

@push('js')

<script>
    var auditIndex = 0;;
    var auditiname = "{{ $auditiname }}";
    var auditieename = "{{ $auditieename }}";
</script>

<script src="{{ asset('assets/js/auditRecords.js') }}"></script>

@endpush