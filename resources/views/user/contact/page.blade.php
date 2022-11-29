@extends('layout.user_master')

@section('title','Contact')

@section('content')
<div class="container-fluid">
    <div class="row col-10 offset-1 bg-light p-4">
        <div class="col-5 d-flex flex-column justify-content-start align-items-center">
            <h3 class="my-3 font-italic">Have some questions ? </h3>
            <p class="text-success">contact us.</p>
            <img src="{{asset('undraw_contact_us_re_4qqt.svg')}}" style="width: 100%;" class="mt-5">
        </div>
        <div class="col-6 offset-1">
            <form action="{{ route('user#contact') }}" method="POST">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid
                    @enderror" id="floatingInput" placeholder="Enter Name">
                    <label for="floatingInput">Enter Name</label>
                    @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid
                    @enderror" id="floatingInput" placeholder="Enter Name">
                    <label for="floatingInput">Email Email</label>
                    @error('email')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <textarea name="message" class="form-control @error('message') is-invalid
                    @enderror" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 300px"></textarea>
                    <label for="floatingTextarea2">Enter Message</label>
                    @error('message')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>

                <div class="button text-end mt-3">
                    <button class="btn btn-primary">Send Message</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('json')
<!-- <script>
    $(document).ready(function() {
        @if(Session::has('success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('success') }}");
        @endif
    })
</script> -->
@endsection
