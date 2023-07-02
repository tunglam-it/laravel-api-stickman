<?php

namespace App\Repositories\Admin;

use App\Models\User;
use App\Repositories\BaseRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthRepository extends BaseRepository implements AdminRepositoryInterface
{

    /***
     * get model
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    /***
     * handle login for admin
     * @param $dataLogin
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleLogin($credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Username or Password is not valid'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token']);
        }
        return response()->json(['data' => auth()->user(), 'token' => $token],200);
    }

    /***
     * logout player
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleLogout()
    {
        auth()->logout();
        return response()->json(['message' => 'Admin Logout']);
    }
}
