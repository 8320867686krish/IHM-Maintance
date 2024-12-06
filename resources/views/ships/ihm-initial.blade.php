<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">



    <div class="accrodion-regular">
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headinginitial1">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed  d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseinitial1" aria-expanded="false" aria-controls="collapseinitial1">
                            IHM Part I-1
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapseinitial1" class="collapse show" aria-labelledby="headinginitial1" data-parent="#accordion">
                    <div class="card-body mb-2 mt-2">
                        <x-ihm-part :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-3'"></x-ihm-part>


                    </div>
                    <div class="card-body mb-2 mt-2">

                    </div>
                    <div class="card-body mb-2 mt-2">
                    </div>
                </div>

            </div>





            <div class="card">
                <div class="card-header" id="headinginitial4">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed  d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsinitial4" aria-expanded="false" aria-controls="collapsinitial4">
                            GA Plan
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsinitial4" class="collapse" aria-labelledby="headinginitial4" data-parent="#accordion">
                    <div class="card-body">
                        <a href="{{asset('uploads/shipsVscp/'.$ship->id.'/'.$ship->ga_plan_pdf)}}" target="_blank" class="btn btn-primary float-right mb-3 ">Download</a>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header" id="headinginitial5">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed  d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsinitial5" aria-expanded="false" aria-controls="collapsinitial5">
                            IHM Summary Report
                            <span class="fas fa-angle-down mr-3"></span>
                        </button>
                    </h5>
                </div>
                <div id="collapsinitial5" class="collapse" aria-labelledby="headinginitial5" data-parent="#accordion">
                    <div class="card-body mb-4">
                        <a href="#" class="btn btn-primary float-right addSummary mb-3 ml-2">Add</a>
                       
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>Title</th>
                                        <th width="20%">Updated By</th>
                                        <th width="20%">Date</th>
                                        <th width="20%">Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="summaryList">
                                    <x-summary-list :summary="$summary"></x-summary-list>
                                </tbody>
                             
                            </table>
                        </div>
                        @include('ships.models.SummaryModel')
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headinginitial6">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed  d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsinitial6" aria-expanded="false" aria-controls="collapsinitial6">
                            Part1 Manuel
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsinitial6" class="collapse" aria-labelledby="headinginitial6" data-parent="#accordion">
                    <div class="card-body mb-4">
                        <a href="#" class="btn btn-primary float-right addPart mb-3 ml-2">Add</a>
                      

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>Title</th>
                                        <th width="20%">Updated By</th>
                                        <th width="20%">Date</th>
                                        <th width="20%">Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="partmanullist">
                                    <x-part-manual-list :partMenual="$partMenual"></x-part-manual-list>
                                </tbody>
                               
                            </table>
                        </div>
                        @include('ships.models.partMenualModel')
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headinginitial7">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed  d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapsinitial7" aria-expanded="false" aria-controls="collapsinitial7">
                            Amended IHM Part 1
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsinitial7" class="collapse" aria-labelledby="headinginitial7" data-parent="#accordion">
                    <div class="card-body">
                        Amended IHM Part 1 data goes here.
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@include('ships.models.remarksModel')
@push('js')
<script src="{{ asset('assets/js/PartManual.js') }}"></script>
<script src="{{ asset('assets/js/Summary.js') }}"></script>

@endpush