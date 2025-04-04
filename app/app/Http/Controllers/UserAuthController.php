<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class UserAuthController extends BaseApiController
{
    /**
     * Register user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', (array)$validator->errors());
        }

        if (User::where('email', $request->email)->exists()) {
            return $this->sendError('Email already in use.', ['email' => ['This email is already registered.']]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken(env("TOKEN_ID"))->plainTextToken;
        $success['name'] = $user->name;
        $success['email'] = $user->email;

        return $this->sendResponse($success, 'User register successfully.');
    }


    /**
     * Login to the API to get the Sanctum Token.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken(env("TOKEN_ID"))->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
