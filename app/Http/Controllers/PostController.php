<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostsRequest;
use App\Http\Resources\PostResource;
use Illuminate\Auth\Events\Validated;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Post::where('title', 'like', "%{$request->get('search')}%");

        if($category_uid = $request->get('category_uid')) {
            $query->whereHas('categories', function($q) use($category_uid) {
                $q->where('uid', $category_uid);
            });
        };

        if($request->get('user', false)) {
            $query->with('user');
        };

        if($request->get('category', false)) {
            $query->with('categories');
        };

        return PostResource::collection(
            $query->paginate($request->get('limit', 20))
        ); 

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsRequest $request)
    {
        $post = Post::create($request->validated());
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('user');
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostsRequest $request, Post $post)
    {
        $post->update($request->validated());
        $post->load('user');
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return [
            'success' => true
        ];
    }

    /**
     * Restore the specified resource after using softDelete.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */    
    public function restore(Post $post) 
    {
        $post->restore();
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage using forceDelete.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(Post $post) 
    {
        $post->forceDelete();
        return [
            'success' => true
        ];
    }
}
