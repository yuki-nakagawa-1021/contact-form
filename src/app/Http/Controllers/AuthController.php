<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->only(['name', 'email', 'password']);

        User::create($user);

        return view('/admin');
    }
}
