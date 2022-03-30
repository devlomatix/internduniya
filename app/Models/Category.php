<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            \Cache::forget('categories');
        });

        static::saved(function ($model) {
            \Cache::forget('categories');
        });

        static::deleted(function ($model) {
            \Cache::forget('categories');
        });

    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany($this, 'parent_id')->orderBy('order');
    }

    // recursive, loads all descendants
    public function childs()
    {
        return $this->child()->with('childs')->orderBy('order');
    }

    //Delete
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post','post_category');
    }

    public function internships()
    {
        return $this->belongsToMany('App\Models\Intenship','intenship_category');
    }
}
