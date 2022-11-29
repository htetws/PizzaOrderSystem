<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //contact page
    public function contactPage()
    {
        return view('user.contact.page');
    }

    //contact
    public function contact(Request $request)
    {
        Validator::validate($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Sent message successfully.');
    }

    //admin contact list page
    public function contactListPage()
    {
        $messages = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contact.list', ['messages' => $messages]);
    }
}
