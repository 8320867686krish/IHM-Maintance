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
                <div class="card-header" id="OnbaordTraining">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#onbaord-training" aria-expanded="false" aria-controls="onbaord-training">
                            Onbaord Training Records
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="onbaord-training" class="collapse" aria-labelledby="OnbaordTraining" data-parent="#accordion">
                    <div class="card-body mb-4">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th width="15%">SR NO</th>
                                    <th>Name</th>
                                    <th width="20%">Designation</th>

                                    <th width="10%">Rank</th>
                                    <th width="20%">Passport Numbr</th>
                                    <th width="20%">Sign Of Date</th>
                                    <th width="20%">Sign Of Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <x-trainning-record :trainingRecoreds="$trainingRecoreds"></x-trainning-record>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingma3">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsema3" aria-expanded="false" aria-controls="collapsema3">
                            MD & SDoc
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsema3" class="collapse" aria-labelledby="headingma3" data-parent="#accordion">
                    <div class="card-body mb-4">
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



            <div class="card">
                <div class="card-header" id="headingma4">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsema4" aria-expanded="false" aria-controls="collapsema4">
                            Major Repair / Retrofit / Dry Doc / Conversion
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsema4" class="collapse" aria-labelledby="headingma4" data-parent="#accordion">
                    <div class="card-body">
                        Major Repair / Retrofit / Dry Doc / Conversion data goes here.
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="headingma5">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsema5" aria-expanded="false" aria-controls="collapsema5">
                            Report Center
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsema5" class="collapse" aria-labelledby="headingma5" data-parent="#accordion">
                    <div class="card-body">
                        Report Center data goes here.
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@push('js')
<script>
    document.getElementById('excel_file').addEventListener('change', function() {
        document.getElementById('uploadForm').submit();
    });
</script>
@endpush