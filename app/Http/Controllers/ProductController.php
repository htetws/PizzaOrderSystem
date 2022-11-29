<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //product lists
    public function productLists()
    {
        $products = Product::select('products.*', 'categories.cat_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.created_at', 'desc')->when(request('search'), function ($query) {
                $query->where('products.name', 'like', '%' . request('search') . '%');
            })->paginate(10);
        return view('admin.product.list', compact('products'));
    }

    //product create page
    public function productCreatePage()
    {
        $category = Category::select('id', 'cat_name')->get();
        return view('admin.product.create', ['cats' => $category]);
    }

    //product create
    public function productCreate(Request $request)
    {
        $this->productValidation($request, 'create');
        $query = $this->productQuery($request);

        if ($request->hasFile('image')) {
            $imgName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $imgName);
            $query['image'] = $imgName;
        }

        Product::create($query);
        return redirect()->route('product#list')->with('product_create', 'new product added successfully.');
    }

    //product detail
    public function productDetail($id)
    {
        $product = Product::select('products.*', 'categories.cat_name')->where('products.id', $id)
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->first();
        return view('admin.product.detail', compact('product'));
    }

    //product delete
    public function productDelete(Request $request)
    {
        if ($request->id != null) {
            $oldImage = Product::select('image')->where('id', $request->id)->first();
            $oldImage = $oldImage->image;
            Product::where('id', $request->id)->delete();
            Storage::delete('public/' . $oldImage);
            return redirect()->route('product#list')->with('product_delete', 'this product deleted successfully.');
        } else {
            return back();
        }
    }

    //edit page
    public function editPage($id)
    {
        $cats = Category::select('id', 'cat_name')->get(); // id and name of category
        $product = Product::where('id', $id)->first();

        return view('admin.product.edit', compact('cats', 'product'));
    }
    //update
    public function productUpdate(Request $request, $id)
    {
        $this->productValidation($request, 'update', $id);
        $query = $this->productQuery($request);

        if ($request->hasFile('image')) {
            $oldImage = Product::select('image')->where('id', $id)->first();
            $oldImage = $oldImage->image;

            if ($oldImage != null) {
                Storage::delete('public/' . $oldImage);
            }

            $newImage = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $newImage);
            $query['image'] = $newImage;
        }

        Product::where('id', $id)->update($query);
        return redirect()->route('product#list')->with('product_update', 'this product updated successfully.');
    }

    //private fun
    private function productValidation($request, $type, $id = null)
    {
        $validation = [
            'productName' => 'required|unique:products,name,' . $id,
            'waitingTime' => 'required',
            'productDesc' => 'required|min:10',
            'price' => 'required',
            'category' => 'required',
        ];
        $validation['image'] = $type == 'create' ? 'required|mimes:jpg,png,jpeg,webp|file' : 'mimes:jpg,png,jpeg,webp|file';

        Validator::validate($request->all(), $validation);
    }

    private function productQuery($request)
    {
        return [
            'name' => $request->productName,
            'description' => $request->productDesc,
            'price' => $request->price,
            'category_id' => $request->category,
            'waiting_time' => $request->waitingTime
        ];
    }
}
