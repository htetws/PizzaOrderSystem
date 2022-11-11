@extends('layout.master')

@section('title','Password Change')

@section('search')
<h4>Password Change Page</h4>
@endsection

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <form action="{{ route('change#password') }}" method="POST" class="col-6 offset-3 bg-white p-5 mt-4">
                    @if(session('pwd_changed'))
                    <div class="">
                        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                            <strong>Yahoo...</strong> {{ session('pwd_changed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    @if(session('pwd_error'))
                    <div class="">
                        <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
                            <strong>Oops...</strong> {{ session('pwd_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" name="oldpwd" class="form-control @error('oldpwd') is-invalid @enderror @if(session('pwd_error')) is-invalid @endif" placeholder="Enter old password">
                        @error('oldpwd')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if (session('pwd_error'))
                        <div class="invalid-feedback">{{ session('pwd_error') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="newpwd" class="form-control @error('newpwd') is-invalid @enderror" placeholder="Enter new password">
                        @error('newpwd')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirmpwd" class="form-control @error('confirmpwd') is-invalid @enderror" placeholder="Enter same password again">
                        @error('confirmpwd')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-4 text-start">
                        <input type="submit" value="Change Password" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
