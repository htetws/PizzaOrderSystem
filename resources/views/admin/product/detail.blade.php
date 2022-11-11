@extends('layout.master')

@section('title','Product Detail | Admin')

@section('search')
<h4><i style="cursor: pointer ;" class="fa-solid fa-caret-left me-2"></i><a class="me-2" style="cursor: pointer ;" onclick="history.back();">Back | </a>Product Detail</h4>
<p><i class="fa-solid fa-eye me-3 text-primary"></i>View Count : {{ $product->view_count }}</p>
@endsection

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-10 offset-1 bg-white rounded-2">
                <div class="bg-images pt-3">
                    <img src="{{ asset('storage/'.$product->image) }}" style="width:100%;max-height:350px;object-fit:cover;opacity:0.5">
                </div>
                <div class="main-image position-relative">
                    <img src="{{ asset('storage/'.$product->image) }}" class="img-thumbnail rounded-4" style="
                    width:350px;height:250px;object-fit:cover;position:absolute;top:-130px;left:310px;margin:auto">
                </div>
                <div class="d-flex justify-content-between px-2 align-items-center pt-4">
                    <div class="">
                        <h5 class="text-muted"><i class="fa-brands fa-typo3 text-primary me-3"></i>{{ $product->cat_name }}</h5>

                        <p class="my-5"> <i class="fa-solid fa-sack-dollar me-3 text-primary"></i>{{ $product->price }} kyats</p>
                    </div>
                    <div class="">
                        <h5 class="text-muted"><i class="fa-solid fa-clock me-3 text-primary"></i>{{ $product->created_at->format("j F Y") }}</h5>
                        <p class="my-5"><i class="fa-solid fa-hourglass-end me-3 text-primary"></i>Wating Time : {{ $product->waiting_time }} mins</p>
                    </div>
                </div>
                <div>
                    <h1 class="display-5 fw-bolder pt-3 pb-5">{{ $product->name }}</h1>
                    <p class="text-justify">{!! $product->description !!}</p>
                </div>

                <div class="col-12 my-5 pb-5 text-center">
                    <a href="{{ route('product#edit',$product->id) }}" class="btn btn-primary">Edit Product</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
