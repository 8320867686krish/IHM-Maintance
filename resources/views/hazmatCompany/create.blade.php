@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Hazmat Company Management"></x-page-header>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">{{ $head_title ?? '' }} Hazmat Company</h5>
                <div class="card-body mb-4">
                    <form method="post" action="{{route('hazmatCompany.store')}}" class="needs-validation" novalidate
                        id="hazmatCompanyForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $hazmatCompany->id ?? null }}">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder=" "
                                        value="{{ old('name', $hazmatCompany->name ?? '') }}"
                                        onchange="removeInvalidClass(this)">
                                    <label for="name">Name</label>
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" value="{{ old('name', $hazmatCompany->first_name ?? '') }}" name="first_name"
                                        placeholder="" autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <label for="name">First Name</label>
                                    <div class="invalid-feedback error" id="nameError"></div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group input-label-group">

                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" value="{{ old('last_name', $hazmatCompany->last_name ?? '') }}"
                                        name="last_name" placeholder="" autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <label for="last_name">Last Name</label>
                                    <div class="invalid-feedback error" id="lastNameError"></div>

                                </div>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group input-label-group">

                                    <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $hazmatCompany->phone ?? '') }}"
                                        placeholder="" autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <label for="phone">Phone</label>
                                    <div class="invalid-feedback error" id="phoneError"></div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group input-label-group">

                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $hazmatCompany->email ?? '') }}"
                                        placeholder="" autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback error" id="emailError"></div>
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="{{ $user->id ?? null }}">


                            <div class="col-sm-12 col-md-4">
                                <div class="form-group input-label-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" value="{{ old('password') }}"
                                        placeholder="" autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <label for="password">Password
                                        @if (!isset($user->id))
                                        <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    <div class="invalid-feedback error" id="passwordError"></div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-12 col-md-4">
                                <div class="form-group input-label-group">

                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        id="logo" accept="image/*" name="logo"
                                        onchange="removeInvalidClass(this)">
                                    <label for="level">Logo <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback error" id="logoError"></div>
                                    @if(@$hazmatCompany->logo)
                                     <a href="{{ url('public/uploads/hazmatCompany/' . $hazmatCompany->logo) }}" target="_blank" class="ml-1">{{$hazmatCompany->logo}}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group input-label-group">

                                    <input type="file" class="form-control @error('briefing_plan') is-invalid @enderror"
                                        id="logo" accept="application/pdf" name="briefing_plan" placeholder=""
                                        onchange="removeInvalidClass(this)">
                                    <label for="level">Briefing Plan <span class="text-danger">*</span></label>
                                    @if(@$hazmatCompany->briefing_plan)
                                    <a href="{{ url('public/uploads/briefing_plan/' . $hazmatCompany->briefing_plan) }}" target="_blank" class="ml-1">{{$hazmatCompany->briefing_plan}}</a>
                                    @endif
                                    <div class="invalid-feedback error" id="briefing_planError"></div>

                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group input-label-group">

                                    <input type="file" class="form-control @error('training_material') is-invalid @enderror"
                                        id="logo" accept="application/pdf" name="training_material"
                                        onchange="removeInvalidClass(this)">
                                    <label for="level">Training Material <span class="text-danger">*</span></label>
                                    @if(@$hazmatCompany->training_material)
                                        <a href="{{ url('public/uploads/training_material/'.$hazmatCompany->training_material) }}" target="_blank" class="ml-1 mt-2">{{$hazmatCompany->training_material}}</a>
                                    @endif
                                    <div class="invalid-feedback error" id="training_materialError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                        <div class="col-12 col-md-12">
                            <div class="form-group input-label-group">
                                <input type="text" name="address" id="address" class="form-control" placeholder="" value="{{ $hazmatCompany->address ?? ''}}">
                                <label for="level">Address</label>

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
                                        type="submit">Save</button>
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