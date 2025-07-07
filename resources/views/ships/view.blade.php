@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/switchButton.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css')}}">
<style>
    button.btn.btn-link:not(.collapsed) .fas.fa-angle-down {
        transform: rotate(180deg);
        /* Arrow rotates upwards */
        transition: transform 0.3s ease-out;
        /* Smooth transition */
    }

    /* Default state for the arrow when collapsed */
    button.btn.btn-link .fas.fa-angle-down {
        transition: transform 0.3s ease-out;
        /* Smooth transition */
    }
</style>
@endsection
@section('shiptitle', $ship->ship_name)

@section('content')

<div class="container-fluid dashboard-content" id="projectViewContent">

    <aside class="page-aside" id="page-aside">
        <div class="aside-content">
            <div class="aside-header">
                <span class="title" style="font-size: 20px;">{{ ucFirst($ship->ship_name) ?? '' }} Information</span>
                <p class="description"></p>

            </div>
            <div class="aside-nav collapse">
                <ul class="nav">
                    <li>
                        <a href="{{ route('ships') }}"><span class="icon"><i
                                    class="fas fa-arrow-left"></i></span>Back</a>
                    </li>
                    <li class="active">
                        <a href="#ship_particulars" class="ship_particulars">
                            <span class="icon"><i class="fas fa-ship"></i></span>Ship Particulars
                        </a>
                    </li>

                    @can('assign_team.add')
                    <li>
                        <a href="#assign_project" class="assign_project"><span class="icon"><i
                                    class="fas fa-fw fa-briefcase"></i></span>Assign Team</a>
                    </li>
                    @endcan


                    <li>
                        <a href="#ihm_intial" class="ihm_intial"><span class="icon"><i
                                    class="fas fa-fw fa-briefcase"></i></span>IHM Initial Records</a>
                    </li>

                    <li>
                        <a href="#ihm_maintenance" class="ihm_maintenance"><span class="icon"><i
                                    class="fas fa-fw fa-briefcase"></i></span>IHM Maintenance</a>
                    </li>

                    <li>
                        <a href="#report_center" class="report_center"><span class="icon"><i
                                    class="fas fa-fw fa-briefcase"></i></span>Report Center</a>
                    </li>



                </ul>
            </div>
        </div>
    </aside>
    <div class="main-content container-fluid p-0" id="report_center" style="display: none;">
        <div class="row card-body">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headinginitial5">
                <h5 class="mb-0">
                    Report Center
                </h5>
            </div>

            <div class="card-body">
                <form id="generatePdfForm" action="{{route('report')}}">
                    @csrf
                    <input type="hidden" id="report_type" name="report_type" value="">

                    <span class="dashboard-spinner spinner-sm" id="spinShow" style="display: none;  position: absolute;top: 50%;left: 35%;transform: translate(-50%, -50%);z-index:999999"></span>
                    <div class="row">


                        <div class="form-group col-4 mb-1">
                            <label for="assign_date">
                                From Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-lg" id="from_date" value="" name="from_date" autocomplete="off" onchange="updateToDate()">
                            <div class="invalid-feedback error" id="po_noError"></div>
                        </div>

                        <div class="form-group col-4 mb-1">
                            <label for="assign_date">
                                To Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-lg" id="to_date" value="" name="to_date" autocomplete="off" onchange="removeInvalidClass(this)">
                            <div class="invalid-feedback error" id="po_noError"></div>
                        </div>
                        <div class="form-group col-4 mb-3 text-center mt-4  ">

                            <label class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" name="till_today" class="custom-control-input" id="till_today" value="1"><span class="custom-control-label">Till Today</span>
                            </label>

                        </div>

                        <div class="col-12 mt-4 mb-4">
                            <div class="form-group">
                                <button class="btn btn-primary float-right mb-3 ml-2" type="submit" id="genratereportbtn" data-action="report">Download</button>

                                <button class="btn btn-primary float-right mb-3 ml-2" type="submit" id="downloadMdSd" data-action="download_md_sdoc">Download MD&SDOC</button>

                                <button class="btn btn-primary float-right mb-3 ml-2" type="submit" id="downloadMdSd" data-action="po_history">Download PO History</button>

                            </div>
                        </div>
                    </div>

                </form>
            </div>


        </div>



    </div>
    <div class="main-content container-fluid p-0" id="assign_project" style="display: none;">

        <div class="email-head-subject">
            <div class="title"><span>Assign Team</span></div>
        </div>

        <div class="row">
            @include('ships.assignShip')
        </div>

    </div>



    <div class="main-content container-fluid p-0" id="ship_particulars"
        {{ $isBack == 0 ? 'style=display:block' : 'style=display:none' }}>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block">
                <h5 class="section-title">IHM Summary Key Details</h5>
            </div>

            <div class="accrodion-regular">
                <div id="accordion">


                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button
                                    class="btn btn-link collapsed d-flex justify-content-between w-100 align-items-center"
                                    data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    Ship Particulars
                                    <span class="fas fa-angle-down mr-3"></span>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree">
                            <div class="card-body mb-4">
                                <div class="alert alert-success sucessMsg" role="alert" style="display: none;">
                                    Save Successfully!!<a href="#" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                        <span>×</span>
                                    </a>
                                </div>
                                <form method="post" action="{{ route('ships.store') }}" class="needs-validation"
                                    novalidate id="projectForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $ship->id ?? '' }}" id="id">

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4 mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('ship_name') is-invalid @enderror"
                                                    id="ship_name"
                                                    value="{{ old('ship_name', $ship->ship_name ?? '') }}"
                                                    name="ship_name" placeholder="" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{$readonly}}>
                                                <label for="ship_name">Ship Name <span
                                                        class="text-danger">*</span></label>
                                                <div class="invalid-feedback error" id="ship_nameError"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4 mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="number"
                                                    class="form-control  @error('imo_number') is-invalid @enderror"
                                                    id="imo_number" name="imo_number"
                                                    onchange="removeInvalidClass(this)"
                                                    value="{{ old('imo_number', $ship->imo_number ?? '') }}"
                                                    {{ $readonly }}>
                                                <label for="imo_number">Ship IMO Number <span
                                                        class="text-danger">*</span></label>
                                                <div class="invalid-feedback error" id="imo_numberError"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4 mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('call_sign') is-invalid @enderror"
                                                    id="call_sign" name="call_sign" placeholder=""
                                                    value="{{ old('call_sign', $project->call_sign ?? '') }}"
                                                    {{ $readonly }}>
                                                <label for="call_sign">Call Sign</label>
                                                @error('call_sign')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group  input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('manager_name') is-invalid @enderror"
                                                    id="manager_name"
                                                    value="{{ old('manager_name', $ship['client']['name'] ?? '') }}"
                                                    placeholder="" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" readonly>
                                                <label for="manager_name">Manager Name</label>
                                                @error('manager_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-4 mb-1">
                                            <div class="form-group  input-label-group">

                                                <input type="text" class="form-control" id="owner_name"
                                                    value="{{ old('owner_name', $ship['client']['ship_owner_name'] ?? '') }}"
                                                    readonly>
                                                <label for="client_company_id">Ship Owner</label>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 mb-1">
                                            <div class="form-group  input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('ship_type') is-invalid @enderror"
                                                    id="ship_type" name="ship_type"
                                                    value="{{ old('ship_type', $ship->ship_type ?? '') }}"
                                                    placeholder="" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }} required>
                                                <label for="ship_type">Type of ship</label>
                                                @error('ship_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('port_of_registry') is-invalid @enderror"
                                                    id="port_of_registry"
                                                    value="{{ old('port_of_registry', $ship->port_of_registry ?? '') }}"
                                                    name="port_of_registry" placeholder="   "
                                                    autocomplete="off" onchange="removeInvalidClass(this)"
                                                    {{ $readonly }}>
                                                <label for="port_of_registry">Port Of Registry</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('vessel_class') is-invalid @enderror"
                                                    id="vessel_class"
                                                    value="{{ old('vessel_class', $ship->vessel_class ?? '') }}"
                                                    name="vessel_class" placeholder="" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                <label for="vessel_class">Vessel Class</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('ihm_class') is-invalid @enderror"
                                                    id="ihm_class"
                                                    value="{{ old('ihm_class', $ship->ihm_class ?? '') }}"
                                                    name="ihm_class" placeholder="" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                <label for="ihm_class">IHM Certifying Class</label>
                                                @error('ihm_class')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('flag_of_ship') is-invalid @enderror"
                                                    id="flag_of_ship"
                                                    value="{{ old('flag_of_ship', $ship->flag_of_ship ?? '') }}"
                                                    name="flag_of_ship" placeholder="" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                <label for="flag_of_ship">Flag of ship</label>
                                                @error('flag_of_ship')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="date"
                                                    class="form-control  @error('delivery_date') is-invalid @enderror"
                                                    id="delivery_date"
                                                    value="{{ old('delivery_date', $ship->delivery_date ?? '') }}"
                                                    name="delivery_date" placeholder="" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                <label for="delivery_date">Delivery Date</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('building_details') is-invalid @enderror"
                                                    id="building_details"
                                                    value="{{ old('building_details', $ship->building_details ?? '') }}"
                                                    name="building_details" placeholder=""
                                                    autocomplete="off" onchange="removeInvalidClass(this)"
                                                    {{ $readonly }}>
                                                <label for="building_details">Building Yard Details</label>
                                                @error('building_details')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('x_breadth_depth') is-invalid @enderror"
                                                    id="x_breadth_depth"
                                                    value="{{ old('x_breadth_depth', $ship->x_breadth_depth ?? '') }}"
                                                    name="x_breadth_depth" placeholder=""
                                                    autocomplete="off" onchange="removeInvalidClass(this)"
                                                    {{ $readonly }}>
                                                <label for="x_breadth_depth">Length x breadth x depth</label>
                                                @error('x_breadth_depth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('gross_tonnage') is-invalid @enderror"
                                                    id="gross_tonnage"
                                                    value="{{ old('gross_tonnage', $ship->gross_tonnage ?? '') }}"
                                                    name="gross_tonnage" placeholder="GRT" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                <label for="gross_tonnage">Gross Registered Tonnage (GRT)</label>
                                                @error('grt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control  @error('vessel_previous_name') is-invalid @enderror"
                                                    id="vessel_previous_name"
                                                    value="{{ old('vessel_previous_name', $ship->vessel_previous_name ?? '') }}"
                                                    name="vessel_previous_name" placeholder="Vessel Previous Name"
                                                    autocomplete="off" onchange="removeInvalidClass(this)"
                                                    {{ $readonly }}>
                                                <label for="vessel_previous_name">Vessel Previous Name (If Any) </label>
                                                @error('vessel_previous_names')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">
                                                <input type="file"
                                                    class="form-control @error('ship_image') is-invalid @enderror"
                                                    id="ship_image" name="ship_image" autocomplete="off"
                                                    onchange="removeInvalidClass(this)">
                                                <label for="project_name">Ship Image</label>
                                                @error('ship_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            @if($ship['ship_image'])
                                            <a href="{{ asset('uploads/ship/' . $ship->ship_image) }}" target="_blank">{{$ship['ship_image']}}</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <hr class="mb-4">
                                        </div>
                                    </div>

                                    <h5 class="mb-2">Initial IHM Particulars</h5>
                                    <div class="row mt-4">

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('report_number') is-invalid @enderror"
                                                    id="report_number" name="report_number" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" value="{{ old('report_number', $ship->report_number ?? '') }}" placeholder="">
                                                <label for="project_name">Report Number</label>
                                                @error('report_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="date"
                                                    class="form-control @error('initial_ihm_date') is-invalid @enderror"
                                                    id="initial_ihm_date" name="initial_ihm_date" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" value="{{ old('initial_ihm_date', $ship->initial_ihm_date ?? '') }}">
                                                <label for="project_name">Initial Ihm Report Date</label>
                                                @error('initial_ihm_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('survey_location') is-invalid @enderror"
                                                    id="survey_location" name="survey_location" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" value="{{ old('survey_location', $ship->survey_location ?? '') }}" placeholder="">
                                                <label for="project_name">Survey Location</label>
                                                @error('survey_location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="date"
                                                    class="form-control @error('survey_date') is-invalid @enderror"
                                                    id="survey_date" name="survey_date" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" value="{{ old('survey_date', $ship->survey_date ?? '') }}" placeholder="">
                                                <label for="survey_date">Survey Date</label>
                                                @error('survey_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('prepared_by') is-invalid @enderror"
                                                    autocomplete="off" name="prepared_by"
                                                    onchange="removeInvalidClass(this)" value="{{ old('prepared_by', @$ship->prepared_by ?? '') }}" placeholder="">
                                                <label for="project_name">Prepared By (Company Name)</label>
                                                @error('prepared_by')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('initial_address') is-invalid @enderror"
                                                    autocomplete="off" name="initial_address"
                                                    onchange="removeInvalidClass(this)" value="{{ old('initial_address', @$ship->initial_address ?? '') }}" placeholder="">
                                                <label for="project_name">Address</label>
                                                @error('prepared_by')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('approved_by') is-invalid @enderror"
                                                    autocomplete="off" name="approved_by"
                                                    onchange="removeInvalidClass(this)" value="{{ old('approved_by', @$ship->hazmatComapny->address ?? '') }}">
                                                <label for="project_name">Approved By (Class)</label>
                                                @error('approved_by')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('ship_owner_name_initial') is-invalid @enderror"
                                                    autocomplete="off" name="ship_owner_name_initial"
                                                    onchange="removeInvalidClass(this)" value="{{ old('ship_owner_name_initial', @$ship->ship_owner_name_initial ?? '') }}" placeholder="">
                                                <label for="project_name">Ship Owner Name</label>
                                                @error('ship_owner_name_initial')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('ship_owner_address_initial') is-invalid @enderror"
                                                    autocomplete="off" name="ship_owner_address_initial"
                                                    onchange="removeInvalidClass(this)" value="{{ old('ship_owner_address_initial', @$ship->ship_owner_address_initial ?? '') }}" placeholder="">
                                                <label for="project_name">Ship Owner Address</label>
                                                @error('ship_owner_address_initial')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('manager_name_initial') is-invalid @enderror"
                                                    autocomplete="off" name="manager_name_initial"
                                                    onchange="removeInvalidClass(this)" value="{{ old('manager_name_initial', @$ship->manager_name_initial ?? '') }}" placeholder="">
                                                <label for="project_name">Manager Name</label>
                                                @error('manager_name_initial')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('manager_address_initial') is-invalid @enderror"
                                                    autocomplete="off" name="manager_address_initial"
                                                    onchange="removeInvalidClass(this)" value="{{ old('manager_address_initial', @$ship->manager_address_initial ?? '') }}" placeholder="">
                                                <label for="project_name">Manager Address</label>
                                                @error('manager_address_initial')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <hr class="mb-4">
                                        </div>
                                    </div>

                                    <h5 class="mb-2">Initial IHM Current Version</h5>
                                    <div class="row mt-4">

                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-2">
                                            <div class="form-group input-label-group">

                                                <input type="text"
                                                    class="form-control @error('current_ihm_version') is-invalid @enderror"
                                                    id="current_ihm_version" name="current_ihm_version" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" value="{{ old('current_ihm_version', $ship->current_ihm_version ?? '') }}">
                                                <label for="project_name">Current IHM Version</label>
                                                @error('current_ihm_version')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-4  mb-1">
                                            <div class="form-group input-label-group">

                                                <input type="date"
                                                    class="form-control @error('ihm_version_updated_date') is-invalid @enderror"
                                                    id="ihm_version_updated_date" name="ihm_version_updated_date" autocomplete="off" value="{{ old('ihm_version_updated_date', $ship->ihm_version_updated_date ?? '') }}"
                                                    onchange="removeInvalidClass(this)">
                                                <label for="project_name">Ihm Version Updated Date</label>
                                                @error('ihm_version_updated_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-6">
                                            &nbsp;
                                        </div>
                                        @if(!@$readonly)
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                @can('ships.edit')
                                                <button class="btn btn-primary float-right  formSubmitBtn"
                                                    type="submit">Save</button>
                                                @endcan
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>



    <div class="main-content container-fluid p-0" id="ihm_intial" style="display: none;">
        <div class="row card-body">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h5 class="section-title">IHM Initial Reords</h5>

                </div>
            </div>
        </div>
        @include('ships.ihm-initial')

    </div>


    <div class="main-content container-fluid p-0" id="ihm_maintenance" style="display: none;">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @include('ships.ihm-maintance')

    </div>


</div>

@endsection

@push('js')
<script>
    var shipSave = "{{ route('ships.store') }}";
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ asset('assets/js/ship.js') }}"></script>
<script src="{{ asset('assets/js/checks.js') }}"></script>


<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>
<script>
    $(document).ready(function() {

        if (window.location.hash) {
            var target = $(window.location.hash);
            var subsection = window.location.href.split("#").pop();
            var section = subsection;
            if (subsection == 'po-records' || subsection == 'onbaord-training') {
                section = "ihm_maintenance";
            }
            if (target.length) {
                $('.aside-nav .nav li').removeClass('active');
                $(`.${section}`).parent('li').addClass('active');
                $('.main-content').hide();
                $(`#${section}`).show();
                let targetId = $(this).attr('href');
                $(`#${subsection}`).addClass('show');
                $(targetId).show();

                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
        }
        const url = window.location.href;
        const segments = url.split('/');
        const projectId = segments[segments.length - 1];
        let sidebar = $("#mainSidebar");
        let isSidebarVisible = true;

        if ($(window).width() >= 768) {
            $("#sidebarCollapse").show();
            $("#sidebarCollapse").find('span').css({
                "height": "1em",
                "width": "1em"
            });
        } else {
            $("#sidebarCollapse").hide();
        }

        $(document).on("click", "#sidebarCollapse", function() {
            if ($(window).width() >= 768) {
                if (isSidebarVisible) {
                    sidebar.css("left", "-188px"); //250
                    $('#page-aside').css("left", "78px"); //8
                    $('.dashboard-wrapper').css("margin-left", "78px"); //8
                } else {
                    sidebar.css("left", "0");
                    $('#page-aside').css("left", "265px");
                    $('.dashboard-wrapper').css("margin-left", "264px");
                }
                isSidebarVisible = !isSidebarVisible;
            }
        });

        $('.aside-nav .nav li a').click(function() {
            $('.aside-nav .nav li').removeClass('active');
            $(this).parent('li').addClass('active');
            $('.main-content').hide();
            let targetId = $(this).attr('href');
            $(targetId).show();
            return false;
        });

        $('.aside-nav .nav li a[href="#assign_project"]').click(function() {
            $('.main-content').hide();
            $('#assign_project').show();
            return false;
        });

        setTimeout(function() {
            $('.alert-success').fadeOut();
        }, 15000);
    });
</script>
@endpush