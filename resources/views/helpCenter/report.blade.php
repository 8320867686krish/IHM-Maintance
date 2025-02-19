@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-content">
<x-page-header title="Report Center"></x-page-header>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <form id="generatePdfForm" action="http://127.0.0.1:8000/report">
                        @csrf
                        <span class="dashboard-spinner spinner-sm" id="spinShow" style="display: none;  position: absolute;top: 50%;left: 35%;transform: translate(-50%, -50%);z-index:999999"></span>
                        <div class="row">


                            <div class="form-group col-4 mb-3">
                                <label for="assign_date">
                                    From Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="from_date" value="" name="from_date" autocomplete="off" onchange="updateToDate()" required="">
                                <div class="invalid-feedback error" id="po_noError"></div>
                            </div>

                            <div class="form-group col-4 mb-3">
                                <label for="assign_date">
                                    To Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="to_date" value="" name="to_date" autocomplete="off" onchange="removeInvalidClass(this)" required="">
                                <div class="invalid-feedback error" id="po_noError"></div>
                            </div>
                            <div class="form-group col-4 mb-3">
                                <label for="assign_date">
                                    Version<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="version" value="" name="version" autocomplete="off" onchange="removeInvalidClass(this)" required="">
                                <div class="invalid-feedback error" id="po_noError"></div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right mb-3" type="submit" id="genratereportbtn">Genrate Report</button>
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
</script>
@endpush