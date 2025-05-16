@extends('layouts.app')
@section('shiptitle','Po Records')

@section('content')
<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">

                <input type="hidden" name="client_company_id" value="{{ $client_company_id }}" id="client_company_id">
                <input type="hidden" name="hazmat_companies_id" value="{{ $hazmat_companies_id }}" id="hazmat_companies_id">
                <input type="hidden" name="deleted_id" id="deleted_id">
                <div class="card-body mb-2">
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

                    <div id="AuditItemsContainer" class="row">
                        @if(!empty($auditRecords))


                        @foreach($auditRecords as $key => $item)
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 new-audit-row view-item-btn" data-iteam="{{$item}}">
                            <div class="card">
                                <div class="card-body mb-2">
                                    <div class="text-center mt-1">
                                        <img src="{{asset('images/auditrecords.png')}}" alt="{{ $item->auditee_name }}" class=" user-avatar-xxl">

                                    </div>
                                    <p class="card-text text-center mb-1">
                                        Audit by : {{$auditiname}}
                                    </p>
                                    <p class="card-text text-center mb-1">
                                        Auditee : {{$auditieename}}
                                    </p>
                                    <p class="card-text text-center mb-1">
                                        Audited Date: {{ \Carbon\Carbon::parse($item->date)->format('d/m/y') }}
                                    </p>
                                    <p class="card-text text-center mb-1 mt-2">
                                        @can('auditrecords.remove')
                                       
                                        <a href="{{route('auditrecords.delete', ['id' => $item->id])}}" class="ml-2 remove-item-btn">
                                            <i class="fas fa-trash-alt text-danger" style="font-size: 1rem;"></i>
                                        </a>
                                        @endcan
                                        <a href="{{ asset('uploads/auditrecords/' . $item['client_company_id'] . '/' . $item['attachment']) }}"
                                            download="{{ $item['attachment'] }}" class="ml-2">
                                            <i class="fa fa-download"></i>
                                        </a>

                                         <a href="#" 
                                             class="ml-2 view-item-btn" data-iteam="{{$item}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </p>
                                </div>
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



            </div>
        </div>
    </div>

</div>

@include('auditRecords.AuditModel')
@endsection

@push('js')

<script>
    var auditIndex = 0;;
    var auditiname = "{{ $auditiname }}";
    var auditieename = "{{ $auditieename }}";
</script>

<script src="{{ asset('assets/js/auditRecords.js') }}"></script>

@endpush