<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'username'=>$this->username,
            'gold'=>$this->gold,
            'diamonds'=>$this->diamonds,
            'level'=>$this->level,
            'energy'=>$this->energy,
            'passed_stage'=>$this->passed_stage,
            'exp_profile'=>$this->exp_profile,
            'eliminated_enemy'=>$this->eliminated_enemy,
            'created_at'=>date_format($this->created_at,'d-m-Y H:i:s'),
        ];
    }
}
