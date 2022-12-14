<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function listPage()
    {

        // dd(Str::slug("this is the title."));

        $order = Order::when(request('search'), function ($query) {
            $query->orWhere('users.name', 'like', '%' . request('search') . '%')
                ->orWhere('orders.order_code', 'like', '%' . request('search') . '%');
        })->select('orders.*', 'users.name as user_name')->leftJoin('users', 'users.id', 'orders.user_id')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.order.list', compact('order'));
    }

    public function orderList(Request $request)
    {

        $status = $request->OrderStatus;
        $order = Order::select('orders.*', 'users.name as user_name')->leftJoin('users', 'users.id', 'orders.user_id');

        if ($status == null) {
            $order = $order->paginate(10);
        } else {
            $order = $order->where('status', $status)->paginate(10);
        }
        return view('admin.order.list', compact('order'));
        // return response()->json($order, 200);
    }

    public function status(Request $request)
    {
        $data = Order::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json($data, 200);
    }

    //find item with order code
    public function itemPage($order_code)
    {
        $order = Order::where('order_code', $order_code)->first();
        $orderlists = OrderList::select('order_lists.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'order_lists.user_id')
            ->where('order_code', $order_code)->get();
        return view('admin.order.item', compact('orderlists', 'order'));
    }
}
