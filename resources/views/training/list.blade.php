@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/bootstrap4-toggle.min.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/switchButton.css') }}">
@endsection

@section('content')
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <x-page-header title="Training Management"></x-page-header>

    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('layouts.message')
            <div class="showSucessMsg" style="display: none;"></div>
            <div class="card">
                <h4 class="card-header">
                    <a href=""
                        class="btn btn-primary float-right  assignSets mr-2"> Assign Sets</a>
                    @can('trainingsets.add')
                    <a href="{{ route('trainingsets.add') }}"
                        class="btn btn-primary float-right btn-rounded addNewBtn mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="plus" class="lucide lucide-plus">
                            <path d="M5 12h14"></path>
                            <path d="M12 5v14"></path>
                        </svg> Add</a>
                    @endcan

                </h4>
                <div class="card-body mb-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th> <label class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" id="selectAll" class="custom-control-input">
                                            <span class="custom-control-label">Sr.No</span>
                                        </label></th>
                                    <th>Sets Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($training) && $training->count() > 0)
                                @foreach ($training as $value)
                                <tr>
                                    <td><label class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input assignChk" value="{{$value['id']}}"><span class="custom-control-label">{{$loop->iteration }}</span>
                                        </label> </td>
                                    <td>{{ $value->name ?? '' }}
                                    </td>


                                    <td class="text-center">
                                        @can('trainingsets.edit')
                                        <a href="{{ route('trainingsets.edit', ['id' => $value->id]) }}"
                                            rel="noopener noreferrer" title="Edit" class="text-center">
                                            <i class="fas fa-edit text-primary" style="font-size: 1rem"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('training.assignModel')
@stop

@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>
<script src="{{ asset('assets/js/training.js') }}"></script>


@endpush