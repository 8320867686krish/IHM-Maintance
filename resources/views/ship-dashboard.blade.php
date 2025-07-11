@extends('layouts.app')
@section('css')


<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">

@endsection


@section('content')



<div class="container-fluid dashboard-content">



    <div class="row  mb-1 mt-2 text-center">
        <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11 ">
            <div class="page-header">
            <h2 class="pageheader-title">{{ ucfirst($anyliticsdata['ship']) }}</h2>

            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-end align-items-center"> <!-- Flexbox for alignment -->
                <select name="year" id="yearSelect" class="form-control w-25">
                    @php
                    $currentYear = date('Y');
                    $startYear = $currentYear - 3;
                    $endYear = $currentYear + 3;
                    @endphp
                    <option value="" disabled>Select Year</option>
                    @for ($year = $startYear; $year <= $endYear; $year++)
                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                        {{ $year }}
                        </option>
                        @endfor
                </select>

                <a href="{{ url('ship/view/'.$ship_id) }}" class="btn btn-primary ml-3 addNewBtn">
                    IHM Maintenance
                </a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card">
                <h5 class="card-header text-center">IHM Summary Graph</h5>
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
                <h5 class="card-header text-center">Ship MD-SDoC Overview</h5>
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
                <h5 class="card-header  text-center">Briefing Overview</h5>
                <div class="card-body">
                    <div id="c3chart_donut_brifing"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row  mb-4 mt-4">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title text-center">Help Center</h2>
            </div>
        </div>
    </div>
     <div class="container mb-4 mt-4">
        <div class="row ">
            <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <h4 class="text-muted text-center"><a href="{{url('helpcenter')}}">Correspondence With Ship / Client</a></h4>


                    </div>
                </div>
            </div>

              <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card border-3 border-top border-top-primary">
                    <div class="card-body">
                        <h4 class="text-muted text-center"><a href="{{url('helpcenter')}}">Hazmat Company Credentials</a></h4>
                    </div>
                </div>
            </div>
        </div>
     </div>



    @stop
    @push('js')
    <script>
        var anyliticsdata = @json($anyliticsdata);
        var ship_id = "{{$ship_id}}";
    </script>
    <script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    @endpush