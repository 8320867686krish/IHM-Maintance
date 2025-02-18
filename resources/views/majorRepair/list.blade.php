@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/bootstrap4-toggle.min.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/switchButton.css') }}">
@endsection

@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Repair Management"></x-page-header>

   
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('layouts.message')
            <div class="showSucessMsg" style="display: none;"></div>
            <div class="card">
                <h4 class="card-header">
                    @can('majorrepair.add')
                    <a href="#"
                        class="btn btn-primary float-right btn addMajorBtn">Add Repaair</a>
                    @endcan
                </h4>
                <div class="card-body mb-4">
                    <div>
                        <table class="table table-striped table-bordered first">
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
@include('majorRepair.majorRepairModel')

@stop
@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>
<script src="{{ asset('assets/js/majorRepair.js')}}"></script>

@endpush