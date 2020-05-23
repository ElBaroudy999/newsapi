<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function requestToken (Request $request)
    {
       $request->validate(
           [
               'email'=> 'required',
               'password'=> 'required',
           ]
       );
       $credentials =$request->only('email','password');
       if (Auth::attempt($credentials)){
           $user = User::where('email',$request->get('email'))->first();
           return new TokenResource( ['token '=> $user->api_token]);
       }
       return 'not found';
    }

    /**
     * @return UsersResource
     */
    public function index()
    {
        $users = User::paginate();
        return new UsersResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);
        $user =new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return new UserResource($user);
    }


    /**
     * @return UserResource
     */
    public function show($id)
    {
         return new \App\Http\Resources\UserResource(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return UserResource
     */
    public function update(Request $request, $id)
    {
        $user =User::find($id);
        if ($request->has('name')){
            $user->name = $request->get('name');
        }
        if ($request->has('avatar')){
            $user->avatar = $request->get('avatar');
        }
        $user->save();
        return new UserResource($user);

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

    public function getPosts($id){
        $user = User::find($id);
        $posts = $user->posts()->paginate(5);
        return new \App\Http\Resources\UserPostsResource($posts) ;
        }

     public function getComments($id){
            $user = User::find($id);
            $comments = $user->comments()->paginate(5);
            return new \App\Http\Resources\UserCommentsResource($comments) ;
            }
}
