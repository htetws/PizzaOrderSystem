@extends('layout.master')

@section('title','Profile Update | Admin')

@section('search')
<h4>Profile Update Form</h4>
@endsection

@section('content')
<div class="main-content mt-4">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-10 offset-1">

                <div class="row bg-white p-4 d-flex align-items-start">
                    <div class="col-3 ms-5 mt-4">
                        <input type="text" class="form-control text-center my-2 form-control-sm mb-3" value="Role : {{ ucfirst(Auth::user()->role) }}" readonly>
                        <div class="image">
                            @if(Auth::user()->image != null)
                            <img src="{{ asset('storage/'. Auth::user()->image) }}" />
                            @else
                            @if (Auth::user()->gender == 'male')
                            <img class="img-thumbnail rounded-circle" src="https://cdn4.iconfinder.com/data/icons/e-commerce-181/512/477_profile__avatar__man_-512.png" />
                            @else
                            <img class="img-thumbnail rounded-circle" src="https://www.citypng.com/public/uploads/preview/black-round-female-user-profile-icon-transparent-png-11639961100dq0cerzqqm.png" />
                            @endif
                            @endif
                        </div>
                        <form action="{{ route('admin#profile#update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" class="form-control form-control-sm mt-3">
                    </div>
                    <div class="col-7 offset-1">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Username" value="{{ old('name',Auth::user()->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email" value="{{ old('email',Auth::user()->email) }}">
                            @error('email')
                            <div class=" invalid-feedback">{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Phone Number" value="{{ old('phone',Auth::user()->phone) }}">
                            @error('phone')
                            <div class=" invalid-feedback">{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address" value="{{ old('address',Auth::user()->address) }}">
                            @error('address')
                            <div class=" invalid-feedback">{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" class="form-select">
                                <option value="male" {{ old('gender',Auth::user()->gender) == 'male' ? 'selected' : ''}}>Male</option>
                                <option value="female" {{ old('gender',Auth::user()->gender) == 'female' ? 'selected' : ''}}>Female</option>
                            </select>
                        </div>

                        <div class="form-group mt-4 text-start">
                            <a href="{{ route('admin#profile') }}" class="btn btn-secondary me-2">Back</a>
                            <input type="submit" value="Update Profile" class="btn btn-primary">
                        </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
