@extends('layouts.app')

{{-- Add Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Ships Management"></x-page-header>
    @can('ships.add')
    <a href="{{ route('ships.add') }}" class="btn btn-primary btn-rounded addNewBtn float-right">Add</a>
    @endcan


    <div class="row mb-4">
        <!-- Search Form on the Right -->
        <div class="col-3 col-md-5 offset-7 mb-4 text-right">
            <!-- Search Form with Search Icon Inside Button -->
            <form method="GET" action="{{ route('ships') }}" id="searchForm">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" name="search" placeholder="Search ships by name" value="{{ request()->search }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>


    </div>
    <div class="row equal-height" id="shipslist">
        <x-ships-list :ships=$ships :currentUserRoleLevel=$currentUserRoleLevel></x-ships-list>
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
    $(document).ready(function() {
        $(document).on('click', '.pagination-wrapper a', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');
            fetchShips(url);
        });
        $(document).on('keyup', '#searchInput', function(e) {
            let searchValue = this.value.trim();
            if (searchValue === "") {
                e.preventDefault();
                let formData = $(this).serialize();
                let url = "{{ route('ships') }}?" + formData;
                fetchShips(url);
            }
        });

        $(document).on('submit', '#searchForm', function(e) {


            e.preventDefault();
            let formData = $(this).serialize();
            let url = "{{ route('ships') }}?" + formData;
            fetchShips(url);
        });

        function fetchShips(url) {
            $.ajax({
                url: url,
                type: 'GET',

                success: function(data) {
                    $('#shipslist').html();
                    $('#shipslist').html(data.ships_html);
                },
                error: function() {
                    console.error("Pagination AJAX request failed.");
                }
            });
        }
    });
</script>
@endpush