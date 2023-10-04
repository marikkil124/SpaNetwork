<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\User\StatRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\SubscriberFollow;
use App\Models\User;

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

    }

    public function posts(User $user)
    {
        $posts = $user->posts()->latest()->get();
        $posts = $this->PrepareLikesPost($posts);
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
        $FollowIds = auth()->user()->following()->latest()->get()->pluck('id')->toArray();
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

            $comments = Comment::where('user_id', auth()->id())->get()->where('post_id',$post->id)->pluck('post_id')->toArray();
            if(in_array($post->id,$comments))
                $post->comment_post=$comments;
        }

        return $posts;
    }

    public function stat(StatRequest $request)
    {
        $data = $request->validated();

       $userId = isset($data['user_id']) ? $data['user_id'] : auth()->id();


        $result = [];
        $result['subscribes'] = SubscriberFollow::where('subscriber_id', $userId)->get()->pluck('subscriber_id')->count();
        $result['followers']  = SubscriberFollow::where('follower_id', $userId)->get()->pluck('follower_id')->count();
        $LikedPosts = Post::where('user_id', auth()->id())->get()->pluck('id');

       $result['likes']  = LikedPost::whereIn('post_id', $LikedPosts)->get()->pluck('follower_id')->count();
        $result['posts'] = Post::where('user_id', $userId)->get()->pluck('id')->count();
        return response()->json($result);
    }

}
