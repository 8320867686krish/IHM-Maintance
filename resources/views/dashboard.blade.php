@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
@endsection
@section('shiptitle','Dashboard')
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
    <div class="row">
        <div class="col-xl-4 offset-4  col-lg-4   col-md-4  col-sm-12 col-12 mb-3 ">
            <div class="chartSelect">
                <label><span>Ships</span></label> <select class="form-control">
                    <option>Select Ship</option>
                    <option selected="selected">Ship1</option>
                    <option>Ship2</option>
                    <option>Ship3</option>
                    <option>Ship4</option>
                    <option>Ship5</option>
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
</div>

@stop
@push('js')
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>

<script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
<script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>


@endpush