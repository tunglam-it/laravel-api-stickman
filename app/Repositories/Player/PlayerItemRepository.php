<?php

namespace App\Repositories\Player;

use App\Http\Resources\Player\ItemCurrentInfoResource;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\User;
use App\Repositories\BaseRepository;

class PlayerItemRepository extends BaseRepository implements PlayerRepositoryInterface
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

    /***
     * get all item raw
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemRaw()
    {
        $itemsRaw = Item::all();
        return response()->json([
            'data' => $itemsRaw,
        ]);
    }

    /***
     * update status item
     * @param $itemId
     * @param $statusItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatusItem($itemId, $statusItem)
    {
        $item = ItemUser::find($itemId);
        if ($item) {
            $item->update([
                'status' => $statusItem
            ]);
            return response()->json([
                'data' => new ItemCurrentInfoResource($item)
            ]);
        }
        return response()->json([
            'error' => 'Update Status Failed !!!'
        ]);
    }

    /***
     * upgrade stat, level of item and gold of user
     * @param $itemId
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function upgradeItem($itemId)
    {
        $itemCurrent = ItemUser::find($itemId);
        $userId = $itemCurrent->user_id;
        $itemRaw = $itemCurrent->item()->first();

        $attributeItem = $this->getAttributeItem($itemCurrent);

        $itemCurrentLevel = $itemCurrent->current_level;
        $itemMaxLevel = $itemRaw->max_level;

        $statItemIncrement = $itemRaw->stat_increment;
        $priceItemIncrement = $itemRaw->price_increment;

        $user = $this->find($userId);
        $goldUser = $user->gold;

        $goldNeeded = $itemCurrentLevel == 1 ? $priceItemIncrement : ($itemCurrentLevel - 1) * $priceItemIncrement;

        if ($itemCurrentLevel < $itemMaxLevel) {
            if ($goldUser > $goldNeeded) {
                $itemCurrent->update([
                    'current_level' => $itemCurrentLevel + 1,
                    $attributeItem => $itemCurrent->$attributeItem + $statItemIncrement
                ]);

                $user->update([
                    'gold' => $goldUser - $goldNeeded
                ]);

                return response()->json([
                    'data'=>[
                        'message' => 'Upgrade Success !!!',
                        'item' => $itemCurrent,
                        'user' => $user
                    ]
                ]);
            } else {
                return response()->json([
                    'error' => "You don't have enough Gold "
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Item Max Level !!!'
            ]);
        }
    }

    /***
     * get attribute item
     * @param $item
     * @return string|void
     */
    public function getAttributeItem($item)
    {
        if ($item->atk > 0) {
            return 'atk';
        } elseif ($item->hp) {
            return 'hp';
        } elseif ($item->body_def) {
            return 'body_def';
        } elseif ($item->head_def) {
            return 'head_def';
        }
    }
}
