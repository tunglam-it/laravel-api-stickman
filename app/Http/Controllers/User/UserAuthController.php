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
            'username' => $request->username,
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
        $currentExp = $this->userRepo->find($userId)->exp_profile;
        $currentGold = $this->userRepo->find($userId)->gold;
        $currentEliminatedEnemy = $this->userRepo->find($userId)->eliminated_enemy;
        $currentDiamonds = $this->userRepo->find($userId)->diamonds;
        $data = [
            'gold' => request()->gold+$currentGold,
            'diamonds' => request()->diamonds+$currentDiamonds,
            'passed_stage' => request()->passed_stage,
            'exp_profile' => request()->exp_profile+$currentExp,
            'eliminated_enemy' => request()->eliminated_enemy+$currentEliminatedEnemy,
            'level' => (request()->exp_profile + $currentExp)==0||(floor(((int)request()->exp_profile + $currentExp)/1000)==0)? 1 : floor(((int)request()->exp_profile + $currentExp)/1000)+1
        ];
        return $this->userRepo->update($userId, $data);
    }

}
