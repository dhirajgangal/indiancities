<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'title',
        'description',
        'image',
        'published_date',
        'status',
    ];

    protected $casts = [
        'published_date' => 'datetime',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}