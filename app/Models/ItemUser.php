<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'current_level',
        'status',
        'atk',
        'body_def',
        'head_def',
        'hp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
