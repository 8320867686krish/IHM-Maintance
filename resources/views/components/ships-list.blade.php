@if($ships->count() > 0)
@foreach($ships as $ship)
<!-- <div class="col-12 col-md-6 col-lg-3" id="shipid{{ $ship->id }}">
   
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
</div> -->
<div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12" id="shipid{{ $ship->id }}">
    <a href="{{ route('ship.dashboard', ['id' => $ship->id]) }}" style="color: inherit; text-decoration: none;">
        <div class="product-thumbnail">
            <div class="product-img-head">
                <div class="product-img">
                    <img src="{{ asset('uploads/ship/' . $ship->ship_image) }}" alt="" class="img-fluid">
                </div>

            </div>
            <div class="product-content">
                <div class="product-content-head">
                    <h3 class="product-title">{{ ucfirst($ship->ship_name) }}</h3>
                    <div class="product-rating d-inline-block">
                        @if($currentUserRoleLevel == 1)

                        Hazmat Company : {{@$ship->hazmatComapny->name}}
                        @endif
                    </div>
                    <div class="campaign-info mt-2">
                        <p class="mb-1">Client Company:<span class="text-dark font-medium ml-2"> {{ $ship->client->name }}</span></p>
                        <p>IMO Number: <span class="text-dark font-medium ml-2">{{ $ship->imo_number }}</span></p>
                    </div>
                </div>
                <div class="product-btn float-right mb-2">
                    <a href="{{ route('ships.view', ['ship_id' => $ship->id]) }}" class="btn btn-primary"><i class="fas fa-eye text-primery"></i></a>
                    <a href="{{ route('ships.delete', ['id' => $ship->id]) }}" class="btn btn-outline-light deleteship"><i class="fas fa-trash-alt text-danger"></i></a>
                </div>
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