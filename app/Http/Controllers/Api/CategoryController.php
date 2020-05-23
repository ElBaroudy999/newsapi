<?php

namespace App\Http\Controllers\Api;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\categoriesResource;
use App\Http\Resources\CategoryPostsResources;
use App\Http\Resources\categoryResource;
use Illuminate\Http\Request;

class  CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return categoriesResource
     */
    public function index()
    {
        $categories = Category::paginate();
        return new categoriesResource($categories);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return categoryResource
     */
    public function show($id)
    {
       $category = Category::find($id);
       return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPosts($id)
    {
        $category = Category::find($id);
        $posts = $category->posts()->paginate(5);
        return new CategoryPostsResources($posts) ;
    }

}
