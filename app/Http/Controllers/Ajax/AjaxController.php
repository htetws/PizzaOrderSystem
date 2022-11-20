<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function sorting(Request $request)
    {
        $sorting = $request->sorting;

        // logger($request->sorting);

        // same with dd() but useful for api

        if ($sorting == 'desc') {
            $data = Product::orderBy('created_at', 'desc')->get();
        } else {
            $data = Product::orderBy('created_at', 'asc')->get();
        }
        return response()->json($data, 200);
    }

    //orderList

    public function orderList(Request $request)
    {
        $totalPrice = 0;
        foreach ($request->query as $req) {
            $data = OrderList::create([
                'user_id' => $req['user_id'],
                'product_id' => $req['product_id'],
                'qty' => $req['qty'],
                'total' => $req['total'],
                'order_code' => $req['order_code']
            ]);

            $totalPrice += $req['total'];
        }

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $totalPrice + 3000,
        ]);

        Cart::where('user_id', Auth::user()->id)->delete();
        return response()->json(['message' => 'ordered.'], 200);
    }

    //cart
    public function cart(Request $request)
    {
        $query = $this->cartQuery($request);
        Cart::create($query);
        $cartlist = Cart::where('user_id', Auth::user()->id)->get();
        return response()->json($cartlist, 200, ['message' => 'Pizza add to cart successfully.']);
    }

    //remove
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $primaryKey = $request->primary_key;

        Cart::where('product_id', $productId)->where('id', $primaryKey)->where('user_id', Auth::user()->id)->delete();
        return response()->json(['message' => 'removed'], 200);
    }

    //clear
    public function clear()
    {
        Cart::where('user_id', Auth::user()->id)->delete();
        return response()->json(['message' => 'removed'], 200);
    }

    private function cartQuery($request)
    {
        return [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->countId
        ];
    }
}
