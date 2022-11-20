@extends('layout.master')

@section('title','Order List')

@section('search')
<form class="form-header" action="{{ route('admin#order#list') }}">
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
                                Order Lists
                                @endif</h5>

                        </div>
                    </div>
                    <div class="col-4 table-data__tool-right">
                        <!-- <small class="col-4" for="">Sorting status</small> -->
                        <!-- <select name="status" id="status" class="col-4 form-select">
                            <option value="" selected>All</option>
                            <option value="0">Pending</option>
                            <option value="1">Accepted</option>
                            <option value="2">Rejected</option>
                        </select> -->

                        <form action="{{ route('ajax#order#admin') }}" method="GET">
                            @csrf
                            <div class="input-group">
                                <button class="btn btn-outline-primary me-1 disabled" type="button">
                                    <i class="fa-solid fa-database me-2"></i>{{ count($order) }}
                                </button>
                                <select class="form-select" name="OrderStatus" id="inputGroupSelect04" aria-label="Example select with button addon">
                                    <option value="">All</option>
                                    <option value="0" {{ request('OrderStatus') == '0' ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ request('OrderStatus') == '1' ? 'selected' : '' }}>Accept</option>
                                    <option value="2" {{ request('OrderStatus') == '2' ? 'selected' : '' }}>Reject</option>
                                </select>
                                <button class="btn btn-dark ms-1" type="submit"><i class="fa-solid fa-filter me-2"></i>Filter</button>
                            </div>
                        </form>

                    </div>

                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                        CSV download
                    </button>
                </div>

            </div>
            <div class="table-responsive table-responsive-data2">

                @if (count($order) != 0)
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th class="col-1">user id</th>
                            <th class="col-2">username</th>
                            <th class="col-3">order code</th>
                            <th class="col-2">total price</th>
                            <th class="col-2">date</th>
                            <th class="col-2">status</th>
                        </tr>
                    </thead>

                    <tbody id="Tbody">
                        @foreach ($order as $o)
                        <tr>
                            <input type="hidden" value="{{$o->id}}" id="orderId">
                            <td class="col-1">{{ $o->user_id }}</td>
                            <td class="col-2">{{ $o->user_name }}</td>
                            <td class="col-3"><span class="status--process">{{ $o->order_code }}</span></td>
                            <td class="col-2" id="price">{{ $o->total_price }} kyats</td>
                            <td class="col-2"><span>{{ $o->created_at->format('j F Y') }}</span></td>

                            <td class="col-2">
                                <select name="status" id="statusone" class="form-select">
                                    <option value="0" {{ $o->status == 0 ? 'selected' : ''}}>Pending</option>
                                    <option value="1" {{ $o->status == 1 ? 'selected' : ''}}>Accept</option>
                                    <option value="2" {{ $o->status == 2 ? 'selected' : ''}}>Reject</option>
                                </select>
                            </td>


                        </tr>
                        <tr class="spacer"></tr>

                        @endforeach

                    </tbody>

                </table>
                {{ $order->appends(request()->all())->links() }}
                @else
                <div style="height: 60vh;" class="d-flex justify-content-center align-items-center">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/man-confusing-due-to-no-connection-error-4558763-3780059.png" style="width: 450px;height:450px;object-fit:cover">
                </div>
                @endif

            </div>
            <!-- END DATA TABLE -->

        </div>
    </div>
</div>
</div>

@endsection

@section('js')

<script>
    $(document).ready(function() {
        // $("#status").click(function() {
        //     $selectValue = $(this).val();

        //     $.ajax({
        //         type: 'get',
        //         url: "{{route('ajax#order#admin')}}",
        //         data: {
        //             'selectValue': $selectValue
        //         },
        //         dataType: 'json',
        //         success: (response) => {
        //             $data = response;
        //             $div = '';
        //             $selectBox = '';

        //             $data.forEach(item => {

        //                 $MonthList = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        //                 $day = new Date(item.created_at).getDate() - 1;
        //                 $year = new Date(item.created_at).getFullYear();
        //                 $month = $MonthList[new Date(item.created_at).getMonth()];

        //                 $date = `${$day} ${$month} ${$year}`;

        //                 if (item.status == 0) {
        //                     $selectBox = `<select name="status" id="statusone" class="form-select">
        //                             <option value="0" selected>Pending</option>
        //                             <option value="1">Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>`;
        //                 } else if (item.status == 1) {
        //                     $selectBox = `<select name="status" id="statusone" class="form-select">
        //                             <option value="0">Pending</option>
        //                             <option value="1" selected>Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>`;
        //                 } else {
        //                     $selectBox = `<select name="status" id="statusone" class="form-select">
        //                             <option value="0">Pending</option>
        //                             <option value="1">Accept</option>
        //                             <option value="2" selected>Reject</option>
        //                         </select>`;
        //                 }

        //                 $div += `<tr>
        //                     <td class="col-1">${item.user_id}</td>
        //                     <td class="col-2">${item.user_name}</td>
        //                     <td class="col-3"><span class="status--process">${item.order_code}</span></td>
        //                     <td class="col-2">${item.total_price} kyats</td>
        //                     <td class="col-2"><span>${$date}</span></td>

        //                     <td class="col-2">${$selectBox}</td>

        //                 </tr>
        //                 <tr class="spacer"></tr>`;
        //             });
        //             $('#Tbody').html($div);
        //         }
        //     })
        // })

        $('tr #statusone').change(function() {
            $parentNode = $(this).parents("tr");
            $id = $parentNode.find('#orderId').val();
            $status = $parentNode.find('#statusone').val();

            $.ajax({
                type: 'get',
                url: "{{ route('ajax#status#admin') }}",
                data: {
                    'status': $status,
                    'id': $id
                },
                dataType: 'json',
                success: (data) => {
                    // console.log(data);
                    window.location.reload();
                }
            })

        })
    })
</script>

@endsection
