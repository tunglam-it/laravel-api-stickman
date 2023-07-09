<?php

namespace App\Http\Resources\Player;

use App\Http\Resources\Admin\UserInfoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemCurrentInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "current_level"=> $this->current_level,
            "status"=> $this->status,
            "atk"=> $this->atk,
            "body_def"=> $this->body_def,
            "head_def"=> $this->head_def,
            "hp"=> $this->hp,
            "item"=> new ItemInfoResource($this->item),
            "player" => new UserInfoResource($this->user)
        ];
    }
}
