<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*all comments that has post id = 5*/
Route::get('/custom0',function(){
$post =\App\Post::find(5);
return $post->comments;
});
Route::get('/custom1',function(){
return \App\Post::find(5);
});

Route::get('/comments',function(){
return \App\Comment::all();
});
Route::get('/users',function(){
return \App\User::all();
});
Route::get('/categories',function(){
return \App\Category::all();
});
Route::get('/posts',function(){
return \App\Post::all();
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
