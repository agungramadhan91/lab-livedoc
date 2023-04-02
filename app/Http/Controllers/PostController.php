<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use \Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::query()->get();

        return new JsonResponse([
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $create_post = DB::transaction(function() use ($request)
        {
            $create_post = Post::query()->create([
                "title" => $request->title,
                "body"  => $request->body
            ]);

            $create_post->users()->sync($request->userId);

            return $create_post;
        });

        return new JsonResponse([
            'data' => $create_post
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new JsonResponse([
            'data' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $update = DB::transaction(function() use ($request, $post)
        {
            $update = $post->update([
                "title" => $request->title ?? $post->title,
                "body" => $request->body ?? $post->body,
            ]);

            $post->users()->sync($request->userId);

            return $update;
        });

        if(!$update){
            return new JsonResponse([
                "error" => ["Failed to update!"]
            ], 400);
        }

        return new JsonResponse([
            'data' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $delete = DB::transaction(function() use ($post)
        {
            $post->users()->detach();
            $delete = $post->forceDelete();

            return $delete;
        });

        if(!$delete){
            return new JsonResponse([
                "error" => ["Could not delete resource!"]
            ], 400);
        }

        return new JsonResponse([
            'data' => "succes"
        ]);
    }
}
