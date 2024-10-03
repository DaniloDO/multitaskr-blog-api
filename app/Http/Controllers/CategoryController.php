<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Auth\Events\Validated;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Category::where('name', 'like', "%{$request->get('search')}%");

        if($post_uid = $request->get('post_uid')) {
            $query->whereHas('posts', function($q) use($post_uid) {
                $q->where('uid', $post_uid);
            });
        }
        
        return CategoryResource::collection(
            $query->paginate($request->get('limit', 20))
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        $category = Category::create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, Category $category)
    {
        $category->update($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return [
            'success' => true
        ];
    }

    /**
     * Restore the specified resource after using softDelete.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */    
    public function restore(Category $category) 
    {
        $category->restore();
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage using forceDelete.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(Category $category) 
    {
        $category->forceDelete();
        return [
            'success' => true
        ];
    }

}
