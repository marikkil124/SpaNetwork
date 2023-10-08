<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [


            'user'=> new UserResource($this->user),
            'id'=>$this->id,
            'post_id'=>$this->post_id,
            'comment'=>$this->body,
            'parent_id'=>$this->parent_id,
            'date'=>$this->date,
            'auth_user_id'=>auth()->id(),





        ];
    }
}
