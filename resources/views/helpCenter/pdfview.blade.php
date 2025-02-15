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
            <form method="post" class="needs-validation"  id="configrationForm"
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

<script>
    $(document).ready(function() {


        $('#configrationForm').submit(function(e) {
            e.preventDefault();

            var $submitButton = $(this).find('button[type="submit"]');
            var originalText = $submitButton.html();
            $submitButton.text('Wait...');
            $submitButton.prop('disabled', true);

            // Clear previous error messages and invalid classes
            $('.error').empty().hide();
            $('input').removeClass('is-invalid');
            $('select').removeClass('is-invalid');

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('configration.save') }}", // Change this to the URL where you handle the form submission
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle success response
                    if (response.isStatus) {
                        successMsgWithRedirect(response.message, "{{ route('configration') }}");
                    } else {
                        errorMsgWithRedirect(response.message, "{{ route('configration') }}");
                    }
                },
                error: function(xhr, status, error) {
                    // If there are errors, display them
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        // Loop through errors and display them
                        $.each(errors, function(field, messages) {
                            // Display error message for each field
                            $('#' + field + 'Error').text(messages[0]).show();
                            // Add is-invalid class to input or select field
                            $('[name="' + field + '"]').addClass('is-invalid');
                        });
                    } else {
                        console.error('Error submitting form:', error);
                    }

                    $submitButton.html(originalText);
                    $submitButton.prop('disabled', false);
                },
            });
        });
    });
</script>
@endpush