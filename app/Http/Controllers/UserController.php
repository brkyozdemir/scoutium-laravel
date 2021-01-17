<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\InviteNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{

  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|min:6|max:12'
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 418);
    }

    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
      return response([
        'message' => ['These credentials do not match our records.']
      ], 404);
    }

    $token = $user->createToken('scoutium')->plainTextToken;

    $response = [
      'user' => $user,
      'token' => $token
    ];

    return response($response, 200);
  }

  public function register(Request $request)
  {

    if ($request->token) {
      return $this->registration($request->token, $request);
    }

    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|min:6|max:12'
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 418);
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

    return response($response, 201);
  }

  public function process_invites(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email|unique:users,email'
    ]);
    $validator->after(function ($validator) use ($request) {
      if (Invite::where('email', $request->input('email'))->exists()) {
        $validator->errors()->add('email', 'There exists an invite with this email!');
      }
    });
    if ($validator->fails()) {
      return response()->json($validator->errors(), 418);
    }
    do {
      $token = Str::random(20);
    } while (Invite::where('token', $token)->first());

    Notification::route('mail', $request->email)->notify(new InviteNotification($token));
    Invite::create([
      'token' => $token,
      'email' => $request->input('email')
    ]);

    return ['success' => 'The Invite has been sent successfully'];
  }

  public function registration($token, $request)
  {
    $invite = Invite::where('token', $token)->first();
    $validator = Validator::make($request->all(), [
      'password' => 'required|min:6|max:12'
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 418);
    }

    $request['password'] = bcrypt($request['password']);
    $user = [
      'name' => $request->name,
      'email' => $invite->email,
      'password' => $request->password
    ];
    User::create($user);

    $response = [
      'success' => 'User successfully created with token!'
    ];

    return response($response, 201);
  }
}
