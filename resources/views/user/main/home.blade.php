@extends('layout.user_master')

@section('title','Pizza | Home')

@section('category')
<div class="col-lg-3 col-md-4">
    <!-- Price Start -->
    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pizza Categories</span></h5>
    <div class="bg-light p-4 mb-30">
        <form>
            <div class="bg-dark text-white px-3 d-flex align-items-center justify-content-between mb-3">
                <label for="price-all" class="mt-2"><a href="{{ route('user#home') }}">All</a></label>
                <span class="badge border font-weight-normal">{{ count($categories) }}</span>
            </div>

            <div class="ml-3 mt-4 align-items-center justify-content-between mb-3">
                @foreach ($categories as $cat)
                <ul for="price-1">
                    <li><a id="testing" href="{{ route('category#filter',$cat->id) }}" class="{{ url()->current() == route('category#filter',$cat->id) ? 'bg-primary text-dark' : 'text-dark'   }} "> {{ $cat->cat_name  }}</a>
                    </li>
                </ul>
                @endforeach
            </div>
        </form>
    </div>

    <div class="">
        <button class="btn btn btn-warning w-100">Order</button>
    </div>

</div>
@endsection

@section('content')
<div class="col-lg-9 col-md-8">
    <div class="row pb-3">
        <!-- sorting -->
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <a href="{{ route('pizza#cart') }}" class="btn rounded-3 btn-dark position-relative">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            @isset($cart)
                            {{ count($cart) }}
                            @endisset
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>

                    <a href="{{ route('order#history') }}" class="ms-3 btn rounded-3 btn-dark position-relative">
                        <i class="fa-solid fa-history"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            @isset($order)
                            {{ count($order) }}
                            @endisset
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                </div>
                <div class="me-2">
                    <div class="col-12">
                        <select name="sorting" id="sorting" class="form-select">
                            <option selected disabled value="">Sort by</option>
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pizza Div -->
        <!-- Append data from ajax -->
        <div class="row" id="myList">
            @if (count($products) != 0)
            @foreach ($products as $p)
            <div class="col-lg-4 col-md-6 col-sm-6 pb-1" id="product">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('storage/'. $p->image) }}" style="height:14rem;object-fit:contain;">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="{{ route('pizza#detail',$p->id) }}"><i class="fa-solid fa-circle-info"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h5 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h6 class="text-muted">{{ $p->price }} kyats</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="d-flex flex-column align-items-center mt-5">
                <img style="width: 14rem;" src="{{ asset('no pizza.png') }}" alt="">
                <h4 class="mb-5">There is no pizza found.</h4>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('json')
<script>
    $(document).ready(function() {

        $('#sorting').change(function() {
            $sort = $(this).val();
            if ($sort == 'asc') {
                $.ajax({
                    type: 'get',
                    url: "{{ route('ajax#sorting') }}",
                    dataType: 'json',
                    data: {
                        'sorting': 'asc'
                    },
                    success: function(data) {
                        $list = "";
                        for ($i = 0; $i < data.length; $i++) {
                            $list += `<div class="col-lg-4 col-md-6 col-sm-6 pb-1" id="product">
                                    <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ asset('storage/${data[$i].image}') }}" style="height:14rem;object-fit:contain">
                                    <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="{{ url('user/pizza/detail/${data[$i].id}') }}"><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                    </div>
                                    <div class="text-center py-4">
                                    <a class="h5 text-decoration-none text-truncate" href="">${data[$i].name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h6 class="text-muted">${data[$i].price} kyats</h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    </div>
                                    </div>
                                    </div>
                                    </div>`;
                        }

                        $('#myList').html($list);
                    }
                })
            } else if ($sort == 'desc') {
                $.ajax({
                    type: 'get',
                    url: "{{ route('ajax#sorting') }}",
                    dataType: 'json',
                    data: {
                        'sorting': 'desc'
                    },
                    success: function(data) {
                        $list = "";
                        for ($i = 0; $i < data.length; $i++) {
                            $list += `<div class="col-lg-4 col-md-6 col-sm-6 pb-1" id="product">
                                    <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="{{ asset('storage/${data[$i].image}') }}" style="height:14rem;object-fit:contain">
                                    <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="{{ url('user/pizza/detail/${data[$i].id}') }}"><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                    </div>
                                    <div class="text-center py-4">
                                    <a class="h5 text-decoration-none text-truncate" href="">${data[$i].name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h6 class="text-muted">${data[$i].price} kyats</h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    </div>
                                    </div>
                                    </div>
                                    </div>`;
                        }

                        $('#myList').html($list);
                    }
                })
            }
        })
    })
</script>
@endsection
