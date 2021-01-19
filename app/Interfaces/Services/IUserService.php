<?php

namespace App\Interfaces\Services;

use Illuminate\Http\Request;

interface IUserService
{
    public function login(Request $request);
    public function register(Request $request);
    public function process_invites(Request $request);
    public function register_with_token($token, Request $request);
}
