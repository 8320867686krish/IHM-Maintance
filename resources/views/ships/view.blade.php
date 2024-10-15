@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css')}}">
<style>
    button.btn.btn-link:not(.collapsed) .fas.fa-angle-down {
    transform: rotate(180deg); /* Arrow rotates upwards */
    transition: transform 0.3s ease-out; /* Smooth transition */
}

/* Default state for the arrow when collapsed */
button.btn.btn-link .fas.fa-angle-down {
    transition: transform 0.3s ease-out; /* Smooth transition */
}
</style>
@endsection
@section('shiptitle',$ship->ship_name)

@section('content')

<div class="container-fluid dashboard-content" id="projectViewContent">

    <aside class="page-aside" id="page-aside">
        <div class="aside-content">
            <div class="aside-header">
                <span class="title" style="font-size: 20px;">Ship Information</span>
                <p class="description">{{ $project->ship_name ?? '' }}</p>
                {{-- <button class="navbar-toggle" type="button"><span class="icon" style="cursor: pointer; font-size: 16px !important;"><i class="fas fa-bars" id="pageNavbarToggleBtn"></i></span></button> --}}
            </div>
            <div class="aside-nav collapse">
                <ul class="nav">
                    <li>
                        <a href="{{ route('ships') }}"><span class="icon"><i
                                    class="fas fa-arrow-left"></i></span>Back</a>
                    </li>
                    <li class="{{ $isBack == 0 ? 'active' : '' }}">
                        <a href="#ship_particulars">
                            <span class="icon"><i class="fas fa-ship"></i></span>IHM Summary Key Details
                        </a>
                    </li>

                    @can('ships.add')
                    <li>
                        <a href="#assign_project"><span class="icon"><i
                                    class="fas fa-fw fa-briefcase"></i></span>Assign Team</a>
                    </li>
                    @endcan


                    <li>
                        <a href="#ihm_intial"><span class="icon"><i
                                    class="fas fa-fw fa-briefcase"></i></span>IHM Initial Records</a>
                    </li>

                    <li>
                        <a href="#ihm_maintenance"><span class="icon"><i
                                    class="fas fa-fw fa-briefcase"></i></span>IHM Maintenance</a>
                    </li>



                </ul>
            </div>
        </div>
    </aside>
    <div class="main-content container-fluid p-0" id="assign_project">

        <div class="email-head-subject">
            <div class="title"><span>Assign Team</span>

            </div>
        </div>

        <div class="row">
            @include('ships.assignShip')
        </div>

    </div>
    @php
   
    @endphp

    @can('ships.edit')
    $readonly = "readOnly";
    @php
    $readonly = "";
    @endphp
    @endcan
    <div class="main-content container-fluid p-0" id="ship_particulars"
        {{ $isBack == 0 ? 'style=display:block' : 'style=display:none' }}>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            
            <div class="accrodion-regular">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed d-flex justify-content-between w-100 align-items-center" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    IHM Summary Graph
                                    <span class="fas fa-angle-down mr-3"></span>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                            <div class="card-body">
                                <canvas id="chartjs_bar_ihm_summery"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed d-flex justify-content-between w-100 align-items-center" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    PO Summary Graph
                                    <span class="fas fa-angle-down mr-3"></span>
                                </button>

                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <canvas id="chartjs_bar_ship"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed d-flex justify-content-between w-100 align-items-center" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Ship Particulars
                                    <span class="fas fa-angle-down mr-3"></span>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <div class="alert alert-success sucessMsg" role="alert" style="display: none;">
                                    Save Successfully!!<a href="#" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </a>
                                </div>
                                <form method="post" action="{{ route('ships.store') }}" class="needs-validation" novalidate
                                id="projectForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $ship->id ?? '' }}" id="id">

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="ship_name">Ship Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control  @error('ship_name') is-invalid @enderror"
                                                    id="ship_name" value="{{ old('ship_name', $ship->ship_name ?? '') }}"
                                                    name="ship_name" placeholder="Ship Name..." autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                <div class="invalid-feedback error" id="ship_nameError"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="imo_number">Ship IMO Number <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control  @error('imo_number') is-invalid @enderror"
                                                    id="imo_number" name="imo_number" onchange="removeInvalidClass(this)"
                                                    value="{{ old('imo_number', $ship->imo_number ?? '') }}" {{ $readonly }}>
                                                <div class="invalid-feedback error" id="imo_numberError"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="call_sign">Call Sign</label>
                                                <input type="text" class="form-control  @error('call_sign') is-invalid @enderror"
                                                    id="call_sign" name="call_sign" placeholder="Call Sign..."
                                                    value="{{ old('call_sign', $project->call_sign ?? '') }}" {{ $readonly }}>
                                                @error('call_sign')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="manager_name">Manager Name</label>
                                                <input type="text" class="form-control  @error('manager_name') is-invalid @enderror"
                                                    id="manager_name"
                                                    value="{{ old('manager_name', $ship->client->name ?? '') }}"
                                                    placeholder="Manager Name..." autocomplete="off" onchange="removeInvalidClass(this)"
                                                    readonly>
                                                @error('manager_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="client_id">Ship Owner</label>
                                                
                                                <input type="text" class="form-control" id="owner_name"
                                                    value="{{ old('owner_name', $ship->client->ship_owner_name ?? '') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="ship_type">Type of ship</label>
                                                <input type="text" class="form-control  @error('ship_type') is-invalid @enderror"
                                                    id="ship_type" name="ship_type"
                                                    value="{{ old('ship_type', $ship->ship_type ?? '') }}" placeholder="Ship Type..."
                                                    autocomplete="off" onchange="removeInvalidClass(this)" {{ $readonly }} required>
                                                @error('ship_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="port_of_registry">Port Of Registry</label>
                                                <input type="text"
                                                    class="form-control  @error('port_of_registry') is-invalid @enderror"
                                                    id="port_of_registry"
                                                    value="{{ old('port_of_registry', $ship->port_of_registry ?? '') }}"
                                                    name="port_of_registry" placeholder="Port Of Registry" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="vessel_class">Vessel Class</label>
                                                <input type="text" class="form-control  @error('vessel_class') is-invalid @enderror"
                                                    id="vessel_class" value="{{ old('vessel_class', $ship->vessel_class ?? '') }}"
                                                    name="vessel_class" placeholder="Vessel Class" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="ihm_class">IHM Certifying Class</label>
                                                <input type="text" class="form-control  @error('ihm_class') is-invalid @enderror"
                                                    id="ihm_class" value="{{ old('ihm_class', $ship->ihm_class ?? '') }}"
                                                    name="ihm_class" placeholder="Ihm Class" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                @error('ihm_class')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="flag_of_ship">Flag of ship</label>
                                                <input type="text" class="form-control  @error('flag_of_ship') is-invalid @enderror"
                                                    id="flag_of_ship" value="{{ old('flag_of_ship', $ship->flag_of_ship ?? '') }}"
                                                    name="flag_of_ship" placeholder="Flag of ship..." autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                @error('flag_of_ship')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="delivery_date">Delivery Date</label>
                                                <input type="date" class="form-control  @error('delivery_date') is-invalid @enderror"
                                                    id="delivery_date" value="{{ old('delivery_date', $ship->delivery_date ?? '') }}"
                                                    name="delivery_date" placeholder="Delivery Date" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="building_details">Building Yard Details</label>
                                                <input type="text"
                                                    class="form-control  @error('building_details') is-invalid @enderror"
                                                    id="building_details"
                                                    value="{{ old('building_details', $ship->building_details ?? '') }}"
                                                    name="building_details" placeholder="Builder Details" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                @error('building_details')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="x_breadth_depth">Length x breadth x depth</label>
                                                <input type="text"
                                                    class="form-control  @error('x_breadth_depth') is-invalid @enderror"
                                                    id="x_breadth_depth"
                                                    value="{{ old('x_breadth_depth', $ship->x_breadth_depth ?? '') }}"
                                                    name="x_breadth_depth" placeholder="Length x breadth x depth" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                @error('x_breadth_depth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="gross_tonnage">Gross Registered Tonnage (GRT)</label>
                                                <input type="text" class="form-control  @error('gross_tonnage') is-invalid @enderror"
                                                    id="gross_tonnage" value="{{ old('gross_tonnage', $ship->gross_tonnage ?? '') }}"
                                                    name="gross_tonnage" placeholder="GRT" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                @error('grt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="vessel_previous_name">Vessel Previous Name (If Any) </label>
                                                <input type="text"
                                                    class="form-control  @error('vessel_previous_name') is-invalid @enderror"
                                                    id="vessel_previous_name"
                                                    value="{{ old('vessel_previous_name', $ship->vessel_previous_name ?? '') }}"
                                                    name="vessel_previous_name" placeholder="Vessel Previous Name" autocomplete="off"
                                                    onchange="removeInvalidClass(this)" {{ $readonly }}>
                                                @error('vessel_previous_names')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-6">
                                           &nbsp;
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                @can('ships.edit')
                                                <button class="btn btn-primary float-right btn-rounded formSubmitBtn"
                                                    type="submit">Save</button>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>



    <div class="main-content container-fluid p-0" id="ihm_intial">

        @include('ships.ihm-initial')

    </div>

    <div class="main-content container-fluid p-0" id="ihm_maintenance">

        @include('ships.ihm-maintance')
    </div>


</div>
@endsection

@push('js')
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>
<script>
  $(document).ready(function() {
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

     
      

      

        let back = "{{ $isBack }}";
        if (back == 1) {
            $('#ship_particulars').hide();
            $('#ihm_maintenance').hide();
            $('#ihm_intial').hide();
            $("#assign_project").hide();
        } else {
            $('#ship_particulars').show();
            $('#ihm_maintenance').hide();
            $('#ihm_intial').hide();
            $("#assign_project").hide();
        }

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
                        successMsg(response.message);
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

      
    });
   
</script>
@endpush