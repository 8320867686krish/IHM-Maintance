@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
@endsection

@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Shore Dp"></x-page-header>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
            @include('layouts.message')
            <div id="showSucessMsg" style="display: none;"></div>
            <div class="card">
                <h5 class="card-header">
                    <div class="row">

                        @can('shoredp.add')
                        <div class="col-12 float-right">
                            <button class="btn btn-primary float-right mb-4" type="button" id="addDesignated" data-target="#DesignatedModel" data-toggle="modal">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                        @endcan
                    </div>
                </h5>
                <div class="card-body mb-4">
                    <div>
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th>SR No</th>
                                    <th>Name</th>
                                    <th>Designation</th>
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