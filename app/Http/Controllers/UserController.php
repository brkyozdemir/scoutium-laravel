<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\Services\IUserService;
use App\Models\Invite;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  private $userService;

  public function __construct(IUserService $userService)
  {
    $this->userService = $userService;
  }

  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|min:6|max:12'
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 418);
    }

    dd(config('app.mal'));

    $response = $this->userService->login($request);
    return response(['deneme' => config('db.connection')], 200);
  }

  public function register(Request $request)
  {
    if ($request->token) {
      $validator = Validator::make($request->all(), [
        'password' => 'required|min:6|max:12'
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 418);
      }
    }

    if (!$request->token) {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6|max:12'
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 418);
      }
    }

    $response = $this->userService->register($request);
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

    $response = $this->userService->process_invites($request);
    return response($response, 200);
  }
}
