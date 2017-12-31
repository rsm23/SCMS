<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Category extends Model
{
    use Sluggable;

    /**
     *  Boot the model.
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::saved(function ($category) {
            Artisan::call('cache:clear');
        });
        static::deleted(function ($category) {
            Artisan::call('cache:clear');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
