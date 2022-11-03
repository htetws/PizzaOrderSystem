@extends('layout.auth')

@section('title','Register Page')

@section('content')
<div class="login-form">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input class="au-input au-input--full @error('name') is-invalid @enderror" type="text" name="name" placeholder="Username" value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input class="au-input au-input--full @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input class="au-input au-input--full @error('phone') is-invalid @enderror" type="number" name="phone" placeholder="eg.09xxx" value="{{ old('phone') }}">
            @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Address</label>
            <input class="au-input au-input--full @error('address') is-invalid @enderror" type="text" name="address" placeholder="Address" value="{{ old('address') }}">
            @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="au-input au-input--full @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="au-input au-input--full @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Confirm Password">
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>

    </form>
    <div class="register-link">
        <p>
            Already have account?
            <a href="{{ route('auth#login') }}">Sign In</a>
        </p>
    </div>
</div>
@endsection
