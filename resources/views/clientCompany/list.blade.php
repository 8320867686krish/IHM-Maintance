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
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Client Company  Management</h2>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                @include('layouts.message')
                <div class="showSucessMsg" style="display: none;"></div>
                <div class="card">
                    <h4 class="card-header">
                    
                          
                                @can('clientCompany.add')
                                    <a href="{{ route('clientCompany.add') }}"
                                        class="btn btn-primary float-right btn-rounded addNewBtn">Add New Client Company</a>
                                @endcan
                          
                        
                    </h4>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th width="5%">Sr.No</th>
                                        <th>Name</th>
                                        <th width="15%">Ship Owner_email</th>
                                        <th width="15%">Hazmat Company</th>
                                        <th width="18%">Client Email</th>
                                        <th width="10%">Client Phone</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($clientCompany) && $clientCompany->count() > 0)
                                        @foreach ($clientCompany as $client)
                                        <tr class="clientCompanyId">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $client->name}}</td>
                                                <td>{{ $client->ship_owner_email}}</td>
                                                <td>{{$client->hazmatCompaniesId->name}}</td>
                                                <td>{{$client->userDetail->email}}</td>
                                                <td>{{$client->userDetail->phone}}</td>
                                                <td>
                                                    @can('clientCompany.edit')
                                                        <a href="{{ route('clientCompany.edit', ['id' => $client->id]) }}"
                                                            rel="noopener noreferrer" title="Edit">
                                                            <i class="fas fa-edit text-primary" style="font-size: 1rem;"></i>
                                                        </a>
                                                    @endcan
                                                    @can('clientCompany.remove')
                                                        <a href="{{ route('clientCompany.delete', ['id' => $client->id]) }}" class="ml-2 delete-btn">
                                                            <i class="fas fa-trash-alt text-danger" style="font-size: 1rem;"></i>
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
@stop

@push('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/libs/js/bootstrap4-toggle.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();
                let deleteUrl = $(this).attr('href');
                let $deleteButton = $(this);
                let confirmMsg = "Are you sure you want to delete this role?";

                confirmDelete(deleteUrl, confirmMsg, function(response) {
                    // Success callback
                    $deleteButton.closest('.clientCompanyId').remove();
                }, function(response) {
                    // Error callback (optional)
                    console.log("Failed to delete: " + response.message);
                });
            });
        });
    </script>
@endpush
