<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Chest;
use App\Models\Item;
use App\Models\User;
use App\Repositories\Item\ItemRepository;
use App\Repositories\ItemUser\ItemUserRepository;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemRepo;
    protected $itemUserRepo;

    public function __construct(ItemRepository $itemRepo, ItemUserRepository $itemUserRepo)
    {
        $this->itemRepo = $itemRepo;
        $this->itemUserRepo = $itemUserRepo;
    }

    /***
     * create new item
     * @param Request $request
     * @return mixed
     */
    public function createNewItem(Request $request)
    {
        $dataInsert = $request->all();
        return $this->itemRepo->create($dataInsert);
    }

    /***
     * get all info of items
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemInfo()
    {
        $name = request()->input('name');
        $rarity = request()->input('rarity');
        $type = request()->input('type');
        return $this->itemRepo->getAllItemInfo($name, $rarity, $type);
    }

    /***
     * test
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemUsers()
    {
        $playerName = request()->input('playerName');
        $itemName = request()->input('itemName');
        $rarityItem = request()->input('rarityItem');
        $typeItem = request()->input('typeItem');
        $start_level = request()->input('start_level');
        $end_level = request()->input('end_level');
        $status = request()->input('status');
        return $this->itemUserRepo->getAllItemUsers($playerName, $itemName, $rarityItem, $typeItem, $start_level, $end_level, $status);
    }

    /***
     * get all items of user by $userId
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemUserById($userId)
    {
        $allItem = $this->itemRepo->getAllItemsUserById($userId);
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
        return $this->itemRepo->getAllItemRaw();
    }

    public function getItemInfo($itemId)
    {
        return $this->itemRepo->find($itemId);
    }

    /***
     * update item info
     * @param Request $request
     * @param $itemid
     * @return false|mixed
     */
    public function updateItemInfo(Request $request, $itemId)
    {
        $dataUpdate = $request->except('id');
        return $this->itemRepo->updateItemInfo($itemId, $dataUpdate);
    }

    /***
     * update status of item & hp, atk, def with 1-onbody, 2-invent
     * @param $userId
     * @return mixed
     */
    public function updateStatusItem()
    {
        $oldItemId = request()->oldItemId;
        $newItemId = request()->newItemId?request()->newItemId:'';
        return $this->itemUserRepo->updateStatusItem($oldItemId,$newItemId);
    }

    /***
     * upgrade stats, level of item and gold of user
     * @return \Illuminate\Http\JsonResponse
     */
    public function upgradeItem()
    {
        $itemId = request()->itemId;
        return $this->itemRepo->upgradeItem($itemId);
    }

    /***
     * delete item
     * @param $itemId
     * @return bool|mixed
     */
    public function deleteItem($itemId)
    {
        return $this->itemRepo->delete($itemId);
    }

    /***
     * delete item of user by itemUserId
     * @param $itemUserId
     * @return mixed
     */
    public function deleteItemUser($itemUserId)
    {
        return $this->itemUserRepo->delete($itemUserId);
    }

    /***
     * give a item for a player
     * @return \Illuminate\Http\JsonResponse
     */
    public function giveItemForUser()
    {
        $itemRawId = request()->itemRawId;
        $userId = request()->userId;
        return $this->itemRepo->giveItemForUser($itemRawId, $userId);
    }

    /***
     * open chest to get items
     */
    public function openChest()
    {
        $userId = request()->userId;
        $ownDiamonds = User::find($userId)->diamonds;//lấy số kc hiệnt ại của user
        $listItem = ['Spear', 'Shield', 'Helmet', 'Cloak'];
        $chestId = request()->chestId;//xác định đang mở hòm loại nào
        $chestType = Chest::find($chestId)->type;//lấy loại rương(common, rare, epic)
        $randomValue = rand(0, 100);//random 1 số trong khaongr
        $nameItem = $listItem[rand(0, count($listItem) - 1)];//lấy tên random từ listItem trên
        if ($ownDiamonds > Chest::find($chestId)->price) {//check số kc
            if ($chestType == 1)//hòm hạng Common 84 95 100
            {
                if ($randomValue >= 0 && $randomValue <= 84) {//với mỗi trường hợp thì sẽ so sánh tên và độ hiếm quay được bên trên với item gốc để add cho user
                    $item = Item::where('name', $nameItem)->where('rarity', 1)->first();
                } elseif ($randomValue > 84 && $randomValue <= 95) {
                    $item = Item::where('name', $nameItem)->where('rarity', 2)->first();
                } elseif ($randomValue > 95 && $randomValue <= 100) {
                    $item = Item::where('name', $nameItem)->where('rarity', 3)->first();
                }
            } elseif ($chestType == 2)//hòm hang Rare 59 79 94 100
            {
                if ($randomValue >= 0 && $randomValue <= 59) {
                    $item = Item::where('name', $nameItem)->where('rarity', 1)->first();
                } elseif ($randomValue > 59 && $randomValue <= 79) {
                    $item = Item::where('name', $nameItem)->where('rarity', 2)->first();
                } elseif ($randomValue > 79 && $randomValue <= 94) {
                    $item = Item::where('name', $nameItem)->where('rarity', 3)->first();
                } elseif ($randomValue > 94 && $randomValue <= 100) {
                    $item = Item::where('name', $nameItem)->where('rarity', 4)->first();
                }
            } elseif ($chestType == 3)//hòm hạng epic 49 69 86 100
            {
                if ($randomValue >= 0 && $randomValue <= 49) {
                    $item = Item::where('name', $nameItem)->where('rarity', 1)->first();
                } elseif ($randomValue > 49 && $randomValue <= 69) {
                    $item = Item::where('name', $nameItem)->where('rarity', 2)->first();
                } elseif ($randomValue > 69 && $randomValue <= 86) {
                    $item = Item::where('name', $nameItem)->where('rarity', 3)->first();
                } elseif ($randomValue > 86 && $randomValue <= 100) {
                    $item = Item::where('name', $nameItem)->where('rarity', 4)->first();
                }
            }
            User::find($userId)->update(['diamonds'=>($ownDiamonds) - (Chest::find($chestId)->price)]);//update lại số kc sau quay số
            $item->items()->create([//thêm mới đồ vừa quay cho user
                'atk' => $item->atk,
                'hp' => $item->hp,
                'body_def' => $item->body_def,
                'head_def' => $item->head_def,
                'status' => 2,
                'current_level' => 1,
                'user_id' => $userId
            ]);
        }
        else{
            return response()->json([
                'error' => 'You dont have enough diamonds !!!'
            ]);
        }
        return $item;

    }
}
