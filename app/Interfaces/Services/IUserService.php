<?php

namespace App\Interfaces\Services;

use Illuminate\Http\Request;

interface IUserService
{
    public function login(Request $request);
    public function register(Request $request);
    public function processInvites(Request $request);
    public function registerWithToken($token, Request $request);
}
