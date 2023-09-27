<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $with = ['image','likesCount'];

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


}

