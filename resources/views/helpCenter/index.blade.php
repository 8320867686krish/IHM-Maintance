@extends('layouts.app')

@section('content')
@section('shiptitle','Help Center')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/select.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/bootstrap4-toggle.min.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/css/switchButton.css') }}">
@endsection
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->

    <div class="col-xl-12  col-lg-12 col-md-12 col-sm-12 col-12 mb-5">

        <div class="tab-regular">
            <ul class="nav nav-tabs " id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Correspondence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Credentials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Extract From SMS</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                    @if($currentUserRoleLevel == 5 || $currentUserRoleLevel == 6)
                    <form id="correspondencesForm" action="{{route('correspondence.save')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @if($ships)
                            <div class="form-group col-12 mb-3">
                                <select name="ship_id" id="ship_id" class="form-control form-control-lg">
                                    @foreach($ships as $ship)
                                    <option value="{{$ship['id']}}">{{$ship['ship_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="form-group col-12 mb-3">
                                <label for="assign_date">Subject<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="subject" value="" name="subject" autocomplete="off" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="subjectError"></div>
                            </div>

                            <div class="form-group col-12 mt-3">
                                <label for="attachment">Content</label>
                                <textarea id="mytextarea" value=""></textarea>

                            </div>
                            <div class="form-group col-12 mb-3">
                                <label for="attachment">Attachment</label>
                                <input type="file" class="form-control form-control-lg" id="attachment" name="attachment" autocomplete="off" onchange="removeInvalidClass(this)">
                                <div class="invalid-feedback error" id="fileError"></div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="button" id="correspondencesSave">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <x-correspondence-history :correspondence=$correspondence :currentUserRoleLevel=$currentUserRoleLevel></x-correspondence-history>
                    @endif
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
        </div>
    </div>
</div>
</div>
@include('ships.models.remarksModel')
@include('helpCenter.models.credentialModel')
@include('helpCenter.models.smsModel')

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


    });
</script>
@endpush