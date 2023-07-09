<?php

namespace App\Repositories\ItemUser;

use App\Http\Resources\Player\ItemCurrentInfoResource;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemUserRepository extends BaseRepository implements ItemUserRepositoryInterface
{

    /***
     * get model
     * @return string
     */
    public function getModel()
    {
        return ItemUser::class;
    }

    /***
     * test
     * @param $playerName
     * @param $itemName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllItemUsers($playerName, $itemName)
    {
        $itemsUser = ItemUser::query();
        if ($itemName) {
            $items = $itemsUser->join('items', 'items.id', '=', 'item_users.item_id')
                ->where('items.name', 'like', '%' . $itemName . '%')
                ->select('item_users.*')
                ->get();
        }
        if ($playerName) {
            $items = $itemsUser->join('users', 'users.id', '=', 'item_users.user_id')
                ->where('users.username', 'like', '%' . $playerName . '%')
                ->select('item_users.*')
                ->get();
        }
        else{
            $items = $itemsUser->get();
        }
        foreach ($items as $item) {
            $item['item'] = Item::where('id', $item->item_id)->first();
            $item['player'] = User::where('id', $item->user_id)->first();
        }
        $perPage = 8;
        $currentPage = request()->get('page') ?? 1;
        $pagedData = $items->slice(((int)$currentPage - 1) * $perPage, $perPage)->all();
        $items = new LengthAwarePaginator($pagedData, count($items), $perPage, $currentPage, ['path' => url()->current()]);
        return response()->json(['data'=>$items]);
    }

    /***
     * update status item
     * @param $itemId
     * @param $statusItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatusItem($oldItemId, $newItemId)
    {
        if ($newItemId && $oldItemId) {
            $newItem = $this->find($newItemId);
            $newItemStatus = $newItem->status;
            $oldItem = $this->find($oldItemId);
            $oldItemStatus = $oldItem->status;

            $oldItem->update([
                'status' => $newItemStatus
            ]);
            $newItem->update([
                'status' => $oldItemStatus
            ]);
            return response()->json([
                'data' => new ItemCurrentInfoResource($newItem)
            ]);
        }
        if ($oldItemId) {
            $oldItem = $this->find($oldItemId);
            $oldItem->update([
                'status' => 2
            ]);
            return response()->json([
                'data' => new ItemCurrentInfoResource($oldItem)
            ]);
        }
        if ($newItemId) {
            $newItem = $this->find($newItemId);
            $newItem->update([
                'status' => 1
            ]);
            return response()->json([
                'data' => new ItemCurrentInfoResource($newItem)
            ]);
        }
        return response()->json([
            'error' => 'Update Status Failed !!!'
        ]);
    }
}
