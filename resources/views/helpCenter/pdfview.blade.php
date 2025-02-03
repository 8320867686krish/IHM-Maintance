@extends('layouts.app')

@section('content')
@section('shiptitle','Portal User Guide')
<div class="container-fluid dashboard-content">
<div class="col-xl-12  col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
      

<pdf-viewer src="{{$showurl}}"></pdf-viewer>
</div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/libs/js/pdfview.js') }}"></script>


@endpush