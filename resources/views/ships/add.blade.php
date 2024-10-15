@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
@endsection
@section('shiptitle','Ships')

@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Ship Management</h2>
                    {{-- <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('ships') }}"
                                        class="breadcrumb-link">Ships</a></li>
                                <li class="breadcrumb-item active"><a href="#"
                                        class="breadcrumb-link">{{ $head_title ?? 'Add' }}</a></li>
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
                    <h5 class="card-header">{{ $head_title ?? '' }} Ship</h5>
                    <div class="card-body">
                        <form method="post" action="{{ route('ships.store') }}" class="needs-validation" novalidate
                            id="projectForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $ship->id ?? '' }}">
                            <input type="hidden" name="user_id" value="{{$shipUser->id ?? ''}}">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="client_id">Client <span class="text-danger">*</span></label>
                                        <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror" onchange="removeInvalidClass(this)">
                                            <option value="">Select Client</option>
                                            @if (isset($clients) && $clients->count() > 0)
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        data-identi="{{ $client->manager_initials }}"
                                                        {{ old('client_id') == $client->id || (isset($ship) && $ship->client_id == $client->id) ? 'selected' : '' }}>
                                                        {{ $client->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('client_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="ship_name">Ship Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('ship_name') is-invalid @enderror"
                                            id="ship_name" value="{{ old('ship_name', $ship->ship_name ?? '') }}"
                                            name="ship_name" placeholder="Ship Name..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        @error('ship_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="project_name">Ship Type</label>
                                        <input type="text" class="form-control @error('ship_type') is-invalid @enderror"
                                            id="ship_type" name="ship_type"
                                            value="{{ old('ship_type', $ship->ship_type ?? '') }}"
                                            placeholder="Ship Type..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        @error('ship_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="project_name">Ship Image</label>
                                        <input type="file" class="form-control @error('ship_image') is-invalid @enderror"
                                            id="ship_image" name="ship_image" autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        @error('ship_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                               
                               
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="imo_number">IMO Number <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('imo_number') is-invalid @enderror"
                                            id="imo_number" name="imo_number" placeholder="IMO Number..."
                                            value="{{ old('imo_number', $ship->imo_number ?? '') }}" onchange="removeInvalidClass(this)">
                                        @error('imo_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="project_no">Project Number</label>
                                        <input type="text" class="form-control @error('project_no') is-invalid @enderror"
                                            id="project_no" name="project_no" placeholder="Ship Number..."
                                            value="{{ old('project_no', $ship->project_no ?? '') }}" >
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="project_no">Ship Initials <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('ship_initials') is-invalid @enderror"
                                            id="ship_initials" name="ship_initials" placeholder="Ship Initials..."
                                            value="{{ old('ship_initials', $ship->ship_initials ?? '') }}"  onchange="removeInvalidClass(this)" {{ @$ship->ship_initials ? '' : '' }}>
                                            @error('ship_initials')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="client_email">Email<span class="text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email"
                                            value="{{ old('email', $shipUser->email ?? '') }}"
                                            placeholder="Ship Email..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        <div class="invalid-feedback error" id="emailError"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="phone">Phon</label>
                                        <input type="number"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone"
                                            value="{{ old('phone', $shipUser->phone ?? '') }}"
                                            placeholder="Client Phone..." autocomplete="off"
                                            onchange="removeInvalidClass(this)">
                                        <div class="invalid-feedback error" id="phoneError"></div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6">
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
                                <div class="form-group col-12 mb-3">
                                    <label for="project_no">Managers <span class="text-danger">*</span></label>
                                    <select class="selectpicker show-tick form-control form-control-lg" name="maneger_id[]"
                                        id="manager_id" multiple data-live-search="true" data-actions-box="true"
                                         onchange="removeInvalidClass(this)">
                                        @if ($managers->count() > 0)
                                            @foreach ($managers as $manager)
                                         
                                        
                                                    <option value="{{ $manager->id }}">
                                                        {{ $manager->name }}
                                                    </option>
                                              
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback error" id="user_idError"></div>
                                </div>
                                <div class="form-group col-12 mb-3">
                                    <label for="project_no">Experts <span class="text-danger">*</span></label>
                                    <select class="selectpicker show-tick form-control form-control-lg" name="expert_id[]"
                                        id="expert_id" multiple data-live-search="true" data-actions-box="true"
                                       onchange="removeInvalidClass(this)">
                                        @if ($experts->count() > 0)
                                            @foreach ($experts as $expert)
                                          
                                                    <option value="{{ $expert->id }}">
                                                        {{ $expert->name }}
                                                    </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback error" id="user_idError"></div>
                                </div>
                             
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <a href="{{ route('ships') }}" class="btn pl-0" type="button"><i
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
@endsection

@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <script>
         $('#projectForm').submit(function(e) {
            e.preventDefault();

            $('.error').empty().hide();
            $('input').removeClass('is-invalid');
            $('select').removeClass('is-invalid');

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('ships.store') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.isStatus) {
                        successMsgWithRedirect(response.message, "{{ route('ships') }}");

                    } else {
                        errorMsg(response.message);
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
            });
        });

    </script>
@endpush
