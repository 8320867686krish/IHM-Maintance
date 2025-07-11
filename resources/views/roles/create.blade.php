@extends('layouts.app')

@section('content')
    <div class="container-fluid dashboard-content">
    <x-page-header title="Role Management"></x-page-header>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{{ $head_title ?? '' }} Role</h5>
                    <div class="card-body">
                        <form method="post" action="{{ route('roles.store') }}" class="needs-validation" novalidate
                            id="rolesForm">
                            @csrf
                            <input type="hidden" name="id" value="{{ $role->id ?? null }}">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Role"
                                            value="{{ old('name', $role->name ?? '') }}"
                                            onchange="removeInvalidClass(this)">
                                        <div class="invalid-feedback error" id="nameError"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="level">Level <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('level') is-invalid @enderror"
                                            id="level" value="{{ old('level', $role->level ?? '') }}" name="level"
                                            placeholder="Role Level..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        <div class="invalid-feedback error" id="levelError"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="section-block">
                                        <h5 class="section-title">Permissions</h5>
                                    </div>
                                </div>
                                @foreach ($allPermissions as $permission)
                                    @if ($permission['group_type'] === 'main' && $permission['name'] != 'permissions')
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="card" style="background-color:transparent !important">
                                                <div class="card-body">
                                                    <h6 class="mb-2">{{ ucfirst($permission['full_name']) }}</h6>
                                                    @foreach ($allPermissions as $submenu)
                                                        @if ($submenu['group_type'] === $permission['name'])
                                                            <label
                                                                class="custom-control custom-checkbox custom-control-inline">
                                                                @php
                                                                    $displayValue = substr(
                                                                        strrchr($submenu['name'], '.'),
                                                                        1,
                                                                    );
                                                                @endphp
                                                                @if (@$role_permissions && in_array($submenu['id'], $role_permissions))
                                                                    <?php $checked = 'checked'; ?>
                                                                @else
                                                                    <?php $checked = ''; ?>
                                                                @endif
                                                                <input type="checkbox" value="{{ $submenu['name'] }}"
                                                                    name="permissions[{{ $permission['name'] }}][]"
                                                                    {{ $checked }} class="custom-control-input"><span
                                                                    class="custom-control-label">
                                                                    {{ ucfirst($displayValue) }}
                                                                </span>
                                                            </label>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-12">
                                    <div class="invalid-feedback error" id="permissionsError"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <a href="{{ route('roles') }}" class="btn pl-0" type="button"><i
                                                class="fas fa-arrow-left"></i> <b>Back</b></a>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <button class="btn btn-primary float-right formSubmitBtn"
                                            type="submit">{!! $button ?? '<i class="fas fa-plus"></i>  Add' !!}</button>
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
        $("#rolesForm").submit(function(e) {
            e.preventDefault();

            var $submitButton = $(this).find('button[type="submit"]');
            var originalText = $submitButton.html();
            $submitButton.text('Wait...');
            $submitButton.prop('disabled', true);

            // Clear previous error messages and invalid classes
            $('.error').empty().hide();
            $('input').removeClass('is-invalid');

            let formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.isStatus) {
                        successMsgWithRedirect(response.message, "{{ route('roles') }}");
                    } else {
                        errorMsgWithRedirect(response.message, "{{ route('roles') }}");
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
