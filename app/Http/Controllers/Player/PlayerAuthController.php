<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Player\PlayerLoginRequest;
use App\Http\Requests\Player\PlayerRegisterRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class PlayerAuthController extends Controller
{
    private $playerRepo;

    public function __construct(UserRepository $playerRepo)
    {
        $this->playerRepo = $playerRepo;
    }

    /***
     * register a new Player
     * @param PlayerRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(PlayerRegisterRequest $request)
    {
        $player = [
            'username' => request()->username,
            'password' => Hash::make(request()->password),
        ];
        return $this->playerRepo->registerUser($player);
    }

    /***
     * Player Login
     * @param PlayerLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(PlayerLoginRequest $request)
    {
        $credentials = $request->only('username', 'password');
        return $this->playerRepo->handleLogin($credentials);
    }

    public function changeStatus($userId)
    {
        $status = request()->status;
        $this->playerRepo->update($userId, ['status'=>$status]);
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
        return $this->playerRepo->handleLogout();
    }

}
