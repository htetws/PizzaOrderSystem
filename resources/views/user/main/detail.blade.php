@extends('layout.user_master')

@section('title',"$pizza->name")

@section('css')
<style>
    .scroll {
        height: 400px;

        overflow: scroll;
    }

    .scroll::-webkit-scrollbar {
        width: 12px;
    }
</style>
@endsection

@section('content')

<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="{{asset('storage/'.$pizza->image)}}" alt="Image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3>{{ $pizza->name }}</h3>

                <input type="hidden" value="{{ Auth::user()->id }}" id="userId">
                <input type="hidden" value="{{ $pizza->id }}" id="pizzaId">

                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <p class="pt-1 text-muted"><i class="fa solid fa-eye me-2"></i>{{ $pizza->view_count + 1 }}</p>
                </div>
                <h3 class="font-weight-semi-bold mb-4">{{ $pizza->price }} kyats</h3>
                <hr>

                <div style="max-height: 25rem;" class="scroll mb-4 overflow-auto">{!! $pizza->description !!}</div>

                <div class="d-flex align-items-center mb-4 mt-5 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" id="countId" class="form-control bg-secondary border-0 text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="cartBtn" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                        Cart</button>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Share on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach ($pizzaList as $pl)
                <div class="product-item bg-light">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('storage/'.$pl->image) }}" style="height:230px;object-fit:cover" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="{{route('pizza#detail',$pl->id)}}"><i class="fa-solid fa-circle-info"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">{{ $pl->name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{ $pl->price }} kyats</h5>
                            <!-- <h6 class="text-muted ml-2"><del>$123.00</del></h6> -->
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small>({{ $pl->view_count }})</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->
@endsection

@section('cart')
<a href="{{ route('pizza#cart') }}" type="button" class="btn rounded-3 btn-dark position-relative">
    <i class="fa-solid fa-cart-plus"></i>
    <span id="cartlist" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> {{ count($cart) }}
        <span class="visually-hidden">unread messages</span>
    </span>
</a>
@endsection

@section('json')

<script>
    $(document).ready(function() {

        $.ajax({
            type: 'get',
            url: "{{ route('ajax#view') }}",
            data: {
                'postId': $('#pizzaId').val(),
            },
            success: (data) => {
                // console.log(data);
            }
        })

        $('#cartBtn').click(function() {
            $object = {
                'userId': $('#userId').val(),
                'pizzaId': $('#pizzaId').val(),
                'countId': $('#countId').val()
            }
            $.ajax({
                type: 'get',
                url: "{{ route('ajax#cart') }}",
                data: $object,
                dataType: 'json',
                success: (data) => {
                    $total = data.length;
                    $('#cartlist').text($total)
                    if (data) {
                        toastr.success('added to the cart.');
                        setTimeout(function() {
                            window.location.href = "{{ route('user#home') }}"
                        }, 2000)
                    }

                }
            })
        })
    })
</script>

@endsection
