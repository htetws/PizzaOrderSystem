<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //initial state authentication
    public function AuthOrNot()
    {
        if (!Auth::user()) {
            return redirect()->route('auth#login');
        } else {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('category#list');
            } else {
                return redirect()->route('user#home');
            }
        }
    }
    //login
    public function login()
    {
        return view('auth.login');
    }
    //register
    public function register()
    {
        return view('auth.register');
    }
}
