<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected  $table='accounts';
    protected $fillable=['name','address','user_id'];
}
