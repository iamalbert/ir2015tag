<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  public function resultToTag(){
    return $this->hasMany('App\PoolResult', 'assignee_id');
  }
}
