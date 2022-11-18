<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Comment::orderBy($request->get('sort_name', 'created_at'), $request->get('sort_type', 'desc'));

        if($post_uid = $request->get('post_uid')) {
            $query->whereHas('post', function($q) use($post_uid) {
                $q->where('uid', $post_uid);
            });
        }

        if($user_uid = $request->get('user_uid')) {
            $query->whereHas('user', function($q) use($user_uid) {
                $q->where('uid', $user_uid);
            });
        }

        if($request->get('user', false)) {
            $query->with('user');
        }

        if($request->get('post', false)) {
            $query->with('post');
        }

        return CommentResource::collection($query->paginate($request->get('limit', 20))); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $comment->load(['user', 'post']);
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return [
            'success' => true
        ];
    }

    /**
     * Restore the specified resource after using softDelete.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */    
    public function restore(Comment $comment) 
    {
        $comment->restore();
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage using forceDelete.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(Comment $comment) 
    {
        $comment->forceDelete();
        return [
            'success' => true
        ];
    }
}
