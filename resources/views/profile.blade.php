@extends('layouts.app')
@section('shiptitle','Change Password')

@section('content')
<div class="container-fluid dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('layouts.message')
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.save') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                        <div class="row">
                            <div class="form-group col-6 mb-2">
                                <label>Name</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Name" onchange="removeInvalidClass(this)" aria-describedby="nameError" value="{{ $user->name }}" />
                                @error('name')
                                <div id="nameError" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-6 mb-2">
                                <label>Email</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" onchange="removeInvalidClass(this)" aria-describedby="emailError" value="{{ $user->email }}" />
                                @error('email')
                                <div id="emailError" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-6 mt-2">
                                <label>Image</label>
                                <input id="image" class="form-control @error('image') is-invalid @enderror" type="file" name="image" placeholder="image" onchange="removeInvalidClass(this)" aria-describedby="imageError" />
                                @error('image')
                                <div id="imageError" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group pt-2 float-right">
                            <button class="btn btn-block btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection