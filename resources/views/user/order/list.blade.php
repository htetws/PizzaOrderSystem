@extends('layout.user_master')

@section('title','Order History')

@section('content')
<div class="container-fluid" style="height: 50vh;">
    <div class="row px-xl-5">
        <div class="col-lg-8 offset-2 table-responsive mb-5">
            <table class="mb-4 table table-light table-borderless table-hover text-center mb-0" id="Table">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody class="align-middle">

                    @foreach ($order as $o)
                    <tr>
                        <td class="align-middle"> {{ $o->created_at->format('j F Y') }} </td>
                        <td class="align-middle"> {{ $o->order_code}} </td>
                        <td class="align-middle"> {{ $o->total_price }} kyats</td>
                        <td class="align-middle text-start">
                            @if ($o->status == 0)
                            <i class="fa-regular fa-clock me-2 text-primary"></i><span class="text-primary">pending...</span>
                            @elseif($o->status == 1)
                            <i class="fa-regular fa-circle-check me-2 text-success"></i><span class="text-success">accepted</span>
                            @elseif($o->status == 2)
                            <i class="fa-regular fa-circle-xmark me-2 text-danger"></i><span class="text-danger">rejected</span>
                            @endif
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
            {{ $order->links() }}
        </div>


    </div>
</div>
@endsection
