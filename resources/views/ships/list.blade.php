@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@section('shiptitle','Ships')

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
        <div class="col-12 col-md-6 col-lg-3" id="shipid{{$ship->id}}">
            <a href="{{ route('ships.view', ['ship_id' => $ship->id]) }}" style='color:#71748d !important;'>

                <div class="card">
                    <img src="{{ asset('uploads/ship/' . $ship->ship_image) }}" alt="Company Logo" class="card-img-top">

                    <div class="card-header px-4 pt-4">
                        <div class="card-actions float-end">
                            <div class="position-relative">
                                @can('ships.remove')
                                <a href="{{ route('ships.delete', ['id' => $ship->id]) }}" class="deleteship" data-id="{{$ship->id}}"
                                   title="Delete"> <i class="fas fa-trash-alt text-danger" style="font-size: 1rem"></i>
                                </a>
                                @endcan

                            </div>
                        </div>
                        <h5 class="card-title mb-0">{{ ucfirst($ship->ship_name) }}</h5>
                    </div>
                    <div class="card-body px-4 pt-2">
                        <p style="line-height: 2.0rem;">IMO Number : {{ $ship->imo_number }}<br />
                            Client Name : {{ $ship->client->name }}<br />
                            Project No. : {{ $ship->project_no }}</p>

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
    $('.deleteship').on('click', function(e) {
                e.preventDefault();
                var id =$(this).attr('data-id');
              
                let deleteUrl = $(this).attr('href');
                let $deleteButton = $(this);
                let confirmMsg = "Are you sure you want to delete this ship?";

                confirmDelete(deleteUrl, confirmMsg, function(response) {
                    // Success callback
                    $('#shipid'+id).remove();
                  //  $deleteButton.closest('.shipid').remove();
                }, function(response) {
                    // Error callback (optional)
                    console.log("Failed to delete: " + response.message);
                });
            });
</script>
@endpush