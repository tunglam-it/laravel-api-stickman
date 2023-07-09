<?php

namespace App\Repositories\Item;

use App\Http\Resources\Player\ItemCurrentInfoResource;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\User;
use App\Repositories\BaseRepository;

class ItemRepository extends BaseRepository implements ItemRepositoryInterface
{

    /***
     * get model
     * @return string
     */
    public function getModel()
    {
        return Item::class;
    }

    /***
     * get all info users
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemInfo($name, $rarity, $type)
    {
        $items = Item::query();
        if ($name) {
            $items = $items->where('name', 'like', '%' . $name . '%')->orderBy('id');
        } else {
            $items = $items->orderBy('id');
        }
        if ($rarity) {
            $items = $items->where('rarity', $rarity);
        }
        if ($type) {
            $items = $items->where('type', $type);
        }
        $response = [
            'data' => $items->paginate(8),
        ];
        return response()->json($response, 200);
    }

    /***
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemUsers()
    {
        return response()->json([
            'data' => ItemCurrentInfoResource::collection(ItemUser::all())
        ]);
    }

    /***
     * get all items of user by $userId
     * @param $userId
     * @return mixed
     */
    public function getAllItemsUserById($userId)
    {
        $user = User::find($userId);
        $allItem = $user->items()->get();
        return $allItem;
    }

    /***
     * get all item raw
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemRaw()
    {
        $itemsRaw = $this->getAll();
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
        $itemCurrent = ItemUser::find($itemId); //item của user hiện đang upgrade
        $itemRaw = $itemCurrent->item()->first();//lấy info của item gốc

        $attributeItem = $this->getAttributeItem($itemCurrent);//lấy tên của chỉ số của item(hp, atk)

        $itemCurrentLevel = $itemCurrent->current_level;//lấy level của item của user

        $priceItemIncrement = $itemRaw->price_increment;//lấy giá tiền

        $user = $this->find($itemCurrent->user_id);//lấy info user
        $goldUser = $user->gold;//lấy gold hiện tại của user

        // dựa vào giá tiền để tính số gold cần để nâng cấp, mỗi cấp sẽ cộng dồn $priceItemIncrement
        $goldNeeded = $itemCurrentLevel == 1 ? $priceItemIncrement : ($itemCurrentLevel - 1) * $priceItemIncrement;

        if ($itemCurrentLevel < $itemRaw->max_level) {//nếu item max level thì noti k upgrade đc
            if ($goldUser > $goldNeeded) {//nếu thiếu gold thì k upgrade đc
                $itemCurrent->update([
                    'current_level' => $itemCurrentLevel + 1,//click 1 lần tăng 1 cấp
                    $attributeItem => $itemCurrent->$attributeItem + $itemRaw->stat_increment//tăng luôn chỉ số item của user
                ]);
                $user->update([
                    'gold' => $goldUser - $goldNeeded//update lại số gold user sau mỗi click upgrade
                ]);
                return response()->json([
                    'data' => [
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
     * give item for user
     * @param $itemRawId
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function giveItemForUser($itemRawId, $userId)
    {
        $item = $this->find($itemRawId);
        $itemAttribute = [
            'atk' => $item->atk,
            'hp' => $item->hp,
            'body_def' => $item->body_def,
            'head_def' => $item->head_def,
            'status' => 2,
            'current_level' => 1,
            'user_id' => $userId
        ];
        $itemGave = $item->items()->create($itemAttribute);
        return response()->json([
            'data' => $itemGave
        ]);
    }

    public function updateItemInfo($itemId, $dataUpdate)
    {
        $this->update($itemId, $dataUpdate);//update lại data cho item gốc
        $itemsUsers = ItemUser::all();//lấy list items của mọi user
        $itemRaw = $this->find($itemId);//lấy info item gốc
        $rarityRaw= $itemRaw->rarity;//lấy rarity của item gốc
        $attributeItemRaw = $this->getAttributeItem($itemRaw);//lấy tên chỉ số của item gốc (atk, hp,....)
        $statItemIncrement = $itemRaw->stat_increment;//lấy độ tăng chỉ số khi upgrade của item gốc

         foreach ($itemsUsers as $itemUser) {//quét mảng
             $rarityItemUser = ItemUser::find($itemUser->item_id)->item->rarity;//lấy rarity của item của user hiện tại
             $attributeItemUser = $this->getAttributeItem($itemUser);//lấy tên chỉ số của item của user
             if($attributeItemRaw == $attributeItemUser && $rarityRaw==$rarityItemUser){//nếu cùng rarity và tên chỉ số mới thực hiện
                 $itemUser->update([
                     $attributeItemUser => $dataUpdate[$attributeItemUser] + $statItemIncrement * ($itemUser->current_level-1)//update lại chỉ số item user sau khi chỉnh sửa chỉ số item gốc
                 ]);
             }
         }
         return response()->json([
             'data'=>[
                 'message'=>'ok'
             ]
         ]);
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
        } elseif ($item->hp > 0) {
            return 'hp';
        } elseif ($item->body_def > 0) {
            return 'body_def';
        } elseif ($item->head_def > 0) {
            return 'head_def';
        }
    }
}
