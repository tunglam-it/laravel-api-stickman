<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'atk',
        'head_def',
        'body_def',
        'hp',
        'rarity',
        'stat_increment',
        'price_increment',
        'max_level'
    ];

    public function items()
    {
        return $this->hasMany(ItemUser::class);
    }
}
