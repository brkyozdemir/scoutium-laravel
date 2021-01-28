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
use App\Models\Wallet as ModelsWallet;
use Wallet;

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
      return $this->registerWithToken($request->token, $request);
    }

    $request['password'] = bcrypt($request['password']);

    $wallet = ModelsWallet::create([
      'amount' => 0,
      'email' => $request->email,
      'currency' => 'TRY'
    ]);

    $user = [
      'currency' => 'TRY',
      'name' => $request->name,
      'email' => $request->email,
      'password' => $request->password,
      'wallet' => $wallet->id,
    ];
    User::create($user);

    $response = [
      'success' => 'User successfully created!'
    ];

    return $user;
  }

  public function processInvites(Request $request)
  {

    do {
      $token = Str::random(20);
    } while (Invite::where('token', $token)->first());

    $to_email = env('MAIL_TO_ADDRESS');
    SendOrderEmail::dispatch($token, $to_email);

    Invite::create([
      'token' => $token,
      'sender' => $request->input('sender'),
      'email' => $request->input('email')
    ]);

    if (Mail::failures() != 0) {
      return ['success' => "Success! Your Invitation has been sent."];
    } else {
      return ['failure' => "Failed! Your E-mail has not sent."];
    }
  }

  public function registerWithToken($token, Request $request)
  {
    $invite = Invite::where('token', $token)->first();

    $request['password'] = bcrypt($request['password']);

    $invitedUserWallet = ModelsWallet::create([
      'amount' => 30,
      'currency' => 'TRY',
      'email' => $invite->email
    ]);

    $user = [
      'currency' => 'TRY',
      'name' => $request->name,
      'email' => $invite->email,
      'password' => $request->password,
      'wallet' => $invitedUserWallet->id,
    ];

    $sender = User::where('email', $invite->sender)->first();
    $senderWallet = ModelsWallet::where('email', $invite->sender)->first();
    $senderWallet->amount += 50;
    $senderWallet->save();

    User::create($user);

    $invite->delete();

    $invitedUser = [
      'name' => $request->name,
      'email' => $invite->email,
      'wallet' => $invitedUserWallet
    ];

    $senderUser = [
      'name' => $sender->name,
      'email' => $sender->email,
      'wallet' => $senderWallet
    ];

    $response = [
      'message' => 'User successfully created with token!',
      'user' => $invitedUser,
      'sender' => $senderUser
    ];

    return $response;
  }
}
