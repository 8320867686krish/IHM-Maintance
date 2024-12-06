@extends('layouts.app')

@section('css')


<link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
<link href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
<link rel="stylesheet" href="../../assets/libs/css/style.css">
<link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
<link rel="stylesheet" type="text/css" href="../../assets/vendor/cropper/dist/cropper.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<style>
    #pdf-container {
        position: relative;
        width: 100%;
        overflow: auto;
    }

    #pdf-page {
        display: block;
        margin: auto;
    }

    #cropper-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
</style>
</style>
@endsection
@section('shiptitle',$ship->ship_name)

@section('content')

<div class="container-fluid dashboard-content" id="projectViewContent">

    <aside class="page-aside" id="page-aside">
        <div class="aside-content">
            <div class="aside-header">
                <span class="title" style="font-size: 20px;">Initial IHM Details</span>
                <p class="description">{{ $project->ship_name ?? '' }}</p>
                {{-- <button class="navbar-toggle" type="button"><span class="icon" style="cursor: pointer; font-size: 16px !important;"><i class="fas fa-bars" id="pageNavbarToggleBtn"></i></span></button> --}}
            </div>
            <div class="aside-nav collapse">
                <ul class="nav">
                    <li>
                        <a href="{{ url('/ship/view/'.$ship_id.'#ihm_intial') }}"><span class="icon"><i
                                    class="fas fa-arrow-left"></i></span>Back</a>
                    </li>
                    <li class="active">
                        <a href="#vscp_list" class="vscp_list">
                            <span class="icon"><i class="fas fa-ship"></i></span>Vscp
                        </a>
                    </li>
                    <li>
                        <a href="#check_list" class="check_list"><span class="icon"><i
                                    class="fas fa-fw fa-briefcase"></i></span>Check List</a>
                    </li>


                </ul>
            </div>
        </div>
    </aside>
    <div class="main-content container-fluid p-0" id="vscp_list">
        <div class="email-head">
            <div class="email-head-subject">
                @include('ships.vscp.deck')
            </div>
        </div>
    </div>
    <div class="main-content container-fluid p-0" id="check_list" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Check List</h5>
            </div>
            <div class="card-body mb-4 mt-2">
                @include('ships.vscp.check.list')

            </div>
            @include('ships.models.remarksModel')
        </div>
    </div>

    <div class="main-content container-fluid p-0" id="ihm_maintenance" style="display: none;">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

</div>
@include('ships.models.checkDetail')

@endsection
@push('js')
<script>
    var hazmatOptions = @json($hazmats);
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>
<script src="{{ asset('assets/js/checks.js') }}"></script>

@endpush