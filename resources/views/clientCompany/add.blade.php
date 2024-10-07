@extends('layouts.app')

@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Client Management</h2>
                    {{-- <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('clientCompany') }}" class="breadcrumb-link">Client</a></li>
                                <li class="breadcrumb-item active"><a href="#" class="breadcrumb-link">{{ $head_title ?? 'Add' }}</a></li>
                            </ol>
                        </nav>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                @include('layouts.message')
                <div class="card">
                    <h5 class="card-header">Client Company</h5>
                    <div class="card-body">
                        <form method="post" class="needs-validation" novalidate id="clientForm"
                            enctype="multipart/form-data">
                            @csrf
                            <h5>Client Company  Details</h5>
                            <input type="hidden" name="id" value="{{ $clientCompany->id ?? '' }}">
                            <input type="hidden" name="hazmat_companies_id" value="{{ $clientCompany->hazmat_companies_id ?? $hazmat_companies_id}}">
                            <input type="hidden" name="created_by" value="{{ $clientCompany->created_by ?? $created_by  }}">
                            <input type="hidden" name="user_id" value="{{ $clientCompany->user_id ?? '' }}">


                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="name" value="{{ old('name', $clientCompany->name ?? '') }}"
                                            name="name" placeholder="Comapny Name..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        <div class="invalid-feedback error" id="nameError"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="manager_initials">Client Comapny Initials <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('manager_initials') is-invalid @enderror"
                                            id="manager_initials" name="manager_initials"
                                            onchange="removeInvalidClass(this)" placeholder="Client Comapny Initials..."
                                            autocomplete="off"
                                            value="{{ old('manager_initials', $clientCompany->manager_initials ?? '') }}">
                                        <div class="invalid-feedback error" id="manager_initialsError"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="client_email">Email<span class="text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email"
                                            value="{{ old('email', $user->email ?? '') }}"
                                            placeholder="Client Email..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        <div class="invalid-feedback error" id="emailError"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="phone">Phone<span class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone"
                                            value="{{ old('phone', $user->phone ?? '') }}"
                                            placeholder="Client Phone..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        <div class="invalid-feedback error" id="phoneError"></div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="phone">Password<span class="text-danger">*</span></label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password"
                                            placeholder="password..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        <div class="invalid-feedback error" id="passwordError"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="tax_details">Tax Information</label>
                                        <input type="text" name="tax_details" id="tax_details"
                                            class="form-control @error('tax_details') is-invalid @enderror"
                                            placeholder="Enter information..."
                                            value="{{ old('tax_details', $clientCompany->tax_details ?? '') }}"
                                            onchange="removeInvalidClass(this)" autocomplete="off">
                                       
                                    </div>
                                </div>
                              
                            </div>
                            
                            <div class="row">
                             
                               

                           
                               
                                <div class="col-12">
                                    <hr class="mb-4">
                                </div>
                            </div>

                            <h5>Ship Owner Details</h5>

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="ship_owner_name">Ship Owner NAme</label>
                                        <input type="text"
                                            class="form-control @error('ship_owner_name') is-invalid @enderror"
                                            id="owner_name" value="{{ old('ship_owner_name', $clientCompany->ship_owner_name ?? '') }}"
                                            name="ship_owner_name" placeholder="Ship Owner Name..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        @error('ship_owner_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="ship_owner_email">Email</label>
                                        <input type="email"
                                            class="form-control @error('ship_owner_email') is-invalid @enderror"
                                            id="owner_email" name="ship_owner_email"
                                            value="{{ old('ship_owner_email', $clientCompany->ship_owner_email ?? '') }}"
                                            placeholder="Ship Owner Email..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                      
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="ship_owner_phone">Phone</label>
                                        <input type="number"
                                            class="form-control @error('ship_owner_phone') is-invalid @enderror"
                                            id="owner_phone" name="ship_owner_phone"
                                            value="{{ old('ship_owner_phone', $clientCompany->ship_owner_phone ?? '') }}"
                                            placeholder="Ship Owner Phone..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                      
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="ship_owner_address">Address</label>
                                        <textarea name="owner_address" id="ship_owner_address" rows="1"
                                            class="form-control @error('ship_owner_address') is-invalid @enderror">{{ old('ship_owner_address', $clientCompany->ship_owner_address ?? '') }}</textarea>
                                        @error('owner_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="IMO_ship_owner_details">IMO Ship owner details<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="IMO_ship_owner_details"
                                            name="IMO_ship_owner_details"
                                            value="{{old('IMO_ship_owner_details', $clientCompany->IMO_ship_owner_details ?? '')}}"
                                            placeholder="IMO Ship owner details..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                            <div class="invalid-feedback error" id="IMO_ship_owner_detailsError"></div>

                                    </div>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="contact_person_name">Contact Person Name</label>
                                        <input type="text"
                                            class="form-control @error('contact_person_name') is-invalid @enderror"
                                            id="contact_person_name"
                                            value="{{ old('contact_person_name', $clientCompany->contact_person_name ?? '') }}"
                                            name="contact_person_name" placeholder="Contact Person Name..."
                                            autocomplete="off" onchange="removeInvalidClass(this)">
                                       
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="owner_contact_person_email">Email</label>
                                        <input type="email"
                                            class="form-control @error('owner_contact_person_email') is-invalid @enderror"
                                            id="owner_contact_person_email" name="owner_contact_person_email"
                                            value="{{ old('owner_contact_person_email', $clientCompany->owner_contact_person_email ?? '') }}"
                                            placeholder="Contact Person Email..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        @error('owner_contact_person_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="contact_person_phone">Phone</label>
                                        <input type="number"
                                            class="form-control @error('contact_person_phone') is-invalid @enderror"
                                            id="contact_person_phone" name="contact_person_phone"
                                            value="{{ old('contact_person_phone', $clientCompany->contact_person_phone ?? '') }}"
                                            placeholder="Contact Person Phone..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                      
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="contact_person_designation">Designation</label>
                                        <input type="text"
                                            class="form-control @error('contact_person_designation') is-invalid @enderror"
                                            id="contact_person_designation" name="contact_person_designation"
                                            value="{{ old('contact_person_designation', $clientCompany->contact_person_designation ?? '') }}"
                                            placeholder="Contact Person Designation..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                      
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <a href="{{ route('clientCompany') }}" type="button" class="btn pl-0"><i
                                                class="fas fa-arrow-left"></i> <b>Back</b></a>
                                    </div>
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
@endsection

@push('js')
    <script>
        $(document).ready(function() {
       

            $('#clientForm').submit(function(e) {
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
                    url: "{{ route('clientCompany.store') }}", // Change this to the URL where you handle the form submission
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle success response
                         if (response.isStatus) {
                             successMsgWithRedirect(response.message, "{{ route('clientCompany') }}");
                         } else {
                            errorMsgWithRedirect(response.message, "{{ route('clientCompany') }}");
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
