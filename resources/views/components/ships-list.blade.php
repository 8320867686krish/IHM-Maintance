@if($ships->count() > 0)
@foreach($ships as $ship)
<div class="col-12 col-md-6 col-lg-3" id="shipid{{ $ship->id }}">
   
    <a href="{{ route('ship.dashboard', ['id' => $ship->id]) }}" style="color: inherit; text-decoration: none;">
        <div class="card">
            <img src="{{ asset('uploads/ship/' . $ship->ship_image) }}" alt="Ship Image" class="card-img-top">
            
            <div class="card-body px-4 pt-2 pb-4 text-center">
                <h3 class="product-title mb-3 mt-3">{{ ucfirst($ship->ship_name) }}</h3>
                <p class="card-text mb-2">IMO Number :  {{ $ship->imo_number }}</p>
                <p class="card-text mb-2">Client Company : {{ $ship->client->name }}</p>
                @if($currentUserRoleLevel == 1)
                <p class="card-text mb-2">Hazmat Company : {{@$ship->hazmatComapny->name}}</p>
                @endif
                <a href="{{ route('ships.view', ['ship_id' => $ship->id]) }}" class="btn btn-outline-light mt-2" title="view"><i class="fas fa-eye text-primery"></i></a>
                <a href="{{ route('ships.delete', ['id' => $ship->id]) }}" class="btn btn-outline-light deleteship mt-2"  title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>
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