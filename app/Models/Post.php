<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $withCount=['comments'];
    protected $with = ['image','likesCount','repostedPost','PostByUser'];

    public function image()
    {
        return $this->hasOne(PostImage::class)->whereNotNull('post_id');
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->diffForHumans()
        );
    }

    public function LikesCount()
    {
        return $this->belongsToMany(User::class,'liked_posts','post_id','user_id');
    }

    public function repostedPost()
    {
        return $this->belongsTo(Post::class, 'reposted_id', 'id');
    }

    public function comments()
    {
       return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'comments', 'post_id','user_id');
    }

    public function repostedByPost()
    {
        return $this->hasMany(Post::class, 'reposted_id', 'id');
    }

    public function PostByUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

