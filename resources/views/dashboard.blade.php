@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css" integrity="sha512-pmAAV1X4Nh5jA9m+jcvwJXFQvCBi3T17aZ1KWkqXr7g/O2YMvO8rfaa5ETWDuBvRq6fbDjlw4jHL44jNTScaKg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js" integrity="sha512-Ysw1DcK1P+uYLqprEAzNQJP+J4hTx4t/3X2nbVwszao8wD+9afLjBQYjz7Uk4ADP+Er++mJoScI42ueGtQOzEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets\libs\css\swiper.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
@endsection


@section('content')



<div class="container-fluid dashboard-content">

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h3 style="color:#6c757d;font-size:14px;">Welcome {{Auth()->user()->name}}, everything looks great.</h3>
            </div>
        </div>
    </div>
    @if($currentUserRoleLevel == 6 || $currentUserRoleLevel == 5)

    <div class="row">
        <div class="col-12">
            <div class="alert alert-info card" role="alert">
                All The designated personnel of IHM must do their familiarization Training within 15 days of joining as per company SMS Manual and crew brifing every 3 months.
            </div>
        </div>
    </div>
    @endif
    <div class="row  mb-4 mt-4">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title text-center">{{$title}}</h2>
            </div>
        </div>
    </div>

    <div class="base-template__content mt-4">

        <div class="row ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <x-swiper-slide :data=$hazmatCompany :path=$path :imagekey=$imagekey :routename=$routename></x-swiper-slide>
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
            <div class="row container">
                <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h4 class="text-muted text-center"><a href="{{url('helpcenter')}}">Correspondence</a></h4>


                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h4 class="text-muted text-center"><a href="{{url('helpcenter')}}">Credentials</a></h4>

                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="card border-3 border-top border-top-primary">
                        <div class="card-body">
                            <h4 class="text-muted text-center"><a href="{{url('helpcenter')}}">Extract From SM</a></h4>


                        </div>
                    </div>
                </div>

             
        </div>
    </div>
</div>


@stop
@push('js')
<script src="{{ asset('assets/js/sliderswiper.js') }}"></script>

@endpush