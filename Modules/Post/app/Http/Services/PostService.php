<?php

namespace Modules\Post\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Post\Http\Dto\PostDto;
use Modules\Post\Http\Dto\UpdatePostDto;
use Modules\Post\Models\Post;

class PostService
{
    public function save(PostDto $postDto): Post
    {

        $post =  new Post();
        $post->title = $postDto->title;
        $post->description =  $postDto->description;
        $post->user_id =  $postDto->user_id;
        $post->save();
        return $post;
    }

    public function findAll()
    {
        return Post::with(["author:id,name"])->get();
    }


    public function getListCursorPaginate(Request $request)
    {

        return Post::orderBy('id', 'desc')->cursorPaginate(20);
    }
    public function findById(string $id): Post|null
    {
        $findPost = Post::where('id', $id)->first();

        return $findPost;
    }

    public function update(UpdatePostDto $postDto, string $id): Post
    {

        $post =  Post::find($id);
        $post->title = $postDto->title;
        $post->description =  $postDto->description;
        $post->save();
        return $post;
    }

    public function delete(string $id): post | null
    {

        $post =  Post::find($id);
        $post->delete();
        return $post;
    }
}
