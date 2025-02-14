@extends('layouts.app')

@section('content')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/bootstrap4-toggle.min.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/switchButton.css') }}">
@endsection
<div class="container-fluid dashboard-content">
    <x-page-header title="Help Management"></x-page-header>

    <div class="col-xl-12  col-lg-12 col-md-12 col-sm-12 col-12 mb-5">

        <div class="tab-regular">
            <ul class="nav nav-tabs " id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Correspondence With Ship / Client</a>
                </li>
             
                @if($currentUserRoleLevel != 1)
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Hazmat Company Credentials</a>
                </li>
                @endif
                @if($currentUserRoleLevel == 5 ||$currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel==4)
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Extract For Client SMS</a>
                </li>
                @endif
                @if( $currentUserRoleLevel == 2)
                <li class="nav-item">
                    <a class="nav-link" id="superadmincorrespondence-tab" data-toggle="tab" href="#superadmincorrespondence" role="tab" aria-controls="superadmincorrespondence" aria-selected="true">SuperAdmin Correspondence</a>
                </li>
                @endif
                @if($currentUserRoleLevel == 1 || $currentUserRoleLevel == 2)
                <li class="nav-item">
                    <a class="nav-link" id="avilabletemplate-tab" data-toggle="tab" href="#avilabletemplate" role="tab" aria-controls="avilabletemplate" aria-selected="true">Available Template</a>
                </li>
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">

                    @if($currentUserRoleLevel == 1)
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>SR NO.</th>
                                <th>Subject</th>
                                @if($currentUserRoleLevel == 1)
                                <th>Hazmat Company</th>
                                @endif
                                <th>Attachment</th>
                                <th>Content</th>
                            </tr>
                        </thead>
                        <tbody id="admincorospondanceList">
                            <x-super-admin-corospondance :admincorrespondence=$admincorrespondence :currentUserRoleLevel=$currentUserRoleLevel></x-super-admin-corospondance>
                        </tbody>
                    </table>
                    @else
                    <div class="row mb-4">
                        <div class="col-12">
                            <a href="#" class="btn btn-primary float-right addcorospondence">Add </a>

                        </div>
                    </div>
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>SR NO.</th>
                                <th>Subject</th>
                                <th>Ship Name</th>
                                <th>Client Name</th>
                                @if($currentUserRoleLevel == 1)
                                <th>Hazmat Company</th>
                                @endif
                                <th>Attachment</th>
                                <th>Content</th>
                            </tr>
                        </thead>
                        <tbody id="corospondenceList">
                            <x-correspondence-history :correspondence=$correspondence :currentUserRoleLevel=$currentUserRoleLevel></x-correspondence-history>
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="tab-pane fade" id="superadmincorrespondence" role="tabpanel" aria-labelledby="superadmincorrespondence-tab">

                    <div class="row mb-4">
                        <div class="col-12">
                            <a href="#" class="btn btn-primary float-right addadmincorospondence">Add </a>

                        </div>
                    </div>

                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>SR NO.</th>
                                <th>Subject</th>
                                @if($currentUserRoleLevel == 1)
                                <th>Hazmat Company</th>
                                @endif
                                <th>Attachment</th>
                                <th>Content</th>
                            </tr>
                        </thead>
                        <tbody id="admincorospondanceList">
                            <x-super-admin-corospondance :admincorrespondence=$admincorrespondence :currentUserRoleLevel=$currentUserRoleLevel></x-super-admin-corospondance>
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @if($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4)
                    <div class=" row mb-4">
                        <div class="col-12">
                            <a href="#" class="btn btn-primary float-right addCredential">Add Credential </a>
                        </div>
                    </div>
                    @endif
                    <div class="row credentials">
                        <x-credential :credentials=$credentials :currentUserRoleLevel=$currentUserRoleLevel></x-credential>

                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    @if($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4)

                    <div class=" row">
                        <div class="col-12">
                            <a href="#" class="btn btn-primary float-right addSms">Add Sms </a>

                        </div>
                    </div>
                    @endif
                    <div class="row mt-4 smsList">
                        <x-extract-sms :extractSsms=$extractSsms :currentUserRoleLevel=$currentUserRoleLevel></x-extract-sms>

                    </div>
                </div>

                <div class="tab-pane fade" id="avilabletemplate" role="tabpanel" aria-labelledby="avilabletemplate-tab">
                    @if($currentUserRoleLevel == 1)
                    <x-avilable-templete-form :configration=$configration></x-avilable-templete-form>
                    @else
                    <div class="row mt-4">
                        <x-avilable-templete :configration=$configration></x-avilable-templete>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('ships.models.remarksModel')
@include('helpCenter.models.credentialModel')
@include('helpCenter.models.smsModel')
@include('helpCenter.models.admincorospondanceModel')
@include('helpCenter.models.addcorospondence')


@endsection
@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/js/data-table.js') }}"></script>
<script src="{{ asset('assets/libs/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('assets/js/correspondences.js')}}"></script>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        var currentUserRoleLevel = "{{$currentUserRoleLevel}}";
        console.log(currentUserRoleLevel);
        if (currentUserRoleLevel == 5 || currentUserRoleLevel == 6) {
            CKEDITOR.replace('mytextarea', {
                versionCheck: false,
            });
        }
        CKEDITOR.replace('mytextareasuperadmin', {
            versionCheck: false,
        });

    });
</script>
@endpush