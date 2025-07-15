@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
@endsection

@section('content')
<div class="container-fluid dashboard-content">
    <x-page-header title="Hazmat Company Management"></x-page-header>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('layouts.message')
            <div id="showSucessMsg" style="display: none;"></div>
            <div class="card">
                <h5 class="card-header">

                    <a href="{{ route('hazmatCompany.add') }}"
                        class="btn btn-primary float-right btn-rounded addNewBtn">Add</a>

                </h5>
                <div class="card-body mb-4">
                    <div>
                        <table class="table table-striped table-bordered first" id="HazmatCompany">
                            <thead>
                                <tr>
                                    <th width="10%">Sr.No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Logo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($hazmatCompany) && $hazmatCompany->count() > 0)
                                @foreach ($hazmatCompany as $hazmatCompanyValue)
                                <tr class="hazmatCompanyRowTr">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst($hazmatCompanyValue->name) }}</td>
                                    <td>{{ $hazmatCompanyValue->email }}</td>
                                    <td><img src="{{ asset('uploads/hazmatCompany/' . $hazmatCompanyValue->logo) }}" height="100" width="100" alt="Company Logo"></td>
                                    <td>
                                        @can('hazmatCompany.edit')
                                        <a href="{{ route('hazmatCompany.edit', ['id' => $hazmatCompanyValue->id]) }}"
                                            rel="noopener noreferrer" title="Edit">
                                            <i class="fas fa-edit text-primary" style="font-size: 1rem;"></i>
                                        </a>
                                        @endcan
                                        @can('hazmatCompany.remove')
                                        <a href="{{ route('hazmatCompany.delete', ['id' => $hazmatCompanyValue->id]) }}" class="ml-2 delete-btn" title="Delete">
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

<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            let deleteUrl = $(this).attr('href');
            let $deleteButton = $(this);
            let confirmMsg = "Are you sure you want to delete this role?";

            confirmDelete(deleteUrl, confirmMsg, function(response) {
                // Success callback
                $deleteButton.closest('.hazmatCompanyRowTr').remove();
            }, function(response) {
                // Error callback (optional)
                console.log("Failed to delete: " + response.message);
            });
        });
    });
</script>
@endpush