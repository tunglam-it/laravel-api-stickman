<?php

namespace App\Repositories\Admin;

use App\Http\Resources\Admin\UserInfoResource;
use App\Models\User;
use App\Repositories\BaseRepository;

class AdminCRUDRepository extends BaseRepository implements AdminRepositoryInterface
{

    /***
     * get model
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    public function getAllUser($username)
    {
        if ($username) {
            $users = User::whereNotIn('username', ['admin'])->where('username', 'like', '%' . $username . '%')->orderBy('id')->get();
        } else {
            $users = User::whereNotIn('username', ['admin'])->orderBy('id')->get();
        }
        return response()->json([
            'data' => UserInfoResource::collection($users)
        ], 200);
    }


}
