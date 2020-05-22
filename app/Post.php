<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
        protected $fillable = [
                 'title','content','vote_up',
                 'vote_down','date_written',
                 'featured_image','user_id',
                 'category_id'
        ];

        public function author(){
                return $this->belongsTo('App\User','user_id','id');
            }
        public function comments(){
                return $this->hasMany('App\Comment') ;
        }
        public function category ()
        {
            return $this->belongsTo('App\Category') ;
        }
}
