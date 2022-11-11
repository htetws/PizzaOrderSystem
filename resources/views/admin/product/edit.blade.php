@extends('layout.master')

@section('title','Product Update')

@section('search')
<h4>Product Update Page</h4>
@endsection

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-10 offset-1 bg-white px-5">
                <div class="text-center p-3 mb-5">
                    <p class="display-6">Product update form</p>
                </div>
                <form action="{{ route('product#update',$product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-7">
                            <div class="row">
                                <div class="col form-group">
                                    <label for="">Product Name</label>
                                    <input type="text" name="productName" class="form-control @error('productName') is-invalid @enderror" placeholder="Enter product name ... " value="{{ old('productName',$product->name) }}">
                                    @error('productName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col form-group">
                                    <label for="">Waiting Time</label>
                                    <input type="number" name="waitingTime" class="form-control @error('waitingTime') is-invalid @enderror" placeholder="Enter waiting time ... " value="{{ old('watingTime',$product->waiting_time) }}">
                                    @error('waitingTime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea id="editor" name="productDesc" cols="30" rows="5" class="form-control @error('productDesc') is-invalid @enderror" placeholder="Enter product description ...">{{ old('productDesc',$product->description) }}</textarea>
                                @error('productDesc')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder=" Enter product price ..." value="{{ old('price',$product->price) }}">
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Category</label>
                                <select name="category" class="form-control form-select @error('category') is-invalid @enderror"">
                                    @foreach ($cats as $cat)
                                    <option value=" {{ $cat->id }}" {{ old('category',$product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->cat_name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"">
                                 <small class=" text-primary">{{ $product->image }}</small>
                                @error('image')
                                <div class=" invalid-feedback">{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="my-5">
                                <input type="submit" class="btn btn-primary" value="Create Product">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            editor.ui.view.editable.element.style.height = '5.5rem';
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
