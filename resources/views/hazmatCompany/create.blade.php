@extends('layouts.app')
@section('shiptitle','Hazmat Company Management')

@section('content')
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
   
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">{{ $head_title ?? '' }} Company Hazmat</h5>
                <div class="card-body">
                    <form method="post" action="{{route('hazmatCompany.store')}}" class="needs-validation" novalidate
                        id="hazmatCompanyForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $hazmatCompany->id ?? null }}">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Company Name"
                                        value="{{ old('name', $hazmatCompany->name ?? '') }}"
                                        onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="level">Logo <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        id="logo" accept="image/*" name="logo"
                                        onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="logoError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">First Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" value="{{ old('name', $hazmatCompany->first_name ?? '') }}" name="first_name"
                                        placeholder="First Name..." autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" value="{{ old('last_name', $hazmatCompany->last_name ?? '') }}"
                                        name="last_name" placeholder="Last Name..." autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    {{-- @error('name') --}}
                                    <div class="invalid-feedback error" id="lastNameError"></div>
                                    {{-- @enderror --}}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $hazmatCompany->phone ?? '') }}"
                                        placeholder="Phone..." autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="phoneError"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $hazmatCompany->email ?? '') }}"
                                        placeholder="User Email..." autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="emailError"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <input type="hidden" name="user_id" value="{{ $user->id ?? null }}">

                          
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="password">Password
                                        @if (!isset($user->id))
                                        <span class="text-danger">*</span>
                                        @endif
                                    </label> <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" value="{{ old('password') }}"
                                        placeholder="password" autocomplete="off"
                                        onchange="removeInvalidClass(this)">

                                    <div class="invalid-feedback error" id="passwordError"></div>
                                </div>
                            </div>


                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <a href="{{ route('hazmatCompany') }}" class="btn pl-0" type="button"><i
                                            class="fas fa-arrow-left"></i> <b>Back</b></a>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right formSubmitBtn"
                                        type="submit">{!! $button ?? '<i class="fas fa-plus"></i> Add' !!}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
    $("#hazmatCompanyForm").submit(function(e) {
        e.preventDefault();

        var $submitButton = $(this).find('button[type="submit"]');
        var originalText = $submitButton.html();
        $submitButton.text('Wait...');
        $submitButton.prop('disabled', true);

        // Clear previous error messages and invalid classes
        $('.error').empty().hide();
        $('input').removeClass('is-invalid');

        var formData = new FormData(this);


        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.isStatus) {
                    successMsgWithRedirect(response.message, "{{ route('hazmatCompany') }}");
                } else {
                    errorMsgWithRedirect(response.message, "{{ route('hazmatCompany') }}");
                }
            },
            error: function(xhr, status, error) {
                // If there are errors, display them
                let errors = xhr.responseJSON.errors;
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
            },
            complete: function() {
                // $submitButton.html('<i class="fas fa-plus"></i>  Add');
                $submitButton.html(originalText); // Restore original text
                $submitButton.prop('disabled', false);
            }
        });
    });
</script>
@endpush