<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
           'title'=>$this->title,
           'content'=>$this->content,
           'image_url'=>$this->image?$this->image->url_path:null,
            'data'=>$this->date,
            'id'=>$this->id,
            'is_liked'=>$this->is_liked??false,
            'likes_count'=>$this->likescount->count(),
            'reposted_id'=> new PostRepostResource($this->repostedPost),
            'comments_count'=> $this->comments_count,
            'repost_counts'=> $this->repostedByPost->count(),
            'user'=>new UserResource($this->postbyuser)


        ];
    }
}
