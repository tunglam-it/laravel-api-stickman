<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Repositories\Admin\AdminAuthRepository;


class AdminAuthController extends Controller
{
    protected $adminAuthRepo;

    public function __construct(AdminAuthRepository $adminAuthRepo)
    {
        $this->adminAuthRepo = $adminAuthRepo;
    }

    /***
     * Login admin
     * @param AdminLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AdminLoginRequest $request)
    {
        $dataLogin = $request->all();
        return $this->adminAuthRepo->handleLogin($dataLogin);
    }

    /***
     * Logout admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->adminAuthRepo->handleLogout();
    }

    /***
     * respond with token
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
        ]);
    }

    /***
     * refresh token
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json($this->respondWithToken(auth()->refresh()));
    }

}
