@extends('layout.user_master')

@section('title','Pizza | Cart List')

@section('content')

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="Table">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($cartlist as $cl)
                    <tr>
                        <input type="hidden" value="{{ $cl->id }}" id="CartListId">
                        <input type="hidden" value="{{ $cl->product_id }}" id="productId">
                        <input type="hidden" value="{{Auth::user()->id}}" id="userId">
                        <input type="hidden" value="{{$cl->product_price}}" id="pricePizza">

                        <td class="align-middle text-start"><img src="{{ asset('storage/'.$cl->image) }}" class="me-5 rounded-1 img-thumbnail" style="width: 5rem;object-fit:cover">{{ $cl->product_name }}</td>
                        <td class="align-middle">{{ $cl->product_price }} kyats</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="{{ $cl->qty }}" id="qty">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle" id="total">{{ $cl->product_price * $cl->qty }} kyats</td>
                        <td class="align-middle"><button id="remove" class="btn btn-sm btn-danger remove"><i class="fa fa-times"></i></button></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="subTotal">{{ $totalPrice }} kyats</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">3000 kyats</h6>
                    </div>
                </div>
                <div class="pt-2" id="div1">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="finalPrice">{{ $totalPrice + 3000 }} kyats</h5>
                    </div>
                    <button id="orderBtn" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                    <button id="clearCart" class="btn btn-block btn-danger font-weight-bold my-3 py-3">Clear Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection

@section('json')
<script src="{{ asset('js/cart.js') }}"></script>
<script>
    $(document).ready(function() {

        //remove current product
        $(".remove").click(function() {
            $parentNode = $(this).parents("tr");
            $parentNode.remove();
            $total = 0;
            $("tr").each(function(index, row) {
                $total += Number($(row).find("#total").text().replace("kyats", ""));
            });

            $("#subTotal").text(`${$total} kyats`);
            $("#finalPrice").text(`${$total + 3000} kyats`);

            $.ajax({
                type: 'get',
                url: "{{ route('ajax#remove') }}",
                data: {
                    'product_id': $parentNode.find('#productId').val(),
                    'primary_key': $parentNode.find('#CartListId').val(),
                },
                dataType: 'json',
                success: (data) => {
                    console.log(data);
                }
            })
        });

        //clear cart
        $('#clearCart').click(() => {
            $("tbody tr").remove()
            $.ajax({
                type: 'get',
                url: "{{route('ajax#clear')}}",
                dataType: 'json'
            })
        })

        // Order process

        $('#orderBtn').click(function() {

            if ($('tbody tr').length != 0) {
                if (confirm('Are you sure want to order ?')) {
                    $order_code = Math.random().toString(16).slice(2) + Math.floor(Math.random() * 552001);

                    $query = [];

                    $('tbody tr').each(function(index, row) {
                        $product_id = $(row).find('#productId').val()
                        $user_id = $(row).find('#userId').val()
                        $total = $(row).find('#total').text().replace('kyats', '') * 1
                        $qty = $(row).find('#qty').val()

                        $query.push({
                            'product_id': $product_id,
                            'user_id': $user_id,
                            'total': $total,
                            'qty': $qty,
                            'order_code': $order_code
                        })

                    })

                    $.ajax({
                        type: 'get',
                        url: "{{ route('ajax#orderList') }}",
                        // data: Object.assign({}, $query),
                        data: {
                            ...$query
                        },
                        dataType: 'json',
                        success: (data) => {
                            // console.log(data);
                            if (data) {
                                toastr.success('order done.wait for accepting your order from admin team.')
                            }
                            setTimeout(function() {
                                window.location.replace("{{ route('user#home') }}");
                            }, 2500)
                        }
                    })
                }
            } else {
                alert("choose atleast one item plz.")
                window.location.href = "{{route('user#home')}}"
            }

        })
    })
</script>
@endsection
