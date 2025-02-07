@extends('layouts.app')

{{-- Add Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Ships Management"></x-page-header>

    <!-- ============================================================== -->
    <!-- Page Header -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            @include('layouts.message') {{-- Flash messages --}}
        </div>
        <div class="col-12 mb-4">
            @can('ships.add')
            <a href="{{ route('ships.add') }}" class="btn btn-primary float-right btn-rounded addNewBtn">Add New Ship</a>
            @endcan
        </div>
    </div>
    
    <!-- ============================================================== -->
    <!-- Ships Display -->
    <!-- ============================================================== -->
    <div class="row equal-height">
        @if(isset($ships) && $ships->count() > 0)
        @foreach($ships as $ship)
    <div class="col-12 col-md-6 col-lg-3" id="shipid{{ $ship->id }}">
        <a href="{{ route('ships.view', ['ship_id' => $ship->id]) }}" style="color: inherit; text-decoration: none;">
            <div class="card">
                {{-- Ship Image --}}
                <img src="{{ asset('uploads/ship/' . $ship->ship_image) }}" alt="Ship Image" class="card-img-top">
                
                <div class="card-header px-4 pt-4">
                    <div class="card-actions float-end">
                        <div class="position-relative">
                            @can('ships.remove')
                            <a href="{{ route('ships.delete', ['id' => $ship->id]) }}" 
                                class="deleteship" 
                                data-id="{{ $ship->id }}" 
                                title="Delete">
                                <i class="fas fa-trash-alt text-danger" style="font-size: 1rem"></i>
                            </a>
                            @endcan
                        </div>
                    </div>
                    <h5 class="card-title mb-0">{{ ucfirst($ship->ship_name) }}</h5>
                </div>
                
                <div class="card-body px-4 pt-2">
                    <p style="line-height: 2rem;">
                        <strong>IMO Number:</strong> {{ $ship->imo_number }}<br>
                        <strong>Client Name:</strong> {{ $ship->client->name }}<br>
                        <strong>Project No.:</strong> {{ $ship->project_no }}
                    </p>
                </div>
            </div>
        </a>
    </div>
@endforeach

        @else
            <div class="col-12">
                <div class="alert alert-danger fade show text-center" role="alert">
                    No ships found.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    // Function to handle matchHeight logic
    $(document).ready(matchHeight);
    $(window).resize(matchHeight);

    // Handle delete ship button
    $('.deleteship').on('click', function(e) {
        e.preventDefault();
        
        var shipId = $(this).data('id');
        var deleteUrl = $(this).attr('href');
        var confirmMessage = "Are you sure you want to delete this ship?";

        // Confirm delete
        confirmDelete(deleteUrl, confirmMessage, 
            function(response) {
                // Success: Remove the ship card from DOM
                $('#shipid' + shipId).remove();
            }, 
            function(response) {
                // Error: Log failure
                console.error("Failed to delete: " + response.message);
            }
        );
    });
</script>
@endpush
