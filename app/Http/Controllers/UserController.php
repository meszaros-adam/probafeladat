<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'fullName' => 'required|min:4',
            'password' => 'required|confirmed'
        ]);

        return User::create([
            'email' => $request->email,
            'fullName' => $request->fullName,
            'password' => Hash::make($request->password),
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'required|boolean',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return response('Successful login!', 200);
        } else {
            return response('Login failed!', 401);
        }
    }
}
