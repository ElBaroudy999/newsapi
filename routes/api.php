<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* User */
Route::get('users','Api\UserController@index');
Route::get('user/{id}','Api\UserController@show');
/* endUser */

/* Post */
Route::post('token','Api\UserController@requestToken');
Route::post('register','Api\UserController@store');
/*************************************************************************/
/* start category */
 Route::get('categories','Api\CategoryController@index');
 Route::get('category/{id}','Api\CategoryController@show');
 Route::get('category/posts/{id}','Api\CategoryController@getPosts');
/* end category */
/*************************************************************************/
/* start Post */
 Route::get('posts','Api\PostController@index');
 Route::get('post/{id}','Api\PostController@show');
 Route::get('post/comments/{id}','Api\PostController@getComments');
/* End Post */
/*************************************************************************/

/*get request with api*/
//Route::get('users',function(){
//    return \App\User::all();
//});

/*use api controller*/
Route::post('register','Api\UserController@store');
Route::post('token','Api\UserController@requestToken');
Route::get('usersresourceuseapicontroller','Api\UserController@index');
Route::get('userresourceuseapicontroller/{id}','Api\UserController@show');
Route::get('posts/user/{id}','Api\UserController@getPosts');
Route::get('comments/user/{id}','Api\UserController@getComments');
Route::get('post/{id}','Api\PostController@show');
/**/
//Route::get('usersresource',function(){
//    $users =\App\User::paginate();
//    return new App\Http\Resources\UsersResource($users);
//});
//Route::get('posts',function(){
//    return \App\Post::all();
//});

Route::middleware('auth:api')->group(
    function (){
        Route::post('update-user/{id}','Api\UserController@update');

        Route::post('savePost','Api\PostController@store');
        Route::post('update-post/{id}','Api\PostController@update');
        Route::post('delete-post/{id}','Api\PostController@destroy');

        Route::post('comment/post/{id}','Api\CommentController@store');
        //Route::post('update-comment/{id}','Api\CommentController@update');
       //Route::post('delete-comment/{id}','Api\CommentController@destroy');
    }
);
