<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'date_written',
         'post_id',
         'author_id',
    ];

     public function posts (){

                return $this->belongsTo('App\Post') ;

            }
             public function user (){

                            return $this->belongsTo('App\User') ;

                        }
}
