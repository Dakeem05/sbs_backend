<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\RegisterUserRequest;
use App\Http\Requests\Api\V1\RegistrationVerifyRequest;
use App\Http\Requests\Api\V1\VerifyForgotPassword;
use App\Models\User;
use App\Services\Api\V1\AuthenticationService;
use App\Services\Api\V1\MiddeyService;
use App\Traits\Api\V1\ApiResponseTrait;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    use ApiResponseTrait;
    // public function register (RegisterUserRequest $request, MiddeyService $middey_service)
    // {
    //     $_data = $request->validated();

    //     $data = array(
    //         "first_name"=> $_data['first_name'],
    //         "last_name"=> $_data['last_name'],
    //         "email"=> $_data['email'],
    //         "password"=> $_data['password'],
    //     );
    //     $request = $middey_service->middey('auth/register/user', $data);
    //     $res = json_decode($request, true);
    //     return $res['data']['role']['uuid'];
    //     return response()->json([
    //         // 'role' => $request['role'],
    //         'role' => $request->role,
    //         // 'uuid' => $request['role']['uuid'],
    //         // 'uuid' => $request['role']->uuid
    //     ]);
    // }

    public function resend(String $email, AuthenticationService $auth_service)
    {
        $_data = (Object) array(
            "email" => $email,
        );

        $request = $auth_service->resend($_data);
        // return $request;
        if ($request) {
            return $this->successResponse("The otp has been resent.", 201);
        } else{
            return $this->serverErrorResponse('Email does not exist.');
        }
    }

    public function verify (RegistrationVerifyRequest $request, AuthenticationService $auth_service)
    {
        $_data = (Object) $request->validated();

        $request = $auth_service->verify($_data);
        
        if ($request) {
            return $this->successResponse("Registration successful.");
        } else{
            return $this->serverErrorResponse('Wrong code? Resend.');
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request, AuthenticationService $auth_service)
    {
        $_data = (Object) $request->validated();

        $request = $auth_service->forgotPassword($_data);
        
        if ($request) {
            return $this->successResponse("Sent, check your mail");
        } else{
            return $this->serverErrorResponse('Something went wrong');
        }
       
    }

    public function resendForgotPassword(ForgotPasswordRequest $request, AuthenticationService $auth_service)
    {
        $_data = (Object) $request->validated();

        $request = $auth_service->forgotPassword($_data);
        
        if ($request) {
            return $this->successResponse("The otp has been resent.");
        } else{
            return $this->serverErrorResponse('Email does not exist');
        }
    }

    public function verifyForgotPassword (RegistrationVerifyRequest $request, AuthenticationService $auth_service)
    {
        $_data = (Object) $request->validated();

        $request = $auth_service->verifyForgot($_data);
        
        if ($request) {
            return $this->successResponse("Verification successful.");
        } else{
            return $this->serverErrorResponse('Wrong code? Resend.');
        }
    }

    public function changePassword (VerifyForgotPassword $request, AuthenticationService $auth_service)
    {
        $_data = (Object) $request->validated();

        $request = $auth_service->changePassword($_data);
        
        if ($request) {
            return $this->successResponse("Password changed.");
        } else{
            return $this->serverErrorResponse('An error occurred.');
        }

    }

    public function getUser()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user) {
            return $this->successResponse($user, 'User data', 200);
        } else {
            return $this->unauthorizedResponse('Unauthorized');
        }
    }
}
