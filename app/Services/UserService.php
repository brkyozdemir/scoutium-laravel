<?php

namespace App\Services;

use App\Jobs\SendOrderEmail;
use App\Models\Invite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Interfaces\Services\IUserService;

class UserService implements IUserService
{

  public function login(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
      return [
        'message' => ['These credentials do not match our records.']
      ];
    }

    $token = $user->createToken('scoutium')->plainTextToken;

    $response = [
      'user' => $user,
      'token' => $token
    ];

    return $response;
  }

  public function register(Request $request)
  {

    if ($request->token) {
      return $this->register_with_token($request->token, $request);
    }

    $request['password'] = bcrypt($request['password']);
    $user = [
      'name' => $request->name,
      'email' => $request->email,
      'password' => $request->password
    ];
    User::create($user);

    $response = [
      'success' => 'User successfully created!'
    ];

    return $response;
  }

  public function process_invites(Request $request)
  {
    
    do {
      $token = Str::random(20);
    } while (Invite::where('token', $token)->first());

    SendOrderEmail::dispatch($token);

    Invite::create([
      'token' => $token,
      'email' => $request->input('email')
    ]);

    if (Mail::failures() != 0) {
      return ['success' => "Success! Your Invitation has been sent."];
    } else {
      return ['failure' => "Failed! Your E-mail has not sent."];
    }
  }

  public function register_with_token($token, Request $request)
  {
    $invite = Invite::where('token', $token)->first();

    $request['password'] = bcrypt($request['password']);
    $user = [
      'name' => $request->name,
      'email' => $invite->email,
      'password' => $request->password
    ];

    $invite->delete();

    User::create($user);

    $response = [
      'success' => 'User successfully created with token!'
    ];

    return $response;
  }
}
