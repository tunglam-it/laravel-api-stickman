<?php

namespace App\Http\Resources\Player;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name,
            'atk'=>$this->atk+($this->stat_increment),
            'head_def'=>$this->head_def,
            'body_def'=>$this->body_def,
            'hp'=>$this->hp,
            'rarity'=>$this->rarity,
            'stat_increment'=>$this->stat_increment,
            'price_increment'=>$this->stat_increment,
            'max_level'=>$this->max_level,
        ];
    }
}
