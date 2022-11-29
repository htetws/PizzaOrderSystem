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

            <button class="btn btn-dark mb-4" onclick="history.back()"><i class="fa-solid fa-left-long me-2"></i>Back</button>

            <div class="my-1 col-5">

                <div class="card">
                    <div class="card-header">
                        <h3><i class="fa-solid fa-clipboard me-3"></i>Order info</h3>
                        <small class="text-warning"><i class="fa-solid fa-circle-exclamation me-2"></i>include delivary charages +3k</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <p class="my-2"><i class="fa-regular fa-user me-3"></i>Name</p>
                                <p class="my-2"><i class="fa-solid fa-barcode me-3"></i>Code</p>
                                <p class="my-2"><i class="fa-regular fa-clock me-3"></i>Date</p>
                                <p class="my-2"><i class="fa-solid fa-coins me-3"></i>Total</p>
                            </div>
                            <div class="col">
                                <p class="my-2">{{ $orderlists[0]->user_name }}</p>
                                <p class="my-2">{{ $orderlists[0]->order_code }}</p>
                                <p class="my-2">{{ $orderlists[0]->created_at->format('d M , Y') }}</p>
                                <p class="my-2">{{ $order->total_price }} kyats</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="table-responsive table-responsive-data2">

                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th class="col-1">Id</th>
                            <th class="col-2">product image</th>
                            <th class="col-3">product name</th>
                            <th class="col-2">quantity</th>
                            <th class="col-2">Amount</th>

                        </tr>
                    </thead>

                    <tbody id="Tbody">
                        @foreach ($orderlists as $ol)
                        <tr>
                            <td class="col-1">{{ $ol->id }}</td>
                            <td class="col-2"><img src="{{asset('storage/'. $ol->products->image)}}" style="width:90px;height:60px;object-fit:cover"></td>
                            <td>{{ $ol->products->name }}</td>
                            <td class="col-2">{{ $ol->qty }}</td>
                            <td class="col-2">{{ $ol->total }} kyats</td>

                        </tr>
                        <tr class="spacer"></tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <!-- END DATA TABLE -->

        </div>
    </div>
</div>
</div>

@endsection
