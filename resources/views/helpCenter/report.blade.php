@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Initial Ihm Records"></x-page-header>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
            <a href="{{url('generate-IHM-sticker/'.$ship_id)}}"><button class="btn btn-primary float-right ml-2">Generate IHM Sticker </button></a>
            <a href="{{url('summeryReport/'.$ship_id)}}"><button class="btn btn-primary float-right">Summary Report</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body mb-4">
                    <h5>Record Of IHMM Part1 Maintenance</h5>
                    <x-previous-i-hm-amended :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-1'"></x-previous-i-hm-amended.>
                        <div class=" mb-2 mt-2">
                            <x-previous-i-hm-amended :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-2'"></x-previous-i-hm-amended>
                        </div>
                        <div class=" mb-4 mt-2">
                            <x-previous-i-hm-amended :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-3'"></x-ihm-part>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body mb-4">
                    <h5> Supplement to initial IHM Part</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th width="15%">SR NO</th>
                                    <th>Title</th>
                                    <th width="20%">Document</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="partmanullist">
                                <tr>
                                    <td>1</td>
                                    <td>GA Plan</td>

                                    <td><a href="{{asset('uploads/shipsVscp/'.$ship->id.'/'.$ship->ga_plan_pdf)}}" target="_blank" download>{{$ship->ga_plan_pdf}}</a></td>
                                    <td>
                                        <a href="{{asset('uploads/shipsVscp/'.$ship->id.'/'.$ship->ga_plan_pdf)}}" title="download" download target="_blank" class="mr-2">
                                            <span class="icon"><i class="fas fa-download  text-primary"></i></span>
                                        </a>
                                    </td>
                                </tr>
                                <x-part-manual-list :partMenual="$partMenual"></x-part-manual-list>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body mb-4">
                    <h5>Records of IHM Previous Maintance</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th width="5%">Sr.No</th>
                                    <th>Name</th>
                                    <th width="15%">Date From</th>
                                    <th width="15%">Date Till</th>
                                    <th width="18%">Maintained By</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="PreviousAttachmentList">
                                @if(count($previousAttachment)>0)
                                <x-previous-attachment-list :previousAttachment=$previousAttachment></x-previous-attachment-list>
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No HM Previous Maintance available.</td>

                                </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-page-header title="Report Center"></x-page-header>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Records of IHM Previous Maintance</h5>
                    <form id="generatePdfForm" action="{{route('report')}}">
                        @csrf
                        <span class="dashboard-spinner spinner-sm" id="spinShow" style="display: none;  position: absolute;top: 50%;left: 35%;transform: translate(-50%, -50%);z-index:999999"></span>
                        <div class="row mt-2">


                            <div class="form-group col-4 mb-3">
                                <label for="assign_date">
                                    From Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="from_date" value="" name="from_date" autocomplete="off" onchange="updateToDate()">
                                <div class="invalid-feedback error" id="po_noError"></div>
                            </div>

                            <div class="form-group col-4 mb-3">
                                <label for="assign_date">
                                    To Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="to_date" value="" name="to_date" autocomplete="off" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="po_noError"></div>
                            </div>
                            <div class="form-group col-4 mb-3 mt-4 text-center">

                                <label class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" name="till_today" class="custom-control-input" id="till_today" value="1"><span class="custom-control-label">Till Today</span>
                                </label>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right mb-3" type="submit" id="genratereportbtn">Generate Report</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body mb-4">
                    <h5>MD & SD Recort Report</h5>
                    <form id="generateMdForm" action="{{route('md&sd')}}" method="POST">
                        @csrf
                        <span class="dashboard-spinner spinner-sm" id="spinShowMd" style="display: none;  position: absolute;top: 50%;left: 35%;transform: translate(-50%, -50%);z-index:999999"></span>
                        <div class="row">
                            <div class="form-group col-4 mb-3">
                                <label for="assign_date">
                                    From Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="from_date" value="" name="from_date" autocomplete="off" onchange="updateToDate()">
                                <div class="invalid-feedback error" id="po_noError"></div>
                            </div>

                            <div class="form-group col-4 mb-3">
                                <label for="assign_date">
                                    To Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="to_date" value="" name="to_date" autocomplete="off" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="po_noError"></div>
                            </div>
                            <div class="form-group col-4 mb-3 mt-4 text-center">

                                <label class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" name="till_today" class="custom-control-input" id="till_today" value="1"><span class="custom-control-label">Till Today</span>
                                </label>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right mb-3" type="submit" id="downloadMdSd">Download MD & SD</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body mb-4">
                    <h5>Po Order History</h5>
                    <div class="col-12">
                        <div class="form-group">
                            <a href="{{ url('poorder-history-export/'.$ship->id) }}" target="_blank"><button class="btn btn-primary float-right mb-3" id="genratereportbtn">Download PO History </button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
@push('js')
<script>
    $('#generatePdfForm').submit(function(event) {
        $(".bg-overlay").show();
        var ship_id = "{{$ship_id}}";
        event.preventDefault(); // Prevent default form submission
        let $submitButton = $('#genratereportbtn');

        let originalText = $submitButton.html();


        // Show loading spinner and disable the submit button
        $('#spinShow').show();
        $submitButton.text('Wait...');
        $submitButton.prop('disabled', true);

        let formData = new FormData(this);
        formData.append('ship_id', ship_id); // Add action to formData

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

    $('#generateMdForm').submit(function(event) {
        $(".bg-overlay").show();
        var ship_id = "{{$ship_id}}";
        event.preventDefault(); // Prevent default form submission
        let $submitButton = $('#downloadMdSd');

        let originalText = $submitButton.html();


        // Show loading spinner and disable the submit button
        $('#spinShowMd').show();
        $submitButton.text('Wait...');
        $submitButton.prop('disabled', true);

        let formData = new FormData(this);
        formData.append('ship_id', ship_id); // Add action to formData

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
                $('#spinShowMd').hide();
                $submitButton.text(originalText);
                $submitButton.prop('disabled', false);

                // Revoke the object URL after the download
                URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle errors or show an error message
                $('#spinShowMd').hide();
                $submitButton.text(originalText);
                $submitButton.prop('disabled', false);
            }

        });
    });
</script>
@endpush