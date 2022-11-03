<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function user_home_page()
    {
        return view('user.welcome');
    }
}
