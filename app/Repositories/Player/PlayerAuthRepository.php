<?php

namespace App\Repositories\Player;

use App\Models\Item;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class PlayerAuthRepository extends BaseRepository implements PlayerRepositoryInterface
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
     * register new player
     * @param $playerRegister
     * @return \Illuminate\Http\JsonResponse
     */
    public function register($playerRegister)
    {
        $registerPlayer = $this->create($playerRegister);
        $item = Item::find(1);
        $itemAttribute = [
            'atk' => $item->atk,
            'hp' => $item->hp,
            'body_def' => $item->body_def,
            'head_def' => $item->head_def,
            'status' => 2,
            'current_level' => 1,
            'user_id' => $registerPlayer->id
        ];
        $item->items()->create($itemAttribute);
        return response()->json([
            'message' => 'Register Success !!!',
            'player' => $registerPlayer
        ], 201);
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
                return response()->json(['error' => 'Username or Password is not valid'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token']);
        }
        return response()->json(['user_data' => auth()->user(), 'token' => $token]);
    }

    /***
     * logout player
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleLogout()
    {
        auth()->logout();
        return response()->json(['message' => 'Player Logout']);
    }

    /***
     * get all items of user by $userId
     * @param $userId
     * @return mixed
     */
    public function getAllItems($userId)
    {
        $user = $this->find($userId);
        $allItem = $user->items()->get();
        return $allItem;
    }
}
