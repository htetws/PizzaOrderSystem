@extends('layout.master')

@section('title','Product List')

@section('search')
<form class="form-header" action="{{ route('product#list') }}">
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
                @if(session('product_create'))
                <div class="">
                    <div class="col-5 offset-7 alert alert-success alert-dismissible fade show mb-5" role="alert">
                        <strong>Yahoo...</strong> {{ session('product_create') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                @if(session('product_update'))
                <div class="">
                    <div class="col-5 offset-7 alert alert-success alert-dismissible fade show mb-5" role="alert">
                        <strong>Yahoo...</strong> {{ session('product_update') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                @if(session('product_delete'))
                <div class="">
                    <div class="col-5 offset-7 alert alert-warning alert-dismissible fade show mb-5" role="alert">
                        <strong>Oops...</strong> {{ session('product_delete') }}
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
                        <a class="au-btn au-btn-icon au-btn--green au-btn--small" href="{{ route('product#create') }}">
                            <i class="fa-solid fa-circle-plus mr-2"></i>add Product
                        </a>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">

                    @if ($products->total() != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th class="col-2"><span>image</span></th>
                                <th class="col-2">Product Name</th>
                                <th class="col-2">category</th>
                                <th class="col-2">price</th>
                                <th class="col-1">view</th>
                                <th>total item : <span style="font-size: 1.2rem;" class="text-success ms-3">{{ $products->total() }}<i class="fa-solid fa-database ms-2"></i></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $pd)
                            <tr class="tr-shadow">
                                <td class="col-2">
                                    <img src="{{ asset('storage/'.$pd->image) }}" style="width:70px;height:70px;object-fit:cover;" class="img-fluid rounded-2">
                                </td>
                                <td class="desc col-3 font-weight-bold">{{ $pd->name }}</td>
                                <td class="col-2"><span class="ms-1 status--process">{{ $pd->cat_name }}</span></td>
                                <td class="col-2">{{ $pd->price }}</td>
                                <td class="col-1"><span class="ms-2">{{ $pd->view_count }}</span></td>

                                <!-- <td>
                                    <span class="status--process">Processed</span>
                                </td> -->

                                <td class="col-2">
                                    <div class="table-data-feature w-100 justify-content-around">
                                        <a href="{{ route('product#detail',$pd->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="View">
                                            <i class="fa-solid fa-eye text-success"></i>
                                        </a>
                                        <a href="{{ route('product#edit',$pd->id) }}" class="item" data-toggle="tooltip" id="edit" data-placement="top" title="Edit">
                                            <i class="zmdi zmdi-edit text-primary"></i>
                                        </a>
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete" id="del" data-bs-target="#delete_category" data-bs-toggle="modal" data-id="{{ $pd->id }}">
                                            <i class="zmdi zmdi-delete text-danger"></i>
                                        </button>

                                    </div>
                                </td>
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
                {{ $products->appends(request()->query())->links() }}
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
                <form action="{{ route('product#delete') }}" method="post">
                    @csrf @method('delete')
                    <input type="number" value="" class="here" name="id" hidden>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
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
