@extends('layouts.app')

@section('css')
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/css/select2.css') }}"> --}}

    <style>
        #checkList {
            overflow: auto;
        }

        .zoom-tool-bar {
            bottom: 0px;
            width: 100%;
            height: 20px;
            right: 0;
            top: 0px;
            padding: 3px 0;
            font-size: 13px;
            /* color: #007cc0; */
            color: #008476 !important;
            accent-color: #008476 !important;
        }

        .zoom-tool-bar i {
            color: #008476 !important;
            font-size: 16px;
        }

        .zoom-tool-bar input {
            width: 20%;
        }

        .outfit {
            line-height: 0;
            position: relative;
            width: 100%;
            height: auto;
            display: inline-block;
            overflow: hidden;

            img {
                height: auto;
                cursor: pointer;
            }
        }

        .dot {
            position: absolute;
            width: 20px;
            height: 20px;
            background: #000;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 0 3px 0 rgba(0, 0, 0, .2);
            line-height: 20px;
            font-size: 12px;
            font-weight: bold;
            transition: box-shadow .214s ease-in-out, transform .214s ease-in-out, background .214s ease-in-out;
            text-align: center;
            opacity: 0.7;

            &.ui-draggable-dragging {
                box-shadow: 0 0 25px 0 rgba(0, 0, 0, .5);
                transform: scale3d(1.2, 1.2, 1.2);
                background: rgba(white, .7);
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Check Management</h2>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        {{-- <div class="row"> --}}
        {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> --}}
        @include('layouts.message')
        <div id="showSuccessMsg"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <a href="{{ url('ship/vscp/'.$deck->ship_id.'/amended') }}"><i class="fas fa-arrow-left"></i></a>
                    <b>Back</b></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-3">
                        <div class="card" id="checkList">
                            <h5 class="card-header">Checks List</h5>
                            <div class="card-body p-0">
                                <ul class="country-sales list-group list-group-flush" id="checkListUl">
                                <x-check-list :checks="$deck->checks"></x-check-list>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-9">
                        <div class="zoom-tool-bar mb-5">
                            <div class="row">
                                <div class="col-sm-12 p-1 text-center zoominout">
                                    <span class="zoom-value">100%</span>
                                    <a href="javascript:;" title="Zoom Out" class="zoom-out" id="zoom-out"> <i
                                            class="fa fa-minus m-1"></i></a>
                                    <input class="mb-1 ranger" type="range" value="100" step="25" min="50"
                                        max="200">
                                    <a href="javascript:;" title="Zoom In" class="zoom-in" id="zoom-in"> <i
                                            class="fa fa-plus m-1"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="outfit">
                            <div class="target">
                                <img id="previewImg1" src="{{$deck->image}}" 
                                alt="Upload Image">
                                <div id="showDeckCheck">
                                    @include('ships.vscp.check.dot')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

     

     

        @include('ships.models.checkDetail')

    </div>
@stop

@push('js')
<script>
    var hazmatOptions  = @json($hazmats);
</script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/js/checks.js') }}"></script>

@endpush
