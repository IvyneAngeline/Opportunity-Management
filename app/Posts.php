<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        // your other new column
    ];
    protected  $fillable=['title','description','asset','likes','downloads','category','user_id','comments'];


    public  function user(){
        return $this->belongsTo('App\User');
    }
    public  function  comment(){
        return $this->hasMany('App\Comments');
    }

}
