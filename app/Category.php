<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @method static find(int $id)
 */
class Category extends Model
{
    protected $fillable =[
        'title',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post') ;
    }

}
