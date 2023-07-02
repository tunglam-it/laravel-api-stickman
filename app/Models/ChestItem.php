<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'chest_id',
        'item_id',
        'ratio',
    ];
}
