<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\SubscriberFollow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();

        $Follows = SubscriberFollow::where('subscriber_id', auth()->id())->get('follower_id')->pluck('follower_id')->toArray();

        foreach ($users as $user) {
            if (in_array($user->id, $Follows))
                $user->is_followed = true;

        }

        return UserResource::collection($users);
        //return response([$Likes,'sasa']);
    }

    public function posts(User $user)
    {

        $posts = $this->PrepareLikesPost($user->posts);
        return PostResource::collection($posts);
    }

    public function toggleFollow(User $user)
    {
        $res = auth()->user()->following()->toggle($user->id);
        $data['is_followed'] = count($res['attached']) > 0;
        return $data;
    }

    public function followingPost()
    {
        $FollowIds = auth()->user()->following()->get()->pluck('id')->toArray();
        $followingPosts = Post::whereIn('user_id', $FollowIds)->get();
        $posts = $this->PrepareLikesPost($followingPosts);

        return PostResource::collection($posts);
        // return response($MyFollows);

    }

    public function PrepareLikesPost($posts)
    {
        $Likes = LikedPost::where('user_id', auth()->id())->get('post_id')->pluck('post_id')->toArray();

        foreach ($posts as $post)
        {
            if(in_array($post->id,$Likes))
                $post->is_liked=true;
        }

        return $posts;
    }

}
