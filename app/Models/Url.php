<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Url extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'url'];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $url) {
            if (is_null($url->hash_id)) {
                $url->hash_id = Str::random(8);
            }
        });
    }

    /**
     * Generating short url address
     *
     * @return string
     */
    public function getShortUrlAttribute()
    {
        return route('redirect', [$this->attributes['hash_id']]);
    }
}
