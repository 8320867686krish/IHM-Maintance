@extends('layouts.app')

@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Ships Management</h2>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                @include('layouts.message')
            </div>
            <div class="col-12 mb-4">
                @can('ships.add')
                    <a href="{{ route('ships.add') }}" class="btn btn-primary float-right btn-rounded addNewBtn">Add New Ships</a>
                @endcan
            </div>
        </div>
        <div class="row equal-height">
            @if (isset($ships) && $ships->count() > 0)
                @foreach ($ships as $ship)
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <a href="{{ route('ships.view', ['ship_id' => $ship->id]) }}">
                            <div class="card campaign-card text-center pt-0 pb-0">
                                <div class="card-body">
                                    <div class="campaign-img">
                                        <img src="{{ $ship->image }}"
                                            onerror="this.onerror=null;this.src='{{ asset('assets/images/dribbble.png') }}';"
                                            class="user-avatar-xl rounded-circle">
                                    </div>
                                    <div class="campaign-info">
                                        <h3 class="mb-1">{{ ucfirst($ship->ship_name) }}</h3>
                                        <p class="mb-1 line-clamp">IMO Number:<span
                                                class="text-dark font-medium ml-2">{{ $ship->imo_number }}</span></p>
                                        </p>
                                        <p class="line-clamp">Project No.:<span class="text-dark font-medium ml-2">{{ $ship->project_no }}</span></p>

                                      
                                        @can('ships.edit')
                                            <a href="{{ route('ships.edit', ['id' => $ship->id]) }}"
                                                rel="noopener noreferrer" title="Edit">
                                                <i class="fas fa-edit text-primary" style="font-size: 1rem"></i>
                                            </a>
                                        @endcan
                                        @can('ships.remove')
                                            <a href="{{ route('ships.delete', ['id' => $ship->id]) }}" class="ml-2"
                                                onclick="return confirm('Are you sure you want to delete this project?');"
                                                title="Delete">
                                                <i class="fas fa-trash-alt text-danger" style="font-size: 1rem"></i>
                                            </a>
                                        @endcan
                                        @can('ships.read')
                                            <a href="{{ route('ships.view', ['ship_id' => $ship->id]) }}"
                                                rel="noopener noreferrer" title="View" class="ml-2">
                                                <i class="fas fa-eye text-info" style="font-size: 1rem"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-danger fade show text-center" role="alert">
                        Data not found.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(matchHeight);
        $(window).resize(matchHeight);
    </script>
@endpush
