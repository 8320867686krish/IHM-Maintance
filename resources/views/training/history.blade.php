@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/bootstrap4-toggle.min.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/switchButton.css') }}">
@endsection
@section('shiptitle','Training & Briefing Management')

@section('content')
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Training Management</h2>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-danger">
        {{ session('success') }}
    </div>
@endif

    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
            <div class="tab-regular">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="training-tab" data-toggle="tab" href="#traingRecored" role="tab" aria-controls="traingRecored" aria-selected="true">Training Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="brif-tab" data-toggle="tab" href="#brifPlan" role="tab" aria-controls="brifPlan" aria-selected="false">Briefing Plan</a>
                    </li>


                </ul>

                <div class="tab-content" id="myTabContent">


                    <div class="tab-pane fade active show" id="traingRecored" role="tabpanel" aria-labelledby="training-tab">
                        <button class="btn btn-primary float-right mb-4" type="button" id="startTraining">Start Training
                        </button>
                        <div class="table-responsive">
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
                    <div class="tab-pane fade" id="brifPlan" role="tabpanel" aria-labelledby="brif-tab">
                        <button class="btn btn-primary float-right mb-4" type="button" id="startBrifing">Start Briefing
                        </button>
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
                                <tbody class="brifingHistory">
                                    <x-brifing-history :brifingHistory=$brifingHistory></x-brifing-history>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop
@include('training.model.startBrifing')
@include('training.model.startTraining')


@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>

<script src="{{ asset('assets/js/training.js') }}"></script>

@endpush