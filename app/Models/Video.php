<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'title',
        'youtube_url',
        'description',
        'status',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}