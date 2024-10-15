@extends('layouts.app')

@section('content')
@section('shiptitle','Help Center')
<div class="container-fluid dashboard-content">
<pdf-viewer src="{{ asset('assets/tet.pdf')}}"></pdf-viewer>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/libs/js/pdfview.js') }}"></script>


@endpush