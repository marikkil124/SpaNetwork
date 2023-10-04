<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostRepostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $url = isset($this->image)?$this->image->url_path:null;
        return [
            'title'=>$this->title,
            'content'=>$this->content,
            'image_url'=>$url,
            'user'=>new UserResource($this->postbyuser)

        ];
    }
}
