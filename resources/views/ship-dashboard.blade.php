@extends('layouts.app')
@section('css')


<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">

@endsection


@section('content')



<div class="container-fluid dashboard-content">



    <div class="row  mb-4 mt-4">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Ship Dashbord</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">

            <div class="card">
                <h5 class="card-header text-center">IHM Summery Graph</h5>
                <div class="card-body">
                    <canvas id="chartjs_bar_ihm_summery"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header  text-center">Training Overview</h5>
                <div class="card-body">
                    <div id="c3chart_donut"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">

            <div class="card">
                <h5 class="card-header text-center">Ship PO Overview</h5>
                <div class="card-body">
                    <canvas id="chartjs_bar_ship"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header  text-center">Brifing Overview</h5>
                <div class="card-body">
                    <div id="c3chart_donut_brifing"></div>
                </div>
            </div>
        </div>
    </div>

 

    @stop
    @push('js')
    <script>
        var anyliticsdata = @json($anyliticsdata);
        var hazmatSummeryName = @json($hazmatSummeryName);
        var trainingverviewData = @json($trainingverviewData);
        var brifingViewData = @json($brifingViewData);

        console.log(trainingverviewData);
    </script>
    <script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>

    @endpush