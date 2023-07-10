<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class AdminCRUDController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /***
     * get all info users, search & paginate
     * @return mixed
     */
    public function index()
    {
        $username = request()->input('username');
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');
        $status = request()->input('status');
        $start_level = request()->input('start_level');
        $end_level = request()->input('end_level');
        $start_gold = request()->input('start_gold');
        $end_gold = request()->input('end_gold');
        $start_diamonds = request()->input('start_diamonds');
        $end_diamonds = request()->input('end_diamonds');
        return $this->userRepo->getAllUser($username, $start_date, $end_date, $status,$start_level, $end_level, $start_gold, $end_gold, $start_diamonds, $end_diamonds);
    }

    /***
     * get info user by userId
     * @param $userId
     * @return mixed
     */
    public function userInfo($userId)
    {
        return $this->userRepo->find($userId);
    }

    /***
     * admin update user by userId
     * @param Request $request
     * @param $userId
     * @return false|mixed
     */
    public function updateUser(Request $request, $userId)
    {
        $exp_profile = (int)$request->exp_profile;
        $dataUpdate = [
            'gold' => $request->gold,
            'diamonds' => $request->diamonds,
            'energy' => $request->energy,
            'exp_profile' => $exp_profile,
            'level' => $exp_profile===0 ? 1 : floor($exp_profile / 1000)
        ];
        return $this->userRepo->update($userId, $dataUpdate);
    }

    /***
     * delete user
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($userId)
    {
        if(!$this->userRepo->delete($userId)){
            return response()->json([
                'error'=>'Delete User Failed !!!'
            ]);
        }
        return response()->json([
            'message'=>'Delete User Success !!!'
        ]);
    }

}

