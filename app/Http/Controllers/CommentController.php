<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use \Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::query()->get();

        return new JsonResponse([
            'data' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $create_comment = DB::transaction(function() use ($request)
        {
            $create_comment = Comment::query()->create([
                "body"      => $request->body,
                "user_id"   => $request->userId,
                "post_id"   => $request->postId
            ]);

            return $create_comment;
        });

        return new JsonResponse([
            'data' => $create_comment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return new JsonResponse([
            'data' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $update = DB::transaction(function() use ($request, $comment)
        {
            $update = $comment->update([
                "body" => $request->body ?? $comment->body,
            ]);

            return $update;
        });

        if(!$update){
            return new JsonResponse([
                "error" => ["Failed to update!"]
            ], 400);
        }

        return new JsonResponse([
            'data' => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $delete = DB::transaction(function() use ($comment)
        {
            $delete = $comment->forceDelete();

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
