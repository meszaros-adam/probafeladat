<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $this->validate($request,[
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
}
