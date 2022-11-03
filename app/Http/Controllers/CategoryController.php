<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function list(Request $request)
    {
        $cats = Category::when(request('search'), function ($query) {
            $query->where('cat_name', 'like', '%' . request('search') . '%');
        })->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.category.list', compact('cats'));
    }
    public function create(Request $request)
    {
        $this->validation($request);
        Category::create(['cat_name' => $request->name]);
        return redirect()->route('category#list')->with('create_msg', 'new category created successfully.');
    }
    public function delete(Request $request)
    {
        Category::where('id', $request->id)->delete();
        return redirect()->route('category#list')->with('delete_msg', 'that category deleted successfully.');
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        $this->validation($request, $id);
        Category::where('id', $id)->update(['cat_name' => $request->name]);
        return redirect()->route('category#list')->with('update_msg', 'that category updated successfully.');
    }

    //private function
    private function validation($request, $id = null) //initial value null
    {
        Validator::validate($request->all(), [
            'name' => 'required|unique:categories,cat_name,' . $id
        ]);
    }
}
