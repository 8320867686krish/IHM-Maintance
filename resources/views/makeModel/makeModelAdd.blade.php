@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/switchButton.css') }}">
@endsection

@section('content')
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <x-page-header title="Document Declaration Management"></x-page-header>

    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            @include('layouts.message')
            <div class="card">
                <h5 class="card-header">{{ $head_title ?? '' }} Document</h5>
                <div class="card-body">
                    <form method="post" action="{{ route('documentdeclaration.store') }}" class="needs-validation" novalidate id="makeModelForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $model->id ?? '' }}">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="hazmat_id">Hazmat <span class="text-danger">*</span></label>
                                    <select name="hazmat_id" id="hazmat_id" class="form-control" onchange="removeInvalidClass(this)">
                                        <option value="">Select hazmat</option>
                                        @if (isset($hazmats) && $hazmats->count() > 0)
                                        @foreach ($hazmats as $hazmat)
                                        <option value="{{ $hazmat->id }}" {{ old('hazmat_id') == $hazmat->id || (isset($model) && $model->hazmat_id == $hazmat->id) ? 'selected' : '' }}>
                                            {{ $hazmat->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback error" id="hazmat_idError"></div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="equipment">Equipment <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="equipment" value="{{ old('equipment', $model->equipment ?? '') }}" name="equipment" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="equipmentError"></div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="model">Model <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="model" value="{{ old('model', $model->model ?? '') }}" name="model" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="modelError"></div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="make">Make <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        id="make" name="make" value="{{ old('make', $model->make ?? '') }}" autocomplete="off"
                                        onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="makeError"></div>
                                </div>
                            </div>



                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="part">Part <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="part" name="part" value="{{ old('part', $model->part ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="manufacturer">Manufacturer <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $model->manufacturer ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="manufacturerError"></div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="document1">MD Documnet<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="document1" name="document1" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="document1Error"></div>
                                </div>
                                @if (isset($model) && !empty($model->document1['name']))
                                <a href="{{$model->document1['path']}}" target="_black">{{$model->document1['name']}}</a>
                                @endif
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="document2">SDoc Document</label>
                                    <input type="file" class="form-control" id="document2" name="document2" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="document2Error"></div>
                                </div>
                                @if (isset($model) && !empty($model->document2['name']))
                                <a href="{{$model->document2['path']}}" target="_black">{{$model->document2['name']}}</a>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="part">Other Information</label>
                                    <textarea row="3" cols="5" class="form-control" id="other_information" name="other_information" value="{{ old('other_information', $model->other_information ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">{{$model->other_information ?? ''}}</textarea>
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h4>MD Information</h4>
                            </div>
                            <div class="col-sm-6 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="part">MD No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="md_no" name="md_no" value="{{ old('md_no', $model->md_no ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="part">MD Date of Declaration</label>
                                    <input type="date" class="form-control" id="md_date" name="md_date" value="{{ old('md_date', $model->md_date ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>

                             <div class="col-sm-6 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="part">Qty <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="md_qty" name="md_qty" value="{{ old('md_qty', $model->md_qty ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>

                             <div class="col-sm-6 col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="part">Unit <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="md_unit" name="md_unit" value="{{ old('md_unit', $model->md_unit ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>

                           
                        </div>
                        <hr/>
                        <div class="row">
                        <div class="col-12">
                                <h4>SDoC Information</h4>
                            </div>
                            <div class="col-sm-4 col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="part">SDoC No<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sdoc_no" name="sdoc_no" value="{{ old('sdoc_no', $model->sdoc_no ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>


                            <div class="col-sm-4 col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="part">SDoC Date of Issue <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="sdoc_date" name="sdoc_date" value="{{ old('sdoc_date', $model->sdoc_date ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="part">Issuer's Name</label>
                                    <input type="text" class="form-control" id="issuer_name" name="issuer_name" value="{{ old('issuer_name', $model->issuer_name ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="part">SDoC Objects</label>
                                    <textarea row="3" cols="5" class="form-control" id="sdoc_objects" name="sdoc_objects" value="{{ old('sdoc_objects', $model->sdoc_objects ?? '') }}" autocomplete="off" onchange="removeInvalidClass(this)">{{$model->sdoc_objects ?? ''}}</textarea>
                                    <div class="invalid-feedback error" id="partError"></div>
                                </div>
                            </div>



                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h4>Supplier Information</h4>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">Company Name</label>
                                    <input type="text" name="coumpany_name" id="coumpany_name"
                                        class="form-control @error('coumpany_name') is-invalid @enderror"
                                        placeholder="Company Name..."
                                        value="{{ old('coumpany_name', $model->coumpany_name ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">Division Name</label>

                                    <input type="text" name="division_name" id="division_name"
                                        class="form-control @error('division_name') is-invalid @enderror"
                                        placeholder="Division Name..."
                                        value="{{ old('division_name', $model->division_name ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">Address</label>

                                    <input type="text" name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Address..."
                                        value="{{ old('address', $model->address ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">Contact Person</label>

                                    <input type="text" name="contact_person" id="contact_person"
                                        class="form-control @error('contact_person') is-invalid @enderror"
                                        placeholder="Contact Person..."
                                        value="{{ old('contact_person', $model->contact_person ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">Telephone Number</label>

                                    <input type="text" name="telephone_number" id="telephone_number"
                                        class="form-control @error('telephone_number') is-invalid @enderror"
                                        placeholder="Telephone Number..."
                                        value="{{ old('telephone_number', $model->telephone_number ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">Fax Number</label>

                                    <input type="text" name="fax_number" id="fax_number"
                                        class="form-control @error('fax_number') is-invalid @enderror"
                                        placeholder="Fax Number..."
                                        value="{{ old('fax_number', $model->fax_number ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">E-mail address</label>

                                    <input type="text" name="email_address" id="email_address"
                                        class="form-control @error('email_address') is-invalid @enderror"
                                        placeholder="Email Address..."
                                        value="{{ old('email_address', $model->email_address ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="level">SDoC ID-No</label>

                                    <input type="text" name="sdoc_id_no" id="sdoc_id_no"
                                        class="form-control @error('sdoc_id_no') is-invalid @enderror"
                                        placeholder="SDOC ID-No"
                                        value="{{ old('sdoc_id_no', $model->sdoc_id_no ?? '') }}"
                                        onchange="removeInvalidClass(this)" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <a href="{{ route('documentdeclaration') }}" id="modelBackBtn" type="button"><i class="fas fa-arrow-left"></i> <b>Back</b></a>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-4">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" id="modelFormSubmitBtn" type="submit">{{ $button }}</button>
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
        $('#makeModelForm').submit(function(event) {
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
            let formData = new FormData(this);

            let formAction = $(this).attr('action');

            // Submit form via AJAX
            $.ajax({
                url: formAction,
                method: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.isStatus) {
                        successMsgWithRedirect(response.message, "{{ route('documentdeclaration') }}");
                    } else {
                        errorMsgWithRedirect(response.message, "{{ route('documentdeclaration') }}");
                    }
                },
                error: function(xhr, status, error) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(field, messages) {
                            $('#' + field + 'Error').text(messages[0]).show();
                            $('[name="' + field + '"]').addClass('is-invalid');
                        });
                    } else {
                        console.error('Error submitting form:', error);
                    }
                },
                complete: function() {
                    $submitButton.html(originalText);
                    $submitButton.prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush