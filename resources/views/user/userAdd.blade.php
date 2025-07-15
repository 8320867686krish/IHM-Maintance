@extends('layouts.app')



@section('content')
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">User Management</h2>
                {{-- <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('users') }}" class="breadcrumb-link" title="User">User</a>
                </li>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        @include('layouts.message')
        <div class="card">
            <h5 class="card-header">{{ $head_title ?? '' }} User</h5>
            <div class="card-body mb-4">
                <form method="post" class="needs-validation" novalidate id="userForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                    <div class="row">
                        <div class="col-sm-12 col-md-4  mb-1">
                            <div class="form-group">
                                @if (isset($user) && !empty($user->role))
                                <input type="hidden" name="roles" id="roles" value="{{ $user->role }}">
                                @endif
                                <select name="roles" id="roles" class="form-control"
                                    @if (!empty($user->role)) disabled @endif
                                    onchange="removeInvalidClass(this)">
                                    <option value="">Select Role</option>
                                    @if (isset($roles) && $roles->count() > 0)
                                    @foreach ($roles as $role)
                                    @if (@$role->level == 5 || @$role->level == 6 || @$role->level == 2)
                                    @continue
                                    @endif
                                    <option value="{{ @$role->level }}"
                                        {{ old('roles') == @$role->name || (isset($user) && @$role->name == @$user->role) ? 'selected' : '' }}>
                                        {{ @$role->name }}
                                    </option>

                                    @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback error" id="rolesError"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4  mb-1">
                            <div class="form-group input-label-group">

                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" value="{{ old('name', $user->name ?? '') }}" name="name"
                                    placeholder="" autocomplete="off"
                                    onchange="removeInvalidClass(this)">
                                <label for="name">First Name <span class="text-danger">*</span></label>

                                <div class="invalid-feedback error" id="nameError"></div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4  mb-1">
                            <div class="form-group input-label-group">

                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    id="last_name" value="{{ old('last_name', $user->last_name ?? '') }}"
                                    name="last_name" placeholder="" autocomplete="off"
                                    onchange="removeInvalidClass(this)">
                                <label for="last_name">Last Name</label>
                                <div class="invalid-feedback error" id="lastNameError"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-1">
                            <div class="form-group input-label-group mb-1">

                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                    placeholder="" autocomplete="off"
                                    onchange="removeInvalidClass(this)">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <div class="invalid-feedback error" id="emailError"></div>
                            </div>
                        </div>
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
                       
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group input-label-group mb-1">

                                <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                    placeholder="" autocomplete="off"
                                    onchange="removeInvalidClass(this)">
                                <label for="phone">Phone</label>
                                <div class="invalid-feedback error" id="phoneError"></div>
                            </div>
                        </div>
                         @if($currentUserRoleLevel == 1)
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <select name="hazmat_companies_id" id="hazmat_companies_id " class="form-control" onchange="removeInvalidClass(this)">
                                <option value="">Select Hazmat Company</option>
                                @if (isset($hazmetCompany) && $hazmetCompany->count() > 0)
                                @foreach ($hazmetCompany as $value)

                                <option value="{{ $value->id }}"
                                    {{ old('hazmat_companies_id') == $role->id || (isset($user) && $value->id == $user->hazmat_companies_id) ? 'selected' : '' }}>
                                    {{ $value->name }}
                                </option>

                                @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback error" id="hazmat_companies_idError"></div>

                        </div>
                    </div>
                    @else
                    <input type="hidden" id="hazmat_companies_id" name="hazmat_companies_id" value="{{ $hazmat_companies_id ?? '' }}">
                    @endif
                    </div>


                   
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <a href="{{ route('users') }}" title="users" id="userBackBtn" type="button"><i class="fas fa-arrow-left"></i> <b>Back</b></a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <button class="btn btn-primary float-right formSubmitBtn" id="formSubmitBtn"
                                    type="submit">{{ $button }}</button>
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
        $('#userForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            let $submitButton = $(this).find('button[type="submit"]');
            let originalText = $submitButton.html();
            $submitButton.text('Wait...');
            $submitButton.prop('disabled', true);

            // Clear previous error messages and invalid classes
            $('.error').empty().hide();
            $('input').removeClass('is-invalid');
            $('select').removeClass('is-invalid');

            // Serialize form data
            let formData = $(this).serialize();

            // Submit form via AJAX
            $.ajax({
                url: "{{ route('users.store') }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.isStatus) {
                        successMsgWithRedirect(response.message, "{{ route('users') }}");
                    } else {
                        errorMsgWithRedirect(response.message, "{{ route('users') }}");
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
                },
                complete: function() {
                    // $submitButton.html('<i class="fas fa-plus"></i>  Add');
                    $submitButton.html(originalText); // Restore original text
                    $submitButton.prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush