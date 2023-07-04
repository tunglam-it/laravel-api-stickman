<?php

namespace App\Repositories\User;

use App\Http\Resources\Player\ItemCurrentInfoResource;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;
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
    public function getAllUser($username, $start_date, $end_date, $status)
    {
        $users = User::query();
        if ($username) {
            $users = $users->whereNotIn('username', ['admin'])->where('username', 'like', '%' . $username . '%')->orderByDesc('id');
        } else {
            $users = $users->whereNotIn('username', ['admin'])->orderByDesc('id');
        }
        if ($start_date && $end_date) {
            $users->whereBetween('created_at',[$start_date, $end_date]);
        }
        if ($status) {
            $users->where('status', $status);
        }

        $usersPaginate = $users->paginate(5)->toArray();
        $usersFields = ['current_page', 'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total'];
        $response = [
            'data' => ($usersPaginate['data']),
            'pagination' => Arr::only($usersPaginate, $usersFields)
        ];
        return response()->json($response, 200);
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
            if(auth()->user()->status==2) {
                return response()->json(['error' => 'Account has been Blocked'], 401);
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
