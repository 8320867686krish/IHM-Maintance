@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                <div class="col-12 col-md-6 col-lg-3">
							<div class="card">
								<img class="card-img-top" src="https://appstack.bootlab.io/img/photos/unsplash-1.jpg" alt="Unsplash">

								<div class="card-header px-4 pt-4">
									<div class="card-actions float-end">
										<div class="dropdown position-relative">
											<a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="more-horizontal" class="lucide lucide-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
              </a>

											<div class="dropdown-menu dropdown-menu-end">
											
                                                @can('ships.edit')
                                            <a href="{{ route('ships.edit', ['id' => $ship->id]) }}"  class="dropdown-item"
                                                rel="noopener noreferrer" title="Edit">
                                                Edit
                                            </a>
                                        @endcan
                                        @can('ships.remove')
                                            <a href="{{ route('ships.delete', ['id' => $ship->id]) }}" class="dropdown-item
                                                onclick="return confirm('Are you sure you want to delete this project?');"
                                                title="Delete">
                                                Remove
                                            </a>
                                        @endcan
                                        @can('ships.read')
                                            <a href="{{ route('ships.view', ['ship_id' => $ship->id]) }}"
                                                rel="noopener noreferrer" title="View" class="dropdown-item">
                                                View
                                            </a>
                                            @endcan
											</div>
										</div>
									</div>
									<h5 class="card-title mb-0">{{ ucfirst($ship->ship_name) }}</h5>
								</div>
								<div class="card-body px-4 pt-2">
									<p style="line-height: 2.0rem;">IMO Number : {{ $ship->imo_number }}<br/>
                                    Client Name : {{ $ship->client->name }}<br/>
                                    Project No. : {{ $ship->project_no }}</p>
									
								</div>
								
							</div>
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
