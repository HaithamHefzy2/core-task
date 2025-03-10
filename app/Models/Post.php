<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use  SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
        'published_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
