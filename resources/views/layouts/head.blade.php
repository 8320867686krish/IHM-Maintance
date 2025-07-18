<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ ucfirst(Request::segment(1)) }}</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/extrastyle.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/sweet-alert.css') }}">
    
    {{-- <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css"> --}}
   

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;1,300&display=swap');

        .navbar-center {
    position: absolute;
    left: 55%;
    transform: translateX(-55%);
    display: flex;
    justify-content: center;
    align-items: center;
    list-style: none;
    margin-top: 15px;
}

.pageheader-title {
    font-size: 20px; /* Adjust as needed */
   
}
        .invalid-feedback {
            font-size: 14px;
        }

        .sa-button-container .cancel {
            background-color:rgb(221, 107, 85) !important; /* Green color for cancel button */
            color: white !important;
            border: none !important;
        }
    </style>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />

    @yield('css')
@show
</head>
