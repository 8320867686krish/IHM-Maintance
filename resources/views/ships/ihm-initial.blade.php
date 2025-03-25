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
                    <div class="card-body mb-2">

                        @can('ships.edit')
                        <a href="{{ url('ship/vscp/' . $ship_id) }}" id="initialIhm" class="btn btn-primary float-right mb-3 {{ $ship['is_unlock']  ? 'initialIhmDisable' : '' }}">Edit Initial IHM</a>
                        <label class="switch float-right">
                            <input class="switch-input" type="checkbox" data-shipId="{{$ship_id}}" {{ $ship['is_unlock']  ? 'checked' : '' }}>
                            <span class="switch-label" data-on="" data-off=""></span>
                            <span class="switch-handle"></span>
                        </label>
                        @endcan
                        <x-ihm-part :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-1'"></x-ihm-part>



                        <div class=" mb-2 mt-2">
                            <x-ihm-part :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-2'"></x-ihm-part>
                        </div>
                        <div class=" mb-4 mt-2">
                            <x-ihm-part :checkHazmatIHMPart="$checkHazmatIHMPart" :type="'i-3'"></x-ihm-part>
                        </div>
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
                        @can('ships.edit')
                        <a href="#" class="btn btn-primary float-right addSummary mb-3 ml-2">Add</a>
                        @endcan
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>Title</th>
                                        <th>Version</th>

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
                            Supplement  to initial IHM Part
                            <span class="fas fa-angle-down mr-3"></span>

                        </button>
                    </h5>
                </div>
                <div id="collapsinitial6" class="collapse" aria-labelledby="headinginitial6" data-parent="#accordion">
                    <div class="card-body mb-4">
                        @can('ships.edit')
                        <a href="#" class="btn btn-primary float-right addPart mb-3 ml-2">Add</a>
                        @endcan

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="15%">SR NO</th>
                                        <th>Title</th>
                                        <th>Version</th>
                                        <th width="20%">Updated By</th>
                                        <th width="20%">Date</th>
                                        <th width="20%">Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="partmanullist">
                                    <tr>
                                        <td>1</td>
                                        <td>GA Plan</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
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
                @can('ships.edit')
                <div id="collapsinitial7" class="collapse" aria-labelledby="headinginitial7" data-parent="#accordion">
                    <div class="card-body">
                   

                        <a href="#" class="btn btn-primary float-right mb-3 startAmended">Start Amendment </a>
                    
                    </div>
                </div>
                @endif
            </div>


        </div>
    </div>
</div>
@include('ships.models.remarksModel')
@include('ships.models.unlockWarningModel')
@include('ships.models.amendedModel')



@push('js')
<script src="{{ asset('assets/js/PartManual.js') }}"></script>
<script src="{{ asset('assets/js/Summary.js') }}"></script>
<script src="{{ asset('assets/libs/js/bootstrap4-toggle.min.js') }}"></script>
<script>
    var unlockurl = "{{route('unlockVscp')}}";
    var unlockToken = "{{ csrf_token() }}";
</script>
@endpush