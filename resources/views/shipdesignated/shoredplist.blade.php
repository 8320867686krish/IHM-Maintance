@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
@endsection
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
        <div class="tab-regular">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @if($currentUserRoleLevel == 6)
                <li class="nav-item">
                    <a class="nav-link active show" id="overall-tab" data-toggle="tab" href="#overallIncharge" role="tab" aria-controls="overallIncharge" aria-selected="true">Overall-incharge (Captain)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="responsible-tab" data-toggle="tab" href="#responsiblePerson" role="tab" aria-controls="responsiblePerson" aria-selected="false">Responsible Person</a>
                </li>
                @elseif($currentUserRoleLevel == 5)
                <li class="nav-item">
                    <a class="nav-link active show" id="overall-tab" data-toggle="tab" href="#overall-tab" role="tab" aria-controls="overall-tab" aria-selected="true">Shore DP</a>
                </li>
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                <button class="btn btn-primary float-right mb-4" type="button" id="addDesignated" data-target="#DesignatedModel" data-toggle="modal">
                    <i class="fas fa-plus"></i> Add
                </button>
                @if($currentUserRoleLevel == 6)
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
                @elseif($currentUserRoleLevel == 5)
                <div class="tab-pane fade  active show" id="overall-tab" role="tabpanel" aria-labelledby="overall-tab">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>SR No</th>
                                <th>Name</th>
                                <th>Rank</th>
                                <th>Passport Number</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <x-designated-person-list :designatePerson="$designatePerson" type='SuperDp'></x-designated-person-list>

                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
