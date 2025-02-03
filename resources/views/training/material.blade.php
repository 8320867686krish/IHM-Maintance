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
   
    <div class="alert alert-info card" role="alert">
 "{{@$designatedPersonDetail->name }}! All the best , Your training is about to begin."

</div>
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
     
        <button class="btn btn-primary float-right mb-4" type="button" id="startExam">Start Exam
        </button>
      
            <div class="tab-regular">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="material-tab" data-toggle="tab" href="#material_details" role="tab" aria-controls="material_details" aria-selected="true">Material Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="brif-tab" data-toggle="tab" href="#ship_detai" role="tab" aria-controls="brifPlan" aria-selected="false">Ship Details</a>
                    </li>


                </ul>

                <div class="tab-content" id="myTabContent">


                    <div class="tab-pane fade active show" id="material_details" role="tabpanel" aria-labelledby="material-tab">
                       
                        <pdf-viewer src="{{$material}}"></pdf-viewer>

                    </div>
                    <div class="tab-pane fade" id="brifPlan" role="tabpanel" aria-labelledby="brif-tab">
                       
                        <pdf-viewer src="{{$material}}"></pdf-viewer>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop

@include('training.model.startExam')


@push('js')
<script src="{{ asset('assets/libs/js/pdfview.js') }}"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>

<script src="{{ asset('assets/js/training.js') }}"></script>

@endpush