@extends('layouts.app')
@section('css')


<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/tempusdominus-bootstrap-4.css')}}">

@endsection


@section('content')



<div class="container-fluid dashboard-content">



    <div class="row  mb-4 mt-4">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title text-center">{{$anyliticsdata['ship']}} Dashbord</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group text-right"> <!-- Aligning to right -->
                <div class="input-group date  d-inline-flex " id="datetimepicker11" data-target-input="nearest" style="max-width: 250px;">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker11">
                    <div class="input-group-append" data-target="#datetimepicker11" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                </div>
                <a href="{{url('ship/view/'.$ship_id)}}" class="btn btn-primary ml-3 mr-1 addNewBtn">IHM Maintenance</a>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card">
                <h5 class="card-header text-center">IHM Summery Graph</h5>
                <div class="card-body">
                    <canvas id="chartjs_bar_ihm_summery"></canvas>
                </div>
            </div>
        </div>



    </div>
    <div class="row">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

            <div class="card">
                <h5 class="card-header text-center">Ship PO Overview</h5>
                <div class="card-body">
                    <canvas id="chartjs_bar_ship"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

            <div class="card">
                <h5 class="card-header text-center">Ship MD-Sdoc Overview</h5>
                <div class="card-body">
                    <canvas id="chartjs_bar_md"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header  text-center">Training Overview</h5>
                <div class="card-body">
                    <div id="c3chart_donut"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
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
        var ship_id = "{{$ship_id}}";
        var hazmatSummeryName = @json($hazmatSummeryName);
        var brifingViewData = @json($brifingViewData);
    </script>
    <script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    <script src="{{ asset('assets/vendor/datepicker/moment.js')}}"></script>
    <script src="{{ asset('assets/vendor/datepicker/tempusdominus-bootstrap-4.js')}}"></script>
    <script src="{{ asset('assets/vendor/datepicker/datepicker.js')}}"></script>
    @endpush