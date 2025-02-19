<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="section-block">
        <h5 class="section-title">IHM Maintenance</h5>
    </div>


    <div class="accrodion-regular">
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="poRecordsHeading">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#po-records" aria-expanded="false" aria-controls="po-records">
                            PO Records
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="po-records" class="collapse show" aria-labelledby="headinginitial1" data-parent="#accordion">
                    <div class="card-body mb-4 mt-2">
                        @include('ships.po.poItems')
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="TrainingRecoreds">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#traing-records" aria-expanded="false" aria-controls="soreDpRecoreds">
                            OnBoard Training Recoreds
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="traing-records" class="collapse" aria-labelledby="TrainingRecoreds" data-parent="#accordion">
                    <div class="card-body mb-4">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>

                                    <th>SR NO</th>
                                    <th>Designated Person</th>
                                    <th>Date</th>
                                    <th>Correct Answer</th>
                                    <th>Wrong Answer</th>
                                    <th>Total Questions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trainingRecoredHistory as $history)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$history->designated_name}}</td>
                                    <td>{{ $history->created_at->format('d/m/Y') }}</td>

                                    <td>{{$history->correct_ans}}</td>
                                    <td>{{$history->wrong_ans}}</td>
                                    <td>{{$history->total_ans}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="soreDpRecoreds">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#sordp" aria-expanded="false" aria-controls="soreDpRecoreds">
                            ShoreDP Recoreds
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="sordp" class="collapse" aria-labelledby="soreDpRecoreds" data-parent="#accordion">

                    <div class="card-body mb-4">
                        @can('ships.edit')

                        <a href="#" class="btn btn-primary float-right addadminShoreDp mb-3 ml-2">Add</a>
                        @endcan
                        <div class="table-responsive">

                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>Name</th>
                                        <th width="20%">Designation</th>
                                        <th width="20%">Start Date</th>
                                        <th width="20%">End Date</th>
                                        @can('ships.edit')

                                        <th>Action</th>
                                        @endcan

                                    </tr>
                                </thead>
                                <tbody class="shoredplist">
                                    <x-soredp-list :dpsore="$dpsore"></x-soredp-list>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="OnbaordTraining">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#onbaord-training" aria-expanded="false" aria-controls="onbaord-training">
                            OnBoard Designated Person Records
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="onbaord-training" class="collapse" aria-labelledby="OnbaordTraining" data-parent="#accordion">
                    <div class="card-body mb-4">
                        @can('ships.edit')

                        <a href="#" class="btn btn-primary float-right addadmineditdesignatedPerson mb-3 ml-2">Add</a>
                        @endcan
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first" id="admindprecoredsTable">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>Name</th>
                                        <th width="20%">Designation</th>

                                        <th width="10%">Rank</th>
                                        <th width="20%">Passport Numbr</th>
                                        <th width="20%">Sign On Date</th>
                                        <th width="20%">Sign Off Date</th>
                                        @can('ships.edit')
                                        <th>Action</th>
                                        @endcan

                                    </tr>
                                </thead>
                                <tbody class="admindprecoreds">
                                    <x-trainning-record :trainingRecoreds="$trainingRecoreds"></x-trainning-record>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingmacrew">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsemacrew" aria-expanded="false" aria-controls="collapsemacrew">
                            OnBoard Crew Briefing
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsemacrew" class="collapse" aria-labelledby="headingmacrew" data-parent="#accordion">
                    <div class="card-body mb-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>SR NO</th>
                                        <th>Number Of Attendance</th>
                                        <th>Briefing Date</th>
                                        <th>Briefing By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-brifing-history :brifingHistory=$brifingHistory></x-brifing-history>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="headingma3">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsema3" aria-expanded="false" aria-controls="collapsema3">
                            MD Records
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsema3" class="collapse" aria-labelledby="headingma3" data-parent="#accordion">
                    <div class="card-body mb-4">
                        <div class="table-responsive">

                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>Issue Date</th>
                                        <th width="20%">MD-ID-No</th>
                                        <th width="10%">Supplier Information</th>
                                        <th width="20%">Product Information</th>
                                        <th width="20%">Contained Material Information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-md-records :mdnoresults="$mdnoresults"></x-trainning-record>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingmasd">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsemasd" aria-expanded="false" aria-controls="collapsemasd">
                            SDoC Records
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsemasd" class="collapse" aria-labelledby="headingmasd" data-parent="#accordion">
                    <div class="card-body mb-4">
                        <div class="table-responsive">

                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>Issue Date</th>
                                        <th width="20%">SDoC No.</th>

                                        <th width="10%">Issuer’s Name</th>

                                        <th width="20%">Object(s) of Declaration</th>
                                        <th width="20%">Supplier’s Declaration of Conformity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <x-sd-records :mdnoresults="$sdocresults"></x-trainning-record>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header" id="headingma4">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsema4" aria-expanded="false" aria-controls="collapsema4">
                            Repair / Retrofit / Dry Dock / Conversion
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsema4" class="collapse" aria-labelledby="headingma4" data-parent="#accordion">
                    <div class="card-body mb-4">
                        @can('ships.edit')
                        <a href="#"
                            class="btn btn-primary float-right btn addMajorBtn mb-4">Add</a>
                        @endcan
                        <div class="table-responsive">

                            <table class="table table-striped table-bordered first" id="majorlttable">
                                <thead>
                                    <tr>
                                        <th width="5%">Sr.No</th>
                                        <th>Name</th>
                                        <th width="15%">Date</th>
                                        <th width="15%">Location Name</th>
                                        <th width="18%">Document Upload By</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="majorList">
                                    <x-majorrepair-list :majorrepair=$majorrepair></x-majorrepair-list>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


          





        </div>
    </div>
</div>
@include('shipdesignated.AdminDesignatedModel')
@include('shipdesignated.AdminShoreDp')
@include('majorRepair.majorRepairModel')
@include('training.model.startBrifing')

@push('js')
<script src="{{ asset('assets/js/shipdesignatedperson.js') }}"></script>
<script src="{{ asset('assets/js/majorRepair.js')}}"></script>
<script src="{{ asset('assets/js/training.js') }}"></script>

<script>
   document.addEventListener("DOMContentLoaded", function() {
    let fileInput = document.getElementById('excel_file');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            document.getElementById('uploadForm').submit();
        });
    }
});


    function updateToDate() {
        var fromDate = document.getElementById("from_date").value;
        var toDate = document.getElementById("to_date");

        if (fromDate) {
            toDate.min = fromDate; // Set 'To Date' min value to 'From Date'
            toDate.value = ""; // Reset 'To Date' if already selected before
        }
    }
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