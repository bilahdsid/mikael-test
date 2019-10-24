<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        try{
            $user = User::create([
                'email'    => $request->email,
                'name'    => $request->name,
                'password' => bcrypt($request->password),
            ]);

            $token = auth()->login($user);

            return $this->successResponse($this->respondWithToken($token),'sucess');
        }catch (\Exception  $e){
            return $this->errorResponse($e->getMessage());
        }

    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->errorResponse('Unauthorized');
        }

        return $this->successResponse($this->respondWithToken($token),'sucess');
    }

    public function logout()
    {
        auth()->logout();

        return $this->successResponse(true,'Successfully logged out');
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 600
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->successResponse($this->guard()->user(),'Success');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
