@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
@endsection

@section('content')
<div class="row">
@if($currentUserRoleLevel == 6 || $currentUserRoleLevel == 5)

<div class="row">
    <div class="col-12">
        <div class="alert alert-info card" role="alert">
            All The designated personnel of IHM must do their familiarization Training within 15 days of joining as per company SMS Manual and crew brifing every 3 months.
        </div>
    </div>
</div>
@endif
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
        <div class="tab-regular">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" id="overall-tab" data-toggle="tab" href="#overallIncharge" role="tab" aria-controls="overallIncharge" aria-selected="true">Overall-incharge (Captain)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="responsible-tab" data-toggle="tab" href="#responsiblePerson" role="tab" aria-controls="responsiblePerson" aria-selected="false">Responsible Person</a>
                </li>
               
            </ul>
            <div class="tab-content" id="myTabContent">
                <button class="btn btn-primary float-right mb-4" type="button" id="addDesignated" data-target="#DesignatedModel" data-toggle="modal">
                    <i class="fas fa-plus"></i> Add
                </button>
                <div class="tab-pane fade active show" id="overallIncharge" role="tabpanel" aria-labelledby="overall-tab">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>SR NO</th>
                                <th>Name</th>
                                <th>Rank</th>
                                <th>Passport Number</th>
                                <th>Sign On Date</th>
                                <th>Sign Off Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <x-designated-person-list :designatePerson="$designatePerson" type='incharge'></x-designated-person-list>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="responsiblePerson" role="tabpanel" aria-labelledby="responsible-tab">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>SR NO</th>
                                <th>Name</th>
                                <th>Rank</th>
                                <th>Passport Number</th>

                                <th>Sign On Date</th>
                                <th>Sign Off Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <x-designated-person-list :designatePerson="$designatePerson" type='responsible'></x-designated-person-list>

                        </tbody>
                    </table>
                </div>
              
            </div>
        </div>
    </div>
</div>
@include('shipdesignated.DesignatedModel')

@stop

@push('js')
<script src="{{ asset('assets/js/shipdesignatedperson.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>


@endpush