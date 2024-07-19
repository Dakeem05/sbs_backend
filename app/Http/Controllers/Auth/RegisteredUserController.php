<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistration;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterUserRequest;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Traits\Api\V1\ApiResponseTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    use ApiResponseTrait;
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request)
    {
        $_data = $request->validated();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);

        $otp = PasswordResetToken::GenerateOtp($user->email);

        event(new UserRegistration($otp, $user->last_name, $user->email));

        $token = Auth::login($user);

        return $this->successResponse([
            "token" => $token
        ], "Signup successful", 201);
    }
}
