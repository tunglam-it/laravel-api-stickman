<?php

namespace App\Repositories\User;

use App\Models\Item;
use App\Models\User;
use App\Repositories\BaseRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
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
     * get all info users
     * @param $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUser($username, $start_date, $end_date, $status,$start_level, $end_level, $start_gold, $end_gold, $start_diamonds, $end_diamonds)
    {
        $users = User::query();
        if ($username) {
            $users = $users->whereNotIn('username', ['admin'])->where('username', 'like', '%' . $username . '%')->orderBy('id');
        } else {
            $users = $users->whereNotIn('username', ['admin'])->orderBy('id');
        }
        if ($start_date && $end_date) {
            $users->whereBetween('created_at',[$start_date, $end_date]);
        }
        if ($start_gold && $end_gold) {
            $users->whereBetween('gold',[$start_gold, $end_gold]);
        }
        if ($start_level && $end_level) {
            $users->whereBetween('level',[$start_level, $end_level]);
        }
        if ($start_diamonds && $end_diamonds) {
            $users->whereBetween('diamonds',[$start_diamonds, $end_diamonds]);
        }
        if ($status) {
            $users->where('status', $status);
        }

        $response = [
            'data' => ($users->paginate(5)),
        ];
        return response()->json($response, 200);
    }

    /***
     * handle user login
     * @param $credentials
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
        return response()->json(['data' => auth()->user(), 'token' => $token],200);
    }

    /***
     * logout player
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleLogout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logout Success']);
    }

    /***
     * register new player
     * @param $playerRegister
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerUser($playerRegister)
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

}
