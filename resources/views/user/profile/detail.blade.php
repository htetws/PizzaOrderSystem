@extends('layout.user_master')

@section('content')
<div class="main-content mt-4">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-10 offset-1">
                <div class="row bg-white p-5">
                    @if(session('update_success'))
                    <div class="">
                        <div class="alert col-8 offset-2 alert-success alert-dismissible fade show mb-5" role="alert">
                            <strong>Yahoo...</strong> {{ session('update_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    <div class="col-4 offset-2">
                        <div class="image">
                            @if(Auth::user()->image != null)
                            <img style="width:100%;min-height:16rem;object-fit:contain" src="{{ asset('storage/'. Auth::user()->image) }}" />
                            @else
                            @if (Auth::user()->gender == 'male')
                            <img style="height:250px;object-fit:cover" class="img-thumbnail rounded-circle" src="https://cdn4.iconfinder.com/data/icons/e-commerce-181/512/477_profile__avatar__man_-512.png" />
                            @else
                            <img style="height:250px;object-fit:cover" class="img-thumbnail rounded-circle" src="https://www.citypng.com/public/uploads/preview/black-round-female-user-profile-icon-transparent-png-11639961100dq0cerzqqm.png" />
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <i style="font-size: 1.15rem;" class="fa-solid fa-user me-3 mb-1"></i>
                            <h4 class="mt-2 mb-3">{{ Auth::user()->name }}</h4>
                        </div>

                        <div class="d-flex align-items-center">
                            <i style="font-size: 1.15rem;" class="fa-solid fa-envelope me-3 mt-1"></i>
                            <h4 class="my-3">{{ Auth::user()->email }}</h4>
                        </div>

                        <div class="d-flex align-items-center">
                            <i style="font-size: 1.2rem;" class="fa-solid fa-mobile-button me-3"></i>
                            <h4 class="my-3">{{ Auth::user()->phone }}</h4>
                        </div>

                        <div class="d-flex align-items-center">
                            <i style="font-size: 1.19rem;" class="fa-solid fa-location-dot me-3"></i>
                            <h4 class="my-3">{{ Auth::user()->address }}</h4>
                        </div>

                        <div class="d-flex align-items-center">
                            <i style="font-size: 1.2rem;font-weight:bolder" class="{{ Auth::user()->gender == 'male' ? 'fa-solid fa-mars' : 'fa-solid fa-venus' }} me-3"></i>
                            <h4 class="my-3">{{ ucfirst(Auth::user()->gender) }}</h4>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-5">
                        <a href="{{ route('user#profile#editPage') }}" class="btn btn-primary"><i class="fa-solid fa-user-pen me-3"></i>Update Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
