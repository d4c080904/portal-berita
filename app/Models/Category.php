<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    // route model binding pakai slug
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
