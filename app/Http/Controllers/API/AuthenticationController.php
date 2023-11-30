<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends BaseController
{
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function register(CustomerRequest $request): JsonResponse
    {

        $payload = $request->validated();
        $customerRole = Role::where('name', 'Customer')->first();
        $payload['role_id'] = $customerRole->id;

        $customer = User::create($payload);

        return $this->sendResponse($customer, 'Registered successfully.');
    }

    public function me(Request $request): JsonResponse
    {
        return $this->sendResponse($request->user(), 'User Fetched Successfully.');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->sendResponse(["success"], 'User Logout Successffuly.');
    }
}
