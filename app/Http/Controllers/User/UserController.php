<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //homepage  user
    public function user_home_page()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', ['products' => $products, 'categories' => $categories, 'cart' => $cart, 'order' => $order]);
    }

    //category filter
    public function categoryFilter($categoryId)
    {
        $categories = Category::get();
        $products = Product::where('category_id', $categoryId)->orderBy('created_at', 'desc')->get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', ['products' => $products, 'categories' => $categories, 'cart' => $cart, 'order' => $order]);
    }

    //Detail Pizza
    public function pizzaDetail($id)
    {
        $pizza = Product::where('id', $id)->first();
        $pizzaList = Product::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        return view('user.main.detail', compact('pizza', 'pizzaList', 'cart'));
    }

    //change password page
    public function changePasswordPage()
    {
        return view('user.password.change');
    }

    //change password
    public function changePassword(Request $request)
    {
        $this->passwordValidation($request);
        $dbPwd = Auth::user()->password;
        $newPwd = $request->oldpwd;

        if (Hash::check($newPwd, $dbPwd)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newpwd)
            ]);
            return back()->with('pwd_changed', 'changed password successfully.');
        } else {
            return back()->with('change_err', 'old password is not match.try again.');
        }
    }

    //cart list
    public function cartlist()
    {
        $cartlist = Cart::select('carts.*', 'products.name as product_name', 'products.price as product_price', 'products.image')->leftJoin('products', 'products.id', 'carts.product_id')->orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();

        $totalPrice = 0;
        foreach ($cartlist as $cl) {
            $totalPrice += $cl->product_price * $cl->qty;
        }
        return view('user.cart.list', compact('cartlist', 'totalPrice'));
    }

    //profile page
    public function profilePage()
    {
        return view('user.profile.detail');
    }

    //edit page
    public function profileEdit()
    {
        return view('user.profile.edit');
    }

    //update page
    public function profileUpdate(Request $request)
    {
        $this->profileValidation($request);
        $query = $this->profileQuery($request);

        if ($request->hasFile('image')) {
            $old_image = User::select('image')->where('id', Auth::user()->id)->first();
            $old_image = $old_image->image;

            if ($old_image != null) {
                Storage::delete('public/' . $old_image);
            }

            $newImage = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $newImage);
            $query['image'] = $newImage;
        }

        User::where('id', Auth::user()->id)->update($query);
        return back()->with('update_success', 'profile updated successfully.');
    }

    public function orderHistory()
    {
        $order = Order::where('user_id', Auth::user()->id)->paginate(5);
        return view('user.order.list', compact('order'));
    }

    //private functions

    //password validation
    private function passwordValidation($request)
    {
        $validationQuery = [
            'oldpwd' => 'required|min:8',
            'newpwd' => 'required|min:8',
            'confirmpwd' => 'required|min:8|same:newpwd'
        ];

        Validator::validate($request->all(), $validationQuery);
    }

    // profile validaton
    private function profileValidation($request)
    {
        $validation = [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'gender' => 'required'
        ];
        Validator::validate($request->all(), $validation);
    }

    // query for profile
    private function profileQuery($request)
    {
        return [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
        ];
    }
}
