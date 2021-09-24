<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected  $fillable=['name','amount','stage','user_id','account_id'];
}
