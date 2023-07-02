<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Resources\Player\ItemInfoResource;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\User;
use App\Repositories\Player\PlayerItemRepository;


class PlayerItemController extends Controller
{
    private $playerItemRepo;

    public function __construct(PlayerItemRepository $playerItemRepo)
    {
        $this->playerItemRepo = $playerItemRepo;
    }

    /***
     * get all items of user by $userId
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemUser()
    {
        $userId = request()->userId;
        $allItem = $this->playerItemRepo->getAllItems($userId);
        return response()->json([
            'data' => $allItem
        ]);
    }

    /***
     * get all items of user by $userId
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemRaw()
    {
        return $this->playerItemRepo->getAllItemRaw();
    }

    /***
     * update status of item & hp, atk, def with 1-onbody, 2-invent
     * @param $userId
     * @return mixed
     */
    public function updateStatusItem()
    {
        $statusItem = request()->status;
        $itemId = request()->itemId;
        return $this->playerItemRepo->updateStatusItem($itemId, $statusItem);
    }

    /***
     * upgrade stats, level of item and gold of user
     * @return \Illuminate\Http\JsonResponse
     */
    public function upgradeItem()
    {
        $itemId = request()->itemId;
        $userId = request()->userId;

        return $this->playerItemRepo->upgradeItem($itemId);
    }


    public function openChest()
    {

    }
}
