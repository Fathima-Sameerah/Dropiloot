<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardCatalog extends Model
{
    protected $fillable = ['name', 'points_required', 'description'];
}
