@extends('layout.master')

@section('title','Messages')

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

                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h5>@if (request('search'))
                                the result of search key are : <span class="text-primary ms-1">{{ ucfirst(request('search')) }}</span>
                                @else
                                Message Lists
                                @endif</h5>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <button class="btn btn-danger" id="deleteAllMessage">
                            <i class="fa-solid fa-remove mr-2"></i>Delete All
                        </button>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2 col-12 offset-0">

                    @if ($messages->total() != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Messages</th>
                                <th>Created At</th>
                                <th>total item : <span style="font-size: 1.2rem;" class="text-success ms-3">{{ $messages->total() }}<i class="fa-solid fa-database ms-2"></i></span></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $msg)
                            <tr class="tr-shadow">
                                <td></td>
                                <td>
                                    <h5> > </h5>
                                </td>
                                <td id="name" class="text-dark">{{ $msg->name }}</td>
                                <td id="email" class="col-2 desc">{{ $msg->email }}</td>
                                <td id="message" class="col-3">{{ Str::words($msg->message,5,' ...') }}</td>
                                <td>
                                    <span class="block-email">{{ $msg->created_at->format('d F,  Y') }}</span>
                                </td>
                                <td class="col-2">
                                    <div class="table-data-feature w-100 justify-content-around">
                                        <a href="#" class="viewContact" data-message="{{ $msg->message }}" data-bs-target="#contactModal" data-bs-toggle="modal" class="item" data-toggle="tooltip" data-placement="top" title="View">
                                            <i class="fa-solid fa-eye text-success"></i>
                                        </a>
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
                {{ $messages->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-muted" id="exampleModalLabel">Message from <span class="modalName text-primary"></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mt-3 mb-4">
                    <i class="fa-solid fa-envelope me-3"></i>
                    <p class="modalEmail"></p><br>
                </div>
                <p class="modalMessage"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('.viewContact').click(function() {
            $parentNode = $(this).parents('tbody tr');
            $('.modalName').text($parentNode.find('#name').text());
            $('.modalEmail').text($parentNode.find('#email').text());
            $('.modalMessage').text($(this).data('message'));
        })

        if ($('table').length == 0) {
            $('#deleteAllMessage').attr('disabled', 'disabled')
        } else {
            $('#deleteAllMessage').click(function() {
                if (confirm('Are you sure want to deleted all messages.')) {
                    $('table').remove();
                    $.get("{{ route('ajax#contact#removeAll') }}", {
                        'status': 'removeAll'
                    }, (data) => {
                        toastr.success('deleted all messages.');
                    })
                }
            })
        }


    })
</script>
@endsection
