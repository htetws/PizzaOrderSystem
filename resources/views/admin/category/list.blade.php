@extends('layout.master')

@section('title','Category List')

@section('search')
<form class="form-header" action="{{ route('category#list') }}">
    <input class="au-input au-input--lg" type="text" name="search" placeholder="Search for datas &amp; reports..." value="{{ request('search') }}" />
    <button class="au-btn--submit ml-2" type="submit">
        <i class="zmdi zmdi-search"></i>
    </button>
</form>
@endsection

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                @if(session('create_msg'))
                <div class="">
                    <div class="col-5 offset-7 alert alert-success alert-dismissible fade show mb-5" role="alert">
                        <strong>Yahoo...</strong> {{ session('create_msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                @if(session('delete_msg'))
                <div class="">
                    <div class="col-5 offset-7 alert alert-warning alert-dismissible fade show mb-5" role="alert">
                        <strong>Oops...</strong> {{ session('delete_msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                @if(session('update_msg'))
                <div class="">
                    <div class="col-5 offset-7 alert alert-success alert-dismissible fade show mb-5" role="alert">
                        <strong>Done...</strong> {{ session('update_msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h5>@if (request('search'))
                                the result of search key are : <span class="text-primary ms-1">{{ ucfirst(request('search')) }}</span>
                                @else
                                Category Lists
                                @endif</h5>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-bs-toggle="modal" data-bs-target="#create_category">
                            <i class="fa-solid fa-circle-plus mr-2"></i>add category
                        </button>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2 col-12 offset-0">

                    @if ($cats->total() != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="col-2">id</th>
                                <th class="col-2">Category</th>
                                <th>Created At</th>
                                <th>total item : <span style="font-size: 1.2rem;" class="text-success ms-3">{{ $cats->total() }}<i class="fa-solid fa-database ms-2"></i></span></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cats as $cat)
                            <tr class="tr-shadow">
                                <td></td>
                                <td class="col-2">{{ $cat->id }}</td>
                                <td class="desc col-2 font-weight-bold">{{ $cat->cat_name }}</td>
                                <td>
                                    <span class="block-email">{{ $cat->created_at->format('j F y  |  h : m : s A') }}</span>
                                </td>

                                <!--
                                <td>
                                    <span class="status--process">Processed</span>
                                </td>
                                <td>$679.00</td> -->

                                <td class="col-2">
                                    <div class="table-data-feature w-100 justify-content-around">

                                        <button class="item" data-toggle="tooltip" id="edit" data-placement="top" title="Edit" data-bs-toggle="modal" data-bs-target="#edit_category" data-id="{{ $cat->id }}" data-name="{{ $cat->cat_name }}">
                                            <i class="zmdi zmdi-edit text-primary"></i>
                                        </button>
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete" id="del" data-bs-target="#delete_category" data-bs-toggle="modal" data-id="{{ $cat->id }}">
                                            <i class="zmdi zmdi-delete text-danger"></i>
                                        </button>

                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr class="spacer"></tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div style="height: 60vh;" class="d-flex justify-content-center align-items-center">
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/man-confusing-due-to-no-connection-error-4558763-3780059.png" style="width: 450px;height:450px;object-fit:cover">
                    </div>
                    @endif

                </div>
                <!-- END DATA TABLE -->
                {{ $cats->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Create Modal -->
<div class="modal fade" id="create_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('category#create') }}" method="post">
                    @csrf
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control @error('name')
                        is-invalid
                    @enderror" placeholder="eg.seafood">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete ?</p>
            </div>

            <div class="modal-footer">
                <form action="{{ route('category#delete') }}" method="post">
                    @csrf @method('delete')
                    <input type="number" value="" class="here" name="id" hidden>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="edit_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('category#edit') }}" method="post">
                    @csrf
                    <p class="text-muted"> id : <span class="text-primary" id="id">1</span></p>
                    <input type="number" name="id" value="" id="id_form" hidden>
                    <div class="form-group mt-2 mb-4">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" value="" class="form-control @error('name')
                            is-invalid
                        @enderror" id="edit_form">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // delete category
    $(document).on('click', '#del', function() {
        var id = $(this).data('id');
        $('.here').val(id);
    });

    // update category
    $(document).on('click', '#edit', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#id').text(id);
        $('#id_form').val(id);
        $('#edit_form').val(name);
    });

    //alert animation
    $(document).ready(function() {
        $('.alert').delay(3000).animate({
            right: '-100%'
        }, 1500, function() {
            $(this).remove()
        });
    });
</script>
@endsection
