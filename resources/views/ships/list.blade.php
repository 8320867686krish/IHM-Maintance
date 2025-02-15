@extends('layouts.app')

{{-- Add Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Ships Management"></x-page-header>
    @can('ships.add')
        <a href="{{ route('ships.add') }}" class="btn btn-primary btn-rounded addNewBtn float-right">Add</a>
        @endcan
    <div class="row">
    
</div>

    <!-- ============================================================== -->
    <!-- Page Header -->
    <!-- ============================================================== -->
    <div class="row">
    <!-- Search Form on the Right -->
    <div class="col-6 offset-6 mb-4 text-right">
        <!-- Search Form with Search Icon Inside Button -->
        <form method="GET" action="{{ route('ships') }}">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search ships by name" value="{{ request()->search }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
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
                        </p>
                    </div>
                    
                </div>
            </a>
        </div>
        @endforeach
        <div class="col-12 d-flex justify-content-center">
    <div class="pagination-wrapper">
        {{ $ships->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>


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