<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
