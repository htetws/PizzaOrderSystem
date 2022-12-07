<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function products()
    {
        $products = Product::orderBy('created_at', 'desc')->take(2)->get();
        $categories = Category::get();
        $users = User::get();

        $data = [
            'user' => $users,
            'products' => $products,
            'categories' => $categories
        ];

        return response()->json($data, 200);
    }

    //get contacts
    public function contacts()
    {
        return Contact::get();
    }

    //create contact
    public function contact(Request $request)
    {
        $contact = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];

        return Contact::create($contact);
    }

    //delete contact
    public function delete(Request $request)
    {
        $contact = Contact::where('id', $request->id)->first();
        if (isset($contact)) {
            Contact::where('id', $request->id)->delete();
            return response()->json(['status' => 'delete', 'message' => 'delete success', 'deletedData' => $contact]);
        }
        return response()->json(['status' => 'error', 'message' => 'id not match'], 404);
    }

    //update contact
    public function update(Request $request)
    {
        $contact = Contact::where('id', $request->contactID)->first();
        $query = $this->getContactQuery($request);
        if (isset($contact)) {
            Contact::where('id', $contact->id)->update($query);
            $contact = Contact::where('id', $request->contactID)->first();
            return response()->json(['status' => 'update', 'message' => 'updated successfully.', 'updatedData' => $contact]);
        }
        return response()->json(['status' => 'error', 'message' => 'content id not match'], 404);
    }


    //private get contact query
    private function getContactQuery($request)
    {
        return [
            'name' => $request->contactName,
            'email' => $request->contactEmail,
            'message' => $request->contactMessage,
            'updated_at' => Carbon::now()
        ];
    }
}
