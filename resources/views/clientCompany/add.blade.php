@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-content">

    <x-page-header title="Client Company Management"></x-page-header>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('layouts.message')
            <div class="card">
                <h5 class="card-header">Client Company</h5>
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate id="clientForm"
                        enctype="multipart/form-data">
                        @csrf
                        <h5>Client Company Details</h5>
                        <input type="hidden" name="id" value="{{ $clientCompany->id ?? '' }}">
                        <input type="hidden" name="created_by" value="{{ $clientCompany->created_by ?? $created_by  }}">
                        <input type="hidden" name="user_id" value="{{ $clientCompany->user_id ?? '' }}">


                        <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="name">Name <span class="text-danger"> *</span></label>
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
                                    <label for="manager_initials">Client Comapny Initials <span class="text-danger"> *</span></label>
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
                                    <label for="client_email">Email<span class="text-danger"> *</span></label>
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
                                    <label for="phone">Phone</label>
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
                                    <label for="manager_contact_person_name">Contact Person Name</label>
                                    <input type="text"
                                        class="form-control @error('manager_contact_person_name') is-invalid @enderror"
                                        id="manager_contact_person_name"
                                        value="{{ old('manager_contact_person_name', $clientCompany->manager_contact_person_name ?? '') }}"
                                        name="manager_contact_person_name" placeholder="Contact Person Name..."
                                        autocomplete="off" onchange="removeInvalidClass(this)">
                                    {{-- @error('manager_contact_person_name') --}}
                                    <div class="invalid-feedback error" id="manager_contact_person_nameError"></div>
                                    {{-- @enderror --}}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="manager_contact_person_email">Contact Person Email</label>
                                    <input type="email"
                                        class="form-control @error('manager_contact_person_email') is-invalid @enderror"
                                        id="manager_contact_person_email" name="manager_contact_person_email"
                                        value="{{ old('manager_contact_person_email', $clientCompany->manager_contact_person_email ?? '') }}"
                                        placeholder="Contact Person Email..." autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    {{-- @error('manager_contact_person_email') --}}
                                    <div class="invalid-feedback error" id="manager_contact_person_emailError"></div>
                                    {{-- @enderror --}}
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="manager_contact_person_phone">Contact Person Phone</label>
                                    <input type="number"
                                        class="form-control @error('manager_contact_person_phone') is-invalid @enderror"
                                        id="manager_contact_person_phone" name="manager_contact_person_phone"
                                        value="{{ old('manager_contact_person_phone', $clientCompany->manager_contact_person_phone ?? '') }}"
                                        placeholder="Contact Person Phone..." autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    {{-- @error('manager_contact_person_phone') --}}
                                    <div class="invalid-feedback error" id="manager_contact_person_phoneError"></div>
                                    {{-- @enderror --}}
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="phone">Password<span class="text-danger"> *</span></label>
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
                            <div class="col-sm-12 col-md-8 col-lg-8">
                                <div class="form-group mb-3">
                                    <label for="manager_address">Address</label>
                                    <textarea name="manager_address" id="manager_address" rows="1"
                                        class="form-control @error('manager_address') is-invalid @enderror" onchange="removeInvalidClass(this)">{{ old('manager_address', $clientCompany->manager_address ?? '') }}</textarea>
                                    {{-- @error('manager_address') --}}
                                    <div class="invalid-feedback error" id="manager_addressError"></div>
                                    {{-- @enderror --}}
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="level">Logo <span class="text-danger"> *</span></label>
                                    <input type="file" class="form-control @error('client_image') is-invalid @enderror"
                                        id="logo" accept="image/*" name="client_image"
                                        onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="logoError"></div>
                                </div>
                            </div>

                            @if($currentUserRoleLevel == 1)
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level"> Hazmat Company <span class="text-danger"> *</span></label>

                                    <select name="hazmat_companies_id" id="hazmat_companies_id " class="form-control" onchange="removeInvalidClass(this)">
                                        <option value="">Select Hazmat Company</option>
                                        @if (isset($hazmetCompany) && $hazmetCompany->count() > 0)
                                        @foreach ($hazmetCompany as $value)

                                        <option value="{{ $value->id }}"
                                            {{ (isset($clientCompany) && $value->id == $clientCompany->hazmat_companies_id) ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>

                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="hazmat_companies_id" value="{{ $clientCompany->hazmat_companies_id ?? $hazmat_companies_id}}">

                            @endif
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">Accounting Team Email<span class="text-danger"> *</span></label>

                                    <input type="text" name="accounting_team_email" id="accounting_team_email"
                                        class="form-control @error('accounting_team_email') is-invalid @enderror"
                                        placeholder="Accounting Team Email..."
                                        value="{{ old('accounting_team_email', $clientCompany->accounting_team_email ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                    <div class="invalid-feedback error" id="accounting_team_emailError"></div>

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-1">
                                <div class="form-group mb-3">
                                    <label for="level">Responsible Person Rank <span class="text-danger"> *</span></label>

                                    <input type="text" name="responsible_person" id="responsible_person"
                                        class="form-control @error('responsible_person') is-invalid @enderror"
                                        placeholder="Responsible Person Rank..."
                                        value="{{ old('responsible_person', $clientCompany->responsible_person ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-1">
                                <div class="form-group mb-3">
                                    <label for="level">Overall Incharge (Ownership) Rank<span class="text-danger"> *</span></label>

                                    <input type="text" name="overall_incharge" id="overall_incharge"
                                        class="form-control @error('overall_incharge') is-invalid @enderror"
                                        placeholder="Overall Incharge (Ownership) Rank..."
                                        value="{{ old('overall_incharge', $clientCompany->overall_incharge ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-1">
                                <div class="form-group mb-3">
                                    <label for="level">Training Requirement OI & RP Incharge<span class="text-danger"> *</span></label>

                                    <input type="text" name="training_requirement_overall_incharge" id="training_requirement_overall_incharge"
                                        class="form-control @error('training_requirement_overall_incharge') is-invalid @enderror"
                                        placeholder="Training Requirement OI & RP Incharge..."
                                        value="{{ old('tax_details', $clientCompany->training_requirement_overall_incharge ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-1">
                                <div class="form-group mb-3">
                                    <label for="level">Crew Briefing Requiremet<span class="text-danger"> *</span></label>
                                    <input type="text" name="crew_briefing_requiremet" id="crew_briefing_requiremet"
    class="form-control @error('crew_briefing_requiremet') is-invalid @enderror"
    placeholder="Crew Briefing Requirement..."
    value="{{ old('crew_briefing_requiremet', $clientCompany->crew_briefing_requiremet ?? '') }}"
    onchange="removeInvalidClass(this)" autocomplete="off">

                                </div>

                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mt-1">
                                <div class="form-group mb-3">
                                    <label for="level">choose logo for report<span class="text-danger"> *</span></label>
                                    <select class="form-control" name="is_report_logo" id="is_report_logo">
    <option value="0" {{ optional($clientCompany)->is_report_logo == 0 ? 'selected' : '' }}>Use Own Logo</option>
    <option value="1" {{ optional($clientCompany)->is_report_logo == 1 ? 'selected' : '' }}>Client Banner</option>
</select>

                                </div>

                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="isSameAsManager"
                                        id="isSameAsManager" @if (isset($clientCompany) && $clientCompany->isSameAsManager == 1) checked @endif>
                                    <label class="custom-control-label" for="isSameAsManager">Same As Client Company</label>
                                </div>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-12">
                                <hr class="mb-4">
                            </div>
                        </div>

                        <h5>Ship Owner / Manager Details</h5>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="ship_owner_name">Ship Owner Name</label>
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
                                    <textarea name="ship_owner_address" id="ship_owner_address" rows="1"
                                        class="form-control @error('ship_owner_address') is-invalid @enderror">{{ old('ship_owner_address', $clientCompany->ship_owner_address ?? '') }}</textarea>
                                    @error('owner_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="IMO_ship_owner_details">IMO Ship owner details<span class="text-danger"> *</span></label>
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
                                    <label for="owner_contact_person_email">Contact Person Email</label>
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
                                    <label for="contact_person_phone">Contact Person Phone</label>
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

                            <div class="col-12 col-md-4">
                                <div class="form-group mb-3">
                                    <label for="owner_logo">Ship Owner Logo</label>
                                    <input type="file"
                                        class="form-control @error('owner_logo') is-invalid @enderror"
                                        id="owner_logo" name="owner_logo" onchange="removeInvalidClass(this)"
                                        accept="image/*" value="">
                                    @error('owner_logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

        $('#isSameAsManager').click(function() {
            if ($(this).is(':checked')) {
                // Copy manager details to owner details
                $('#owner_name').val($('#name').val());
                $('#owner_email').val($('#email').val());
                $('#owner_phone').val($('#phone').val());
                $('#ship_owner_address').val($('#manager_address').val());
                $('#contact_person_name').val($('#manager_contact_person_name').val());
                $('#owner_contact_person_email').val($('#manager_contact_person_email').val());
                $('#contact_person_phone').val($('#manager_contact_person_phone').val());

                var fileName = $("#logo").val().split('\\').pop();
                $("#owner_logo").val(fileName);
                $('#logo').trigger('change');
            } else {
                // Clear owner fields if checkbox is unchecked
                $('#owner_name, #owner_email, #owner_phone, #ship_owner_address, #contact_person_name, #owner_contact_person_email, #contact_person_phone')
                    .val('');
                $('#owner_logo').text('');
            }
        });
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