<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected function create(array $data)
    {
        $invite = Invite::where('token', $data['token'])->first();
        $invite->delete();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
