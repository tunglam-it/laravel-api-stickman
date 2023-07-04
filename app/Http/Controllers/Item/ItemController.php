<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Chest;
use App\Repositories\Item\ItemRepository;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemRepo;

    public function __construct(ItemRepository $itemRepo)
    {
        $this->itemRepo = $itemRepo;
    }

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
        return $this->itemRepo->getAllItemInfo($name);
    }

    /***
     * get all items of user by $userId
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemUser()
    {
        $userId = request()->userId;
        $allItem = $this->itemRepo->getAllItemsUser($userId);
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
    public function updateItemInfo(Request $request, $itemid)
    {
        $dataUpdate = $request->except('id');
        return $this->itemRepo->update($itemid, $dataUpdate);
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
        return $this->itemRepo->updateStatusItem($itemId, $statusItem);
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
     * open chest to get items
     */
//    public function openChest()
//    {
//        $chest_id = request()->chest_id;//xác định đang mở hòm loại nào
//        $randomValue = rand(0,100);
//        if(Chest::find($chest_id)->type==0)//hòm hạng Common 84 95 100
//        {
//            if ($randomValue>=0 && $randomValue<=84){}
//            elseif ($randomValue>84 && $randomValue<=95){}
//            elseif ($randomValue>95 && $randomValue<=100){}
//        }
//        elseif (Chest::find($chest_id)->type==1)//hòm hàng Rare 59 79 94 100
//        {
//            if ($randomValue>=0 && $randomValue<=59){}
//            elseif ($randomValue>59 && $randomValue<=79){}
//            elseif ($randomValue>79 && $randomValue<=94){}
//            elseif ($randomValue>94 && $randomValue<=100){}
//        }
//        elseif (Chest::find($chest_id)->type==2)//hòm hạng epic 49 69 86 100
//        {
//            if ($randomValue>=0 && $randomValue<=49){}
//            elseif ($randomValue>49 && $randomValue<=69){}
//            elseif ($randomValue>69 && $randomValue<=86){}
//            elseif ($randomValue>86 && $randomValue<=100){}
//        }
//
//    }
}
