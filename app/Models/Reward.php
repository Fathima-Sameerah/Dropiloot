<?php

namespace App\Models;
use App\Models\RewardCatalog;


use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'user_id', 'points_earned', 'points_redeemed', 'action_type', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
