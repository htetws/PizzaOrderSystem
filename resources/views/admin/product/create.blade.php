@extends('layout.master')

@section('title','Product List')

@section('search')
<h4>Product Creat Page</h4>
@endsection

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-10 offset-1 bg-white px-5">
                <div class="text-center p-3 mb-5">
                    <p class="display-6">Product create form</p>
                </div>
                <form action="{{ route('product#create#post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-7">
                            <div class="row">
                                <div class="col form-group">
                                    <label for="">Product Name</label>
                                    <input type="text" name="productName" class="form-control @error('productName') is-invalid @enderror" placeholder="Enter product name ... " value="{{ old('productName') }}">
                                    @error('productName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col form-group">
                                    <label for="">Waiting Time</label>
                                    <input type="number" name="waitingTime" class="form-control @error('waitingTime') is-invalid @enderror" placeholder="Enter waiting time ... " value="{{ old('waitingTime') }}">
                                    @error('waitingTime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea id="editor" name="productDesc" cols="30" rows="5" class="form-control @error('productDesc') is-invalid @enderror" placeholder="Enter product description ...">
                                {{ old('productDesc') }}
                                </textarea>
                                @error('productDesc')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder=" Enter product price ..." value="{{old('price')}}">
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Category</label>
                                <select name="category" class="form-control form-select @error('category') is-invalid @enderror"">
                                    <option value="" selected disabled>Choose category ...</option>
                                    @foreach ($cats as $cat)
                                    <option value=" {{ $cat->id }}" {{ old('category') == $cat->id ? 'selected' : '' }}>{{ $cat->cat_name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"">
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
