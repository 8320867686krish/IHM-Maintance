@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/cropper/dist/cropper.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css')}}">
<style>
    .bg-overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        background: #0f0f0fd1;
        z-index: 999999999999;
        display: none;
    }

    #pdf-container {
        position: relative;
        width: 100%;
        overflow: auto;
    }

    #pdf-page {
        display: block;
        margin: auto;
    }

    #cropper-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .output {
        padding: 10px 0;
        color: #fff;
        background: #525252;
        width: 100%;
        max-width: 420px;
        padding-left: 5px;
    }

    .outfit {
        line-height: 0;
        position: relative;
        width: auto;
        height: auto;
        background: gray;
        display: inline-block;
        max-width: 420px;

        img {
            width: 100%;
            height: auto;
            cursor: pointer;
        }
    }

    .dot {
        position: absolute;
        width: 24px;
        height: 24px;
        /* background: rgba(white, 1); */
        background: #fff;
        border-radius: 50%;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 0 3px 0 rgba(0, 0, 0, .2);
        line-height: 24px;
        font-size: 12px;
        font-weight: bold;
        transition: box-shadow .214s ease-in-out, transform .214s ease-in-out, background .214s ease-in-out;
        text-align: center;

        &.ui-draggable-dragging {
            box-shadow: 0 0 25px 0 rgba(0, 0, 0, .5);
            transform: scale3d(1.2, 1.2, 1.2);
            background: rgba(white, .7);
        }
    }

    .fancybox-button--rotate {
        position: absolute;
        bottom: 10px;
        right: 60px;
        background: rgba(30, 30, 30, 0.8);
        border: none;
        border-radius: 50%;
        padding: 10px;
        cursor: pointer;
        z-index: 9999;
    }

    .fancybox-button--update {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(30, 30, 30, 0.8);
        border: none;
        border-radius: 50%;
        padding: 10px;
        cursor: pointer;
        z-index: 9999;
    }

    .checkImagePreview {
        display: inline-block;
        margin: 10px;
        position: relative;
    }

    .checkImagePreview img {
        width: 160px;
    }

    .checkImagePreview a {
        position: absolute;
        top: 2px;
        right: 2px;
        text-decoration: none;
        color: red;
        cursor: pointer;
        /* background: white; */
        /* border-radius: 50%; */
        padding: 2px;
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
                            <span class="icon"><i class="fas fa-ship"></i></span>IHM Summary
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
                                    class="fas fa-fw fa-briefcase"></i></span>IHM Initial Record</a>
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

    <div class="main-content container-fluid p-0" id="ship_particulars"
        {{ $isBack == 0 ? 'style=display:block' : 'style=display:none' }}>
        <div class="email-head">
            <div class="email-head-subject">
                <div class="title">
                    <span>Ship Particulars</span>
                </div>
            </div>
        </div>
        <div class="email-body">
            <div class="alert alert-success sucessMsg" role="alert" style="display: none;">
                Save Successfully!!<a href="#" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <form method="post" class="needs-validation" novalidate id="projectForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $ship->id ?? '' }}" id="projectId">

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
                                value="{{ old('manager_name', $project->client->manager_name ?? '') }}"
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
                            <input type="hidden" name="client_id" id="client_id"
                                value="{{ old('client_id', $project->client->id ?? '') }}">
                            <input type="text" class="form-control" id="owner_name"
                                value="{{ old('owner_name', $project->client->owner_name ?? '') }}" readonly>
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
                                value="{{ old('port_of_registry', $project->port_of_registry ?? '') }}"
                                name="port_of_registry" placeholder="Port Of Registry" autocomplete="off"
                                onchange="removeInvalidClass(this)" {{ $readonly }}>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="vessel_class">Vessel Class</label>
                            <input type="text" class="form-control  @error('vessel_class') is-invalid @enderror"
                                id="vessel_class" value="{{ old('vessel_class', $project->vessel_class ?? '') }}"
                                name="vessel_class" placeholder="Vessel Class" autocomplete="off"
                                onchange="removeInvalidClass(this)" {{ $readonly }}>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ihm_class">IHM Certifying Class</label>
                            <input type="text" class="form-control  @error('ihm_class') is-invalid @enderror"
                                id="ihm_class" value="{{ old('ihm_class', $project->ihm_class ?? '') }}"
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
                                id="flag_of_ship" value="{{ old('flag_of_ship', $project->flag_of_ship ?? '') }}"
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
                                id="delivery_date" value="{{ old('delivery_date', $project->delivery_date ?? '') }}"
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
                                value="{{ old('building_details', $project->building_details ?? '') }}"
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
                                value="{{ old('x_breadth_depth', $project->x_breadth_depth ?? '') }}"
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
                        <div class="form-group">
                            <a href="{{ route('ships') }}" class="btn pl-0" type="button"><i
                                    class="fas fa-arrow-left"></i> <b>Back</b></a>
                        </div>
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
        <div class="row mt-5">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header text-center">Po Overview</h5>
                    <div class="card-body">
                        <canvas id="chartjs_bar_ship"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="main-content container-fluid p-0" id="ihm_intial">

        <div class="email-head-subject">
            <div class="title">
                Po Records
            </div>
        </div>

        <div class="row">
            <divv class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th width="15%">Sr.No</th>
                                <th>PO Detalis</th>
                                <th width="10%">PO Detalis</th>
                                <th width="20%">Date</th>
                                <th width="20%">Checked By</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                            </tr>


                        </tbody>
                    </table>
                </div>
        </div>

    </div>

    <div class="main-content container-fluid p-0" id="ihm_maintenance">

        <div class="email-head-subject">
            <div class="title">
                Onbaord Training Record
            </div>
        </div>

        <div class="row">
            <divv class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th width="15%">Sr.No</th>
                                <th>Date</th>
                                <th width="10%">Duration</th>
                                <th width="20%">Number of Pepole</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>10-10-2024</td>
                                <td>15 Days</td>
                                <td>15</td>

                            </tr>


                        </tbody>
                    </table>
                </div>
        </div>

    </div>


</div>
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>

<script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>
<script>
    let rotationState = 0;

    let clickedButton = null;

    // Attach click event to both buttons
    $('#summery, #fullreport').click(function() {
        clickedButton = $(this).attr('id');
    });


    $('#generatePdfForm').submit(function(event) {
        $(".bg-overlay").show();
        var projectId = $('#projectId').val();
        event.preventDefault(); // Prevent default form submission

        let $submitButton = $('#' + clickedButton);
        let originalText = $submitButton.html();


        // Show loading spinner and disable the submit button
        $('#spinShow').show();
        $submitButton.text('Wait...');
        $submitButton.prop('disabled', true);

        let formData = new FormData(this);
        formData.append('action', clickedButton); // Add action to formData

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhrFields: {
                responseType: 'blob' // Important
            },
            success: function(response, status, xhr) {
                let fileName = xhr.getResponseHeader('X-File-Name');
                $(".bg-overlay").hide();
                if (!fileName) {
                    console.log("dd");
                    fileName = projectId + '.pdf';
                }
                // Create a Blob from the response
                let blob = new Blob([response], {
                    type: 'application/pdf'
                });
                let url = URL.createObjectURL(blob);

                // Create a link element and trigger a download
                let a = document.createElement('a');
                a.href = url;
                a.download = fileName; // Set the file name
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

                // Hide loading spinner and re-enable the submit button
                $('#spinShow').hide();
                $submitButton.text(originalText);
                $submitButton.prop('disabled', false);

                // Revoke the object URL after the download
                URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle errors or show an error message
                $('#spinShow').hide();
                $submitButton.text(originalText);
                $submitButton.prop('disabled', false);
            }

        });
    });

    function previewFile(input) {
        let file = $("input[type=file]").get(0).files[0];

        if (file) {
            let reader = new FileReader();

            reader.onload = function() {
                $("#previewImg").attr("src", reader.result);
            }

            reader.readAsDataURL(file);
        }
    }

    function handleTableTypeChange(selectedValue, cloneTableTypeDiv) {
        if (!selectedValue || !cloneTableTypeDiv) {
            console.error("Missing parameters for handleTableTypeChange function");
            return;
        }

        const targetElements = cloneTableTypeDiv.find(".table_typecol, .dochazmat, .imagehazmat");

        const newClass = (selectedValue === "Unknown") ? "col-12" : "col-4";

        targetElements.removeClass("col-12 col-4").addClass(newClass);
        cloneTableTypeDiv.find(".imagehazmat").toggle(selectedValue !== "Unknown");
        cloneTableTypeDiv.find(".dochazmat").toggle(selectedValue !== "Unknown");
        cloneTableTypeDiv.find(".remarks").toggle(selectedValue == "PCHM");
        if (selectedValue == "Unknown") {
            cloneTableTypeDiv.find(".documentLoadCheckbox").prop('checked', false);
            cloneTableTypeDiv.find(".equipment, .manufacturer, .modelMakePart").hide();
        }
        cloneTableTypeDiv.find(`.documentLoadCheckboxDiv`).toggle(selectedValue !== "Unknown");
    }

    function handleIHMTypeChange(selectedValue, cloneTableTypeDiv) {
        if (!selectedValue || !cloneTableTypeDiv) {
            console.error("Missing parameters for handleIHMTypeChange function");
            return;
        }

        const targetElements = cloneTableTypeDiv.find(".IHMPartDiv, .IHMTypeDiv");
        const isContainedOrPCHM = selectedValue === "Contained" || selectedValue === "PCHM";
        const newClass = isContainedOrPCHM ? "col-6" : "col-12";

        targetElements.removeClass("col-12 col-6").addClass(newClass);
        cloneTableTypeDiv.find(".IHMPartDiv").toggle(isContainedOrPCHM);
    }

    function labResult(selectedValue, selectedText) {

        let clonedElement = $('#cloneIHMTableDiv').clone();
        clonedElement.removeAttr("id");
        clonedElement.attr("id", "cloneIHMTableDiv" + selectedValue);

        clonedElement.find('label.ihmTableLable').text(selectedText);

        clonedElement.find('select.IHM_type').attr('id', `IHM_type_${selectedValue}`).attr('name',
            `IHM_type[${selectedValue}]`);

        clonedElement.find('select.IHM_part').attr('id', `IHM_part_${selectedValue}`).attr('name',
            `IHM_part[${selectedValue}]`);

        clonedElement.find('input[type="text"].unit').prop({
            id: `unit_${selectedValue}`,
            name: `unit[${selectedValue}]`
        });

        clonedElement.find('input[type="number"].number').prop({
            id: `number_${selectedValue}`,
            name: `number[${selectedValue}]`
        });

        clonedElement.find('input[type="text"].weight').prop({
            id: `sample_weight_${selectedValue}`,
            name: `sample_weight[${selectedValue}]`
        });

        clonedElement.find('input[type="text"].sarea').prop({
            id: `sample_area_${selectedValue}`,
            name: `sample_area[${selectedValue}]`
        });

        clonedElement.find('input[type="text"].density').prop({
            id: `density_${selectedValue}`,
            name: `density[${selectedValue}]`
        });

        clonedElement.find('input[type="text"].affected').prop({
            id: `affected_${selectedValue}`,
            name: `affected_area[${selectedValue}]`
        });

        clonedElement.find('input[type="text"].total').prop({
            id: `total_${selectedValue}`,
            name: `total[${selectedValue}]`
        });

        clonedElement.find('textarea.labRemarksTextarea').prop({
            id: `lab_remarks_${selectedValue}`,
            name: `lab_remarks[${selectedValue}]`
        });

        clonedElement.find(`.IHMPartDiv`).hide();
        // // Append cloned element to showTableTypeDiv
        $('#showLabResult').append(clonedElement);
    }

    function triggerFileInput(inputId) {
        $(`#${inputId}`).val('');
        document.getElementById(inputId).click();
        $(".dashboard-spinner").show();
    }

    async function convertToImage() {
        $(".dashboard-spinner").show();

        const pdfFile = document.getElementById('pdfFile').files[0];
        if (!pdfFile) {
            alert('Please select a PDF file.');
            return;
        }

        const fileReader = new FileReader();
        fileReader.onload = async function() {
            const pdfData = new Uint8Array(this.result);
            const pdf = await pdfjsLib.getDocument({
                data: pdfData
            }).promise;

            for (let i = 1; i <= pdf.numPages; i++) {
                const page = await pdf.getPage(i);
                const viewport = page.getViewport({
                    scale: 1
                });


                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                $(".dashboard-spinner").show();

                await page.render({
                    canvasContext: context,
                    viewport
                }).promise;
                const imageData = canvas.toDataURL('image/png');
                const img = document.createElement('img');
                img.src = imageData;
                img.classList.add('pdf-image'); // Add a class to the image

                const container = document.getElementById('img-container');
                var pdfContainer = document.createElement('div');
                pdfContainer.id = 'pdfContainer' + i; // Set the ID for the new div
                pdfContainer.className = 'pdfContainer'; // Set the class for the new div
                container.appendChild(pdfContainer);
                // if(i == 1) {
                // } else {
                //     container.appendChild(pdfContainer).style="display:none";
                // }
                pdfContainer.appendChild(img);
                img.onload = function() {
                    var options = {
                        currentPage: i,
                        deleteMethod: 'doubleClick',
                        handles: true,
                        area: {
                            strokeStyle: 'green',
                            lineWidth: 2
                        },
                        onSelectEnd: function(image, selection) {
                            console.log("Selection End:", selection);
                        },
                        initAreas: []
                    };
                    $(this).areaSelect(options);
                };
                $(".dashboard-spinner").hide();
            }

            // Bind event listeners after images are loaded
            // $('.pdf-image').on('load', function() {
            //     var options = {
            //         deleteMethod: 'doubleClick',
            //         handles: true,
            //         area: {
            //             strokeStyle: 'green',
            //             lineWidth: 2
            //         },

            //         onSelectEnd: function(image, selection) {
            //             console.log("Selection End:", selection);
            //         },
            //         initAreas: []
            //     };
            //     $(this).areaSelect(options);
            // });
        };
        fileReader.readAsArrayBuffer(pdfFile);
        $('#pdfModal').modal('show');
    }

    function detailOfHazmats(checkId) {
        $.ajax({
            type: 'GET',
            url: "{{ url('check') }}" + "/" + checkId + "/hazmat",
            success: function(response) {
                $('#showTableTypeDiv').html(response.html);
                $('#showLabResult').html(response.labResult);

                let jsonObject = response.check;
                for (var key in jsonObject) {
                    if (jsonObject.hasOwnProperty(key)) {
                        $(`#checkDataAddForm #${key}`).val(jsonObject[key]);
                    }
                }

                $('#checkDataAddForm #suspected_hazmat').selectpicker('val', response.hazmatIds);

                $.each(response.check.hazmats, function(index, hazmatData) {
                    if (hazmatData.type === 'Unknown') {
                        $(`#imagehazmat${hazmatData.hazmat_id}`).hide();
                        $(`#dochazmat${hazmatData.hazmat_id}`).hide();
                    }
                });

                const cloneTableTypeDiv = $(".cloneTableTypeDiv select.table_type").closest(
                    ".cloneTableTypeDiv");

                cloneTableTypeDiv.find(".equipment").hide();
                cloneTableTypeDiv.find(".manufacturer").hide();
                cloneTableTypeDiv.find(".modelMakePart").hide();

                $("#checkDataAddModal").modal('show');
            },
        });
    }

    function getHazmatEquipment(hazmat_id) {
        $.ajax({
            type: 'GET',
            url: "{{ url('getHazmatEquipment') }}" + "/" + hazmat_id,
            success: function(response) {
                if (response.isStatus) {
                    $(`#equipmentSelectTag_${hazmat_id}`).attr('data-id', hazmat_id);
                    $.each(response.equipments, function(index, value) {
                        $(`#equipmentSelectTag_${hazmat_id}`).append($('<option>', {
                            value: index,
                            text: index
                        }));
                    });

                    const cloneTableTypeDiv = $(".cloneTableTypeDiv select.table_type").closest(
                        ".cloneTableTypeDiv");

                    cloneTableTypeDiv.find(`#equipmentDiv_${hazmat_id}`).closest('.equipment').show();
                    cloneTableTypeDiv.find(`#manufacturerDiv_${hazmat_id}`).closest('.manufacturer').show();
                    cloneTableTypeDiv.find(`#modelMakePartDiv_${hazmat_id}`).closest('.modelMakePart')
                        .show();
                }
            },
        });
    }

    function rotateImage() {
        rotationState = (rotationState + 1) % 4;
        let degree;
        switch (rotationState) {
            case 0:
                degree = 0; // Original position
                break;
            case 1:
                degree = 90; // Left
                break;
            case 2:
                degree = 180; // Bottom
                break;
            case 3:
                degree = 270; // Right
                break;
        }
        $('#demo-image').css({
            '-webkit-transform': 'rotate(' + degree + 'deg)',
            '-moz-transform': 'rotate(' + degree + 'deg)',
            'transform': 'rotate(' + degree + 'deg)'
        });
    }

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

        $('#pdfModal').on('hidden.bs.modal', function() {
            $("#img-container").empty();
            $(".pdf-image").empty();
        });

        $('#pdfFile').change(function() {
            convertToImage();
        });

        // $('.main-content').hide();

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

        $(".formgenralButton").click(function() {
            $('span').html("");

            $.ajax({
                type: "POST",
                url: "{{ url('detail/save') }}",
                data: $("#genralForm").serialize(),
                success: function(msg) {
                    $(".sucessgenralMsg").show();
                }
            });
        });

        $('#projectForm').submit(function(e) {
            e.preventDefault();

            $('.error').empty().hide();
            $('input').removeClass('is-invalid');
            $('select').removeClass('is-invalid');

            let formData = new FormData(this);

            $.ajax({
                url: "{{ url('detail/save') }}",
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

        $(".outfit img").click(function(e) {

            var dot_count = $(".dot").length;

            var top_offset = $(this).offset().top - $(window).scrollTop();
            var left_offset = $(this).offset().left - $(window).scrollLeft();

            var top_px = Math.round((e.clientY - top_offset - 12));
            var left_px = Math.round((e.clientX - left_offset - 12));

            var top_perc = top_px / $(this).height() * 100;
            var left_perc = left_px / $(this).width() * 100;

            // alert('Top: ' + top_px + 'px = ' + top_perc + '%');
            // alert('Left: ' + left_px + 'px = ' + left_perc + '%');

            var dot = '<div class="dot" style="top: ' + top_perc + '%; left: ' + left_perc + '%;">' + (
                dot_count +
                1) + '</div>';

            $(dot).hide().appendTo($(this).parent()).fadeIn(350);
            var position = {
                left: left_perc,
                top: top_perc
            };

            $(".dot").draggable({
                containment: ".outfit",
                stop: function(event, ui) {
                    var new_left_perc = parseInt($(this).css("left")) / ($(".outfit")
                            .width() / 100) +
                        "%";
                    var new_top_perc = parseInt($(this).css("top")) / ($(".outfit")
                            .height() / 100) +
                        "%";
                    var output = 'Top: ' + parseInt(new_top_perc) + '%, Left: ' + parseInt(
                        new_left_perc) + '%';
                    var position = {
                        left: new_left_perc,
                        top: new_top_perc
                    };

                    $(this).css("left", parseInt($(this).css("left")) / ($(".outfit")
                            .width() / 100) +
                        "%");
                    $(this).css("top", parseInt($(this).css("top")) / ($(".outfit")
                            .height() / 100) +
                        "%");

                    $('.output').html('CSS Position: ' + output);
                }
            });

            // console.log("Left: " + left_perc + "%; Top: " + top_perc + '%;');
            $('.output').html("CSS Position: Left: " + parseInt(left_perc) + "%; Top: " + parseInt(
                    top_perc) +
                '%;');
        });

        $("#imageForm").submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            let dots = [];
            $(".dot").each(function(index) {
                let containerWidth = $(this).parent().width();
                let containerHeight = $(this).parent().height();

                let left = parseFloat($(this).css('left')) / containerWidth * 100;
                let top = parseFloat($(this).css('top')) / containerHeight * 100;

                dots.push({
                    left: left,
                    top: top
                });
            });

            formData.append('dots', JSON.stringify(dots));

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.isStatus) {
                        $("#imageId").val(response.id);
                    }
                    // Handle success response
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error response
                }
            });
        });

        $("#hotsportNameTypeDiv").hide();

        $(document).on("click", ".dot", function() {
            let dotCounText = $(this).text();
            let cloneHtml = $("#hotsportNameTypeDiv .form-group").clone();

            cloneHtml.find('input').each(function() {
                let currentId = $(this).attr('id');
                let currentName = $(this).attr('name');
                let newId = currentId + '_' + dotCounText.trim();
                let newName = currentName + '_' + dotCounText.trim();
                $(this).attr('id', newId);
                $(this).attr('name', newName);
            });

            $("#hotsportNameType").append(cloneHtml);
        });













        //Check Image javascript code
        let selectedFiles = [];













        $(document).on('change', '.documentLoadCheckbox', function() {
            let id = $(this).attr('data-id');

            if ($(this).is(':checked')) {
                getHazmatEquipment(id);
            } else {
                const cloneTableTypeDiv = $(".cloneTableTypeDiv select.table_type").closest(
                    ".cloneTableTypeDiv");

                cloneTableTypeDiv.find(`#equipmentSelectTag_${id}`).empty().append($('<option>', {
                    value: "",
                    text: "Select Equipment"
                }));
                cloneTableTypeDiv.find(`#manufacturerSelectTag_${id}`).empty().append($('<option>', {
                    value: "",
                    text: "First Select Equipment"
                }));
                cloneTableTypeDiv.find(`#modelMakePartTag_${id}`).empty().append($('<option>', {
                    value: "",
                    text: "First Select Manufacturer"
                }));

                cloneTableTypeDiv.find(`#equipmentDiv_${id}`).closest('.equipment').hide();
                cloneTableTypeDiv.find(`#manufacturerDiv_${id}`).closest('.manufacturer').hide();
                cloneTableTypeDiv.find(`#modelMakePartDiv_${id}`).closest('.modelMakePart').hide();
            }
        });

        $(document).on('change', '.equipmentSelectTag', function() {
            let optionValue = $(this).val();
            let id = $(this).attr('data-id');

            if (optionValue != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('getManufacturer') }}" + "/" + id + "/" + optionValue,
                    success: function(response) {
                        if (response.isStatus) {
                            $(`#manufacturerSelectTag_${id}`).attr('data-id', id);
                            $(`#manufacturerSelectTag_${id}`).attr('data-equipment',
                                optionValue);
                            $(`#manufacturerSelectTag_${id}`).empty();
                            $(`#manufacturerSelectTag_${id}`).append($(
                                '<option>', {
                                    value: "",
                                    text: "Select Manufacturer"
                                }));
                            $(`#modelMakePartTag_${id}`).empty().append($('<option>', {
                                value: "",
                                text: "First Select Manufacturer"
                            }));

                            $.each(response.manufacturers, function(index, value) {
                                $(`#manufacturerSelectTag_${id}`).append($(
                                    '<option>', {
                                        value: value.manufacturer,
                                        text: value.manufacturer
                                    }));
                            });
                        }
                    },
                });
            } else {
                $(`#manufacturerSelectTag_${id}`).empty().append($('<option>', {
                    value: "",
                    text: "First Select Equipment"
                }));
                $(`#modelMakePartTag_${id}`).empty().append($('<option>', {
                    value: "",
                    text: "First Select Manufacturer"
                }));
                $(`#docNameShow_${id}`).empty();
                $(`#imageNameShow_${id}`).empty();
            }
        });

        $(document).on('change', '.manufacturerSelectTag', function() {
            let optionValue = $(this).val();
            let id = $(this).attr('data-id');
            let equipment = $(this).attr('data-equipment');

            if (optionValue != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('getManufacturerBasedDocumentData') }}" + "/" + id + "/" +
                        equipment + "/" + optionValue,
                    success: function(response) {
                        if (response.isStatus) {
                            $(`#modelMakePartTag_${id}`).attr('data-id', id);
                            $(`#modelMakePartTag_${id}`).empty();
                            $(`#modelMakePartTag_${id}`).append($(
                                '<option>', {
                                    value: "",
                                    text: "Select Model Make and Part"
                                }));

                            $.each(response.documentData, function(index, value) {
                                $(`#modelMakePartTag_${id}`).append($(
                                    '<option>', {
                                        value: value.id,
                                        text: value.modelmakepart
                                    }));
                            });
                        }
                    },
                });
            } else {
                $(`#modelMakePartTag_${id}`).empty().append($('<option>', {
                    value: "",
                    text: "First Select Manufacturer"
                }));
                $(`#docNameShow_${id}`).empty();
                $(`#imageNameShow_${id}`).empty();
            }
        });

        $(document).on('change', '.modelMakePartTag', function() {
            let optionValue = $(this).val();
            let id = $(this).attr('data-id');

            if (optionValue != "") {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('getPartBasedDocumentFile') }}" + "/" + optionValue,
                    success: function(response) {
                        // console.log(response.documentFile.document1['name']);
                        if (response.isStatus) {
                            let data = response.documentFile;

                            if (data.document1['name'] != null) {
                                $(`#imageNameShow_${id}`).empty();
                                let html =
                                    `<a href="${data.document1['path']}" target="_black" > ${data.document1['name']} </a>`;
                                $(`#imageNameShow_${id}`).append(html);
                            }

                            if (data.document2['name'] != null) {
                                $(`#docNameShow_${id}`).empty();
                                let html =
                                    `<a href="${data.document2['path']}" target="_black"> ${data.document2['name']} </a>`;
                                $(`#docNameShow_${id}`).append(html);
                            }
                        }
                    },
                });
            } else {
                $(`#docNameShow_${id}`).empty();
                $(`#imageNameShow_${id}`).empty();
            }
        });

        $(document).on("click", ".deleteCheckbtn", function(e) {
            e.preventDefault();
            let recordId = $(this).data('id');
            let deleteUrl = $(this).attr("href");
            let $liToDelete = $(this).closest('li');
            let confirmMsg = "Are you sure you want to delete this check?";

            confirmDeleteWithElseIf(deleteUrl, confirmMsg, function(response) {
                // Success callback
                if (response.isStatus) {
                    $liToDelete.remove();
                    $(".dot").remove();
                    $('#showDeckCheck').html();
                    $('#checkListUl').html();
                    $('#showDeckCheck').html(response.htmldot);
                    $('#checkListUl').html(response.htmllist);
                    makeDotsDraggable();
                }
            });
        });

        // Remove Hazmat Document Analysis Results Document
        $(document).on('click', '.removeHazmatDocument', function(e) {
            e.preventDefault();
            let deleteUrl = $(this).attr('href');
            let parentDiv = $(this).closest('div');
            let confirmMsg = "Are you sure you want to delete this document?";

            confirmDeleteWithElseIf(deleteUrl, confirmMsg, function(response) {
                // Success callback
                if (response.isStatus) {
                    parentDiv.empty();
                }
            });
        });

        // Add event listener for Save button click
        $(document).on("click", "#checkDataAddSubmitBtn", function() {
            let checkFormData = new FormData($("#checkDataAddForm")[0]);
            checkFormData.append('deselectId', selectedHazmatsIds);
            let $submitButton = $(this);
            let originalText = $submitButton.html();
            $submitButton.text('Wait...');
            $submitButton.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: $("#checkDataAddForm").attr('action'),
                data: checkFormData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.isStatus) {
                        $("#checkListTable").html(response.trtd);
                        successMsg(response.message);
                        $("#checkDataAddForm")[0].reset();
                        $("#id").val("");
                        $submitButton.html(originalText);
                        $submitButton.prop('disabled', false);
                        $("#checkDataAddModal").modal('hide');
                    } else {
                        $.each(response.message, function(field, messages) {
                            $('#' + field + 'Error').text(messages[0]).show();
                            $('[name="' + field + '"]').addClass('is-invalid');
                        });

                        $submitButton.html(originalText);
                        $submitButton.prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    $submitButton.html(originalText);
                    $submitButton.prop('disabled', false);
                }
            });
        });
    });
    $('.addfiles').on('click', function() {
        $('#image').click();
        return false;
    });
</script>
@endpush