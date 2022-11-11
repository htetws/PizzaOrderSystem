@extends('layout.master')

@section('title','Admin List')

@section('search')
<form class="form-header" action="{{ route('admin#list') }}">
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

                @if(session('change_role'))
                <div class="">
                    <div class="col-5 offset-7 alert alert-success alert-dismissible fade show mb-5" role="alert">
                        <strong>Yahoo...</strong> {{ session('change_role') }}
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

                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h5>@if (request('search'))
                                the result of search key are : <span class="text-primary ms-1">{{ ucfirst(request('search')) }}</span>
                                @else
                                Admin Lists
                                @endif</h5>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <!-- <a class="au-btn au-btn-icon au-btn--green au-btn--small" href="{{ route('product#create') }}">
                            <i class="fa-solid fa-circle-plus mr-2"></i>add Product
                        </a> -->
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">

                    @if ($admins->total() != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th class="col-2"><span>image</span></th>
                                <th class="col-2">Name</th>
                                <th class="col-2">email</th>
                                <th class="col-2">gender</th>
                                <th class="col-2">phone</th>
                                <th class="col-2">address</th>
                                <th class="text-primary"><i class="fa-solid fa-database me-3"></i>{{ $admins->total() }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                            <tr class="tr-shadow">
                                <td class="col-2">
                                    @if ($admin->image != null)
                                    <img src="{{ asset('storage/'.$admin->image) }}" style="height:60px;object-fit:cover;" class="rounded-3">
                                    @else
                                    @if ($admin->gender == 'male')
                                    <img src="https://static.vecteezy.com/system/resources/previews/002/318/271/original/user-profile-icon-free-vector.jpg" alt="" style="height:60px;object-fit:cover;" class="rounded-3">
                                    @else
                                    <img src="https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200008.jpg" alt="" style="height:60px;object-fit:cover;" class="rounded-3">
                                    @endif
                                    @endif
                                </td>
                                <td class="desc col-2 font-weight-bold">{{ $admin->name }}</td>
                                <td class="col-2"><span class="ms-1 status--process">{{ $admin->email }}</span></td>
                                <td class="col-2">{{ $admin->gender }}</td>
                                <td class="col-2">{{ $admin->phone }}</td>
                                <td class="col-2"><span>{{ $admin->address }}</span></td>

                                <!-- <td>
                                    <span class="status--process">Processed</span>
                                </td> -->

                                <td class="col-2">
                                    <div class="table-data-feature w-100 justify-content-around">

                                        @if (Auth::user()->id != $admin->id)
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Change Role" id="edit" data-bs-target="#changeRole" data-bs-toggle="modal" data-id="{{ $admin->id }}" data-role="{{ $admin->role }}">
                                            <i class="fa-solid fa-person-circle-exclamation text-primary"></i>
                                        </button>

                                        <button class="item ms-2" data-toggle="tooltip" data-placement="top" title="Delete" id="del" data-bs-target="#delete_category" data-bs-toggle="modal" data-id="{{ $admin->id }}">
                                            <i class="zmdi zmdi-delete text-danger"></i>
                                        </button>
                                        @endif

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
                {{ $admins->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

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
                <form action="{{ route('admin#delete') }}" method="post">
                    @csrf @method('delete')
                    <input type="number" value="" class="here" name="id" hidden>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- change role modal -->
<div class="modal fade" id="changeRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Change Role | Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin#role#change') }}" method="post">
                    @csrf
                    <div class="form-group my-3">
                        <input type="number" value="" id="id" name="id" hidden>
                        <label for="">Gender</label>
                        <select name="role" id="role" class="form-select">
                            <option value="admin" {{ old('role') == 'user' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('role') == 'admin' ? 'selected' : '' }}>User</option>
                        </select>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                            <button type="submit" class="btn btn-primary">Change Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    // delete category
    $(document).on('click', '#del', function() {
        var id = $(this).data('id');
        $('.here').val(id);
    });
    $(document).on('click', '#edit', function() {
        var id = $(this).data('id');
        var role = $(this).data('role');
        $('#id').val(id);
        $('#role').val(role);
    })

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
