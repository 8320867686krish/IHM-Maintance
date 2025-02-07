@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
@endsection


@section('content')

<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h3 style="color:#6c757d;font-size:14px;">Welcome {{Auth()->user()->name}}, everything looks great.</h3>
            </div>
        </div>
    </div>
    <!-- For ship Login -->
    @if($currentUserRoleLevel == 6 || $currentUserRoleLevel == 5)

    <div class="row">
        <div class="col-12">
        <div class="alert alert-info card" role="alert">
            All The designated personnel of IHM must do their familiarization Training within 15 days of joining as per company SMS Manual and crew brifing every 3 months.
        </div>
        </div>
    </div>
    @include('shipdesignated.list')
    @endif
    <!-- end -->
    <div class="row">

        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header text-center">PO Overview</h5>
                <div class="card-body">
                    <canvas id="chartjs_bar"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header  text-center">Training Overview</h5>
                <div class="card-body">
                    <div id="c3chart_pie"></div>
                </div>
            </div>
        </div>
    </div>
    @if($currentUserRoleLevel != 6)
    <div class="row">
        <div class="col-xl-4 offset-4  col-lg-4   col-md-4  col-sm-12 col-12 mb-3 ">
            <div class="chartSelect">
                <label><span>Ships</span></label>
                <select class="form-control shipswisePo">
                    <option>Select Ship</option>
                    @foreach($ships as $value)
                    <option value="{{$value['id']}}" {{ $loop->first ? 'selected' : '' }}>
                        {{$value['ship_name']}}
                    </option>
                    @endforeach

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12  col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header text-center">Ship PO Overview</h5>
                <div class="card-body">
                    <canvas id="chartjs_bar_ship"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@include('shipdesignated.DesignatedModel')

@stop
@push('js')
<script>
    var shipsPo = @json($shipsPo);
    var nonRelevantCounts = @json($nonRelevantCounts);
    var relevantCounts = @json($relevantCounts);
    // Initialize the chart
</script>
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script src="{{ asset('assets/js/shipdesignatedperson.js') }}"></script>

<script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
<script src="{{ asset('assets/js/dashbord.js') }}"></script>


@endpush