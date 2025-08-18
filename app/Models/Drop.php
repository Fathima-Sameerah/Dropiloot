<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Drop extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'category_id',
        'media',
        'campaign_type',
        'user_id' // if drops are linked to a user
    ];

    // If media is stored as JSON
    protected $casts = [
        'media' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
