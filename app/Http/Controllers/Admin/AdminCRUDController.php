<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminCRUDRepository;
use Illuminate\Http\Request;

class AdminCRUDController extends Controller
{
    protected $adminCRUDRepo;

    public function __construct(AdminCRUDRepository $adminCRUDRepo)
    {
        $this->adminCRUDRepo = $adminCRUDRepo;
    }

    /***
     * @return mixed
     */
    public function index()
    {
        $username = request()->input('username');
        return $this->adminCRUDRepo->getAllUser($username);
    }

    /***
     * get info user by userId
     * @param $userId
     * @return mixed
     */
    public function userInfo($userId)
    {
        return $this->adminCRUDRepo->find($userId);
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
            'level' => floor($exp_profile / 500)
        ];
        return $this->adminCRUDRepo->update($userId, $dataUpdate);
    }


    public function deleteUser($userId)
    {
        if(!$this->adminCRUDRepo->delete($userId)){
            return response()->json([
                'error'=>'Delete User Failed !!!'
            ]);
        }
        return response()->json([
            'message'=>'Delete User Success !!!'
        ]);
    }

}

