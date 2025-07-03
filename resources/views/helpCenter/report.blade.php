@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Report Of IHM Maintance"></x-page-header>

    <div class="ml-1 mr-1">


        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="accrodion-regular">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="poRecordsHeading">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#po-records" aria-expanded="false" aria-controls="po-records">
                                        Initial IHMM Records
                                        <span class="fas fa-angle-down mr-3"></span>

                                    </button>
                                </h5>
                            </div>
                            <div id="po-records" class="collapse show" aria-labelledby="headinginitial1" data-parent="#accordion">
                                <div class="card-body mb-4">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
                                        <a href="{{url('generate-IHM-sticker/'.$ship_id)}}"><button class="btn btn-primary float-right ml-2 mb-4">Generate IHM Sticker </button></a>
                                        <a href="{{url('summeryReport/'.$ship_id)}}"><button class="btn btn-primary float-right mb-4">Summary Report</button></a>
                                    </div>
                                    <div class="table-responsive">
                                        <h5> Supplement to IHM Part</h5>
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
                        <div class="card">
                            <div class="card-header" id="TrainingRecoreds">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#traing-records" aria-expanded="false" aria-controls="soreDpRecoreds">
                                        <h5> Records of IHM Maintance</h5>
                                        <span class="fas fa-angle-down mr-3"></span>

                                    </button>
                                </h5>
                            </div>
                            <div id="traing-records" class="collapse" aria-labelledby="TrainingRecoreds" data-parent="#accordion">
                                <div class="card-body mb-4">
                                    <x-previous-i-hm-amended :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-1'"></x-previous-i-hm-amended>
                                    <div class=" mb-2 mt-2">
                                        <x-previous-i-hm-amended :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-2'"></x-previous-i-hm-amended>
                                    </div>
                                    <div class=" mb-4 mt-2">
                                        <x-previous-i-hm-amended :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-3'"></x-ihm-part>
                                    </div>
                                    <h5>IHM Maintance Report</h5>
                                    <form id="generatePdfForm" action="{{route('report')}}">
                                        @csrf
                                        <input type="hidden" id="report_type" name="report_type" value="">
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
                                                    <button class="btn btn-primary float-right mb-3 ml-2" type="submit" id="genratereportbtn" data-action="report">Download</button>

                                                    <button class="btn btn-primary float-right mb-3 ml-2" type="submit" id="downloadMdSd" data-action="download_md_sdoc">Download MD&SDOC</button>

                                                    <a href="{{ url('poorder-history-export/'.$ship->id) }}" target="_blank">
                                                        <button class="btn btn-primary float-right mb-3" type="button">Download PO History</button>
                                                    </a>
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











    </div>
</div>
@endsection
@push('js')
<script>
    let clickedAction = ''; // Track which button was clicked

    $('#generatePdfForm button[type="submit"]').on('click', function() {
        clickedAction = $(this).data('action');
        $('#report_type').val(clickedAction); // Set hidden input
    });
    $('#generatePdfForm').submit(function(event) {
        event.preventDefault(); // Stop normal form submission
        let fromDate = $('#from_date').val();
        let toDate = $('#to_date').val();
        let tillToday = $('#till_today').is(':checked');

        if (!fromDate && !toDate && !tillToday) {
            errorMsg("Please select at least one date or check 'Till Today");
            return false;
        }
        $(".bg-overlay").show();
        let ship_id = "{{$ship_id}}";

        const reportType = $('#report_type').val(); // Get action type
        let $submitButton = $('#generatePdfForm button[data-action="' + reportType + '"]');
        let originalText = $submitButton.html();

        $('#spinShow').show();
        $submitButton.text('Wait...').prop('disabled', true);

        let formData = new FormData(this);
        formData.append('ship_id', ship_id);
        formData.append('report_type', reportType);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, status, xhr) {
                let fileName = xhr.getResponseHeader('X-File-Name') || reportType + '.pdf';
                let blob = new Blob([response], {
                    type: 'application/pdf'
                });
                let url = URL.createObjectURL(blob);
                let a = document.createElement('a');
                a.href = url;
                a.download = fileName;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

                URL.revokeObjectURL(url);
                $('#spinShow').hide();
                $submitButton.text(originalText).prop('disabled', false);
                $(".bg-overlay").hide();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#spinShow').hide();
                $submitButton.text(originalText).prop('disabled', false);
                $(".bg-overlay").hide();
            }
        });
    });
</script>
@endpush