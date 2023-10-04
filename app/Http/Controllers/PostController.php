<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostCommentResource;
use App\Http\Resources\Post\PostRepostResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();

        $Likes = LikedPost::where('user_id', auth()->id())->get('post_id')->pluck('post_id')->toArray();


        //$comments = Comment::where('user_id', auth()->id())->get()->where('post_id',$post->id)->pluck('post_id')->toArray();

        foreach ($posts as $post) {

            if (in_array($post->id, $Likes))
                $post->is_liked = true;



        }

        // return response($posts);
        return PostResource::collection($posts);
    }

    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $imageId = $data['image_id'];

            unset($data['image_id']);

            $data['user_id'] = auth()->id();
            $post = Post::create($data);

            if (isset($imageId)) {
                $PI = PostImage::find($imageId);
                $PI->update([
                    'post_id' => $post->id
                ]);

            }
            PostImage::clearStorage();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }


// добавлением айди поста к изображению мы указываем на то, что изображения без айди поста нужно очистить из хранилища


        return new PostResource($post);
    }


    public function toggleLike(Post $post)
    {
        $res = auth()->user()->toggleLikes()->toggle($post->id);
        $data['is_liked'] = count($res['attached']) > 0;
        $data['likes_count'] = $post->likesCount()->count();
        return $data;
    }

    public function repost(RepostRequest $request, Post $post)
    {

        $data = $request->validated();
        $data['reposted_id'] = $post->id;
        $data['user_id'] = auth()->id();
        Post::create($data);


    }

    public function comment(CommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['post_id'] = $post->id;
        $data['user_id'] = auth()->id();
        Comment::create($data);


        //return response($comments);
    }

    public function getComments(Post $post)

    {
        //$comments = Comment::where('user_id', auth()->id())->where('post_id',$post->id)->get();

        $comments = $post->comments()->get();
        return PostCommentResource::collection($comments);

    }



}
