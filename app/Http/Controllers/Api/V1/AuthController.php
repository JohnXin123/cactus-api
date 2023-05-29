<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{   
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $token = $user->createToken('API Token')->accessToken;

            return response()->success($token, "Successfully Authenticated", 200);

        }

        return response()->error("Unauthorized", 401);
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userRepository->storeUser($validated);

        if ($user) {
            return response()->success(null, "Successfully Registered", 200);

        } else {
            return response()->error("User Register Failed", 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->success(null, "Successfully Logout", 200);
    }
}
