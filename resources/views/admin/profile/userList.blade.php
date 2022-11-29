@extends('layout.master')

@section('title','Admin List')

@section('search')
<form class="form-header" action="{{ route('user#list') }}">
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

                    @if ($users->total() != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th class="col-2"><span>image</span></th>
                                <th class="col-2">Name</th>
                                <th class="col-2">email</th>
                                <th class="col-2">gender</th>
                                <th class="col-2">phone</th>
                                <th class="text-primary"><i class="fa-solid fa-database me-3"></i>{{ $users->total() }}</th>
                                <th class="col-2">Setting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="tr-shadow">
                                <td class="col-2">
                                    @if ($user->image != null)
                                    <img src="{{ asset('storage/'.$user->image) }}" style="height:60px;object-fit:cover;" class="rounded-3">
                                    @else
                                    @if ($user->gender == 'male')
                                    <img src="https://static.vecteezy.com/system/resources/previews/002/318/271/original/user-profile-icon-free-vector.jpg" alt="" style="height:60px;object-fit:cover;" class="rounded-3">
                                    @else
                                    <img src="https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200008.jpg" alt="" style="height:60px;object-fit:cover;" class="rounded-3">
                                    @endif
                                    @endif
                                </td>
                                <input type="hidden" id="userid" value="{{ $user->id }}">
                                <td class="desc col-2 font-weight-bold">{{ $user->name }}</td>
                                <td class="col-2"><span class="ms-1 status--process">{{ $user->email }}</span></td>
                                <td class="col-2">{{ $user->gender }}</td>
                                <td class="col-2">{{ $user->phone }}</td>
                                <!-- <td class="col-2"><span>{{ $user->address }}</span></td> -->

                                <td class="col-2">
                                    <select name="userList" id="userList" class="form-select">
                                        <option value="admin" {{ old('userList',$user->role) == 'admin' ? "selected" : '' }}>Admin</option>
                                        <option value="user" {{ old('userList',$user->role) == 'user' ? "selected" : '' }}>User</option>
                                    </select>
                                </td>

                                <td class="col-2">
                                    <a href="{{ route('user#edit#page',$user->id) }}"><i class="fa-regular fa-pen-to-square fs-5 text-primary"></i></a>
                                    <i data-bs-target="#delete_user" data-bs-toggle="modal" class="fa-solid fa-trash-can fs-5 mt-2 text-danger deleteBtn"></i></a>
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
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

//user delete
<div class="modal fade" id="delete_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form action="{{ route('user#delete') }}" method="post">
                    @csrf @method('delete')
                    <input type="hidden" value="" class="user_id form-control" name="userid">
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
    //user delete with modal
    $(document).on('click', '.deleteBtn', function() {
        $parentNode = $(this).parents('tbody tr');
        $('.user_id').val($parentNode.find('#userid').val());
    })

    //ajax user role change
    $(document).on('change', '#userList', function() {
        $selectValue = $(this).val();
        $parentNode = $(this).parents('tr');
        $userid = $parentNode.find('#userid').val();

        $.ajax({
            type: 'get',
            url: "{{route('user#role#ajax')}}",
            data: {
                'user_id': $userid,
                'role': $selectValue
            },
            success: (data) => {
                window.location.reload();
            }

        })
    })
</script>
@endsection
