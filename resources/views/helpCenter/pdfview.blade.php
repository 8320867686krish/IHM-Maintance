@extends('layouts.app')

@section('content')

@if($showurl)
<div class="container-fluid dashboard-content">
<x-page-header title="Portal User Guide"></x-page-header>

<div class="col-xl-12  col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
      

<pdf-viewer src="{{$showurl}}"></pdf-viewer>
</div>
</div>
@else
<div class="container-fluid dashboard-content">
<x-page-header title="Configration Management"></x-page-header>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        @include('layouts.message')
        <div class="card">
            <h5 class="card-header">User Guide Configration</h5>
            <div class="card-body  mb-4">
                <form method="post" class="needs-validation" novalidate id="configrationForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{@$configration['id']}}">

                    <div class="row">

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label for="name">Ship Staff <span class="text-danger">*</span></label>
                                <input type="file"
                                    class="form-control mb-2 @error('ship_staff') is-invalid @enderror"
                                    id="name" value="{{ old('ship_staff', $clientCompany->name ?? '') }}"
                                    name="ship_staff" placeholder="Comapny Name..." autocomplete="off"
                                    onchange="removeInvalidClass(this)">
                                    @if(@$configration['ship_staff'])
                                    <a href="{{asset('uploads/configration/'.$configration['ship_staff'])}}" target="_blank">View Attachment</a>

                                    @endif
                                <div class="invalid-feedback error" id="ship_staffError"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label for="name">Client Company <span class="text-danger">*</span></label>
                                <input type="file"
                                    class="form-control mb-2 @error('client_company') is-invalid @enderror"
                                    id="client_company" value="{{ old('client_company', $clientCompany->client_company ?? '') }}"
                                    name="client_company" placeholder="Comapny Name..." autocomplete="off"
                                    onchange="removeInvalidClass(this)">
                                    @if(@$configration['client_company'])
                                    <a href="{{asset('uploads/configration/'.$configration['client_company'])}}" target="_blank">View Attachment</a>
                                    @endif
                                <div class="invalid-feedback error" id="client_companyError"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group mb-3">
                                <label for="client_email">Hazmat Company<span class="text-danger">*</span></label>
                                <input type="file"
                                    class="form-control mb-2 @error('hazmat_company') is-invalid @enderror"
                                    id="hazmat_company" name="hazmat_company"
                                  
                                    placeholder="Client Email..." autocomplete="off"
                                    onchange="removeInvalidClass(this)">
                                    @if(@$configration['hazmat_company'])
                                    <a href="{{asset('uploads/configration/'.$configration['hazmat_company'])}}" target="_blank">View Attachment</a>

                                    @endif
                                <div class="invalid-feedback error" id="hazmat_companyError"></div>
                            </div>
                        </div>
                    </div>



                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-6">

                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group mb-3">
                                <button class="btn btn-primary float-right formSubmitBtn"
                                    type="submit">{!! $button ?? 'Add' !!}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endif
@endsection
@push('js')
<script src="{{ asset('assets/libs/js/pdfview.js') }}"></script>


@endpush