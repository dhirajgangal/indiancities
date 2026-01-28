<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id', 'slug', 'title', 'image', 'description', 'published_date', 'status'
    ];

    protected $casts = [
        'published_date' => 'datetime',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected static function booted()
    {
        static::saving(function (Place $place) {
            if (!filled($place->slug) && filled($place->title)) {
                $base = Str::slug($place->title);
                $slug = $base;
                $i = 1;

                while (
                    static::where('city_id', $place->city_id)
                        ->where('slug', $slug)
                        ->where('id', '!=', $place->id ?? 0)
                        ->exists()
                ) {
                    $slug = $base.'-'.$i;
                    $i++;
                }

                $place->slug = $slug;
            }
        });
    }
}
