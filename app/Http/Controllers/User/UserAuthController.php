<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /***
     * register a new Player
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        $player = [
            'username' => request()->username,
            'password' => Hash::make(request()->password),
        ];
        return $this->userRepo->registerUser($player);
    }

    /***
     * Player Login
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('username','password');
        return $this->userRepo->handleLogin($credentials);
    }

    /***
     * active or unactive user
     * @param $userId
     * @return mixed
     */
    public function changeStatus($userId)
    {
        $status = request()->status;
        $this->userRepo->update($userId, ['status'=>$status]);
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

    /***
     * logout
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->userRepo->handleLogout();
    }

    public function updateUserAfterBattle()
    {
        $userId = request()->userId;
        $data = ['gold' => request()->gold,
            'diamonds' => request()->diamonds,
            'passed_stage' => request()->passed_stage,
            'exp_profile' => request()->exp_profile,
            'eliminated_enemy' => request()->eliminated_enemy,
            'level' => (int)request()->exp_profile==0? 1 : floor((request()->exp_profile)==0/500),];
        return $this->userRepo->update($userId, $data);
    }

}
