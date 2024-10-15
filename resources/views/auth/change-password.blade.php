@extends('layouts.app')
@section('shiptitle','Change Password')

@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Password</h2>
                  
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                @include('layouts.message')
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                            <div class="form-group col-6">
                                <x-input-label for="current_password" :value="__('Current Password')" /><span class="text-danger">*</span>
                                <input id="current_password" class="form-control @error('current_password') is-invalid @enderror" type="password" name="current_password" placeholder="Current Password" onchange="removeInvalidClass(this)" aria-describedby="currentPasswordError" />
                                @error('current_password')
                                    <div id="currentPasswordError" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <x-input-label for="password" :value="__('Password')" /><span class="text-danger">*</span>
                                <input class="form-control @error('password') is-invalid @enderror" id="password"
                                    type="password" placeholder="Password" name="password" minlength="8"
                                    onchange="removeInvalidClass(this)" aria-describedby="passwordError" />
                                @error('password')
                                    <div id="passwordError" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-6">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" placeholder="Confirm Password"
                                    onchange="removeInvalidClass(this)" aria-describedby="confirmPasswordError" />
                                @error('password_confirmation')
                                    <div id="confirmPasswordError" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>

                            <div class="form-group pt-2 float-right">
                                <button class="btn btn-block btn-primary" type="submit">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
