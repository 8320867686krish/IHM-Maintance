@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->

    <div class="col-xl-12  col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
        <div class="section-block">
            <h2 class="pageheader-title">Help Center</h2>
        </div>
        <div class="tab-regular">
            <ul class="nav nav-tabs " id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Correspondence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Credential</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Extract From SMS</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">


                        <div class="form-group col-12 mb-3">
                            <label for="assign_date">Subject<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="subject" value="" name="subject" autocomplete="off" onchange="removeInvalidClass(this)">
                            <div class="invalid-feedback error" id="subjectError"></div>
                        </div>
                     
                        <div class="form-group col-12 mt-3">
                        <label for="attachment">Content</label>
                        <textarea id="mytextarea">Content!</textarea>

                        </div>
                        <div class="form-group col-12 mb-3">
                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control form-control-lg" id="file" name="file" autocomplete="off" onchange="removeInvalidClass(this)">
                            <div class="invalid-feedback error" id="fileError"></div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary float-right" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                    @for ($i = 1; $i <= 5; $i++)
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card" style="background-color: #ebeef2;">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h4 class="" style="display: flex;align-items: center;height: 75px;">Credential{{$i}}</h4>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                    <i class="fa fa-download fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class=" row"><div class="col-12">
                <a href="http://127.0.0.1:8000/ships/add" class="btn btn-primary float-right btn-rounded addNewBtn">Add </a>
                </div>
                </div>
                <div class="row mt-4">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card" style="background-color: #ebeef2;">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h4 class="" style="display: flex;align-items: center;height: 75px;">SMS{{$i}}</h4>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                    <i class="fa fa-download fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'mytextarea',{
                versionCheck: false,
            } );
           
        });
    </script>
@endpush