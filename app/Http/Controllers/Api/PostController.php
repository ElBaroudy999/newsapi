<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\PostResource;
use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
       {
           $posts = Post::paginate(10);
           return new \App\Http\Resources\PostsResource($posts);
       }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' =>'required',
            'content'=>'required',
          //  'date_written'=>'required', // we will make automatic system save datetime Now
          //  'user_id'=>'required', // you dont need it becouse you will sent from mob app token of user
            'category_id'=>'required',
        ]);
        $post = new Post();
        $user = $request->user();
        $post->title = $request->get('title');
        $post->content = $request->get('content');
        if (intval($request->get('category_id')) != 0)
        {
            $post->category_id = intval($request->get('category_id'));
        }

        if ($request->has('featured_image'))
        {
            $featured_image = $request->file('featured_image');
            $fileName = time().$featured_image->getClientOriginalName();
            Storage::disk('images')->putFileAs(
                $fileName,
                $featured_image,
                $fileName
            );
            $post->featured_image = url('/').'/images/'.$fileName;
        }
        $post->date_written = now();//->format('Y-m-d H:i:s');
        $post->user_id = $user->id ;
        $post->vote_up = 0;
        $post->vote_down = 0;
        $post->save();
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $post = Post::with(['comments','author','category'])->where('id',$id)->get();
        return new  \App\Http\Resources\PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return PostResource
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $post = Post::find($id);

        if ($request->has('content')){
            $post->content =$request->get('content') ;
        }
        if ($request->has('title')){
            $post->title =$request->get('title') ;
        }
        if ($request->has('category_id')){
            $post->category_id =$request->get('category_id') ;
        }
        if ($request->has('featured_image')){
            $newFeaturedImage = $request->get('featured_image');
            $newFileName = time().$newFeaturedImage->getClientOriginalName();
            Storage::disk('images')->putFileAs(
                $newFileName,
                $newFeaturedImage,
                $newFileName
            );
            $post->featured_image = url('/').'/images/'.$newFileName;

        }
        $post->save();
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delet();
        return new PostResource($post);
    }
    public function getComments($id)
    {
       $post = Post::find($id);
       $comments = $post->comments()->paginate(5);
       return new \App\Http\Resources\PostCommentsResource($comments);
    }
}
