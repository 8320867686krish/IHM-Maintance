@if($ships->count() > 0)
@foreach($ships as $ship)
<div class="col-12 col-md-6 col-lg-3" id="shipid{{ $ship->id }}">
    <a href="{{ route('ships.view', ['ship_id' => $ship->id]) }}" style="color: inherit; text-decoration: none;">
        <div class="card">
            <img src="{{ asset('uploads/ship/' . $ship->ship_image) }}" alt="Ship Image" class="card-img-top">
            <div class="card-header px-4 pt-4">
                <div class="card-actions float-end">
                    @can('ships.remove')
                    <a href="{{ route('ships.delete', ['id' => $ship->id]) }}"
                        class="deleteship"
                        data-id="{{ $ship->id }}"
                        title="Delete">
                        <i class="fas fa-trash-alt text-danger" style="font-size: 1rem"></i>
                    </a>
                    @endcan
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
        {{ $ships->appends(['search' => request()->search])->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@else
<div class="col-12">
    <div class="alert alert-danger text-center" role="alert">
        No ships found.
    </div>
</div>
@endif